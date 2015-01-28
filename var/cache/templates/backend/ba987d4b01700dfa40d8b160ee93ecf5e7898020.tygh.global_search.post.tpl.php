<?php /* Smarty version Smarty-3.1.18, created on 2015-01-24 06:41:09
         compiled from "C:\wamp4\www\billibuys\design\backend\templates\addons\twigmo\hooks\index\global_search.post.tpl" */ ?>
<?php /*%%SmartyHeaderCode:522854c306450e7cb4-01674937%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ba987d4b01700dfa40d8b160ee93ecf5e7898020' => 
    array (
      0 => 'C:\\wamp4\\www\\billibuys\\design\\backend\\templates\\addons\\twigmo\\hooks\\index\\global_search.post.tpl',
      1 => 1417044084,
      2 => 'tygh',
    ),
  ),
  'nocache_hash' => '522854c306450e7cb4-01674937',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'runtime' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54c30645109cb1_89206974',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54c30645109cb1_89206974')) {function content_54c30645109cb1_89206974($_smarty_tpl) {?><?php
fn_preload_lang_vars(array('twgadmin_mobile_app'));
?>
<?php if ($_smarty_tpl->tpl_vars['runtime']->value['twigmo']['admin_connection']['access_id']) {?>

    <div class="twg-mobile-app-link">
        <a href="<?php echo htmlspecialchars(fn_url("twigmo_admin_app.view"), ENT_QUOTES, 'UTF-8');?>
"><?php echo $_smarty_tpl->__("twgadmin_mobile_app");?>
</a>
    </div>

    <script type="text/javascript">
        (function(_, $) {
            $(document).ready(function() {
                $('div.twg-mobile-app-link').detach().insertBefore('ul.nav.hover-show.nav-pills').show();
            });
        }(Tygh, Tygh.$));
    </script>

<?php }?><?php }} ?>
