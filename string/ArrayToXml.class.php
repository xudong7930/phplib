<?php
/**
  * ===========================================
  * Project: phplib
  * Function: 数组转XML
  * Time: 2015-5-20 15:22:16 @ Create
  * Copyright (c) 2007 - 2015 phplib Studio
  * Github: https://github.com/xudong7930/phplib
  * Developer: phplib
  * E-mail: xudong7930@gmail.com
  * Example:
	$opt = new ArrayToXML();
	header('Content-Type: text/xml');
	$data=array(
		0=>	array("name"=>"xudong","from"=>"15811448243","to"=>"13668487930","date"=>"2012-12-12","content"=>"I love you")
	);
	echo $opt->toXml($data);
  * ===========================================
  */ 

  
class ArrayToXML
{
	/**
	 * The main function for converting to an XML document.
	 * Pass in a multi dimensional array and this recrusively loops through and builds up an XML document.
	 *
	 * @param array $data
	 * @param string $rootNodeName - what you want the root node to be - defaultsto data.
	 * @param SimpleXMLElement $xml - should only be used recursively
	 * @return string XML
	 */
	public static function toXml($data, $rootNodeName = 'root', $xml=null)
	{
		// turn off compatibility mode as simple xml throws a wobbly if you don't.
		if (ini_get('zend.ze1_compatibility_mode') == 1)
		{
			ini_set ('zend.ze1_compatibility_mode', 0);
		}

		if ($xml == null)
		{
			$xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName/>");
		}

		// loop through the data passed in.
		foreach($data as $key => $value)
		{
			// no numeric keys in our xml please!
			if (is_numeric($key))
			{
				// make string key...
				$key = "item_". (string)$key;
			}

			// replace anything not alpha numeric
			$key = preg_replace('/[^a-z]/i', '', $key);

			// if there is another array found recrusively call this function
			if (is_array($value))
			{
				$node = $xml->addChild($key);
				// recrusive call.
				ArrayToXML::toXml($value, $rootNodeName, $node);
			}
			else
			{
				// add single node.
				$value = htmlentities($value);
				$xml->addChild($key,$value);
			}

		}
		// pass back as string. or simple xml object if you want!
		return $xml->asXML();
	}
}