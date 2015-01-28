<?php /* Smarty version Smarty-3.1.18, created on 2015-01-28 05:24:01
         compiled from "C:\wamp4\www\billibuys\design\backend\templates\addons\hybrid_auth\views\hybrid_auth\manage.tpl" */ ?>
<?php /*%%SmartyHeaderCode:207854c83a31bc7635-15765243%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd960e71de42fe17fa39f70e64a5e262b52d4b890' => 
    array (
      0 => 'C:\\wamp4\\www\\billibuys\\design\\backend\\templates\\addons\\hybrid_auth\\views\\hybrid_auth\\manage.tpl',
      1 => 1417044076,
      2 => 'tygh',
    ),
  ),
  'nocache_hash' => '207854c83a31bc7635-15765243',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'providers_list' => 0,
    'provider_data' => 0,
    'providers_schema' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54c83a31cd6f97_15557135',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54c83a31cd6f97_15557135')) {function content_54c83a31cd6f97_15557135($_smarty_tpl) {?><?php if (!is_callable('smarty_function_script')) include 'C:/wamp4/www/billibuys/app/functions/smarty_plugins\\function.script.php';
?><?php
fn_preload_lang_vars(array('hybrid_auth.editing_provider','no_items','hybrid_auth.new_provider','hybrid_auth.add_provider','hybrid_auth.providers'));
?>
<?php echo smarty_function_script(array('src'=>"js/tygh/tabs.js"),$_smarty_tpl);?>

<?php $_smarty_tpl->_capture_stack[0][] = array("mainbox", null, null); ob_start(); ?>
<form action="<?php echo htmlspecialchars(fn_url(''), ENT_QUOTES, 'UTF-8');?>
" method="post" name="hybrid_auth_form">

<div class="items-container cm-sortable" data-ca-sortable-table="hybrid_auth_providers" data-ca-sortable-id-name="provider_id" id="manage_providers_list">
<?php if ($_smarty_tpl->tpl_vars['providers_list']->value) {?>
<table class="table table-middle table-objects table-striped">
<?php  $_smarty_tpl->tpl_vars['provider_data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['provider_data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['providers_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['provider_data']->key => $_smarty_tpl->tpl_vars['provider_data']->value) {
$_smarty_tpl->tpl_vars['provider_data']->_loop = true;
?>
    <?php ob_start();?><?php echo $_smarty_tpl->__("hybrid_auth.editing_provider");?>
<?php $_tmp1=ob_get_clean();?><?php echo $_smarty_tpl->getSubTemplate ("common/object_group.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id'=>$_smarty_tpl->tpl_vars['provider_data']->value['provider_id'],'text'=>$_smarty_tpl->tpl_vars['providers_schema']->value[$_smarty_tpl->tpl_vars['provider_data']->value['provider']]['provider'],'href'=>"hybrid_auth.update?provider=".((string)$_smarty_tpl->tpl_vars['provider_data']->value['provider']),'href_delete'=>"hybrid_auth.delete_provider?provider=".((string)$_smarty_tpl->tpl_vars['provider_data']->value['provider']),'table'=>"hybrid_auth_providers",'object_id_name'=>"provider_id",'delete_target_id'=>"manage_providers_list,content_group_*",'status'=>$_smarty_tpl->tpl_vars['provider_data']->value['status'],'additional_class'=>"cm-sortable-row cm-sortable-id-".((string)$_smarty_tpl->tpl_vars['provider_data']->value['provider_id']),'no_table'=>true,'is_view_link'=>false,'header_text'=>$_tmp1.": ".((string)$_smarty_tpl->tpl_vars['providers_schema']->value[$_smarty_tpl->tpl_vars['provider_data']->value['provider']]['provider']),'draggable'=>true), 0);?>

<?php } ?>
</table>
<?php } else { ?>
    <p class="no-items"><?php echo $_smarty_tpl->__("no_items");?>
</p>
<?php }?>
<!--manage_providers_list--></div>
</form>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<?php $_smarty_tpl->_capture_stack[0][] = array("adv_buttons", null, null); ob_start(); ?>
    <?php $_smarty_tpl->_capture_stack[0][] = array("add_new_picker", null, null); ob_start(); ?>
        <?php echo $_smarty_tpl->getSubTemplate ("addons/hybrid_auth/views/hybrid_auth/update.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('provider_data'=>array()), 0);?>

    <?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

    <?php echo $_smarty_tpl->getSubTemplate ("common/popupbox.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('id'=>"add_new_provider",'text'=>__("hybrid_auth.new_provider"),'content'=>Smarty::$_smarty_vars['capture']['add_new_picker'],'title'=>__("hybrid_auth.add_provider"),'act'=>"general",'icon'=>"icon-plus"), 0);?>

<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?>

<?php echo $_smarty_tpl->getSubTemplate ("common/mainbox.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>__("hybrid_auth.providers"),'content'=>Smarty::$_smarty_vars['capture']['mainbox'],'adv_buttons'=>Smarty::$_smarty_vars['capture']['adv_buttons']), 0);?>
<?php }} ?>
