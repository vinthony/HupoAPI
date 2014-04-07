<?php
require_once 'API.php';
require_once 'Curl.class.php';
require_once 'simple_html_dom.php';
echo "<meta charset='gb2312'>";
$item=$_GET['item'];
$type=$_GET['type'];
$bbsType=$_GET['bbstype'];
$uname=$_GET['uname'];
$pwd=$_GET['pwd'];
$cookie_file="./cookie.txt";
if($item=="voice"){
	echo json_encode(HupoAPI::getItemVoice($type));
}
if($item=="bbs"){
	echo print_r(HupoAPI::getBBSItem($type,'hl'));
}
if($item=="page"){
	echo print_r(HupoAPI::getBBSPage("http://bbs.hupu.com/9222995.html"));
}
if($item=="entry"){
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
	"username"=>$uname,
	"password"=>$pwd,
	"rememberme"=>1
	);
	$curl = new CurlUtil($option);
	$curl->setPost($postData);
	$curl->setCookieFileLocation($uname);
	$curl->createCURL();
	if($curl->getHttpStatus()<400){
		echo "entry";
	}else{
		echo "error";
	}
}
if($item=="upload"){
	$cookie_file="./".$uname.".txt";
	$ch=curl_init();
	$url="http://bbs.hupu.com";
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_COOKIEFILE,$cookie_file);
	$page=curl_exec($ch);
	curl_close($ch);
	$html = new simple_html_dom();
	$html->load($page);
	echo $html->find('ul[id=myforums_list] li a ',1)->innertext;
}
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
