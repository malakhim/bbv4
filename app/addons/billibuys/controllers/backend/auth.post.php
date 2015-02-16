<?php

if($mode == 'logout'){
	fn_redirect('/index.php');
}elseif($mode == 'login_form'){
	if(strpos($_SERVER['PHP_SELF'],'/admin.php') === FALSE && $_SESSION['auth']['user_id'] == 0){
		// $url_str = parse_url($_REQUEST['return_url']);
		// parse_str($url_str['query'],$params);
		// if(strpos($params['dispatch'],'billibuys.place_bid') !== FALSE){
			// $return_url = "/index.php?dispatch=billibuys.request&request_id=$params[request_id]&place_bid_redirect=1";
			$return_url = "/index.php?dispatch=billibuys.sso&redirect=".urlencode($_REQUEST['return_url']);
		// }else{
			// $return_url = $_REQUEST['return_url'];
		// }
		fn_redirect('/index.php?dispatch=auth.login_form&return_url='.urlencode($return_url));
		
	}
}

?>