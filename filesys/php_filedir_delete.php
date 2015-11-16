<?php
//删除文件
function delFile($file_name) {
	if(file_exists($file_name)) {
		unlink($file_name);
	}
}

//删除指定目录下的所有文件
function delDirOfAll($dir) {
	if(is_dir($dir)) {
		$dh = opendir($dir);
		while(!!$file=readdir($dh)) {
			if($file!="." && $file!="..") {
				$fullpath=$dir."/".$file;
				if(!is_dir($fullpath)) {
					unlink($fullpath);
				} 
				else {
					self::delDirOfAll($fullpath);
				}
			}
		}
		closedir($dh);

		if(rmdir($dir)){
			return true;
		}
		else {
			return false;
		}
	}
}


//删除目录
function delDir($path) {
	if(is_dir($path)) {
		rmdir($path);
	}
}


?>