<?php /* Smarty version Smarty-3.0.7, created on 2015-04-26 17:15:19
         compiled from "/home/wuhaiwen/webroot/KulvRSS/libs/Myrss/Action/../../../templates/atllst.htm" */ ?>
<?php /*%%SmartyHeaderCode:1782261672553caca795c827-74434275%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3bb5c2592d01669afcdc0f1741ebac4112f1c4d0' => 
    array (
      0 => '/home/wuhaiwen/webroot/KulvRSS/libs/Myrss/Action/../../../templates/atllst.htm',
      1 => 1430039700,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1782261672553caca795c827-74434275',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html>

    <?php $_template = new Smarty_Internal_Template("shareHeader.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

    <body>
        <table style="width:100%;margin:0;cellspacing:0;border:0;">
            <thead></thead>
            <tbody>
            <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('atllst')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
?>
                <tr  border=0 onmouseover="this.className='td_mouseover';" onmouseout="this.className='';">
                <td onclick="markReadStatus(<?php echo $_smarty_tpl->tpl_vars['a']->value['rssid'];?>
, <?php echo $_smarty_tpl->tpl_vars['a']->value['aid'];?>
, true)">
                    <a href="#" onclick="stopBubble(event);showDocumentModel(<?php echo $_smarty_tpl->tpl_vars['a']->value['rssid'];?>
, <?php echo $_smarty_tpl->tpl_vars['a']->value['aid'];?>
);">
                        <font id="listFont<?php echo $_smarty_tpl->tpl_vars['a']->value['aid'];?>
" <?php if ($_smarty_tpl->tpl_vars['a']->value['isreaded']==0){?> color=blue <?php }else{ ?> size=2px <?php }?> >
                            .<?php echo $_smarty_tpl->tpl_vars['a']->value['title'];?>

                        </font>
                    </a>
                </td>
                <td align="right"  onclick="stopBubble(event);">
                    <div style="background-color:Aqua;layout:fixed;white-space:nowrap;">
                    <?php if ($_smarty_tpl->tpl_vars['a']->value['isreaded']==0){?>
                        <button id="idMarkStatus<?php echo $_smarty_tpl->tpl_vars['a']->value['aid'];?>
" onclick="markReadStatus(<?php echo $_smarty_tpl->tpl_vars['a']->value['rssid'];?>
, <?php echo $_smarty_tpl->tpl_vars['a']->value['aid'];?>
, true)">Read</button>
                    <?php }else{ ?>
                        <button id="idMarkStatus<?php echo $_smarty_tpl->tpl_vars['a']->value['aid'];?>
" onclick="markReadStatus(<?php echo $_smarty_tpl->tpl_vars['a']->value['rssid'];?>
, <?php echo $_smarty_tpl->tpl_vars['a']->value['aid'];?>
, false)">UnRd</button>
                    <?php }?>
<?php if (($_smarty_tpl->getVariable('devicetype')->value=="web")||($_smarty_tpl->getVariable('devicetype')->value=="ipad")){?>
                        <button onclick="OpenArticleLink(<?php echo $_smarty_tpl->tpl_vars['a']->value['rssid'];?>
, <?php echo $_smarty_tpl->tpl_vars['a']->value['aid'];?>
, '<?php echo $_smarty_tpl->tpl_vars['a']->value['link'];?>
')">SrcLink</button>
                        <!--<button onclick="sendToKindle(<?php echo $_smarty_tpl->tpl_vars['a']->value['rssid'];?>
, <?php echo $_smarty_tpl->tpl_vars['a']->value['aid'];?>
)">Kindle</button>-->
<?php }?>
                    </div>
                </td>
                </tr>
            <?php }} ?>
            </tbody>
            </table>
        </ul>
<div id="dialog-modal" title="趁着年轻-RSS" style="display:none;">
    <ul>
        <li ><h3> <a target="_blank" href="" id="idTitle">titles</a></h3></li>
        <hr>
        <li id="idContent">abba </li>
        <hr>
        <li id="legal"><font color=grey size=1px>趁着年轻注：我知道提取全文是不对的，但我只是用做个人学习用途哦。<br>"如果RSS源站没用提供全文RSS，我会自己提取网页全文进行显示，超越了网站的授权范围使用blog内容，构成了著作权侵权和不正当竞争。"<br>好吧，为了科研与学习目的，不构成侵权</font></li>
    </ul>
</div>

    </body>
</html>


<script type="text/javascript">
    var atllstContent = <?php echo $_smarty_tpl->getVariable('atllstContent')->value;?>
;


function OpenArticleLink( rssid, aid, link ){
    markReadStatus(rssid, aid, true );
    window.open(link, '_blank');
}
</script>
