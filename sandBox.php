<?php
require_once 'API.php';
require_once 'Curl.class.php';
echo "<meta charset='utf-8'>";

print_r(HupoAPI::getBBSItem("rockets"));
/*
$option=array(
	"url"=>"http://passport.hupu.com/login?from=myIndex",
	"folocation"=>true,
	"timeOut"=>4,
	"maxRed"=>4,
	"noBody"=>false,
	"includeHeader"=>false,
	"binaryTrans"=>false
);
$postData=array(
	"username"=>"橘子不说话",
	"password"=>"bjyz330681740",
	"rememberme"=>1
	);
$curl = new CurlUtil($option);
$curl->setPost($postData);
$curl->createCURL();
$html=new simple_html_dom();
//echo $curl->getPage();
$html->load($curl->getPage());
echo $html;
$userUrl=$html->find(".hasLogin .userImports a")->href;
echo $userUrl;
//$myHtml = file_get_html($userUrl);
//echo $myHtml->find(".personal .mpersonal div");
*/
?>
