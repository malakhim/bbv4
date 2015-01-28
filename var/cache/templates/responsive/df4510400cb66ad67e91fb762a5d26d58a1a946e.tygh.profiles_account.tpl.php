<?php /* Smarty version Smarty-3.1.18, created on 2015-01-28 05:20:50
         compiled from "C:\wamp4\www\billibuys\design\themes\responsive\templates\views\profiles\components\profiles_account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:201454c83972777e65-04451455%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'df4510400cb66ad67e91fb762a5d26d58a1a946e' => 
    array (
      0 => 'C:\\wamp4\\www\\billibuys\\design\\themes\\responsive\\templates\\views\\profiles\\components\\profiles_account.tpl',
      1 => 1422067241,
      2 => 'tygh',
    ),
  ),
  'nocache_hash' => '201454c83972777e65-04451455',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'runtime' => 0,
    'nothing_extra' => 0,
    'settings' => 0,
    'user_data' => 0,
    'auth' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54c839728e6277_57696430',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54c839728e6277_57696430')) {function content_54c839728e6277_57696430($_smarty_tpl) {?><?php if (!is_callable('smarty_block_hook')) include 'C:/wamp4/www/billibuys/app/functions/smarty_plugins\\block.hook.php';
if (!is_callable('smarty_function_set_id')) include 'C:/wamp4/www/billibuys/app/functions/smarty_plugins\\function.set_id.php';
?><?php
fn_preload_lang_vars(array('user_account_info','username','email','password','confirm_password','user_account_info','username','email','password','confirm_password'));
?>
<?php if ($_smarty_tpl->tpl_vars['runtime']->value['customization_mode']['design']=="Y"&&@constant('AREA')=="C") {?><?php $_smarty_tpl->_capture_stack[0][] = array("template_content", null, null); ob_start(); ?><?php if (!$_smarty_tpl->tpl_vars['nothing_extra']->value) {?>
    <?php echo $_smarty_tpl->getSubTemplate ("common/subheader.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>__("user_account_info")), 0);?>

<?php }?>

<?php $_smarty_tpl->smarty->_tag_stack[] = array('hook', array('name'=>"profiles:account_info")); $_block_repeat=true; echo smarty_block_hook(array('name'=>"profiles:account_info"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

    <?php if ($_smarty_tpl->tpl_vars['settings']->value['General']['use_email_as_login']!="Y") {?>
        <div class="ty-control-group">
            <label for="user_login_profile" class="ty-control-group__title cm-required cm-trim"><?php echo $_smarty_tpl->__("username");?>
</label>
            <input id="user_login_profile" type="text" name="user_data[user_login]" size="32" maxlength="32" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['user_data']->value['user_login'], ENT_QUOTES, 'UTF-8');?>
" class="ty-input-text" />
        </div>
    <?php }?>

    <?php if ($_smarty_tpl->tpl_vars['settings']->value['General']['use_email_as_login']=="Y"||$_smarty_tpl->tpl_vars['nothing_extra']->value||$_smarty_tpl->tpl_vars['runtime']->value['checkout']) {?>
        <div class="ty-control-group">
            <label for="email" class="ty-control-group__title cm-required cm-email cm-trim"><?php echo $_smarty_tpl->__("email");?>
</label>
            <input type="text" id="email" name="user_data[email]" size="32" maxlength="128" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['user_data']->value['email'], ENT_QUOTES, 'UTF-8');?>
" class="ty-input-text" />
        </div>
    <?php }?>

    <div class="ty-control-group">
        <label for="password1" class="ty-control-group__title cm-required cm-password"><?php echo $_smarty_tpl->__("password");?>
</label>
        <input type="password" id="password1" name="user_data[password1]" size="32" maxlength="32" value="<?php if ($_smarty_tpl->tpl_vars['runtime']->value['mode']=="update") {?>            <?php }?>" class="ty-input-text cm-autocomplete-off" />
    </div>

    <div class="ty-control-group">
        <label for="password2" class="ty-control-group__title cm-required cm-password"><?php echo $_smarty_tpl->__("confirm_password");?>
</label>
        <input type="password" id="password2" name="user_data[password2]" size="32" maxlength="32" value="<?php if ($_smarty_tpl->tpl_vars['runtime']->value['mode']=="update") {?>            <?php }?>" class="ty-input-text cm-autocomplete-off" />
    </div>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_hook(array('name'=>"profiles:account_info"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><?php if (trim(Smarty::$_smarty_vars['capture']['template_content'])) {?><?php if ($_smarty_tpl->tpl_vars['auth']->value['area']=="A") {?><span class="cm-template-box template-box" data-ca-te-template="views/profiles/components/profiles_account.tpl" id="<?php echo smarty_function_set_id(array('name'=>"views/profiles/components/profiles_account.tpl"),$_smarty_tpl);?>
"><div class="cm-template-icon icon-edit ty-icon-edit hidden"></div><?php echo Smarty::$_smarty_vars['capture']['template_content'];?>
<!--[/tpl_id]--></span><?php } else { ?><?php echo Smarty::$_smarty_vars['capture']['template_content'];?>
<?php }?><?php }?><?php } else { ?><?php if (!$_smarty_tpl->tpl_vars['nothing_extra']->value) {?>
    <?php echo $_smarty_tpl->getSubTemplate ("common/subheader.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('title'=>__("user_account_info")), 0);?>

<?php }?>

<?php $_smarty_tpl->smarty->_tag_stack[] = array('hook', array('name'=>"profiles:account_info")); $_block_repeat=true; echo smarty_block_hook(array('name'=>"profiles:account_info"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

    <?php if ($_smarty_tpl->tpl_vars['settings']->value['General']['use_email_as_login']!="Y") {?>
        <div class="ty-control-group">
            <label for="user_login_profile" class="ty-control-group__title cm-required cm-trim"><?php echo $_smarty_tpl->__("username");?>
</label>
            <input id="user_login_profile" type="text" name="user_data[user_login]" size="32" maxlength="32" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['user_data']->value['user_login'], ENT_QUOTES, 'UTF-8');?>
" class="ty-input-text" />
        </div>
    <?php }?>

    <?php if ($_smarty_tpl->tpl_vars['settings']->value['General']['use_email_as_login']=="Y"||$_smarty_tpl->tpl_vars['nothing_extra']->value||$_smarty_tpl->tpl_vars['runtime']->value['checkout']) {?>
        <div class="ty-control-group">
            <label for="email" class="ty-control-group__title cm-required cm-email cm-trim"><?php echo $_smarty_tpl->__("email");?>
</label>
            <input type="text" id="email" name="user_data[email]" size="32" maxlength="128" value="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['user_data']->value['email'], ENT_QUOTES, 'UTF-8');?>
" class="ty-input-text" />
        </div>
    <?php }?>

    <div class="ty-control-group">
        <label for="password1" class="ty-control-group__title cm-required cm-password"><?php echo $_smarty_tpl->__("password");?>
</label>
        <input type="password" id="password1" name="user_data[password1]" size="32" maxlength="32" value="<?php if ($_smarty_tpl->tpl_vars['runtime']->value['mode']=="update") {?>            <?php }?>" class="ty-input-text cm-autocomplete-off" />
    </div>

    <div class="ty-control-group">
        <label for="password2" class="ty-control-group__title cm-required cm-password"><?php echo $_smarty_tpl->__("confirm_password");?>
</label>
        <input type="password" id="password2" name="user_data[password2]" size="32" maxlength="32" value="<?php if ($_smarty_tpl->tpl_vars['runtime']->value['mode']=="update") {?>            <?php }?>" class="ty-input-text cm-autocomplete-off" />
    </div>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_hook(array('name'=>"profiles:account_info"), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php }?><?php }} ?>
