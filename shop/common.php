<?php

//唯一订单号
function ordersn2(){
    $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
    $orderSn = $yCode[intval(date('Y')) - 2015].date("YmdHis",time()).sprintf('%03d%02d', rand(100, 999),rand(0,99));
    return $orderSn;
}


//生产唯一订单号
function ordersn3(){
	$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
	$orderSn = $yCode[intval(date('Y')) - 2015] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%04d%02d', rand(1000, 9999),rand(0,99));
	return $orderSn;
}


