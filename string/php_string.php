<?php
/**
  * ===========================================
  * Project: phplib
  * Function: php字符串常用处理函数
  * Time: 2015-5-20 15:22:16 @ Create
  * Copyright (c) 2007 - 2015 phplib Studio
  * Github: https://github.com/xudong7930/phplib
  * Developer: phplib
  * E-mail: xudong7930@gmail.com
  * ===========================================
  */



/**
 * 格式化 12312432.23 to ￥12,312,432.23
 * @N_money string
 * @param none $N_money
 */
function ExchangeMoney($N_money) {     
	$A_tmp=explode(".",$N_money ); //将数字按小数点分成两部分，并存入数组$A_tmp     
	$I_len=strlen($A_tmp[0]); //测出小数点前面位数的宽度  
	$I_step = 0;

	if($I_len%3==0) {     
		$I_step=$I_len/3; //如前面位数的宽度mod 3 = 0 ,可按，分成$I_step 部分     
	}
	else {     
		$I_step=($I_len-$I_len%3)/3+1; //如前面位数的宽度mod 3 != 0 ,可按，分成$I_step 部分+1     
	}     

	$C_cur="";  

	//对小数点以前的金额数字进行转换     
	while($I_len<>0){     
		$I_step--;    
		
		if ($I_step==0) {     
			$C_cur .= substr($A_tmp[0],0,$I_len-($I_step)*3);     
		}
		else {     
			$C_cur .= substr($A_tmp[0],0,$I_len-($I_step)*3).",";     
		}     

		$A_tmp[0]=substr($A_tmp[0],$I_len-($I_step)*3);     
		$I_len=strlen($A_tmp[0]);     
	}  

	//对小数点后面的金额的进行转换     
	if ($A_tmp[1]=="") {     
		$C_cur .= ".00";     
	}
	else {     
		$I_len=strlen($A_tmp[1]);   

		if ($I_len<2) {     
			$C_cur .= ".".$A_tmp[1]."0";     
		}
		else {     
			$C_cur .= ".".substr($A_tmp[1],0,2);     
		}     
	} 

	//加上人民币符号并传出     
	$C_cur="￥".$C_cur;     
	return $C_cur;     
}


/**
 * Function : dump()
 * Arguments : $data - the variable that must be displayed
 * Prints a array, an object or a scalar variable in an easy to view format.
 */
function dump($data) {
	if(is_array($data)) { //If the given variable is an array, print using the print_r function.
		print "<pre>-----------------------\n";
		print_r($data);
		print "-----------------------</pre>";
	} elseif (is_object($data)) {
		print "<pre>==========================\n";
		var_dump($data);
		print "===========================</pre>";
	} else {
		print "=========&gt; ";
		var_dump($data);
		print " &lt;=========";
	}
}


//打印调试，带变量类型
function D($array){
	echo "<pre>";
	var_dump($array);
	echo "</pre>";
}


//打印调试
function P($array){
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}


/**
 * get a file extension name
 * 获取文件扩展名
 * 
 * @param  string $filename 文件名称
 * @return string
 */
function getFileExtension($filename) {
	if(empty($filename)) {
		return false;
	}

	$extend = explode(".", $filename);

	return end($extend);
}


/**
 * 判断是否是空字符串
 * 
 * @param  string $string 字符串
 * @return bool
 */
function isempty($string) {
	if(!is_string($string)) {return false;}
	if (empty($string)) {return false;}
	if($string =="") {return false;}
	return true;
}


/**
 * 中英文混合的字符串截取, 支持utf-8和gb2312
 * 
 * @param  [type] $string  [description]
 * @param  [type] $length  [description]
 * @param  string $dot     [description]
 * @param  string $charset [description]
 * @return [type]          [description]
 */
function get_word($string, $length, $dot = '..',$charset='utf-8') {
	
	if(strlen($string) <= $length) {
		return $string;
	}

	$string = str_replace(array('　','&nbsp;', '&', '"', '<', '>'), array('','','&', '"', '<', '>'), $string);

	$strcut = '';
	if(strtolower($charset) == 'utf-8') {

		$n = $tn = $noc = 0;
		while($n < strlen($string)) {

			$t = ord($string[$n]);
			if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
				$tn = 1; $n++; $noc++;
			} elseif(194 <= $t && $t <= 223) {
				$tn = 2; $n += 2; $noc += 2;
			} elseif(224 <= $t && $t < 239) {
				$tn = 3; $n += 3; $noc += 2;
			} elseif(240 <= $t && $t <= 247) {
				$tn = 4; $n += 4; $noc += 2;
			} elseif(248 <= $t && $t <= 251) {
				$tn = 5; $n += 5; $noc += 2;
			} elseif($t == 252 || $t == 253) {
				$tn = 6; $n += 6; $noc += 2;
			} else {
				$n++;
			}

			if($noc >= $length) {
				break;
			}

		}
		if($noc > $length) {
			$n -= $tn;
		}

		$strcut = substr($string, 0, $n);

	} else {
		for($i = 0; $i < $length; $i++) {
			$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
		}
	}

	return $strcut.$dot;
}


/**
 * 截取中文字符串GB2312
 * 
 * @param  string $str 要截取的字符串	
 * @param  int $start 开始位置
 * @param  int $len 字符串长度
 * @return string
 */
function cutGBK($str, $start, $len) {
	$tmpstr = "";
	$strlen = $start + $len;
	for ($i=0; $i < $strlen; $i++) { 
		if(ord(substr($str, $i, 1) > 0xa0)) {
			$tmpstr .= substr($str, $i, 2);
			$i++;
		}
		else {
			$tmpstr .= substr($str, $i, 1);
		}
	}

	return $tmpstr;
}


/**
 * 截取UTF8字符串
 * 
 * @param  string $str 字符串
 * @param  int $start 开始位置
 * @param  int $len 截取的字符串长度
 * @return string
 */
function cutUTF8($str, $start, $len) {
	return preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$from.'}'.'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s','$1',$str);
}


//获取用户的真实IP
function getClientIP() {   
	static $realip = NULL;   
	if ($realip !== NULL) return $realip;  
	if (isset($_SERVER)) {  
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {   
			$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);  
			foreach ($arr AS $ip) {  
				$ip = trim($ip);  
				if ($ip != 'unknown') {   
					$realip = $ip;   
					break;   
				}   
			}   
		} elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {   
			$realip = $_SERVER['HTTP_CLIENT_IP'];  
		} else {   
			if (isset($_SERVER['REMOTE_ADDR'])) {   
				$realip = $_SERVER['REMOTE_ADDR'];   
			} else {   
				$realip = '0.0.0.0';   
			}  
		}  
	} else {  
		if (getenv('HTTP_X_FORWARDED_FOR')) {  
			$realip = getenv('HTTP_X_FORWARDED_FOR');  
		} elseif (getenv('HTTP_CLIENT_IP')) {  
			$realip = getenv('HTTP_CLIENT_IP');  
		} else {  
			$realip = getenv('REMOTE_ADDR');  
		}  
	}
	preg_match('/[\d\.]{7,15}/', $realip, $onlineip);  
	$realip = !empty($onlineip[0]) ? $onlineip[0] : '0.0.0.0';  
	return $realip;  
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


//检查日期格式是否正确
function check_date($data) {

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
 * 检查手机号格式是否正确
 * 
 * @param  string $str 手机号
 * @return bool
 */
function check_mobile($str) {
	$reg = "/13[0-9]{1}\d{8}|14[5,7]\d{8}|15[012356789]\d{8}|18[012356789]\d{8}/";
	return preg_match($reg, $str);
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


/**
 * 生成随机数字和字母
 * 
 * @param  int $len 长度	
 * @param  int $len 1-数字 2-小写字母 3-大写字母 4-小写字母和数字
 * @return [type]
 */
function random($len = 6, $type=1) {
	$chars = array(
		1=>"0123456789",
		2=>"abcdefghijklmnopqrstuvwxyz",
		3=>"ABCDEFGHIJKLMNOPQRSTUVWXYZ",
		4=>"abcdefghijklmnopqrstuvwxyz0123456789",
		);
	$salt = "";
	while(strlen($salt) < $len) {
		$salt .= substr($chars[$type], (mt_rand()%strlen($chars[$type])),1);
	}

	return $salt;
}


