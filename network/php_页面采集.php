<?php 

/**
 * 获取指定页面的url链接
 * @param  [type] $url [description]
 * @return [type]      [description]
 */
function get_page_link($url){
	$html = file_get_contents($url);

	$dom  = new DOMDocument();
	
	@$dom->loadHTML($html);
	
	$xpath = new DOMXPath($dom);
	
	$hrefs = $xpath->evaluate('/html/body//a');

	$url_link = array();

	for ($i = 0; $i < $hrefs->length; $i++) {
	    $href = $hrefs->item($i);
	    $url  = $href->getAttribute('href');
	    
	    // 保留以http开头的链接
	    if (substr($url, 0, 4) == 'http'){
	        $url_link[$i] = $url;
	    }
	}

	return $url_link;
}


?>