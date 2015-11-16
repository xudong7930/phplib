<?php
/**
 * 获取汉字字符串的首字母
 * @param  [type] $str [description]
 * @return [type]      [description]
 */
function getfirstchar($str) {
    $fchar = $str[0];
    //判断是否为字符串
    if (ord($fchar) >= ord("A") && ord($fchar) <= ord("z")) {
        return strtoupper($fchar);
    }
    
    $str = iconv("UTF-8", "gb2312", $str);
    $asc = ord($str[0]) * 256 + ord($str[1]) - 65536;
    if ($asc >= -20319 and $asc <= -20284) return "A";
    if ($asc >= -20283 and $asc <= -19776) return "B";
    if ($asc >= -19775 and $asc <= -19219) return "C";
    if ($asc >= -19218 and $asc <= -18711) return "D";
    if ($asc >= -18710 and $asc <= -18527) return "E";
    if ($asc >= -18526 and $asc <= -18240) return "F";
    if ($asc >= -18239 and $asc <= -17923) return "G";
    if ($asc >= -17922 and $asc <= -17418) return "H";
    if ($asc >= -17417 and $asc <= -16475) return "I";
    if ($asc >= -16474 and $asc <= -16213) return "J";
    if ($asc >= -16212 and $asc <= -15641) return "K";
    if ($asc >= -15640 and $asc <= -15166) return "L";
    if ($asc >= -15165 and $asc <= -14923) return "M";
    if ($asc >= -14922 and $asc <= -14915) return "N";
    if ($asc >= -14914 and $asc <= -14631) return "P";
    if ($asc >= -14630 and $asc <= -14150) return "Q";
    if ($asc >= -14149 and $asc <= -14091) return "R";
    if ($asc >= -14090 and $asc <= -13319) return "S";
    if ($asc >= -13318 and $asc <= -12839) return "T";
    if ($asc >= -12838 and $asc <= -12557) return "W";
    if ($asc >= -12556 and $asc <= -11848) return "X";
    if ($asc >= -11847 and $asc <= -11056) return "Y";
    if ($asc >= -11055 and $asc <= -10247) return "Z";
    return null;
}


/**
 * csv文件导入
 * 
 * @param  [type] $filedname 上传文件字段名
 * @return array  将上传csv文件内容转为数组
 */
function import_csv($filedname){
	$filename = $_FILES[$filedname]['tmp_name'];
	if(empty($filename)){
		echo "请选择要导入的CSV文件";exit;
	}

	$handle = fopen($filename, 'r');   
    $csv_fileconent = array();

	$n = 0;
    while ($rows = fgetcsv($handle, 10000)){
    	$num = count($rows);
    	for ($i = 0; $i < $num; $i++){
    		$csv_fileconent[$n][$i] = $rows[$i];
    	}
    	$n++;
    }

    fclose($handle);

    return $csv_fileconent;
}


/**
 * 将数据导出为csv文件
 * @param  [type] $filename [description]
 * @param  [type] $data     [description]
 * @param  [type] $header    [<description>]
 * @return [type]           [description]
 * example:
 * export_csv("test.csv", 
 * 				array("用户名","邮件","手机号"),
 * 			 	array(array("许东","xudong@qq.com","15811448243")));
 */
function export_csv($filename, $header, $data){
	header("Content-type:text/csv; charset=utf-8");   
    header("Content-Disposition:attachment;filename=".date('YmdHis')."_".$filename);   
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');   
    header('Expires:0');   
    header('Pragma:public');   

    ob_start();
    
    $csv_data = "";
    if($header){
    	$csv_data .= implode(",", $header)."\n";
    }

    if($data){
    	foreach($data as $item){
    		$csv_data .= implode(",", $item)."\n";
    	}
	}

	ob_end_clean();

    echo $csv_data; 
}


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




//检查日期格式是否正确
function check_date($data) {

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


/**
 * 短信验证码
 * @param  integer $lenght [description]
 * @return [type]          [description]
 */
function smsNumber($lenght=6){
	$char="1234567890";
	$str = "";
	while(strlen($str) < $lenght){
		$str .= substr($char, (mt_rand()%strlen($char)),1);
	}
	return $str;
}


/**
 * 计算密码强度
 * @param  [type] $string [description]
 * Returns a float between 0 and 100. The closer the number is to 100 the 
 * the stronger password is; further from 100 the weaker the password is. 
 */
function password_strength($string){ 
    $h    = 0; 
    $size = strlen($string); 
    foreach(count_chars($string, 1) as $v){ 
        $p = $v / $size; 
        $h -= $p * log($p) / log(2); 
    } 
    $strength = ($h / 4) * 100; 
    if($strength > 100){ 
        $strength = 100; 
    } 
    return $strength; 
} 


/**
 * 隐藏手机号hide mobile like 138****5493
 * @param  [type] $mobile [description]
 * @return [type]         [description]
 */
function hideMobile($mobile){
     $pattern = "/(1\d{1,2})\d\d(\d{0,3})/";
     $replacement = "\$1****\$3";
     return preg_replace($pattern, $replacement, $mobile);
}


//最好的序列化对象
public function my_serialize($obj) {
     return base64_encode(gzcompress(serialize($arr)));
}

//最好的反序列化对象
public function my_unserialize($obj) {
     return unserialize(gzuncompress(base64_decode($txt)));
}



