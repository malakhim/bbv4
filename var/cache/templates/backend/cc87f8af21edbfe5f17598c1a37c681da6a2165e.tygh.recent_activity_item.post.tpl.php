<?php /* Smarty version Smarty-3.1.18, created on 2015-01-24 06:42:34
         compiled from "C:\wamp4\www\billibuys\design\backend\templates\addons\news_and_emails\hooks\index\recent_activity_item.post.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1362654c3069a66b903-83748608%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cc87f8af21edbfe5f17598c1a37c681da6a2165e' => 
    array (
      0 => 'C:\\wamp4\\www\\billibuys\\design\\backend\\templates\\addons\\news_and_emails\\hooks\\index\\recent_activity_item.post.tpl',
      1 => 1417044076,
      2 => 'tygh',
    ),
  ),
  'nocache_hash' => '1362654c3069a66b903-83748608',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54c3069a6ee9c2_53638240',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54c3069a6ee9c2_53638240')) {function content_54c3069a6ee9c2_53638240($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['item']->value['type']=="news") {?>
    <a href="<?php echo htmlspecialchars(fn_url("news.update?news_id=".((string)$_smarty_tpl->tpl_vars['item']->value['content']['id'])), ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['item']->value['content']['news'], ENT_QUOTES, 'UTF-8');?>
</a><br>                        
<?php }?><?php }} ?>
