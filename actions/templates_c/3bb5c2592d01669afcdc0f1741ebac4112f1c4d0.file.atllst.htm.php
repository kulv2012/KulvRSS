<?php /* Smarty version Smarty-3.0.7, created on 2018-03-29 00:17:16
         compiled from "/home/wuhaiwen/webroot/KulvRSS/libs/Myrss/Action/../../../templates/atllst.htm" */ ?>
<?php /*%%SmartyHeaderCode:16120228695abbc00c555cb3-82554169%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3bb5c2592d01669afcdc0f1741ebac4112f1c4d0' => 
    array (
      0 => '/home/wuhaiwen/webroot/KulvRSS/libs/Myrss/Action/../../../templates/atllst.htm',
      1 => 1522253834,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16120228695abbc00c555cb3-82554169',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html>

    <?php $_template = new Smarty_Internal_Template("shareHeader.htm", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php unset($_template);?>

    <body id="idbody" class="body_class">

        <div id="dialog-modal" title="趁着年轻-RSS" style="display:none;width:800px">
        <div style="display:block">
            <br/>
            <button style='align:left' onclick="showDocumentModel(curitem, -1);">----Prev------</button>
            <button style='float: right;' onclick="showDocumentModel(curitem, 1);">------Next---------</button>
        </div>
            <ul>
                <li >
                    <h3> 
                        <a target="_blank" href="" id="idTitle">titles</a>
                    </h3>
                </li>
                <hr>
                <li id="idContent">abba </li>
                <hr>
            </ul>
            <button style='align:right' onclick="showDocumentModel(-1, 0);">关闭阅读模式</button>
        </div>

        <div id="articlelist" style="display:block">
            <table style="width:100%;margin:0;cellspacing:0;border:0;">
                <thead></thead>
                <tbody>
    <?php $_smarty_tpl->tpl_vars["i"] = new Smarty_variable("0", null, null);?>
                <?php  $_smarty_tpl->tpl_vars['a'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('atllst')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['a']->key => $_smarty_tpl->tpl_vars['a']->value){
?>
                    <tr  border=0 onmouseover="this.className='td_mouseover';" onmouseout="this.className='';">
                    <td onclick="stopBubble(event);markReadStatus(<?php echo $_smarty_tpl->tpl_vars['a']->value['rssid'];?>
, <?php echo $_smarty_tpl->tpl_vars['a']->value['aid'];?>
, true)">
						<?php if (($_smarty_tpl->getVariable('devicetype')->value=="web")||($_smarty_tpl->getVariable('devicetype')->value=="ipad")){?>
                                <button onclick="OpenArticleLink(<?php echo $_smarty_tpl->tpl_vars['a']->value['rssid'];?>
, <?php echo $_smarty_tpl->tpl_vars['a']->value['aid'];?>
, '<?php echo $_smarty_tpl->tpl_vars['a']->value['link'];?>
')">SrcLink</button>
								&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<?php }?>
                        <a href="#" onclick="stopBubble(event);showDocumentModel(<?php echo $_smarty_tpl->getVariable('i')->value;?>
, 0);">
                            <font id="listFont<?php echo $_smarty_tpl->tpl_vars['a']->value['aid'];?>
" <?php if ($_smarty_tpl->tpl_vars['a']->value['isreaded']==0){?> color='0x000000' <?php }else{ ?> color='gray' size=2px <?php }?> >
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
                <?php $_smarty_tpl->tpl_vars['i'] = new Smarty_variable($_smarty_tpl->getVariable('i')->value+1, null, null);?>
                <?php }} ?>
                </tbody>
            </table>
        </div>

    </body>
</html>


<script type="text/javascript">
    var atllstContent = <?php echo $_smarty_tpl->getVariable('atllstContent')->value;?>
;

    var curitem = 0 ;
    $(document).keydown(function(event){ 
        if( 37 == event.keyCode){
            showDocumentModel(curitem, -1 ) ;
        }else if( 39 == event.keyCode){
            showDocumentModel(curitem, 1 ) ;
        }
    });



$("#idbody").live('swipeleft', function() {  
        alert("aaa");
        }) ;




</script>
