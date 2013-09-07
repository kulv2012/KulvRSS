<?php /* Smarty version Smarty-3.0.7, created on 2013-09-07 12:42:59
         compiled from "/home/wuhaiwen/webroot/KulvRSS/libs/Myrss/Action/../../../templates/head.htm" */ ?>
<?php /*%%SmartyHeaderCode:647796538522aaed306c969-06735381%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '453211d24032828fdc939eb311d29f47b71c41e6' => 
    array (
      0 => '/home/wuhaiwen/webroot/KulvRSS/libs/Myrss/Action/../../../templates/head.htm',
      1 => 1374333695,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '647796538522aaed306c969-06735381',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html>
    <?php $_template = new Smarty_Internal_Template("shareHeader.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
    
    <body>
        <h2><a target="window_menu" href="/menu.php">趁着年轻的RSS</a></h2> 
        <div align="right">
            <a target="_blank" href="/mis/addOPML.php">增加RSS源</a>
            <a target="_blank" href="/mis/updateAllRss.php">更新所有RSS</a>
        </div>
    </body>
</html>
