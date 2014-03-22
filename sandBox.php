<?php
require_once 'Curl.class.php';
require_once 'StringTools.class.php';
echo "<meta charset='utf-8'>";
$options=array(
		"url"=>"http://www.hupu.com/",
		"folocation"=>true,
		"timeOut"=>3,
		//"maxRed"=>4,
		"binaryTrans"=>false,
		"includeHeader"=>false,
		"noBody"=>false,
	);
$curl = new CurlUtil($options);
$curl->createCURL();
$items=explode("div",$curl->getPage());
//print_r(StringTools::getHotNews($items[55]));
print_r(StringTools::getGalleryImgs($items[41]));
?>