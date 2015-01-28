<?php

if ( !defined('AREA') ) { die('Access denied'); }

	fn_register_hooks(
		'order_placement_routines',
		'pre_add_to_cart',
		'post_add_to_cart',
		'clear_cart',
		'delete_cart_product',
		'get_cart_product_data',
		'update_profile',
		'save_session',
		'save_log'
	);

?>