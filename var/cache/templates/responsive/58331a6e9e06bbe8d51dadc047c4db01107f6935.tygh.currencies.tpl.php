<?php /* Smarty version Smarty-3.1.18, created on 2015-01-24 06:46:06
         compiled from "C:\wamp4\www\billibuys\design\themes\responsive\templates\blocks\currencies.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2519954c3076e1dcdc6-30083885%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '58331a6e9e06bbe8d51dadc047c4db01107f6935' => 
    array (
      0 => 'C:\\wamp4\\www\\billibuys\\design\\themes\\responsive\\templates\\blocks\\currencies.tpl',
      1 => 1422067241,
      2 => 'tygh',
    ),
  ),
  'nocache_hash' => '2519954c3076e1dcdc6-30083885',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'runtime' => 0,
    'block' => 0,
    'currencies' => 0,
    'dropdown_limit' => 0,
    'text' => 0,
    'config' => 0,
    'code' => 0,
    'secondary_currency' => 0,
    'format' => 0,
    'currency' => 0,
    'key_name' => 0,
    'auth' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54c3076e3e3432_87542873',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54c3076e3e3432_87542873')) {function content_54c3076e3e3432_87542873($_smarty_tpl) {?><?php if (!is_callable('smarty_function_set_id')) include 'C:/wamp4/www/billibuys/app/functions/smarty_plugins\\function.set_id.php';
?><?php if ($_smarty_tpl->tpl_vars['runtime']->value['customization_mode']['design']=="Y"&&@constant('AREA')=="C") {?><?php $_smarty_tpl->_capture_stack[0][] = array("template_content", null, null); ob_start(); ?><div id="currencies_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['block']->value['block_id'], ENT_QUOTES, 'UTF-8');?>
">

<?php if ($_smarty_tpl->tpl_vars['currencies']->value&&count($_smarty_tpl->tpl_vars['currencies']->value)>1) {?>
    <?php if ($_smarty_tpl->tpl_vars['dropdown_limit']->value>0&&count($_smarty_tpl->tpl_vars['currencies']->value)<=$_smarty_tpl->tpl_vars['dropdown_limit']->value) {?>
        <div class="ty-currencies hidden-phone hidden-tablet">
            <?php if ($_smarty_tpl->tpl_vars['text']->value) {?><div class="ty-currencies__txt"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['text']->value, ENT_QUOTES, 'UTF-8');?>
:</div><?php }?>
            <?php  $_smarty_tpl->tpl_vars['currency'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['currency']->_loop = false;
 $_smarty_tpl->tpl_vars['code'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['currencies']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['currency']->key => $_smarty_tpl->tpl_vars['currency']->value) {
$_smarty_tpl->tpl_vars['currency']->_loop = true;
 $_smarty_tpl->tpl_vars['code']->value = $_smarty_tpl->tpl_vars['currency']->key;
?>
                <a href="<?php echo htmlspecialchars(fn_url(fn_link_attach($_smarty_tpl->tpl_vars['config']->value['current_url'],"currency=".((string)$_smarty_tpl->tpl_vars['code']->value))), ENT_QUOTES, 'UTF-8');?>
" class="ty-currencies__item <?php if ($_smarty_tpl->tpl_vars['secondary_currency']->value==$_smarty_tpl->tpl_vars['code']->value) {?>ty-currencies__active<?php }?>"><?php if ($_smarty_tpl->tpl_vars['format']->value=="name") {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value['description'], ENT_QUOTES, 'UTF-8');?>
&nbsp;(<?php echo $_smarty_tpl->tpl_vars['currency']->value['symbol'];?>
)<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['currency']->value['symbol'];?>
<?php }?></a>
            <?php } ?>
        </div>
        <div class="visible-phone visible-tablet ty-select-wrapper"><?php echo $_smarty_tpl->getSubTemplate ("common/select_object.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('style'=>"graphic",'suffix'=>"currency",'link_tpl'=>fn_link_attach($_smarty_tpl->tpl_vars['config']->value['current_url'],"currency="),'items'=>$_smarty_tpl->tpl_vars['currencies']->value,'selected_id'=>$_smarty_tpl->tpl_vars['secondary_currency']->value,'display_icons'=>false,'key_name'=>$_smarty_tpl->tpl_vars['key_name']->value), 0);?>
</div>
    <?php } else { ?>
        <?php if ($_smarty_tpl->tpl_vars['format']->value=="name") {?>
            <?php $_smarty_tpl->tpl_vars["key_name"] = new Smarty_variable("description", null, 0);?>
        <?php } else { ?>
            <?php $_smarty_tpl->tpl_vars["key_name"] = new Smarty_variable('', null, 0);?>
        <?php }?>
        <div class="ty-select-wrapper"><?php echo $_smarty_tpl->getSubTemplate ("common/select_object.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('style'=>"graphic",'suffix'=>"currency",'link_tpl'=>fn_link_attach($_smarty_tpl->tpl_vars['config']->value['current_url'],"currency="),'items'=>$_smarty_tpl->tpl_vars['currencies']->value,'selected_id'=>$_smarty_tpl->tpl_vars['secondary_currency']->value,'display_icons'=>false,'key_name'=>$_smarty_tpl->tpl_vars['key_name']->value), 0);?>
</div>
    <?php }?>
<?php }?>

<!--currencies_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['block']->value['block_id'], ENT_QUOTES, 'UTF-8');?>
--></div>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><?php if (trim(Smarty::$_smarty_vars['capture']['template_content'])) {?><?php if ($_smarty_tpl->tpl_vars['auth']->value['area']=="A") {?><span class="cm-template-box template-box" data-ca-te-template="blocks/currencies.tpl" id="<?php echo smarty_function_set_id(array('name'=>"blocks/currencies.tpl"),$_smarty_tpl);?>
"><div class="cm-template-icon icon-edit ty-icon-edit hidden"></div><?php echo Smarty::$_smarty_vars['capture']['template_content'];?>
<!--[/tpl_id]--></span><?php } else { ?><?php echo Smarty::$_smarty_vars['capture']['template_content'];?>
<?php }?><?php }?><?php } else { ?><div id="currencies_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['block']->value['block_id'], ENT_QUOTES, 'UTF-8');?>
">

<?php if ($_smarty_tpl->tpl_vars['currencies']->value&&count($_smarty_tpl->tpl_vars['currencies']->value)>1) {?>
    <?php if ($_smarty_tpl->tpl_vars['dropdown_limit']->value>0&&count($_smarty_tpl->tpl_vars['currencies']->value)<=$_smarty_tpl->tpl_vars['dropdown_limit']->value) {?>
        <div class="ty-currencies hidden-phone hidden-tablet">
            <?php if ($_smarty_tpl->tpl_vars['text']->value) {?><div class="ty-currencies__txt"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['text']->value, ENT_QUOTES, 'UTF-8');?>
:</div><?php }?>
            <?php  $_smarty_tpl->tpl_vars['currency'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['currency']->_loop = false;
 $_smarty_tpl->tpl_vars['code'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['currencies']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['currency']->key => $_smarty_tpl->tpl_vars['currency']->value) {
$_smarty_tpl->tpl_vars['currency']->_loop = true;
 $_smarty_tpl->tpl_vars['code']->value = $_smarty_tpl->tpl_vars['currency']->key;
?>
                <a href="<?php echo htmlspecialchars(fn_url(fn_link_attach($_smarty_tpl->tpl_vars['config']->value['current_url'],"currency=".((string)$_smarty_tpl->tpl_vars['code']->value))), ENT_QUOTES, 'UTF-8');?>
" class="ty-currencies__item <?php if ($_smarty_tpl->tpl_vars['secondary_currency']->value==$_smarty_tpl->tpl_vars['code']->value) {?>ty-currencies__active<?php }?>"><?php if ($_smarty_tpl->tpl_vars['format']->value=="name") {?><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['currency']->value['description'], ENT_QUOTES, 'UTF-8');?>
&nbsp;(<?php echo $_smarty_tpl->tpl_vars['currency']->value['symbol'];?>
)<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['currency']->value['symbol'];?>
<?php }?></a>
            <?php } ?>
        </div>
        <div class="visible-phone visible-tablet ty-select-wrapper"><?php echo $_smarty_tpl->getSubTemplate ("common/select_object.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('style'=>"graphic",'suffix'=>"currency",'link_tpl'=>fn_link_attach($_smarty_tpl->tpl_vars['config']->value['current_url'],"currency="),'items'=>$_smarty_tpl->tpl_vars['currencies']->value,'selected_id'=>$_smarty_tpl->tpl_vars['secondary_currency']->value,'display_icons'=>false,'key_name'=>$_smarty_tpl->tpl_vars['key_name']->value), 0);?>
</div>
    <?php } else { ?>
        <?php if ($_smarty_tpl->tpl_vars['format']->value=="name") {?>
            <?php $_smarty_tpl->tpl_vars["key_name"] = new Smarty_variable("description", null, 0);?>
        <?php } else { ?>
            <?php $_smarty_tpl->tpl_vars["key_name"] = new Smarty_variable('', null, 0);?>
        <?php }?>
        <div class="ty-select-wrapper"><?php echo $_smarty_tpl->getSubTemplate ("common/select_object.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('style'=>"graphic",'suffix'=>"currency",'link_tpl'=>fn_link_attach($_smarty_tpl->tpl_vars['config']->value['current_url'],"currency="),'items'=>$_smarty_tpl->tpl_vars['currencies']->value,'selected_id'=>$_smarty_tpl->tpl_vars['secondary_currency']->value,'display_icons'=>false,'key_name'=>$_smarty_tpl->tpl_vars['key_name']->value), 0);?>
</div>
    <?php }?>
<?php }?>

<!--currencies_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['block']->value['block_id'], ENT_QUOTES, 'UTF-8');?>
--></div>
<?php }?><?php }} ?>
