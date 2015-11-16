<?php 

/**
 * 匹配中文
 * @param  [type] $string [description]
 * @return [type]         [description]
 */
function check_chinese($string){
	$pattern = "/^[\x{4e00}-\x{9fa5}]+$/u";
	return preg_match($pattern, $string);
}


//检查身份证号
function check_idcard($idcard){

	// 只能是18位
	if(strlen($idcard)!=18){
		return false;
	}

	// 取出本体码
	$idcard_base = substr($idcard, 0, 17);

	// 取出校验码
	$verify_code = substr($idcard, 17, 1);

	// 加权因子
	$factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);

	// 校验码对应值
	$verify_code_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');

	// 根据前17位计算校验码
	$total = 0;
	for($i=0; $i<17; $i++){
		$total += substr($idcard_base, $i, 1)*$factor[$i];
	}

	// 取模
	$mod = $total % 11;

	// 比较校验码
	if($verify_code == $verify_code_list[$mod]){
		return true;
	}else{
		return false;
	}
}



/**
 * 检查手机号格式是否正确
 * 
 * @param  string $str 手机号
 * @return bool
 */
function check_mobile($str) {
	$reg = "/13[0-9]{1}\d{8}|14[5,7]\d{8}|15[012356789]\d{8}|18[012356789]\d{8}/";
	$pattern = "/^((1[3,5,8][0-9])|(14[5,7])|(17[0,6,7,8]))\d{8}$/";
	return preg_match($reg, $str);
}


/**
 * 检查邮件地址格式是否正确
 * 
 * @param  string $str 邮件地址
 * @return bool
 */
function check_mail($str){
	//return preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$mail);
	return filter_var($str, FILTER_VALIDATE_EMAIL);
}


/**
 * 检查是否是邮编
 * 
 * @param  string $code 邮编
 * @return bool
 */
function check_post($code) {
	$reg = "/^[0-9]d{5}$/";
	return preg_match($reg, $postcode);
}


/**
 * 检查是否是国内电话号格式
 * @param  string $tel 电话号码
 * @return bool
 */
function  check_telphone($tel) {
	$isTel="/^([0-9]{3,4}-)?[0-9]{7,8}$/";
	preg_match($isTel, $tel);
}


//检查用户名
function check_username ($username) {
	return preg_match('/^[a-z\d_]{5,20}$/i', $username);
}


//检查IPV4
function check_ipv4($ip) {
	return preg_match('/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/',$ip);	
}


//检查url
function check_url($url) {
	return preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url);
}