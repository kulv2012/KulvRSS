<?php /* Smarty version Smarty-3.0.7, created on 2016-06-08 00:44:56
         compiled from "/home/wuhaiwen/webroot/KulvRSS/libs/Myrss/Action/../../../templates/index.htm" */ ?>
<?php /*%%SmartyHeaderCode:18693164085756fa088ee316-33360870%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b960bdd36a49039c01ce78d6eec4ce3beb3562ec' => 
    array (
      0 => '/home/wuhaiwen/webroot/KulvRSS/libs/Myrss/Action/../../../templates/index.htm',
      1 => 1465315439,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18693164085756fa088ee316-33360870',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html>
    <?php $_template = new Smarty_Internal_Template("shareHeader.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

            <?php if (($_smarty_tpl->getVariable('devicetype')->value=="web")||($_smarty_tpl->getVariable('devicetype')->value=="ipada")){?>
    <frameset frameborder=1 frameSpacing=1 rows=60,* frameBorder=1 cols="">
        <frame name=topFrame src="head.php" noResize scrolling=no >
        <frameset id="idvirtframeset" border=1 frameSpacing=0 frameBorder=yes cols=300,*>
            <frame id=f1 name=window_menu marginWidth=0 marginHeight=5 src="menu.php" frameborder=1>
            <frame id=f2 marginWidth=0 marginHeight=5 name=window_atllst src="atllst.php">
            <!--<frameset border=1 frameSpacing=0 frameBorder=yes rows=400,*>
                <frame id=f2 marginWidth=0 marginHeight=5 name=window_atllst src="atllst.php">
                <frame id=f2 name=window_article src="article.php" scrolling=yes>
            </frameset>-->
        </frameset>
    </frameset>
            <?php }else{ ?>
    <frameset frameborder=1 frameSpacing=1 rows=60,* frameBorder=1 cols="">
        <frame name=topFrame src="head.php" noResize scrolling=no >
        <frameset id="idvirtframeset" border=1 frameSpacing=0 frameBorder=yes cols=0,*>
            <frame id=f1 name=window_menu marginWidth=0 marginHeight=5 src="menu.php" frameborder=1>
            <frame id=f2 marginWidth=0 marginHeight=5 name=window_atllst src="atllst.php">
        </frameset>
    </frameset>
            <?php }?>

</html>
