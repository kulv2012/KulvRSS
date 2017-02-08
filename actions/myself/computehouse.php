<?php
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">' ;
echo '<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
       <META HTTP-EQUIV="Expires" CONTENT="-1">';
	
$totalprice = isset( $_REQUEST['totalprice'] ) ? intval($_REQUEST['totalprice'] ) : 300 ;
$loantype = isset( $_REQUEST['loantype'] ) ?  $_REQUEST['loantype'] : "business" ;

?>

<form action="/myself/computehouse.php" method="get" >

<input name="type" value='addclass' type='hidden' id="input1">
	成交价:<input type="text" name="totalprice" id="input1" value='<?=$totalprice?>'><br>
	
	<input type="checkbox" name="isfileone" checked="checked" >满五唯一<br/>

	<input type="radio" name="loantype" value="gjj" />公积金 
	<input type="radio" name="loantype" value="both" /> 组合贷
	<input type="radio" name="loantype" value="business" checked="checked"/> 纯商贷
	<hr>
	<input type="submit" value="计算">
</form>
<?php



function getPriceTable( $totalprice, $loantype){
	
	$dataary = array() ;
	if( 1|| $loantype == 'business'){
		$data = array() ;
		$data["成交价"] = $totalprice;
		$data["合同价"] = $totalprice*0.95 ;
		$data["贷款额度"] = $data["合同价"]*0.7 ;
		$data["纯首付"] = $totalprice - $data["贷款额度"];

		$data["契税"] = $data["合同价"]*0.01 ;
		$data["服务费"] = $totalprice*0.022;
		$data["担保"] = $totalprice*0.005;

		$data["评估费"] = 0.1500 ;
		$data["贷款担保"] = 0.0 ;
		$data["房本"] = 0.0090 ;

		$data["总首付费用"] = $data["纯首付"] + $data["契税"] + $data["服务费"] + $data["担保"] 
			+  $data["评估费"] + $data["贷款担保"] + $data["房本"] ;

		$dataary[0] = $data ;
	}
	if(1|| $loantype == 'both'){
		$data = array() ;
		$data["成交价"] = $totalprice;
		$data["合同价"] = $totalprice*0.9 ;
		$data["贷款额度"] = $data["合同价"]*0.7 ;
		$data["纯首付"] = $totalprice - $data["贷款额度"];

		$data["契税"] = $data["合同价"]*0.01 ;
		$data["服务费"] = $totalprice*0.022;
		$data["担保"] = $totalprice*0.005;

		$data["评估费"] = 0.1500 ;
		$data["贷款担保"] = 0.0380 ;
		$data["房本"] = 0.0090 ;

		$data["总首付费用"] = $data["纯首付"] + $data["契税"] + $data["服务费"] + $data["担保"] 
			+  $data["评估费"] + $data["贷款担保"] + $data["房本"] ;

		$dataary[1] = $data ;
	}
	if(1|| $loantype == 'gjj'){
		$data = array() ;
		$data["成交价"] = $totalprice;
		$data["贷款额度"] = 120 ;
		$data["合同价"] = $data["贷款额度"]/0.7 ;
		$data["纯首付"] = $totalprice - $data["贷款额度"];

		$data["契税"] = $data["合同价"]*0.01 ;
		$data["服务费"] = $totalprice*0.022;
		$data["担保"] = $totalprice*0.005;

		$data["评估费"] = 0.1500 ;
		$data["贷款担保"] = 0.0380 ;
		$data["房本"] = 0.0090 ;

		$data["公积金特殊担保"] = 0.3600;

		$data["总首付费用"] = $data["纯首付"] + $data["契税"] + $data["服务费"] + $data["担保"] 
			+  $data["评估费"] + $data["贷款担保"] + $data["房本"] + $data["公积金特殊担保"] ;

		$dataary[2] = $data ;
	}

	return $dataary ;
}
$tabstr = '' ;
$dataary = getPriceTable( $totalprice, '') ;
	$tabstr .= "<table ><thead><tr>
		<th>项目名</th>
		<th>商贷</th><th>-</th> 
		<th>组合贷款</th><th>-</th>
		<th>公积金</th><th>-</th>
		<th>备注</th>
		</tr></head><tbody>" ;

$items = array( "成交价" => "", 
	"贷款额度" => "评估价0.7,公积金最多120", 
	"合同价" => "纯商0.95,就是网签价", 
	"纯首付" => "成交价-贷款额度", 
	"契税" => "合同价1%", 
	"服务费" => "成交价2.2%", 
	"担保" => "成交价0.5%", 
	"评估费" => "",
	"贷款担保" => "",
	"公积金特殊担保" => "",
	"房本" => "",
	"总首付费用" => "",
);

	foreach($items as $it => $extra){
		$tabstr .= "
			<tr>
			<td>{$it}</td>" ;
		for($i = 0 ; $i<3; $i++){
		//for($i = 0 ; $i<1; $i++){
            $value = isset( $dataary[$i][$it]) ? $dataary[$i][$it] : 0 ;
			$value = round($value, 2) ;
			$tabstr .= "<td>{$value}</td><td> </td>
			";
		}

		$tabstr .= "<td>$extra</td></tr>" ;
	}

	$tabstr .= "</tbody></table>" ;
	echo "$tabstr" ;

?>
<!--	
<style type="text/css">
.left {    float:left;    display:inline;}
.center{    float:left;    display:inline;}
.right{    float:left;    display:inline;}
</style>
<div class="left"><?=$business?></div>
<div class="center"><?=$both?></div>
<div class="right"><?=$gjj?></div>


--!>
