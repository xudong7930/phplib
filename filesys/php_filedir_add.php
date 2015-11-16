<?php  
//创建空文件
function createFile($file_name) {
	if(!is_file($file_name)) {
		touch($file_name);
	}
}


//创建目录 
function createDir($dir) {
	if(!is_dir($dir)) {
		mkdir($dir, 0777);
	}
}

//目录复制
function copy_dir($src, $dst) {
    $dir = opendir($src);
    @mkdir($dst);
    while (false !== ($file = readdir($dir))) {
        if (($file != '.') && ($file != '..')) {
            if (is_dir($src . '/' . $file)) {
                copy_dir($src . '/' . $file, $dst . '/' . $file);
                continue;
            } else {
                copy($src . '/' . $file, $dst . '/' . $file);
            }
        }
    }
    closedir($dir);
}

?>