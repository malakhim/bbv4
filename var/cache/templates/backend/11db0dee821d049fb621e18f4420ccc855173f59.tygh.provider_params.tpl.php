<?php /* Smarty version Smarty-3.1.18, created on 2015-01-28 05:24:01
         compiled from "C:\wamp4\www\billibuys\design\backend\templates\addons\hybrid_auth\views\hybrid_auth\provider_params.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2792554c83a31e04483-29491544%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '11db0dee821d049fb621e18f4420ccc855173f59' => 
    array (
      0 => 'C:\\wamp4\\www\\billibuys\\design\\backend\\templates\\addons\\hybrid_auth\\views\\hybrid_auth\\provider_params.tpl',
      1 => 1417044076,
      2 => 'tygh',
    ),
  ),
  'nocache_hash' => '2792554c83a31e04483-29491544',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'id' => 0,
    'provider' => 0,
    'providers_schema' => 0,
    'param' => 0,
    'param_id' => 0,
    'provider_data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54c83a31f15c50_57886414',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54c83a31f15c50_57886414')) {function content_54c83a31f15c50_57886414($_smarty_tpl) {?><div id="content_params_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
">

    <?php  $_smarty_tpl->tpl_vars["param"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["param"]->_loop = false;
 $_smarty_tpl->tpl_vars["param_id"] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['providers_schema']->value[$_smarty_tpl->tpl_vars['provider']->value]['params']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars["param"]->key => $_smarty_tpl->tpl_vars["param"]->value) {
$_smarty_tpl->tpl_vars["param"]->_loop = true;
 $_smarty_tpl->tpl_vars["param_id"]->value = $_smarty_tpl->tpl_vars["param"]->key;
?>
        <?php if ($_smarty_tpl->tpl_vars['param']->value['type']=='input') {?>
            <div class="control-group">
                <label for="section_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param_id']->value, ENT_QUOTES, 'UTF-8');?>
_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" class="control-label<?php if ($_smarty_tpl->tpl_vars['param']->value['required']) {?> cm-required<?php }?>"><?php echo $_smarty_tpl->__($_smarty_tpl->tpl_vars['param']->value['label']);?>
:</label>
                <div class="controls">
                    <input type="text" name="provider_data[params][<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param_id']->value, ENT_QUOTES, 'UTF-8');?>
]" size="30" value="<?php echo htmlspecialchars((($tmp = @$_smarty_tpl->tpl_vars['provider_data']->value['params'][$_smarty_tpl->tpl_vars['param_id']->value])===null||$tmp==='' ? $_smarty_tpl->tpl_vars['param']->value['default'] : $tmp), ENT_QUOTES, 'UTF-8');?>
" id="section_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param_id']->value, ENT_QUOTES, 'UTF-8');?>
_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
">
                </div>
            </div>

        <?php } elseif ($_smarty_tpl->tpl_vars['param']->value['type']=='checkbox') {?>
            <div class="control-group">
                <label for="section_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param_id']->value, ENT_QUOTES, 'UTF-8');?>
_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
" class="control-label<?php if ($_smarty_tpl->tpl_vars['param']->value['required']) {?> cm-required<?php }?>"><?php echo $_smarty_tpl->__($_smarty_tpl->tpl_vars['param']->value['label']);?>
:</label>
                <div class="controls">
                    <input type="hidden" name="provider_data[params][<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param_id']->value, ENT_QUOTES, 'UTF-8');?>
]" value="N" />
                    <input type="checkbox" name="provider_data[params][<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param_id']->value, ENT_QUOTES, 'UTF-8');?>
]" value="Y" id="section_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['param_id']->value, ENT_QUOTES, 'UTF-8');?>
_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
"
                        <?php if ((!isset($_smarty_tpl->tpl_vars['provider_data']->value['params'][$_smarty_tpl->tpl_vars['param_id']->value])&&$_smarty_tpl->tpl_vars['param']->value['default']=='Y')||(isset($_smarty_tpl->tpl_vars['provider_data']->value['params'][$_smarty_tpl->tpl_vars['param_id']->value])&&$_smarty_tpl->tpl_vars['provider_data']->value['params'][$_smarty_tpl->tpl_vars['param_id']->value]=='Y')) {?>checked="checked"<?php }?>>
                </div>
            </div>

        <?php } elseif ($_smarty_tpl->tpl_vars['param']->value['type']=='template') {?>
            <?php echo $_smarty_tpl->getSubTemplate ($_smarty_tpl->tpl_vars['param']->value['template'], $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <?php }?>
    <?php } ?>
<!--content_params_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id']->value, ENT_QUOTES, 'UTF-8');?>
--></div>
<?php }} ?>
