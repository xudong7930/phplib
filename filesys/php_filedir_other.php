<?php 

//大文件下载
function downloadBigFile($filePath){
	if (!empty($filePath)) {
		$fileInfo = pathinfo($filePath);
		$fileName = $fileInfo['basename'];
		$fileExtnesion	 = $fileInfo['extension'];
		$default_contentType = "application/octet-stream";
		$content_types_list  = array(
			"323" => "text/h323",
			"acx" => "application/internet-property-stream",
			"ai" => "application/postscript",
			"aif" => "audio/x-aiff",
			"aifc" => "audio/x-aiff",
			"aiff" => "audio/x-aiff",
			"asf" => "video/x-ms-asf",
			"asr" => "video/x-ms-asf",
			"asx" => "video/x-ms-asf",
			"au" => "audio/basic",
			"avi" => "video/x-msvideo",
			"axs" => "application/olescript",
			"bas" => "text/plain",
			"bcpio" => "application/x-bcpio",
			"bin" => "application/octet-stream",
			"bmp" => "image/bmp",
			"c" => "text/plain",
			"cat" => "application/vnd.ms-pkiseccat",
			"cdf" => "application/x-cdf",
			"cer" => "application/x-x509-ca-cert",
			"class" => "application/octet-stream",
			"clp" => "application/x-msclip",
			"cmx" => "image/x-cmx",
			"cod" => "image/cis-cod",
			"cpio" => "application/x-cpio",
			"crd" => "application/x-mscardfile",
			"crl" => "application/pkix-crl",
			"crt" => "application/x-x509-ca-cert",
			"csh" => "application/x-csh",
			"css" => "text/css",
			"dcr" => "application/x-director",
			"der" => "application/x-x509-ca-cert",
			"dir" => "application/x-director",
			"dll" => "application/x-msdownload",
			"dms" => "application/octet-stream",
			"doc" => "application/msword",
			"dot" => "application/msword",
			"dvi" => "application/x-dvi",
			"dxr" => "application/x-director",
			"eps" => "application/postscript",
			"etx" => "text/x-setext",
			"evy" => "application/envoy",
			"exe" => "application/octet-stream",
			"fif" => "application/fractals",
			"flr" => "x-world/x-vrml",
			"gif" => "image/gif",
			"gtar" => "application/x-gtar",
			"gz" => "application/x-gzip",
			"h" => "text/plain",
			"hdf" => "application/x-hdf",
			"hlp" => "application/winhlp",
			"hqx" => "application/mac-binhex40",
			"hta" => "application/hta",
			"htc" => "text/x-component",
			"htm" => "text/html",
			"html" => "text/html",
			"htt" => "text/webviewhtml",
			"ico" => "image/x-icon",
			"ief" => "image/ief",
			"iii" => "application/x-iphone",
			"ins" => "application/x-internet-signup",
			"isp" => "application/x-internet-signup",
			"jfif" => "image/pipeg",
			"jpe" => "image/jpeg",
			"jpeg" => "image/jpeg",
			"jpg" => "image/jpeg",
			"js" => "application/x-javascript",
			"latex" => "application/x-latex",
			"lha" => "application/octet-stream",
			"lsf" => "video/x-la-asf",
			"lsx" => "video/x-la-asf",
			"lzh" => "application/octet-stream",
			"m13" => "application/x-msmediaview",
			"m14" => "application/x-msmediaview",
			"m3u" => "audio/x-mpegurl",
			"man" => "application/x-troff-man",
			"mdb" => "application/x-msaccess",
			"me" => "application/x-troff-me",
			"mht" => "message/rfc822",
			"mhtml" => "message/rfc822",
			"mid" => "audio/mid",
			"mny" => "application/x-msmoney",
			"mov" => "video/quicktime",
			"movie" => "video/x-sgi-movie",
			"mp2" => "video/mpeg",
			"mp3" => "audio/mpeg",
			"mpa" => "video/mpeg",
			"mpe" => "video/mpeg",
			"mpeg" => "video/mpeg",
			"mpg" => "video/mpeg",
			"mpp" => "application/vnd.ms-project",
			"mpv2" => "video/mpeg",
			"ms" => "application/x-troff-ms",
			"mvb" => "application/x-msmediaview",
			"nws" => "message/rfc822",
			"oda" => "application/oda",
			"p10" => "application/pkcs10",
			"p12" => "application/x-pkcs12",
			"p7b" => "application/x-pkcs7-certificates",
			"p7c" => "application/x-pkcs7-mime",
			"p7m" => "application/x-pkcs7-mime",
			"p7r" => "application/x-pkcs7-certreqresp",
			"p7s" => "application/x-pkcs7-signature",
			"pbm" => "image/x-portable-bitmap",
			"pdf" => "application/pdf",
			"pfx" => "application/x-pkcs12",
			"pgm" => "image/x-portable-graymap",
			"pko" => "application/ynd.ms-pkipko",
			"pma" => "application/x-perfmon",
			"pmc" => "application/x-perfmon",
			"pml" => "application/x-perfmon",
			"pmr" => "application/x-perfmon",
			"pmw" => "application/x-perfmon",
			"pnm" => "image/x-portable-anymap",
			"pot" => "application/vnd.ms-powerpoint",
			"ppm" => "image/x-portable-pixmap",
			"pps" => "application/vnd.ms-powerpoint",
			"ppt" => "application/vnd.ms-powerpoint",
			"prf" => "application/pics-rules",
			"ps" => "application/postscript",
			"pub" => "application/x-mspublisher",
			"qt" => "video/quicktime",
			"ra" => "audio/x-pn-realaudio",
			"ram" => "audio/x-pn-realaudio",
			"ras" => "image/x-cmu-raster",
			"rgb" => "image/x-rgb",
			"rmi" => "audio/mid",
			"roff" => "application/x-troff",
			"rtf" => "application/rtf",
			"rtx" => "text/richtext",
			"scd" => "application/x-msschedule",
			"sct" => "text/scriptlet",
			"setpay" => "application/set-payment-initiation",
			"setreg" => "application/set-registration-initiation",
			"sh" => "application/x-sh",
			"shar" => "application/x-shar",
			"sit" => "application/x-stuffit",
			"snd" => "audio/basic",
			"spc" => "application/x-pkcs7-certificates",
			"spl" => "application/futuresplash",
			"src" => "application/x-wais-source",
			"sst" => "application/vnd.ms-pkicertstore",
			"stl" => "application/vnd.ms-pkistl",
			"stm" => "text/html",
			"svg" => "image/svg+xml",
			"sv4cpio" => "application/x-sv4cpio",
			"sv4crc" => "application/x-sv4crc",
			"t" => "application/x-troff",
			"tar" => "application/x-tar",
			"tcl" => "application/x-tcl",
			"tex" => "application/x-tex",
			"texi" => "application/x-texinfo",
			"texinfo" => "application/x-texinfo",
			"tgz" => "application/x-compressed",
			"tif" => "image/tiff",
			"tiff" => "image/tiff",
			"tr" => "application/x-troff",
			"trm" => "application/x-msterminal",
			"tsv" => "text/tab-separated-values",
			"txt" => "text/plain",
			"uls" => "text/iuls",
			"ustar" => "application/x-ustar",
			"vcf" => "text/x-vcard",
			"vrml" => "x-world/x-vrml",
			"wav" => "audio/x-wav",
			"wcm" => "application/vnd.ms-works",
			"wdb" => "application/vnd.ms-works",
			"wks" => "application/vnd.ms-works",
			"wmf" => "application/x-msmetafile",
			"wps" => "application/vnd.ms-works",
			"wri" => "application/x-mswrite",
			"wrl" => "x-world/x-vrml",
			"wrz" => "x-world/x-vrml",
			"xaf" => "x-world/x-vrml",
			"xbm" => "image/x-xbitmap",
			"xla" => "application/vnd.ms-excel",
			"xlc" => "application/vnd.ms-excel",
			"xlm" => "application/vnd.ms-excel",
			"xls" => "application/vnd.ms-excel",
			"xlt" => "application/vnd.ms-excel",
			"xlw" => "application/vnd.ms-excel",
			"xof" => "x-world/x-vrml",
			"xpm" => "image/x-xpixmap",
			"xwd" => "image/x-xwindowdump",
			"z" => "application/x-compress",
			"rar" => "application/x-rar-compressed",
			"zip" => "application/zip"
		);
			
		// to find and use specific content type, check out this IANA page : http://www.iana.org/assignments/media-types/media-types.xhtml
		if (array_key_exists($fileExtnesion, $content_types_list)) {
			$contentType = $content_types_list[$fileExtnesion];
		} else {
			$contentType = $default_contentType;
		}
		if (file_exists($filePath)) {
			$size   = filesize($filePath);
			$offset = 0;
			$length = $size;
			//HEADERS FOR PARTIAL DOWNLOAD FACILITY BEGINS
			if (isset($_SERVER['HTTP_RANGE'])) {
				preg_match('/bytes=(\d+)-(\d+)?/', $_SERVER['HTTP_RANGE'], $matches);
				$offset  = intval($matches[1]);
				$length  = intval($matches[2]) - $offset;
				$fhandle = fopen($filePath, 'r');
				fseek($fhandle, $offset); // seek to the requested offset, this is 0 if it's not a partial content request
				$data = fread($fhandle, $length);
				fclose($fhandle);
				header('HTTP/1.1 206 Partial Content');
				header('Content-Range: bytes ' . $offset . '-' . ($offset + $length) . '/' . $size);
			} //HEADERS FOR PARTIAL DOWNLOAD FACILITY BEGINS
			//USUAL HEADERS FOR DOWNLOAD
			header("Content-Disposition: attachment;filename=" . $fileName);
			header('Content-Type: ' . $contentType);
			header("Accept-Ranges: bytes");
			header("Pragma: public");
			header("Expires: -1");
			header("Cache-Control: no-cache");
			header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0");
			header("Content-Length: " . filesize($filePath));
			$chunksize = 8 * (1024 * 1024); //8MB (highest possible fread length)
			if ($size > $chunksize) {
				$handle = fopen($_FILES["file"]["tmp_name"], 'rb');
				$buffer = '';
				while (!feof($handle) && (connection_status() === CONNECTION_NORMAL)) {
					$buffer = fread($handle, $chunksize);
					print $buffer;
					ob_flush();
					flush();
				}
				if (connection_status() !== CONNECTION_NORMAL) {
					echo "Connection aborted";
				}
				fclose($handle);
			} else {
				ob_clean();
				flush();
				readfile($filePath);
			}
		} else {
			echo 'File does not exist!';
		}
	} else {
		echo 'There is no file to download!';
	}
}


/**
 * 文件下载
 * @param  string $file_path 要下载的文件路径
 * @return stream
 */
function downloadFile($file_path) {
	$file_path = iconv("utf-8", "gb2312", $file_path);

	if(!file_exists($file_path)) {
		exit("Error: file not exist!");
	}

	$file_name = basename($file_path);
	$file_size = filesize($file_path);
	$file_count = 0;
	$file_buffer = 1024;

	$fp = fopen($file_path, 'r');
	header("Content-type: application/octet-stream");
	header("Accept-Ranges: bytes");
	header("Accept-Length: {$file_size}");
	header("Content-Disposition: attachment;filename={$file_name}");

	while(!feof($fp) && ($file_size - $file_count > 0)) {
		$file_data = fread($fp, $file_buffer);
		$file_count += $file_buffer;
		echo $file_data;
	}

	fclose($fp);
}


/**
 *文件下载
 *file_dir:文件所在目录
 *file_name:文件名
 *download("/home/xd/桌面/","20131122-GW-表单设计3.0含英文111.xlsx");
 */
function download($file_dir="",$file_name=""){

    $file_dir = chop($file_dir);//去掉路径中多余的空格
    
    //得出要下载的文件的路径
    if($file_dir != '') {
        $file_path = $file_dir;
        if(substr($file_dir,strlen($file_dir)-1,strlen($file_dir)) != '/')
            $file_path .= '/';
        $file_path .= $file_name;
    }
    else{
        $file_path = $file_name;
    }

    //判断要下载的文件是否存在
    if(!file_exists($file_path)) {
        echo 'File not exist.';
        return false;
    }
    $file_size = filesize($file_path);

    header("Content-type: application/octet-stream");
    header("Accept-Ranges: bytes");
    header("Accept-Length: $file_size");
    header("Content-Disposition: attachment; filename=".$file_name);

    $fp = fopen($file_path,"r");
    $buffer_size = 1024;
    $cur_pos = 0;

    while(!feof($fp)&&$file_size-$cur_pos>$buffer_size)
    {
        $buffer = fread($fp,$buffer_size);
        echo $buffer;
        $cur_pos += $buffer_size;
    }

    $buffer = fread($fp,$file_size-$cur_pos);
    echo $buffer;
    fclose($fp);
    return true;
}


?>