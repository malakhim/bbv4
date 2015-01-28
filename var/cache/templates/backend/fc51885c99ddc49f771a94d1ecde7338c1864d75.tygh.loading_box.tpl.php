<?php /* Smarty version Smarty-3.1.18, created on 2015-01-24 06:41:06
         compiled from "C:\wamp4\www\billibuys\design\backend\templates\common\loading_box.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2209154c3064231ad89-87730408%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fc51885c99ddc49f771a94d1ecde7338c1864d75' => 
    array (
      0 => 'C:\\wamp4\\www\\billibuys\\design\\backend\\templates\\common\\loading_box.tpl',
      1 => 1417044076,
      2 => 'tygh',
    ),
  ),
  'nocache_hash' => '2209154c3064231ad89-87730408',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54c30642323118_36773347',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54c30642323118_36773347')) {function content_54c30642323118_36773347($_smarty_tpl) {?><?php
fn_preload_lang_vars(array('loading'));
?>
<div id="ajax_overlay" class="ajax-overlay"></div>
<div id="ajax_loading_box" class="hidden ajax-loading-box">
    <strong><?php echo $_smarty_tpl->__("loading");?>
</strong>
</div>
<?php }} ?>
