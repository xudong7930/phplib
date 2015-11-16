<?php 
/**
 * 最好的获取文件扩展名
 * @param  [type] $filename [description]
 * @return [type]           [description]
 */
function getFileExtension($filename){
	/*
	PATHINFO_DIRNAME – 目录
	PATHINFO_BASENAME – 文件名（含扩展名）
	PATHINFO_EXTENSION – 扩展名
	PATHINFO_FILENAME – 文件名（不含扩展名，PHP>5.2）
	*/
	return pathinfo($filename, PATHINFO_EXTENSION);
}


//获取文件目录列表,该方法返回数组
function getDir($dir) {
    $dirArray[]=NULL;
    if (false != ($handle = opendir ( $dir ))) {
        $i=0;
        while ( false !== ($file = readdir ( $handle )) ) {            
            //去掉"“.”、“..”以及带“.xxx”后缀的文件
            if ($file != "." && $file != "..") {
            	$type = is_dir($file)?"directory":"file";
                $dirArray[$i]=array("name"=>$file, "type"=>$type);
                $i++;
            }
        }
        //关闭句柄
        closedir ( $handle );
    }
    return $dirArray;
}


?>