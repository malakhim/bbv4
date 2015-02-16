<?php
/**
 * @author Bryan Wu
 * @copyright BilliBuys 2014
 * @desc Functions for BilliBuys
 */


if ( !defined('AREA') ) { die('Access denied'); }

use Tygh\Session;
use Tygh\Registry;

/**
 * Find position of Nth occurrence of search string
 * @param string $search The search string
 * @param string $string The string to seach
 * @param int $occurence The Nth occurance of string
 * @return int or false if not found
 */
function strpos_offset_recursive($needle,$haystack,$occurence){
	if(($o=strpos($haystack,$needle))===false) 
		return false;
	if($occurence>1){
		$found = strpos_offset_recursive($needle,substr($haystack,$o+strlen($needle)),$occurence-1);
		return ($found!==false) ? $o+$found+strlen($needle) : false;
	}
	return $o;
}

function fn_billibuys_save_log($type, $action, &$data, $user_id, &$content, &$event_type)
{
	if ($type == 'bb_bid') {
		$bid = db_get_field("SELECT product FROM ?:product_descriptions WHERE product_id = ?i AND lang_code = ?s", $data['product_id'], Registry::get('settings.Appearance.admin_default_language'));
		$content = array (
			'product' => $bid . ' (#' . $data['bid']['product_id'] . ')',
		);
	}elseif($type == 'bb_request'){
		$request = db_get_field("SELECT title FROM ?:bb_request_item WHERE bb_request_item_id = ?i", $data['request']['request_item_id']);
		$content = array (
			'request' => $request . ' (#' . $data['request']['request_item_id'] . ')',
		);
		}
}

/**
 * Logs user into vendor side when log into customer side (works for logout too)
 * @param  int $sess_id   cookie ID
 * @param  string $sess_data serialised string of data
 * @param  array $_row      row data to be REPLACEd into db
 */
function fn_billibuys_save_session($sess_id, $sess_data, $_row){
	// Store existing data
	$old_sess = $sess_data;
	$old_row = $_row;

	// Array defining session data that needs to be changed
	$replace_keys = Array(
		'area',
		'user_id',
		'user_type',
		'company_id',
	);

	// Pull data from db
	$sess_string = db_get_field("SELECT data FROM ?:sessions WHERE session_id LIKE ?s && area LIKE ?s",$sess_id, AREA);
	foreach($replace_keys as $rkey){
		// Find first instance of key's position
		$lpos = strpos($sess_string, $rkey);
		// Find position of last " of key
		$semicolon_count = 2; // We're looking for second occurrence of semicolons in the session data string
		$rpos = strpos_offset_recursive(";",substr($sess_string,$lpos),$semicolon_count)+$lpos+2;
		// Build new string
		$key_string = substr($sess_string, $lpos-1, ($rpos-$lpos));
		// Separate key from values in substring
		$key_arr = explode(';', $key_string);
		// Get individual values
		$key_val = explode(':',$key_arr[1]);
		// Replace stuff
		// if($key_val[0] == 's'){
		switch($key_arr[0]){
			case '"area"':
				// Length doesn't need to be stated as it's still a single-char string
				if(AREA == 'C'){
					$key_val[2] = '"A"';
				}elseif(AREA == 'A' || AREA == 'V'){
					$key_val[2] = '"C"';
				}
				break;
			case '"user_id"':
				// It's okay if user_id = 0, just means won't be logged into vendor as well
				$user_id = $_SESSION['auth']['user_id'];
				$key_val[1] = strlen($user_id);
				$key_val[2] = '"'.$user_id.'"';
				break;
			case '"user_type"':
				$user_type = 'V';
				if($key_val[0] == 's'){
					$key_val[2] = '"'.$user_type.'"';
				}else{
					$key_val[0] = 's';
					$key_val[1] = strlen($user_type);
					$key_val[2] = '"'.$user_type.'";s';
				}
				break;
			case '"company_id"':
				$company_id = $_SESSION['auth']['company_id'];
				$key_val[1] = strlen($company_id);
				$key_val[2] = '"'.$company_id.'"'; 
				break;
		}

		// Rebuild string using implode
		$key_arr[1] = implode(':',$key_val);
		$new_key_string = implode(';',$key_arr);
		$sess_string = str_replace($key_string,$new_key_string,$sess_string);
	}

	if(AREA == 'C'){
		$sess_replace_string = 'vendor';
	}elseif(AREA == 'V' || AREA == 'A'){
		$sess_replace_string = 'customer';
	}
	$sess_name = str_replace(ACCOUNT_TYPE, $sess_replace_string, SESS_NAME);

	// Place_order used to avoid sending double headers to paypal
	if(AREA != 'A' && $_REQUEST['dispatch'] != 'checkout.place_order'){
		// Delete all duplicate cookies unless already logged in
		if (isset($_SERVER['HTTP_COOKIE']) && $_SESSION['auth']['user_id'] == 0) {
		    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
		    $unique_cookies = Array();
		    foreach($cookies as $cookie) {
		        $parts = explode('=', $cookie);
		        $name = trim($parts[0]);
		        if(!in_array($name,$unique_cookies)){
		        	array_push($unique_cookies,$name);
			    }else{
			        setcookie($name, '', time()-1000);
			        setcookie($name, '', time()-1000, '/');
			        // Odd fixes for how CS-Cart adds . to front of domain in cookies
			        setcookie($name,'',time()-1000,'/',substr($_SERVER['HTTP_HOST'],strpos($_SERVER['HTTP_HOST'],'.')));
			        setcookie($name,'',time()-1000,'/','.'.$_SERVER['HTTP_HOST']);
			    }
		    }
		    Session::regenerate_id();
		}
		$res = fn_set_cookie($sess_name,$sess_id,Session::$lifetime);
		setcookie($sess_name,$sess_id,Session::$lifetime,'/','.'.$_SERVER['HTTP_HOST']);
	}

	if(AREA == 'C'){
		$new_area = 'A';
	}else{
		$new_area = 'C';
	}

	$row = Array(
		'session_id' => $sess_id,
		'area'		 => $new_area,
		'expiry'	 => TIME + Session::$lifetime,
		'data'		 => $sess_string,
	);

	// Replace existing key with the logged in one
	db_query('REPLACE INTO ?:sessions ?e', $row);

}

function fn_billibuys_update_profile($action, $user_data, $current_user_data){

}

/**
 * Archives the request, ie moves from bb_requests to bb_request_archive
 * @param  Int $request_id
 * @return boolean indicating whether has been successfully archived or not based on whether it was added to archive
 */
function fn_archive_request($request_id){
	//Get request
	$request = db_get_row("SELECT * FROM ?:bb_requests WHERE ?:bb_requests.bb_request_id = ?i",$request_id);

	// Get request details and archive them
	$request_item = db_get_row("SELECT * FROM ?:bb_request_item WHERE bb_request_item_id = ?i",$request['request_item_id']);

	db_query("INSERT INTO ?:bb_request_item_archive ?e",$request_item);

	// Archive actual request
	$id = db_query("INSERT INTO ?:bb_request_archive ?e",$request);

	// If inserted into archive table, return true else return false
	// $id = db_get_field("SELECT LAST_INSERT_ID()");
	if($id){
		db_query("DELETE FROM ?:bb_requests WHERE ?:bb_requests.bb_request_id = ?i",$request_id);
		db_query("DELETE FROM ?:bb_request_item WHERE ?:bb_request_item.bb_request_item_id = ?i",$request_item['bb_request_item_id']);
		return true;
	}else{
		return false;
	}
}

/**
 * Post delete-from-cart script, toggles item_added_to_cart flag to 00 for the request linked to the item that's being deleted from cart
 * @param  array  $cart       The cart
 * @param  int  $cart_id    The ID of the product in the cart
 * @param  boolean $full_erase No idea.
 * @return boolean              Just good practice.
 */

function fn_billibuys_delete_cart_product($cart, $cart_id, $full_erase = true){
	// $update_data = Array("item_added_to_cart" => 0);
	// db_query('UPDATE ?:bb_requests INNER JOIN ?:bb_bids ON ?:bb_bids.request_id = ?:bb_requests.bb_request_id SET ?u 
	// 	WHERE
	// 		?:bb_requests.user_id = ?i 
	// 		AND 
	// 			?:bb_bids.product_id = ?i',$update_data,$_SESSION['auth']['user_id'],$cart['products'][$cart_id]['product_id']);
	return true;
}
/**
 * Get bid pricing for cart products when logging back in, rather than actual product pricing
 * @param  int $product_id The product identifier
 * @param  Array $_pdata     Product data to be inserted into cart
 * @param  Array $product    Product data pulled from database
 * @param  Array $auth       auth array
 * @param  Array $cart       what's actually in the cart
 */
function fn_billibuys_get_cart_product_data($product_id, $_pdata, $product, $auth, $cart){
	
	$price = db_get_field('SELECT a.price FROM ?:bb_bids as a WHERE a.bb_bid_id = ?i AND a.request_id = ?i',$product['bid_id'],$product['request_id']);
	if($price){
		$_pdata['price'] = $price;
		$_pdata['base_price'] = $price;
	}else{
		// Empty pricing, remove from cart for safety reasons
		$_pdata = null;
	}
}

/**
 * Get price based on order_id
 * DEPRECATED: Not used atm
 */
// function fn_get_order_price($order_id, $product_id){
// 	$price = db_get_field('SELECT price FROM ?:order_details WHERE order_id = ?i AND product_id = ?i',$order_id,$product_id);
// 	return $price;
// }

/**
 * Modifying product to have correct price when adding to cart
 * @param  Array $product_data All the products to be added to cart
 * @param  Array $cart         What's in the cart atm
 * @param  Array $auth         Auth array
 * @param  Boolean $update       Not sure...
 */
function fn_billibuys_pre_add_to_cart($product_data, $cart, $auth, $update){
	foreach($product_data as $k => &$pdata){
		// Check if the product data came from a bid
		if(isset($pdata['bid_id'])){
			$pdata['stored_price'] = 'Y';
			$pdata['price'] = db_get_field('SELECT b.price FROM ?:bb_bids AS b WHERE b.bb_bid_id = ?i AND b.request_id = ?i',$pdata['bid_id'],$pdata['request_id']);
			if(!$pdata['price']){
				// In case something goes wrong or empty price, prevent product from 
				// being added to cart at all
				unset($product_data[$k]);
			}
		}
	}
}

/**
 * Post add-to-cart script, toggles item_added_to_cart flag on the request table for associated request
 * @param  Array $product_data product data
 * @param  Array $cart current cart
 * @param  Array $auth auth array
 * @param  Boolean $update if cart has been updated, this will be true
 * @return boolean Just good practice
 */
function fn_billibuys_post_add_to_cart($product_data, $cart, $auth, $update){
	// Check product_data is in cart
	$product_in_cart = false;
	foreach($cart['products'] as &$prod){
		foreach($product_data as $pdata){
			if($pdata['product_id'] == $prod['product_id']){
				if(isset($pdata['bid_id'])){
					$prod['amount'] = $pdata['amount'];
					$prod['bid_id'] = $pdata['bid_id'];
					$prod['request_id'] = $pdata['request_id'];
					$product_in_cart = true;
					$prod['price'] = db_get_field('SELECT b.price FROM ?:bb_bids AS b WHERE b.bb_bid_id = ?i AND b.request_id = ?i',$pdata['bid_id'],$pdata['request_id']);
					if(!$prod['price']){
						// In case something goes wrong or empty price, prevent product from being added to cart at all
						unset($product_data[$k]);
					}
				}

			}
		}
	}
	// Check product exists for the auction
	$product_in_auction = false;
	foreach($product_data as $pdata){
		$product_in_auction = db_get_field(
		"SELECT ?:bb_requests.bb_request_id
		FROM ?:bb_requests 
		INNER JOIN ?:bb_bids ON ?:bb_requests.bb_request_id = ?:bb_bids.request_id
		WHERE ?:bb_bids.product_id = ?i AND ?:bb_requests.user_id = ?i
		",$pdata['product_id'],$auth['user_id']);
	}
	// If both above are true then update product in cart
	$valid_purchase = false;
	if($product_in_cart && ($product_in_auction && $product_in_auction != NULL && !empty($product_in_auction))){
		$valid_purchase = true;
	}

	// if($valid_purchase){
	// 	$update_data = Array(
	// 		"item_added_to_cart" => "1",
	// 	);
	// }else{
	// 	$update_data = Array(
	// 		"item_added_to_cart" => "0",
	// 	);
	// }

	if($valid_purchase){
		foreach($product_data as &$prod){
			// db_query('UPDATE ?:bb_requests INNER JOIN ?:bb_bids ON ?:bb_bids.request_id = ?:bb_requests.bb_request_id SET ?u 
			// 	WHERE 
			// 		?:bb_requests.bb_request_id = ?i',$update_data,$prod['request_id']
			// );
			foreach($cart['products'] as &$cprod){
				if($cprod['product_id'] === $prod['product_id']){
					$cprod['request_id'] = $prod['request_id'];
					$cprod['bid_id'] = $prod['bid_id'];
				}
			}
		}
	}

	return true;
}

/**
 * Sets "item_added_to_cart" to 0 as part of the cart clearing process
 * 
 * @param  Array  $cart      The cart
 * @param  boolean $complete  No idea
 * @param  boolean $clear_all Double no idea
 * @return boolean             Returning true just for good practice
 */
function fn_billibuys_clear_cart($cart, $complete = false, $clear_all = false){
	// if($cart && is_array($cart) && $cart != null){
	// 	// Iterate through cart's products
	// 	foreach($cart['products'] as $product){
	// 		$user_id = $_SESSION['auth']['user_id'];
	// 		if($user_id){ // Good typing practices? What's that?
	// 			// Set item_added_to_cart to 0 for the request
	// 			$update_data = Array('item_added_to_cart' => 0);
	// 			db_query(
	// 				"UPDATE ?:bb_requests INNER JOIN ?:bb_bids ON ?:bb_requests.bb_request_id = ?:bb_bids.request_id SET ?u WHERE
	// 					?:bb_bids.product_id = ?i AND
	// 					?:bb_bids.price = ?i AND
	// 					?:bb_requests.user_id = ?i",
	// 				$update_data,
	// 				$product['product_id'],
	// 				$product['price'],
	// 				$user_id
	// 			);
	// 		}
	// 		// If user isn't logged in (ie someone accidentally enabled "can have cart without logging in" in admin backend) then this will simply ignore everything
	// 	}
	// }
	// return true;	
}

function fn_billibuys_order_placement_routines($order_id, $force_notification, $order_info, $_error){

	if(!$_error){

		// Don't archive if order is open?
		foreach($order_info['items'] as $item){
			$request = fn_get_request_by_order($order_info['user_id'],$item['product_id']);
			if(!empty($request)){
				// Archive bid
				fn_archive_bid($request['bb_bid_id']);
				// Reduce quantity by bidded amount
				$amount = db_get_field("SELECT amount FROM ?:products WHERE product_id = ?i",$request['product_id']);
				$amount -= $request['quantity'];
				db_query("UPDATE ?:products SET ?u WHERE product_id = ?i",Array('amount'=>$amount),$request['product_id']);
				if($amount == 0){

					$same_bids = db_get_array("SELECT * FROM ?:bb_bids WHERE product_id = ?i",$request['product_id']);
					foreach($same_bids as $s){
						db_query("UPDATE ?:bb_bids SET ?u WHERE bb_bid_id = ?i",Array('active'=>'0'),$s['bb_bid_id']);
					}

					// Notify supplier of empty stock and that their auctions with this item have been disabled
					$user = db_get_row("SELECT ?:users.* FROM ?:users INNER JOIN ?:bb_bids_archive ON ?:bb_bids_archive.user_id = ?:users.user_id WHERE bb_bid_id = ?i",$request['bb_bid_id']);
					$email_addr = $user['email'];
					$view_mail = Registry::get('view_mail');
					$product = db_get_row("SELECT product FROM ?:product_descriptions WHERE product_id = ?i AND lang_code = ?s",$request['product_id'],'EN');
					$view_mail->assign('subject',__('zero_amount'));
					$view_mail->assign('user',$user);
					$view_mail->assign('product',$product);
					$url = $_SERVER['HTTP_HOST'].fn_url('vendor.php?dispatch=products.update&product_id='.$product['product_id']);
					$view_mail->assign('product_line',str_replace('[url]',$url,__('reenable_bids')));
					fn_send_mail($email_addr,Registry::get('settings.Company.company_users_department'),'addons/billibuys/bid_subj.tpl','addons/billibuys/empty_quantity_body.tpl','', Registry::get('settings.Appearance.admin_default_language'));
				}
				// Let's allow more bids, so we'll comment this line out for now
				// fn_archive_request($request['bb_request_id']);
			}
		}
	}
}

function fn_get_bid_by_product($product_id,$request_id){
	$bid = db_get_row("SELECT *
			FROM
				?:bb_bids
			WHERE
				?:bb_bids.product_id = $product_id AND ?:bb_bids.request_id = $request_id AND ?:bb_bids.active = '1'
			GROUP BY bb_bid_id
		");

	return $bid;
}

function fn_get_bid_by_id($bid_id){
	$bid = db_get_row("SELECT * FROM ?:bb_bids WHERE bb_bid_id = ?i",$bid_id);
	return $bid;
}

/**
 * This delets bid from the bids table and pushes to bids_archive table
 * @param  Int $bid_id The bid_id corresponding to bb_bid_id
 */
function fn_archive_bid($bid_id){
	$bid = db_get_row("SELECT * FROM ?:bb_bids WHERE bb_bid_id = ?i",$bid_id);
	db_query("DELETE FROM ?:bb_bids WHERE bb_bid_id = ?i",$bid_id);
	$existing_archive = db_get_row("SELECT * FROM ?:bb_bids_archive WHERE bb_bid_id = ?i",$bid_id);
	if(!$existing_archive)
		db_query("INSERT INTO ?:bb_bids_archive ?e",$bid);
	else
		db_query("UPDATE ?:bb_bids_archive SET ?u WHERE bb_bids_archive_id = ?i",$bid,$bid_id);
}

/**
 * Gets all the bids for a particular request
 * @param  Array $params At the moment, array containing the request ID
 * @return Array         List of bids on this particular request
 */
function fn_get_bids($params){

	// Filter by fields if field array was specified in $params
	if(isset($params['fields'])){
		$fields = implode($params['fields'],',');
	}else
		$fields = '*';

	// Set default sort
	$sorting = 'timestamp DESC';

	$sortings = array(
		'date' => '?:bb_bids.timestamp',
		'title' => 'product',
		'price' => 'price',
	);
	if(isset($params['sort_by'])){
		$sorting = $params['sort_by'];
		if(isset($params['sort_order']))
			$sort_order = $params['sort_order'];
		else
			$sort_order = 'DESC';
	}else{
		$sorting = '?:bb_bids.timestamp';
		$sort_order = 'DESC';
	}

	$sorting .= ' '.$sort_order;

	// For pagination			
	$query = 'SELECT COUNT(*) 
		FROM ?:bb_bids
		WHERE request_id = ?i';

	$where = $params['request_id'];

	$bids_count = db_get_field($query,$where);

	$query = "SELECT $fields
		FROM 
			?:bb_bids
		INNER JOIN
			?:product_descriptions ON
				?:product_descriptions.product_id = ?:bb_bids.product_id
		INNER JOIN
			?:products ON
				?:bb_bids.product_id = ?:products.product_id
		INNER JOIN
			?:user_profiles ON
				?:bb_bids.user_id = ?:user_profiles.user_id
		LEFT JOIN
			?:bb_ratings ON
				?:bb_ratings.rating_type_id = ?:products.product_id	
		WHERE 
		 ?:bb_bids.request_id = ?i AND ?:products.status = 'A' AND ?:bb_bids.active = '1' AND (?:bb_ratings.rating_type = 'P' OR ?:bb_ratings.rating_type IS NULL)
		GROUP BY bb_bid_id";

	// Sorting
	if(isset($sorting) && !empty($sorting)){
		$query .= ' ORDER BY ?p';
	}

	// CS-Cart v4 formatting changed, thus this line is unnecessary
	// $limit = fn_paginate($_REQUEST['page'], $bids_count, Registry::get('settings.Appearance.products_per_page')); 
	
	$limit = db_paginate($_REQUEST['page'], Registry::get('settings.Appearance.products_per_page'), $bids_count); 


	$query .= " $limit";

	$bids = db_get_array($query, $params['request_id'], $sorting);

	return $bids;
}

function fn_bb_submit_notification($bb_data){
	if(empty($bb_data))
		return false;
	else{
		$keywords = explode(',',$bb_data['keywords']);
		foreach($keywords as $keyword){
			$data = array(
				'notify_string' => $keyword,
				'user_id'		=> $bb_data['auth']['user_id'],
				'ip_address'    => $bb_data['auth']['ip'],
				'timestamp'     => microtime(true)
			);
			db_query('INSERT INTO ?:bb_notifications ?e',$data);
		}
	}
}

/**
 * Submit a bid (aka offer)
 * @param  array $bb_data The bid data
 * @param  array $auth    duh
 * @return boolean        success?
 */
function fn_submit_bids($bb_data,$auth){

	//TODO: Check is in vendor/admin and in vendor/admin area
	//FIXME: Need a cancel button
	if(empty($bb_data) || !is_array($bb_data)){
		return false;
	}else{
		if(!isset($bb_data['product_ids'])){
			fn_set_notification('E', __('error'), __('no_request_item_selected'));
			return false;
		}

		//Used to get the request_id
		parse_str($bb_data['redirect_url']);

		$request_item = db_get_row("SELECT title, max_price, allow_over_max_price, quantity FROM ?:bb_request_item INNER JOIN ?:bb_requests ON ?:bb_requests.request_item_id = ?:bb_request_item.bb_request_item_id WHERE ?:bb_requests.bb_request_id = ?i",$request_id);

		$currencies = Registry::get('currencies');
		$currency_symbol = $currencies[CART_PRIMARY_CURRENCY]['symbol'];

		foreach($bb_data['product_ids'] as $pid){
			// $price = $bb_data['products_data'][$pid]['price'] * $bb_data['products_data'][$pid]['amount'];
			$price = $bb_data['products_data'][$pid]['price'];
			$product_name = $bb_data['products_data'][$pid]['product'] ;
			$amount = $bb_data['products_data'][$pid]['amount'];
		}

		$mp = $request_item['max_price'];

		// Flag to be set to true if request price > allowed max price
		$over_max = false;

		fn_save_post_data();

		if($price > 0){
			if($price !== NULL && $request_item['max_price'] != 0){
				if($price > 0 && is_numeric($price) && $price != NULL){
					if($bb_data['products_data'][$pid]['amount'] > 0 && is_numeric($bb_data['products_data'][$pid]['amount']) && $bb_data['products_data'][$pid]['amount'] != NULL){
						$mp_plus_extra = $mp + MAX_PRICE_VARIATION*$mp;
						if($request_item['allow_over_max_price'] && ($price > ($mp_plus_extra))){
							// Check if bid price is over requested max by MAX_PRICE_VARIATION, indicated by "allow_over_max_price" flag
							$error_msg = __('bid_is_over_request_max').$currency_symbol.fn_format_price($mp_plus_extra).'. '.__('your_bid_amount').$currency_symbol.fn_format_price($price).'.';
						}elseif(!$request_item['allow_over_max_price'] && $price > $mp){
							// Check bid price is under or equal to request max
							$error_msg = __('bid_is_over_request_max').$currency_symbol.fn_format_price($mp).'. '.__('your_bid_amount').fn_format_price($mp);
						}elseif(stripos($request_item['title'],$product_name) === FALSE && stripos($product_name, $request_item['title']) === FALSE){
							// Throw name-not-matching error
							$error_msg = __('bid_name_matching_error');
						}elseif($amount > $request_item['quantity']){
							$error_msg = __('bid_quantity_more_than_requested');
						}
					}else{
						// Throw zero/negative price flag
						$error_msg = __('qty_cannot_be_zero');
					}
				}
			}elseif(!intval($request_item['max_price'])){
				// Do nothing (since users can choose to place a request without a max price)
			}elseif($request_item['expiry_date'] <= microtime(true)){
				$error_msg = __('auction_finished').'.';
			}else{
				// Throw non-numeric error
				// TODO: This is caught by javascript atm, not PHP but needs to return a value in case an invalid bid is POSTed
				$error_msg = __('error_occurred');
			}
		}elseif($bb_data['products_data'][$pid]['price'] <= 0){
			// TODO: This is caught by javascript atm, not PHP but needs to return a value in case an invalid bid is POSTed
			$error_msg = __('bid_price_cannot_be_zero');
		}

		if($error_msg != null && isset($error_msg)){
			fn_set_notification('E', __('error'), $error_msg);
			return false;
		}

		//Search for existing bid
		$existing_bid = db_get_row('SELECT *
			FROM ?:bb_bids
			WHERE ?:bb_bids.user_id = ?i AND ?:bb_bids.request_id = ?i',$auth['user_id'], $request_id
		);

		//Archive existing bid if exists
		if(!empty($existing_bid) || $existing_bid != NULL){
			db_query('DELETE FROM ?:bb_bids WHERE ?:bb_bids.bb_bid_id = ?i',$existing_bid['bb_bid_id']);
			//Delete from bids archive to prevent duplicates
			// Not used atm
			// db_query('DELETE FROM ?:bb_bids_archive WHERE ?:bb_bids_archive.user_id = ?i AND ?:bb_bids_archive.request_id = ?i',$auth['user_id'],$request_id);
			db_query('INSERT INTO ?:bb_bids_archive ?e',$existing_bid);
		}

		//Execute bid
		foreach($bb_data['product_ids'] as $product){
			foreach($bb_data['products_data'] as $pid=>$pdata){
				if($pid == $product){
					$product_data = $bb_data['products_data'][$pid];
					// We duplicate timestamp and ip here and in logs for faster reference at the cost of spending more resources when submitting an offer
					$new_bid = Array(
						'request_id' => $request_id,
						'price' => $pdata['price'],
						'user_id' => $auth['user_id'],
						'quantity' => $pdata['amount'],
						'product_id' => $product,
						'timestamp' => microtime(true),
						'ip' => $_SERVER['REMOTE_ADDR']
					);
					break;
				}
			}
		}
		db_query('INSERT INTO ?:bb_bids ?e',$new_bid);

		// Send an email to the request person
		$user = db_get_row("SELECT ?:users.* FROM ?:users INNER JOIN ?:bb_requests ON ?:bb_requests.user_id = ?:users.user_id WHERE bb_request_id = ?i",$new_bid['request_id']);
		$email_addr = $user['email'];
		$view_mail = Registry::get('view_mail');
		$view_mail->assign('subject',__('user_placed_bid'));
		$view_mail->assign('user',$user);
		$view_mail->assign('request_item',$request_item);
		$view_mail->assign('bid',$new_bid);
		$view_mail->assign('product',$product_data);
		$view_mail->assign('url',$_SERVER['HTTP_HOST'].fn_url('index.php?dispatch=billibuys.request&request_id='.$request_id));
		fn_send_mail($email_addr,Registry::get('settings.Company.company_users_department'),'addons/billibuys/bid_subj.tpl','addons/billibuys/bid_body.tpl','', Registry::get('settings.Appearance.admin_default_language'));
		//Log event
		fn_log_event('bb_bid', 'create', array('bid' => $new_bid));
		return true;
	}
}

/**
 * Gets all packages (for user if vendor, or all if just admin)
 * @param  Array $auth  The auth array, to use for checking status of user
 * @return Array        List of packages from database
 * DEPRECATED: Using packages addon
 */
function fn_get_packages($auth){

	// Variable initialisation
	$user = $auth['user'];
	$user_type = $auth['user_type'];

	// Set condition for filtering database query
	if($user_type == 'V'){
		$condition = 'user_id = '.$user;
	}else{
		$condition = '1';
	}

	// Get packages
	$data = db_get_array('SELECT * FROM ?:bb_product_packages WHERE ?s',$condition);

	return $data;
}

/**
 * Places a request for an item, so vendors can bid on the request
 * @param  int $user user_id of user that entered request
 * @param  string $post $_POST array
 */
function fn_submit_request($user, $post = ''){
	//Check that this function call is done after a post request
	if(!empty($post)){

		// DEPRECATED: Not needed as javascript sends back unix timestamp in seconds now
		// $expiry_date = strtotime($post['expiry_date']);

		//Do actual insertion of request item name
		//TODO: Return error messages for minimum and max string size
		$id = db_query('INSERT INTO ?:bb_request_item ?e', $post['request']);

		//Get last id of the requested item
		// $id = db_get_field('SELECT last_insert_id()');

		//Same as above, but for the ?:bb_request table
		$data = Array(
			'user_id' => $user,
			'request_item_id' => $id,
			'ip_address' => $_SERVER['REMOTE_ADDR'],
			'timestamp' => microtime(true),
			'expiry_date' => $post['request']['expiry_date'],
			// 'expiry_date' => $expiry_date + SECONDS_PER_DAY, // We want end of day
			'request_category_id' => $post['category'],
		);
		db_query('INSERT INTO ?:bb_requests ?e',$data);

		fn_attach_image_pairs('request_main','request',$id);

		fn_log_event('bb_request', 'create', array('request' => $data));

		//TODO: Body
		$data = db_get_array("SELECT user_id, notify_string FROM ?:bb_notifications WHERE notify_string LIKE ?s", $post['item_name']);
		if($data){
			$email_addr = db_get_field("SELECT email FROM ?:users WHERE user_id = ?i",$data[0]['user_id']);
			foreach($data as $d){
				$item[] = $d['notify_string'];
			}
			fn_send_mail($email_addr,'admin@billibuys.com','A user has placed a request for the item you have!','This is the body');
		}
	}
}

/**
 * Gets all requests that match a %product% search term
 * @author  bryanw
 * @version 1.0.0
 * @param   String    $product search term
 * @return  Array     ['Success'] true or false, error message if false and all matching results if true
 */
function fn_get_requests_by_product_name($product){

	// TODO: What if $product is empty?

	if($product)
		$product = '%'.$product.'%';
	else
		return Array(
			'success' => false,
			'message' => 'no_search_term'
		);
	
// TODO: Check against current date

	$requests = db_get_array(
		'SELECT * 
		FROM ?:bb_requests 
		INNER JOIN ?:bb_request_item ON 
			?:bb_request_item.bb_request_item_id = ?:bb_requests.request_item_id 
		LEFT OUTER JOIN ?:bb_bids ON
			?:bb_requests.bb_request_id = ?:bb_bids.request_id
		WHERE ?:bb_request_item.title LIKE ?l
		ORDER BY price DESC', $product
	);

	if(!empty($requests))
		$requests['success'] = true;
	else
		$requests = Array(
			'success' => false,
			'message' => 'bb_no_results_match_search'
		);
	return $requests;
}


function fn_get_request_by_order($user_id,$product_id){
	$data = db_get_row(
		"SELECT *
		FROM ?:bb_requests
		INNER JOIN ?:bb_bids ON ?:bb_bids.request_id = ?:bb_requests.bb_request_id
		WHERE ?:bb_requests.user_id = ?i AND ?:bb_bids.product_id = ?i
	",$user_id,$product_id);

	return $data;
}

/**
 * Gets details of a single request, based on request_id
 * @param  Array $params  Search parameters
 * @return Array          Array containing request details
 */
function fn_get_request($params){

	// Initialisation
	$params = array_merge(Array(
		'request_id' => 0
		),$params);

	// Filter by fields if field array was specified in $params
	if(isset($params['fields'])){
		$fields = implode($params['fields'],',');
	}else
		$fields = '*';

	$where = array(
		'bb_request_id' => $params['request_id'],
		);

	$data = db_get_row(
		"SELECT $fields
		FROM ?:bb_requests
		INNER JOIN ?:bb_request_item ON 
			?:bb_request_item.bb_request_item_id = ?:bb_requests.request_item_id 
		WHERE ?w
		GROUP BY ?:bb_request_item.bb_request_item_id
		", $where
		);

	return $data;
}

/**
 * Gets all auctions
 * @param  Array $params Array of search criteria
 * @return Array         Array of auction results from database
 * @todo Normalise database functions to work with fn_get_requests_by_product
 */
function fn_get_requests($params = Array()){


	// Initialization
	// DEPRECATED: Not used any more
	// $params = array_merge(Array(
	// 	'user' => 0,
	// 	'own_auctions' => false,
	// 	),$params);

	// FIXME: This is pretty damn insecure
	if(isset($params['category_id']) && is_int($params['category_id'])){
		$where .= 'request_category_id = '.$params['category_id'];
	}

	if(isset($params['current']) && $params['current']){
		if(isset($where))
			$where .= ' AND ';
		$where .= 'expiry_date > '.microtime(true);
	}

	if(isset($params['my_requests']) && $params['my_requests'] && $_SESSION['auth']['user_id']){
		if(isset($where))
			$where .= ' AND ';
		$where .= '?:bb_requests.user_id = '.$_SESSION['auth']['user_id'];
	}

	// Set default sort
	$sorting = 'timestamp DESC';

	$sortings = array(
		'date' => 'timestamp',
		'title' => 'title',
		'price' => 'max_price',
	);
	if(isset($params['sort_by'])){
		$sorting = $params['sort_by'];
		if(isset($params['sort_order']))
			$sort_order = $params['sort_order'];
		else
			$sort_order = 'DESC';
	}else{
		$sorting = 'timestamp';
		$sort_order = 'DESC';
	}

	$sorting .= ' '.$sort_order;

	$requests['success'] = false;
	if($params['own_auctions'] == false){

			// For pagination			
			$query = 'SELECT COUNT(*) 
				FROM ?:bb_requests 
				INNER JOIN ?:bb_request_item ON 
					?:bb_request_item.bb_request_item_id = ?:bb_requests.request_item_id';

			if(isset($where)){
				$query .= ' WHERE ?p';
			}
			$requests_count = db_get_field($query,$where);

			$limit = db_paginate($params['page'], Registry::get('settings.Appearance.products_per_page'), $requests_count); // FIXME: page

			// For actual querying
			$query = 'SELECT * 
				FROM ?:bb_requests 
				INNER JOIN ?:bb_request_item ON 
					?:bb_request_item.bb_request_item_id = ?:bb_requests.request_item_id';

			// Conditions
			if(isset($where)){
				$query .= ' WHERE ?p';
			}

			// Sorting
			if(isset($sorting) && !empty($sorting)){
				$query .= ' ORDER BY ?p';
			}

			// Pagination
			$query .= " $limit";

			$requests = array_merge(db_get_array($query,$where,$sorting),$requests);
			if(sizeof($requests) > 1 && $requests != null){
				foreach($requests as &$request){
					$request['lowest_bid'] = db_get_field('SELECT price * quantity FROM ?:bb_bids WHERE request_id = ?i AND active = "1" ORDER BY price ASC',$request['bb_request_item_id']);
				}
				$requests['success'] = true;
			}
			else{
				$requests['message'] = 'no_results';
			}
	}else{
		$user = $params['user'];
		if($user !== 0){
			// Get request by this user
			$requests = db_get_array(
				'SELECT * 
				FROM ?:bb_requests 
				INNER JOIN ?:bb_request_item ON 
					?:bb_request_item.bb_request_item_id = ?:bb_requests.request_item_id 
				WHERE user_id = ?i',$user
			);
			$requests['success'] = true;
		}else{
			// Return error message if user not logged in
			$requests = Array(
				'success' => false,
				'message' => 'user_not_logged_in'
			);
		}
	}

	return $requests;
}

/**
 * Gets categories given parameters, or gets all categories if no $params is given
 * @param  Array $params Contains fields and where conditions
 * @return Array         An array of categories that fulfils the conditions
 * @todo Need to add in where conditions
 */
function fn_bb_get_categories($params = Array()){
	// Set default variables
	$fields = "*";

	// Check params and replace default variables if params passes all checks
	if(!empty($params)){
		if(!empty($params['fields'])){
			$fields = implode(",",$params['fields']);
		}
	}

	// Get categories
	$categories = db_get_array("SELECT $fields
		FROM ?:bb_request_categories INNER JOIN ?:bb_request_category_descriptions ON ?:bb_request_categories.bb_request_category_id = ?:bb_request_category_descriptions.bb_request_category_id
		WHERE lang_code = ?s
		GROUP BY ?:bb_request_categories.bb_request_category_id
	",CART_LANGUAGE);

	foreach($categories as &$cat){
		$cat['level'] = substr_count($cat['id_path'],'/');
		$cat['position'] = ltrim($cat['position'],'0');
		$cat['product_count'] = fn_get_product_count($cat); // TODO: Normalise this to use it's own column like CS Cart does
		$cat['children_categories'] = 0;
		foreach($categories as $c){
			if($c['parent_category_id'] == $cat['bb_request_category_id']){
				$cat['children_categories']++;
			}
		}
	}

	return $categories;
}

// function fn_billibuys_get_product_data($product_id,$field_list,$join,$auth,$lang_code,$condition){
	// $join .= ' LEFT JOIN '
// }
// 
// function fn_billibuys_get_cart_product_data_post_options($product['product_id'],$_pdata,$product){
// 	die;
// }

/**
 * Gets product count by category
 * @param  Int $category The ID of the category we're looking for
 * @return Int           Number of products in this category
 */
function fn_get_product_count($category){
	$product_count = db_get_field("SELECT COUNT(*) FROM ?:bb_requests WHERE ?:bb_requests.request_category_id = ?i",$category['bb_request_category_id']);

	return $product_count;
}

function fn_bb_add_category($category_data,$auth){
	define(POSITION_INCREMENT,100);

	$_data = $category_data;

	if (isset($_data['position']) && empty($_data['position']) && $_data['position'] != '0' && isset($_data['parent_id'])) {
		$_data['position'] = db_get_field("SELECT max(position) FROM ?:bb_request_categories WHERE parent_id = ?i", $_data['parent_id']);
		$_data['position'] = $_data['position'] + 10;
	}

	if(strlen($_data['category_name']) > 50){
		fn_set_notification('E',__('error'),__('bb_name_too_long'));
		return false;
	}

	if(strlen($_data['category_description']) > 500){
		fn_set_notification('E',__('error'),__('bb_description_too_long'));
		return false;		
	}

	// Get highest value of category position and add 100 to that
	$_data['position'] = db_get_field("SELECT position FROM ?:bb_request_categories ORDER BY position DESC") + POSITION_INCREMENT;

	// create new category
	if (empty($category_id)) {
		$create = true;
		$category_id = db_query("INSERT INTO ?:bb_request_categories ?e", $_data);

		if (empty($category_id)) {
			return false;
		}

		// now we need to update 'id_path' field, as we know $category_id
		/* Generate id_path for category */
		$parent_id = intval($_data['parent_category_id']);
		if ($parent_id == 0) {
			$id_path = $category_id;
		} else {
			$id_path = db_get_row("SELECT id_path FROM ?:bb_request_categories WHERE bb_request_category_id = ?i", $parent_id);
			$id_path = $id_path['id_path'] . '/' . $category_id;
		}

		db_query('UPDATE ?:bb_request_categories SET ?u WHERE bb_request_category_id = ?i', array('id_path' => $id_path), $category_id);

		//
		// Adding same category descriptions for all cart languages
		//
		$_data['bb_request_category_id'] =	$category_id;

		foreach ((array)Registry::get('languages') as $_data['lang_code'] => $v) {
			db_query("INSERT INTO ?:bb_request_category_descriptions ?e", $_data);
		}

	// update existing category
	} else {

		/* regenerate id_path for all child categories of the updated category */
		if (isset($category_data['parent_id'])) {
			fn_change_category_parent($category_id, intval($category_data['parent_id']));
		}

		db_query("UPDATE ?:categories SET ?u WHERE category_id = ?i", $_data, $category_id);
		$_data = $category_data;
		db_query("UPDATE ?:category_descriptions SET ?u WHERE category_id = ?i AND lang_code = ?s", $_data, $category_id, $lang_code);
	}

	// Log category add/update
	fn_log_event('categories', !empty($create) ? 'create' : 'update', array(
		'category_id' => $category_id
	));
}

function fn_bb_get_category($category_id){
	$category = db_get_row("SELECT * FROM ?:bb_request_categories INNER JOIN ?:bb_request_category_descriptions ON ?:bb_request_category_descriptions.bb_request_category_id = ?:bb_request_categories.bb_request_category_id WHERE ?:bb_request_categories.bb_request_category_id = ?i",$category_id);
	return $category;
}
/**
 * Deletes category from categories, category_descriptions, does stuff to requests that are under this category - USE WITH CAUTION
 * @author bryanw
 * @param  int $category_id category id
 * @return none              
 */
function fn_bb_delete_category($category_id){
	$where = array("bb_request_category_id"=>$category_id);
	db_query("DELETE FROM ?:bb_request_categories WHERE ?w",$where);
	db_query("DELETE FROM ?:bb_request_category_descriptions WHERE ?w",$where);

	// What to do in the case of bids under this auction? Not allow deletion, revert to category id = 0 or Misc or what?
	 
	// Should this be an outright deletion for speed purposes or should it be archiving?
}

/**
 * Sorting functions allowable on the frontend
 * @return Array sorting array of sorting methods allowed
 */
function fn_get_requests_sorting()
{
	$sorting = array(
		'timestamp' => array('description' => __('date'), 'default_order' => 'desc'),
		'title' => array('description' => __('name'), 'default_order' => 'asc'),
		'max_price' => array('description' => __('max_price'), 'default_order' => 'asc'),
		'popularity' => array('description' => __('popularity'), 'default_order' => 'desc')
	);

	/**
	 * Change billibuys sortings
	 *
	 * @param array $sorting Sortings
	 * @param boolean $simple_mode Flag that defines if products sortings should be returned as simple titles list
	 */

	// foreach ($sorting as &$sort_item) {
	// 	$sort_item = $sort_item['description'];
	// }

	return $sorting;
}

function fn_get_offers_sorting(){
	$sorting = array(
		'timestamp' => array('description' => __('date'), 'default_order' => 'desc'),
		'title' => array('description' => __('name'), 'default_order' => 'asc'),
		'price' => array('description' => __('price'), 'default_order' => 'asc'),
		// 'popularity' => array('description' => __('popularity'), 'default_order' => 'desc')
	);

	return $sorting;
}

/**
 * Install objects required to log billibuys functions
 */
function fn_install_log_objects(){

	// Insert request log type

	$insert_data = Array(
		'name' => 'log_type_bb_request',
		'section_id' => 12,
		'section_tab_id' => 0,
		'type' => 'N',
		'value' => '#M#create=Y&delete=Y&update=Y',
		);
	$object_id = db_query("INSERT INTO ?:settings_objects ?e",$insert_data);

	// Create

	$insert_data = Array(
		'object_id' => $object_id,
		'name' => 'create',
	);
	$settings_variants_id = db_query("INSERT INTO ?:settings_variants ?e",$insert_data);

	$insert_data = Array(
		'object_id' => $settings_variants_id,
		'object_type' => 'V',
		'value' => 'Create',
	);
	db_query("INSERT INTO ?:settings_descriptions ?e",$insert_data);

	// Delete

	$insert_data = Array(
		'object_id' => $object_id,
		'name' => 'delete',
	);
	$settings_variants_id = db_query("INSERT INTO ?:settings_variants ?e",$insert_data);

	$insert_data = Array(
		'object_id' => $settings_variants_id,
		'object_type' => 'V',
		'value' => 'Delete',
	);
	db_query("INSERT INTO ?:settings_descriptions ?e",$insert_data);

	// Update
	
	$insert_data = Array(
		'object_id' => $object_id,
		'name' => 'update',
	);
	$settings_variants_id = db_query("INSERT INTO ?:settings_variants ?e",$insert_data);

	$insert_data = Array(
		'object_id' => $settings_variants_id,
		'object_type' => 'V',
		'value' => 'Update',
	);
	db_query("INSERT INTO ?:settings_descriptions ?e",$insert_data);

	// Description for log settings page
	$insert_data = Array(
		'object_id' => $object_id,
		'object_type' => 'O',
		'value' => 'Billibuys Request',
	);
	db_query('INSERT INTO ?:settings_descriptions ?e',$insert_data);

	// Insert bid offer type
	
	$insert_data = Array(
		'name' => 'log_type_bb_bid',
		'section_id' => 12,
		'section_tab_id' => 0,
		'type' => 'N',
		'value' => '#M#create=Y&delete=Y&update=Y',
		);
	$object_id = db_query("INSERT INTO ?:settings_objects ?e",$insert_data);

	// Create

	$insert_data = Array(
		'object_id' => $object_id,
		'name' => 'create',
	);
	$settings_variants_id = db_query("INSERT INTO ?:settings_variants ?e",$insert_data);

	$insert_data = Array(
		'object_id' => $settings_variants_id,
		'object_type' => 'V',
		'value' => 'Create',
	);
	db_query("INSERT INTO ?:settings_descriptions ?e",$insert_data);

	// Delete

	$insert_data = Array(
		'object_id' => $object_id,
		'name' => 'delete',
	);
	$settings_variants_id = db_query("INSERT INTO ?:settings_variants ?e",$insert_data);

	$insert_data = Array(
		'object_id' => $settings_variants_id,
		'object_type' => 'V',
		'value' => 'Delete',
	);
	db_query("INSERT INTO ?:settings_descriptions ?e",$insert_data);

	// Update
	
	$insert_data = Array(
		'object_id' => $object_id,
		'name' => 'update',
	);
	$settings_variants_id = db_query("INSERT INTO ?:settings_variants ?e",$insert_data);

	$insert_data = Array(
		'object_id' => $settings_variants_id,
		'object_type' => 'V',
		'value' => 'Update',
	);
	db_query("INSERT INTO ?:settings_descriptions ?e",$insert_data);
}

/**
 * Clear the billibuys log objects upon uninstall
 */
function fn_uninstall_log_objects(){
	// Delete the request objects
	$request_type = db_get_array("SELECT * FROM ?:settings_objects WHERE name LIKE ?s",'log_type_bb_request');
	foreach($request_type as $rtype){
		$settings = db_get_array("SELECT * FROM ?:settings_variants WHERE object_id = ?i",$rtype['object_id']);
		foreach($settings as $setting){
			db_query("DELETE FROM ?:settings_descriptions WHERE object_id = ?i",$setting['variant_id']);
			db_query("DELETE FROM ?:settings_variants WHERE variant_id = ?i",$setting['variant_id']);
		}
		db_query("DELETE FROM ?:settings_descriptions WHERE object_id = ?i",$rtype['object_id']);
	}

	// Delete the bid objects
	$request_type = db_get_array("SELECT * FROM ?:settings_objects WHERE name LIKE ?s",'log_type_bb_bid');
	foreach($request_type as $rtype){
		$settings = db_get_array("SELECT * FROM ?:settings_variants WHERE object_id = ?i",$rtype['object_id']);
		foreach($settings as $setting){
			db_query("DELETE FROM ?:settings_descriptions WHERE object_id = ?i",$setting['variant_id']);
			db_query("DELETE FROM ?:settings_variants WHERE variant_id = ?i",$setting['variant_id']);
		}
		db_query("DELETE FROM ?:settings_descriptions WHERE object_id = ?i",$rtype['object_id']);
	}
}

/**
 * Add/edit stars and ratings to users and products
 * @preconditions All data has been cleaned and verified by controller
 * @param  [Array] $params [Data to be set/type of setting (add/edit)]
 * @return [Array]         [True if successful, false and message if not]
 */
function fn_set_rating($params){
	
	$success = true;

	// Check if $params is an array and isn't empty
	if(is_array($params) && !empty($params)){
		if($params['type'] == 'U' || $params['type'] == 'A'){
			if($params['type'] == 'U'){
				db_query('UPDATE ?:bb_ratings SET ?u WHERE bb_rating_id = ?i',$params,$params['bb_rating_id']);
			}else{
				db_query('INSERT INTO ?:bb_ratings ?e',$params);
			}
		}else{
			$success = Array('success' => false,'message' => __('bb_error_invalid_input_params'));
		}
	}else{
		// Return false and error message
		$success = Array('success' => false, 'message' => __('bb_error_invalid_input_params'));
	}
	return $success;
}

function fn_get_unrated_items($user_id){

	// Set out the rating keys used in the database (note that this is manual, too lazy to do automatically)
	$rating_type_key = Array(
		'product'=>'p',
		'user'=>'u'
	);

	// String for filtering out products user has already rated
	$product_rating_query = db_quote('SELECT rating_type_id FROM ?:bb_ratings WHERE user_id = ?i AND rating_type = ?s',$user_id,$rating_type_key['product']);

	// String for filtering out users that user has already rated
	$user_rating_query = db_quote('SELECT rating_type_id FROM ?:bb_ratings WHERE user_id = ?i AND rating_type = ?s',$user_id,$rating_type_key['user']);

	// Get unrated products/users from orders
	// Company_id has a identity relationship with user_id and is equivalent so result has been renamed user_id
	$unrated_items = db_get_array("SELECT DISTINCT ?:orders.company_id AS user_id,?:order_details.product_id FROM ?:orders INNER JOIN ?:order_details ON ?:orders.order_id = ?:order_details.order_id WHERE ?:orders.user_id = ?i AND ?:order_details.product_id NOT IN (?a) AND ?:orders.company_id NOT IN (?a)",$user_id,$product_rating_query,$user_rating_query);

	return $unrated_items;
}

/**
 * Updates bids
 * @param  Int $bid_id bb_bid_id corresponding to ?:bb_bids table
 * @param  Array $data   Type: D for delete, U for update;
 * @return Boolean false if error
 */
function fn_update_bid($params){
	if(is_array($params)){
		$bid_id = $params['bid_id'];
		$bid_user_id = db_get_field("SELECT user_id FROM ?:bb_bids WHERE bb_bid_id = ?i",$bid_id);
		if($bid_user_id != $_SESSION['auth']['user_id']){
			return array('success'=>false,'message'=>__('bb_error_invalid_input_params'));
		}
		unset($params['bid_id']);
		if(isset($params['price']) && is_string($params['price'])){
			$params['price'] = trim($params['price']);
			if(preg_match('/(([1-9][0-9]{0,2}(,[0-9]{3})*)|[0-9]+)(\.[0-9]{1,2})?$/',$params['price'])){
				$price_setting = db_get_row("SELECT max_price,allow_over_max_price FROM ?:bb_request_item INNER JOIN ?:bb_requests ON ?:bb_requests.request_item_id = ?:bb_request_item.bb_request_item_id INNER JOIN ?:bb_bids ON ?:bb_bids.request_id = ?:bb_requests.bb_request_id WHERE bb_bid_id = ?i",$bid_id);
				$max_price = $price_setting['allow_over_max_price'] ? $price_setting['max_price'] * (1 + MAX_PRICE_VARIATION) : $price_setting['max_price'];
				if($params['price'] > $max_price){
					return array('success'=>false,'message'=>__('bid_is_over_request_max').$max_price);
				}elseif($params['price'] == 0){
					return array('success'=>false,'message'=>__('bid_price_cannot_be_zero'));
				}
			}else{
				return array('success'=>false,'message'=>__('bb_error_validator_price_format'));
			}
		}
		db_query("UPDATE ?:bb_bids SET ?u WHERE bb_bid_id = ?i",$params,$bid_id);
		return array('success'=>true);
	}else{
		return array('success'=>false,'message'=>__('bb_error_invalid_input_params'));
	}
}

?>