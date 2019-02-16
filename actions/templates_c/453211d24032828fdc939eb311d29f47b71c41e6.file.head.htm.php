<?php /* Smarty version Smarty-3.0.7, created on 2018-02-22 13:16:11
         compiled from "/home/wuhaiwen/webroot/KulvRSS/libs/Myrss/Action/../../../templates/head.htm" */ ?>
<?php /*%%SmartyHeaderCode:2120388825a8e521b022ac3-81114876%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '453211d24032828fdc939eb311d29f47b71c41e6' => 
    array (
      0 => '/home/wuhaiwen/webroot/KulvRSS/libs/Myrss/Action/../../../templates/head.htm',
      1 => 1465315439,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2120388825a8e521b022ac3-81114876',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html>
    <?php $_template = new Smarty_Internal_Template("shareHeader.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>
    
    <body>
        <div>
            <b><a target="window_menu" href="/menu.php">趁着年轻的RSS</a></b>
        </div>
        <div align="right">
            | <a target="window_atllst" href="/mis/subscribe.php">关键词订阅</a>
            <a target="_blank" href="/mis/addOPML.php">增加RSS源</a>
            <a target="_blank" href="/mis/updateAllRss.php">更新所有RSS</a>
            <br>

            <form id="form" target="window_atllst" action="/atllst.php" method="get">
                <input type="text" id="" name="szKeyword" style="width:150px;"></input>
                <button type="submit">搜索</button>
            </form>
        </div>
    </body>
</html>
