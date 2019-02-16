<?php /* Smarty version Smarty-3.0.7, created on 2018-02-22 13:16:11
         compiled from "/home/wuhaiwen/webroot/KulvRSS/libs/Myrss/Action/../../../templates/menu.htm" */ ?>
<?php /*%%SmartyHeaderCode:5652324455a8e521b03cbc4-82604055%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e1fa1a6ea591a321b2b8948b37f41e1e426ed36b' => 
    array (
      0 => '/home/wuhaiwen/webroot/KulvRSS/libs/Myrss/Action/../../../templates/menu.htm',
      1 => 1465315440,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5652324455a8e521b03cbc4-82604055',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html>
    <?php $_template = new Smarty_Internal_Template("shareHeader.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
    <body class="body_menu">
        <ul>
            <?php  $_smarty_tpl->tpl_vars['rss'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('rsses')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['rss']->key => $_smarty_tpl->tpl_vars['rss']->value){
?>
                <li onmouseover="this.className='li_mouseover';" onmouseout="this.className='';">
                    <?php if ($_smarty_tpl->tpl_vars['rss']->value['unreadcount']>0){?> <strong><?php }else{ ?> <font size=2px><?php }?>
                    <a href="#" onclick="confirmAllRead(<?php echo $_smarty_tpl->tpl_vars['rss']->value['id'];?>
)">(<?php echo $_smarty_tpl->tpl_vars['rss']->value['unreadcount'];?>
)</a>
                <a target="window_atllst" href="atllst.php?rssid=<?php echo $_smarty_tpl->tpl_vars['rss']->value['id'];?>
"> <?php echo $_smarty_tpl->tpl_vars['rss']->value['name'];?>
</a>
                    <?php if ($_smarty_tpl->tpl_vars['rss']->value['unreadcount']>0){?> </strong><?php }else{ ?></font><?php }?>
                </li>
            <?php }} ?>
        </ul>

    </body>
</html>
<script type="text/javascript">
    $('body').everyTime('1s',function(){
        //top.idvirtframeset.cols = "40,*";
        });

</script>
