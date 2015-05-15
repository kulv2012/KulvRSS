
//阻止事件冒泡函数
function stopBubble(e)
{
    if (e && e.stopPropagation)
        e.stopPropagation();
    else
        window.event.cancelBubble=true ;
    return true ;
}

function markReadStatus(rssid, aid, isreaded){     
    isreaded = isreaded==true ? "1" : "0" ;
    $.post(
            '/api/markreadstatus.php' ,
            {"rssid": rssid, "aid": aid, "isreaded": isreaded},
            function(data) {
                if("ok" != data){
                    alert("MarkasUnread failed. data="+data);
                }
                else {
                    if( isreaded == "1" && aid != -1){
                        $("#listFont"+aid).css({ 'font-size': "13px", 'color': "black" }) ;
                        $("#idMarkStatus"+aid).unbind('click').bind("click", function(){
                                markReadStatus(rssid, aid, false);
                            });
                        $("#idMarkStatus"+aid).attr("onclick", "");
                        $("#idMarkStatus"+aid).html("UnRd");
                    }
                    else if ( aid != -1 ){
                        $("#listFont"+aid).css({ 'font-size': "16px", 'color': "blue" }) ;
                        $("#idMarkStatus"+aid).unbind('click').bind("click", function (){
                                markReadStatus(rssid, aid, true);
                            }) ;
                        $("#idMarkStatus"+aid).attr("onclick", "");
                        $("#idMarkStatus"+aid).html( "Read");
                    }
                }
            }
            ).fail( function () {
                $("#listFont"+aid).css({ 'font-size': "13px", 'color': "red" }) ;
                }
        );
}

function confirmAllRead( rssid ){
    var conf = confirm("really mark all article of this rss as readed ?");
    if(conf == true){
        markReadStatus(rssid, -1, true );
        location.reload();
    }
}

function sendToKindle( rssid, aid ){
    $.post(
            '/api/sendtokindle.php' ,
            {"rssid":rssid, "aid":aid},
            function(data) {
                if("ok" !=data){
                    alert("sendToKindle failed, error:"+data);
                }
                else {
                    alert("sendToKindle success");
                    $("#listFont"+aid).css({ 'font-size': "16px", 'color': "blue" }) ;
                }
            }
            );

}

var atllstContent;
var curitem ;
function showDocumentModel(id, step) {
    if( id == -1){
        $('#dialog-modal').css("display", "none");
        $('#articlelist').css("display", "block");
        return ;
    }
    curitem = id + step ;
    if( curitem < 0) 
        curitem = 0 ;
    atl = atllstContent[ curitem ] ;
    $('#idTitle').html(atl['title']) ;
    $('#idTitle').attr("href", atl['link']) ;
    $('#idContent').html(atl['content']) ;

    $('#dialog-modal').css("display", "block"); 
    $('#articlelist').css("display", "none"); 

    /*//缩小memu，以备放大阅读框
    var tmp = top.idvirtframeset.cols ;
    //top.idvirtframeset.cols = "0,*";

    var dialog_h = $(document).height();
    var dialog_w = $(document).width();
    //dialog_h = dialog_h>1500 ? 1500 : dialog_h ;
    dialog_w = dialog_w>1000 ? 1000 : dialog_w ;
    $('#idTitle').html(atl['title']) ;
    $('#idTitle').attr("href", atl['link']) ;
    $('#idContent').html(atl['content']) ;
    $('#dialog-modal').dialog({
        title: "趁着年轻-RSS ["+atl['title']+"]" , 
        ///height: dialog_h,
        width: dialog_w,
        modal: true,
        position: { my:'left top', at:'left top', of: window.parent},
        //position: { my: "center", at: "left+0px top+0px ", of: window  } ,
        open: function(event, ui){ },
        close: function(event, ui){ },
        beforeClose: function(event, ui) { 
            top.idvirtframeset.cols = tmp; 
            },
        buttons: {
            Close: function() {
                $( this ).dialog( "close" );
            }
        }
    });
    */
    //设置为已读状态
    markReadStatus(atl.rssid, atl.aid, true );
}

function deleteKeywordMonitor( id ){
    $.post(
            '/mis/subscribe.php' ,
            {"op":"delete", "id":id},
            function(data) {
                if("ok" !=data){
                    alert("deleteKeywordMonitor failed, error:"+data);
                }
                else {
                    alert("deleteKeywordMonitor success");
                    location.reload();
                }
            }
            );

}
function deleteRssById( rssid ){
    $.post(
            '/api/rss.php' ,
            {"op":"delete", "rssid":rssid},
            function(data) {
                if("ok" !=data){
                    alert("deleteRssById failed, error:"+data);
                }
                else {
                    alert("deleteRssById success");
                    location.reload();
                }
            }
            );

}
