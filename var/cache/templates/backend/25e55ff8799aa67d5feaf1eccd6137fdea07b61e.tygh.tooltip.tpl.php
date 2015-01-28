<?php /* Smarty version Smarty-3.1.18, created on 2015-01-24 06:42:09
         compiled from "C:\wamp4\www\billibuys\design\backend\templates\common\tooltip.tpl" */ ?>
<?php /*%%SmartyHeaderCode:107054c30681a424d8-88421909%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '25e55ff8799aa67d5feaf1eccd6137fdea07b61e' => 
    array (
      0 => 'C:\\wamp4\\www\\billibuys\\design\\backend\\templates\\common\\tooltip.tpl',
      1 => 1417044076,
      2 => 'tygh',
    ),
  ),
  'nocache_hash' => '107054c30681a424d8-88421909',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tooltip' => 0,
    'params' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54c30681a5f920_39983301',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54c30681a5f920_39983301')) {function content_54c30681a5f920_39983301($_smarty_tpl) {?>&nbsp;<?php if ($_smarty_tpl->tpl_vars['tooltip']->value) {?><a class="cm-tooltip<?php if ($_smarty_tpl->tpl_vars['params']->value) {?> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['params']->value, ENT_QUOTES, 'UTF-8');?>
<?php }?>" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['tooltip']->value, ENT_QUOTES, 'UTF-8');?>
"><i class="icon-question-sign"></i></a><?php }?><?php }} ?>
