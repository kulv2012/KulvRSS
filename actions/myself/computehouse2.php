<?php
echo '<html>
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">' ;
echo '<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
       <META HTTP-EQUIV="Expires" CONTENT="-1">';

$totalprice = isset( $_REQUEST['totalprice'] ) ? intval($_REQUEST['totalprice'] ) : 500 ;
$downpayment = isset( $_REQUEST['downpayment'] ) ? $_REQUEST['downpayment'] : 0.35 ;
$loantype = isset( $_REQUEST['loantype'] ) ?  $_REQUEST['loantype'] : "business" ;

?>
</head>
<body >
<font size="5">
<form action="/myself/computehouse2.php" method="get" >

	成交价:<input type="text" name="totalprice" id="input1" style='font-size:40px;' value='<?=$totalprice?>'><br>
	首付比例:<input type="text" name="downpayment" id="input1" style='font-size:40px;' value='<?=$downpayment?>'><br>
	
	<input type="checkbox" name="isfileone" checked="checked" >满五唯一<br/>

	<input type="radio" name="loantype" value="business" <?if($loantype=='business') echo 'checked="checked"';?>/> 商品房
	<input type="radio" name="loantype" value="jingjisihyong" <?if($loantype=='jingjisihyong') echo 'checked="checked"';?>/>经品房(10%地价款)
	<input type="submit" value="计算" style='font-size:40px;'>
	<hr>
</form>
<?php



function getPriceTable( $totalprice, $loantype){
    global $downpayment, $loantype;	
    $max_sign_value = 374 ;//网签价格最高374W
	$dataary = array() ;

		$data = array() ;
		$data["成交价"] = $totalprice;
		$data["合同价"] = $max_sign_value ;
		$data["贷款额度"] = $data["合同价"]*( 1 - $downpayment ) ;
		$data['综合地价款'] = 0 ;
		if( $loantype == 'jingjisihyong'){
			$data['综合地价款'] = $data["合同价"]*0.1 ;
		}

		$data["纯首付"] = $totalprice - $data["贷款额度"] + $data['综合地价款'] ;

		$data["契税"] = $data["合同价"]*0.01 ;
		$data["服务费"] = $totalprice*0.025;
		$data["担保"] = $totalprice*0.005;

		$data["评估费"] = 0.1500 ;
		#$data["贷款担保"] = 0.0 ;
		#$data["房本"] = 0.0090 ;

		$data["总首付费用"] = $data["纯首付"] + 
			$data["契税"] + 
			$data["服务费"] + 
			$data["担保"] + 
			+$data["评估费"]
			#$data["贷款担保"] + 
			#$data["房本"] 
			;

		$dataary[] = $data ;
	return $dataary;
}

$tabstr = '' ;
$dataary = getPriceTable( $totalprice, '') ;
	$tabstr .= "<table style='font-size:40px;'><thead><tr>
		<th>项目名</th>
		<th>商贷</th><th>-</th> 
		<th>备注</th>
		</tr></thead><tbody>" ;

$items = array( "成交价" => "", 
	"贷款额度" => "评估价0.65，首套首付0.35", 
	"合同价" => "非普最高374W网签价", 
	"综合地价款" => "网签价的10%",
	"纯首付" => "成交价-贷款额度", 
	"契税" => "合同价1%", 
	"服务费" => "成交价2.2%", 
	"担保" => "成交价0.5%", 
	"评估费" => "",
	#"贷款担保" => "",
	#"公积金特殊担保" => "",
	#"房本" => "",
	"总首付费用" => "",
);

	foreach($items as $it => $extra){
		$tabstr .= "
			<tr>
			<td>{$it}</td>" ;
		for($i = 0 ; $i<1; $i++){
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
</font>
</body>
</html>
