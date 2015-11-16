<?php
当前的脚本网址
function get_php_url(){
if(!empty($_SERVER[“REQUEST_URI”])){
$scriptName = $_SERVER[“REQUEST_URI”];
$nowurl = $scriptName;
}else{
$scriptName = $_SERVER[“PHP_SELF”];
if(empty($_SERVER[“QUERY_STRING”])) $nowurl = $scriptName;
else $nowurl = $scriptName.”?”.$_SERVER[“QUERY_STRING”];
}
return $nowurl;
}
//把全角数字转为半角数字
function GetAlabNum($fnum){
$nums = array(“０”,”１”,”２”,”３”,”４”,”５”,”６”,”７”,”８”,”９”);
$fnums = “0123456789”;
for($i=0;$i<=9;$i++) $fnum = str_replace($nums[$i],$fnums[$i],$fnum);
$fnum = ereg_replace(“[^0-9\.]|^0{1,}”,””,$fnum);
if($fnum==””) $fnum=0;
return $fnum;
}
//去除HTML标记
function Text2Html($txt){
$txt = str_replace(” “,”　”,$txt);
$txt = str_replace(“<“,”<“,$txt);
$txt = str_replace(“>”,”>”,$txt);
$txt = preg_replace(“/[\r\n]{1,}/isU”,”
\r\n”,$txt);
return $txt;
}
//清除HTML标记
function ClearHtml($str){
$str = str_replace(‘<‘,'<‘,$str);
$str = str_replace(‘>’,’>’,$str);
return $str;
}
//相对路径转化成绝对路径
function relative_to_absolute($content, $feed_url) {
preg_match(‘/(http|https|ftp):\/\//’, $feed_url, $protocol);
$server_url = preg_replace(“/(http|https|ftp|news):\/\//”, “”, $feed_url);
$server_url = preg_replace(“/\/.*/”, “”, $server_url);
if ($server_url == ”) {
return $content;
}
if (isset($protocol[0])) {
$new_content = preg_replace(‘/href=”\//’, ‘href=”‘.$protocol[0].$server_url.’/’, $content);
$new_content = preg_replace(‘/src=”\//’, ‘src=”‘.$protocol[0].$server_url.’/’, $new_content);
} else {
$new_content = $content;
}
return $new_content;
}
//取得所有链接
function get_all_url($code){
preg_match_all(‘/”\’ ]+)[“|\’]?\s*[^>]*>([^>]+)<\/a>/i’,$code,$arr);
return array(‘name’=>$arr[2],’url’=>$arr[1]);
}
//获取指定标记中的内容
function get_tag_data($str, $start, $end){
if ( $start == ” || $end == ” ){
return;
}
$str = explode($start, $str);
$str = explode($end, $str[1]);
return $str[0];
}
//HTML表格的每行转为CSV格式数组
function get_tr_array($table) {
$table = preg_replace(“‘]*?>’si”,'”‘,$table);
$table = str_replace(“”,'”,’,$table);
$table = str_replace(“”,”{tr}”,$table);
//去掉 HTML 标记
$table = preg_replace(“‘<[\/\!]*?[^<>]*?>’si”,””,$table);
//去掉空白字符
$table = preg_replace(“‘([\r\n])[\s]+'”,””,$table);
$table = str_replace(” “,””,$table);
$table = str_replace(” “,””,$table);
$table = explode(“,{tr}”,$table);
array_pop($table);
return $table;
}
//将HTML表格的每行每列转为数组，采集表格数据
function get_td_array($table) {
$table = preg_replace(“‘]*?>’si”,””,$table);
$table = preg_replace(“‘]*?>’si”,””,$table);
$table = preg_replace(“‘]*?>’si”,””,$table);
$table = str_replace(“”,”{tr}”,$table);
$table = str_replace(“”,”{td}”,$table);
//去掉 HTML 标记
$table = preg_replace(“‘<[\/\!]*?[^<>]*?>’si”,””,$table);
//去掉空白字符
$table = preg_replace(“‘([\r\n])[\s]+'”,””,$table);
$table = str_replace(” “,””,$table);
$table = str_replace(” “,””,$table);
$table = explode(‘{tr}’, $table);
array_pop($table);
foreach ($table as $key=>$tr) {
$td = explode(‘{td}’, $tr);
array_pop($td);
$td_array[] = $td;
}
return $td_array;
}
//返回字符串中的所有单词 $distinct=true 去除重复
function split_en_str($str,$distinct=true) {
preg_match_all(‘/([a-zA-Z]+)/’,$str,$match);
if ($distinct == true) {
$match[1] = array_unique($match[1]);
}
sort($match[1]);
return $match[1];
}
转自：http://www.tengbin.com/100352.shtml