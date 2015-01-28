<?php /* Smarty version Smarty-3.1.18, created on 2015-01-28 05:26:20
         compiled from "C:\wamp4\www\billibuys\design\themes\responsive\templates\addons\hybrid_auth\views\auth\login_error.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3189954c83abcc7c222-69898563%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ad0d3f20e61f52082200c7dc3713cd087adccf88' => 
    array (
      0 => 'C:\\wamp4\\www\\billibuys\\design\\themes\\responsive\\templates\\addons\\hybrid_auth\\views\\auth\\login_error.tpl',
      1 => 1422067249,
      2 => 'tygh',
    ),
  ),
  'nocache_hash' => '3189954c83abcc7c222-69898563',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'runtime' => 0,
    'redirect_url' => 0,
    'auth' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54c83abcd266b5_78431958',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54c83abcd266b5_78431958')) {function content_54c83abcd266b5_78431958($_smarty_tpl) {?><?php if (!is_callable('smarty_function_set_id')) include 'C:/wamp4/www/billibuys/app/functions/smarty_plugins\\function.set_id.php';
?><?php if ($_smarty_tpl->tpl_vars['runtime']->value['customization_mode']['design']=="Y"&&@constant('AREA')=="C") {?><?php $_smarty_tpl->_capture_stack[0][] = array("template_content", null, null); ob_start(); ?><script type="text/javascript">

    <?php if ($_smarty_tpl->tpl_vars['redirect_url']->value) {?>
        var url = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['redirect_url']->value, ENT_QUOTES, 'UTF-8');?>
';
        opener.location.href = url.replace(/\&amp;/g,'&');
    <?php } else { ?>
        opener.location.reload();
    <?php }?>

    close();

</script><?php list($_capture_buffer, $_capture_assign, $_capture_append) = array_pop($_smarty_tpl->_capture_stack[0]);
if (!empty($_capture_buffer)) {
 if (isset($_capture_assign)) $_smarty_tpl->assign($_capture_assign, ob_get_contents());
 if (isset( $_capture_append)) $_smarty_tpl->append( $_capture_append, ob_get_contents());
 Smarty::$_smarty_vars['capture'][$_capture_buffer]=ob_get_clean();
} else $_smarty_tpl->capture_error();?><?php if (trim(Smarty::$_smarty_vars['capture']['template_content'])) {?><?php if ($_smarty_tpl->tpl_vars['auth']->value['area']=="A") {?><span class="cm-template-box template-box" data-ca-te-template="addons/hybrid_auth/views/auth/login_error.tpl" id="<?php echo smarty_function_set_id(array('name'=>"addons/hybrid_auth/views/auth/login_error.tpl"),$_smarty_tpl);?>
"><div class="cm-template-icon icon-edit ty-icon-edit hidden"></div><?php echo Smarty::$_smarty_vars['capture']['template_content'];?>
<!--[/tpl_id]--></span><?php } else { ?><?php echo Smarty::$_smarty_vars['capture']['template_content'];?>
<?php }?><?php }?><?php } else { ?><script type="text/javascript">

    <?php if ($_smarty_tpl->tpl_vars['redirect_url']->value) {?>
        var url = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['redirect_url']->value, ENT_QUOTES, 'UTF-8');?>
';
        opener.location.href = url.replace(/\&amp;/g,'&');
    <?php } else { ?>
        opener.location.reload();
    <?php }?>

    close();

</script><?php }?><?php }} ?>
