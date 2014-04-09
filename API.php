<?php
	require_once 'simple_html_dom.php';
	require_once 'Curl.class.php';
	/**
	* API
	* 
	*/
	class HupoAPI{

		public static function getIndexPageNews(){
			$html=file_get_html('http://www.hupu.com/');
			
			return $html->find('.focusNews dl a');
		}
		public static function getItemNews($type,$page){
			$html=file_get_html("http://voice.hupu.com/".$type."/newslist/".$page.".html");
			
			return $html->find('.news-list li');
		}
		public static function getItemVoice($type){
			$html=file_get_html("http://voice.hupu.com/".$type);
			
			$list=$html->find(".hot-list .voice-card-list");
			$galleryDiv=$html->find(".focusImg .bd-bigPic li");
			$arr=array(
			"news"=>HupoAPI::getNewsInfoAndImg($list),
			"gallery"=>HupoAPI::getNewsGallery($galleryDiv)
			);
			return $arr;
		}
		
		public static function getNewsInfo($list){
			$arr=array();
			foreach ($list as $element){
				$array=array(
					"title"=>$element->find("h4 a",0)->innertext,
					"readNum"=>$element->find(".readNum",0)->innertext,
					"shortContent"=>$element->find(".list-content span",0)->innertext,
					"link"=>$element->find(".list-content a",0)->href,
					"time"=>$element->find(".other-left a ",0)->innertext,
					"commentNum"=>$element->find(".other-right .btn-comment",0)->plaintext	
					);
				array_push($arr,$array);
			}
			return $arr;
		}
		public static function getNewsPage($url){
			$html=file_get_html($url);
			$arr=array(
				"title"=>$html->find(".artical-title .headline",0)->innertext,
				"article"=>$html->find(".artical-main-content",0)->innertext,
				"img"=>$html->find(".artical-importantPic img",0)->src,
				"comment"=>HupoAPI::getComment($html->find(".comment-list dl",0)),
				"supportNum"=>$html->find(".fn-fl .J_supportNum",0)->innertext
				);		
		}
		public static function getBBSItem($type="rockets",$item='zt',$page='1'){
			/**
			* $item : 主题$type, 精华 $type."-digest", 亮了"/highlight", 视频"/video" 
			**/
			$url="http://bbs.hupu.com/".$type;
			switch ($item) {
				case 'jh':
					$url=$url."-digest-$page.html";
					$html=file_get_html($url);
					$return=HupoAPI::getBBSzt($html->find('#content tr[mid]'));
					break;
				case 'hl':
					$url=$url."/highlights-$page";
					$html=file_get_html($url);
					$return=HupoAPI::getBBShl($html->find(".l_w_reply .floor"));
					break;
				case 'sp':
					$url=$url."/video-$page";
					$html=file_get_html($url);
					$return=HupoAPI::getBBSsp($html->find(".video .p_video"));
					break;
				case 'zt':
				default:
					$url=$url."-$page";
					$html=file_get_html($url);
					$return=HupoAPI::getBBSzt($html->find('#content tr[mid]'));
					break;
			}
			return $return;
			
		}
		public static function getBBSPage($url){
			$html=file_get_html($url);
			$arr=array(
				"title"=>$html->find(".bbs-hd-h1 h1",0)->innertext,
				"bbsInfo"=>$html->find(".bbs-hd-h1 .browse",0)->innertext,
				"main"=>HupoAPI::getBBSFloor($html->find("#t_main div[id=tpc]"),$url),
				"highlight"=>HupoAPI::getBBSFloor($html->find("#readfloor .floor"),$url),
				"floors"=>HupoAPI::getReFloor($html->find("#t_main  .floor"),$url)
				);
			return $arr;
		}
		private static function getReFloor($floors){
			$arr=array();
			foreach ($floors as $floor) {
				if($floor->id=='tpc' || $floor->parent()->id=='readfloor') continue;
				$authorLink=$floor->find(".user a",0)->href;
				$author_id=end(explode("/",$authorLink));
				$a=array(
					"authorIMG"=>$floor->find(".user .headpic img",0)->src,
					"authorLink"=>$authorLink,
					"authorName"=>$floor->find(".floor_box .author .left a",0)->innertext,
					"noFollowLink"=>$urlBase."/".$id."_".$author_id.".html",
					"replyLink"=>$floor->find(".floor_box a[pid]",0)->innertext,
					"time"=>$floor->find(".floor_box .left .stime",0)->innertext,
					"admireNum"=>$floor->find(".floor_box .f444 .stime",0)->innertext,
					"contentText"=>$floor->find(".floor_box table td",0)->plaintext,
					"contentImg"=>HupoAPI::getImgs($floor->find(".floor_box table td img")),
					"contentLink"=>HupoAPI::getLinks($floor->find(".floor_box table td a[href]"))
					);
				array_push($arr,$a);
			}
			return $arr;
		}
		private static function getBBSFloor($floors,$url){
			$urlBase="http://bbs.hupu.com";
			$url=explode("/", $url);
			$id=preg_replace("/.html/","", end($url));
			$arr=array();
			foreach ($floors as $floor ) {
				$authorLink=$floor->find(".user a",0)->href;
				$author_id=end(explode("/",$authorLink));
				$a=array(
					"authorIMG"=>$floor->find(".user .headpic img",0)->src,
					"authorLink"=>$authorLink,
					"authorName"=>$floor->find(".floor_box .author .left a",0)->innertext,
					"noFollowLink"=>$urlBase."/".$id."_".$author_id.".html",
					"replyLink"=>$floor->find(".floor_box a[pid]",0)->innertext,
					"addFavor"=>$floor->find(".floor_box .author .right a",0)->href,
					"time"=>$floor->find(".floor_box .left .stime",0)->innertext,
					"admireNum"=>$floor->find(".floor_box .f444 .stime",0)->innertext,
					"contentText"=>$floor->find(".floor_box table td",0)->plaintext,
					"contentImg"=>HupoAPI::getImgs($floor->find(".floor_box table td img")),
					"contentLink"=>HupoAPI::getLinks($floor->find(".floor_box table td a[href]"))
					);
				array_push($arr,$a);
			}
			return $arr;
		}
		private static function getLinks($links){
			$arr=array();
			foreach ($links as $link){
				$a=array(
					"href"=>$link->parent()->children(0)->href,
					"content"=>$link->parent()->children(0)->innertext
					);
				array_push($arr, $a);
			}
			return $arr;
		}
		private static function getBBSsp($videos){
			$url="http://bbs.hupu.com";
			$arr=array();
			foreach ($videos as $video) {
				$a=array(
					"link"=>$video->find(".img_outer a",0)->href,
					"src"=>$video->find(".img_outer img",0)->src,
					"title"=>$video->find("dl dt a")->innertext,
					"time"=>$video->find("dl dd")->innertext
					);
				array_push($arr, $a);
			}
			return $arr;
		}
		private static function getBBShl($floors){
			$url="http://bbs.hupu.com";
			$arr=array();
			foreach ($floors as $floor ) {
				$a=array(
					"authorIMG"=>$floor->find(".user .headpic img",0)->src,
					"authorLink"=>$floor->find(".user a",0)->href,
					"authorName"=>$floor->find(".floor_box .author a",0)->innertext,
					"time"=>$floor->find(".floor_box .stime",0)->innertext,
					"admireNum"=>$floor->find(".floor_box .f444 .stime",0)->innertext,
					"itemTitle"=>$floor->find(".l_w_re a",0)->innertext,
					"itemLink"=>$url.$floor->find(".l_w_re a",0)->href,
					"contentText"=>$floor->find(".floor_box table td",0)->plaintext,
					"contentImg"=>HupoAPI::getImgs($floor->find(".floor_box table td img")),
					"contentLink"=>HupoAPI::getLinks($floor->find(".floor_box table td a"))
					);
				array_push($arr,$a);
			}
			return $arr;
		}
		private static function getImgs($imgs){
			$arr=array();
			foreach ($imgs as $img){
				$a=array(
					"src"=>$img->parent()->children(0)->src,
					);
				array_push($arr, $a);
			}
			return $arr;
		}
		public static function login($username,$password){
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
				"username"=>$username,
				"password"=>$password,
				"rememberme"=>1
				);
			$curl = new CurlUtil($option);
			$curl->setPost($postData);
			date_default_timezone_set("PRC");
			$sign=intval((time()+mt_rand())/2);
			$curl->setCookieFileLocation($sign);
			$curl->createCURL();
			if($curl->getHttpStatus()<400){
				if(filesize($curl->getCookieFile())< 500){
					return 3;//登录失败
				}else{
					return $sign;
				}
			}else{
				return 4;//服务器无响应
			}

		}
		public static function getLogedHtml($sign,$url){
			$cookie_file="./".$sign.".txt";
			$ch=curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_COOKIEFILE,$cookie_file);
			$page=curl_exec($ch);
			curl_close($ch);
			$html = new simple_html_dom();
			$html->load($page);
			return $html;
		}
		private static function getBBSzt($trs){
			$url="http://bbs.hupu.com";
			$arr=array();
			foreach ($trs as $tr) {
				$a=array(
					"title"=>$tr->find(".p_title",0)->plaintext,
					"href"=>$url.$tr->find(".p_title a",0)->href,
					"author"=>$tr->find(".p_author a",0)->innertext,
					"authorLink"=>$tr->find(".p_author a",0)->href,
					"authorAndTime"=>$tr->find(".p_author a",0)->plaintext,
					"replyAndScan"=>$tr->find(".p_re",0)->innertext,
					"lastReTime"=>$tr->find(".p_retime a",0)->innertext
					);
				array_push($arr, $a);
			}
			return $arr;
		}
		private static function getComment($commentList){
			$arr=array();
			foreach ($commentList as $element) {
				$a=array(
					"userImg"=>$element->find(".userAvatar img",0)->src,
					"userLink"=>$element->find(".userAvatar  a",0)->href,
					"userName"=>$element->find(".userInfo-hd a",0)->innertext,
					"supportNum"=>$element->find(".userInfo-hd .fraction .fraction-num",0)->innertext,
					"replyContent"=>$element->find(".comm-bd .J_reply_content",0)->innertext,
					"time"=>$element->find(".comm-bt .time",0)->innertext
					);
				array_push($arr,$a);
			}
			return $arr;
		}
		private static function getNewsInfoAndImg($list){
			$arr=array();
			foreach ($list as $element) {
				$a=array(
					"title"=>$element->find(".card-fullText-hd a",0)->innertext,
					"content"=>$element->find(".voice-card-content span",0)->innertext,
					"photo"=>$element->find(".card-smaillPhoto img",0)->src,
					"time"=>$element->find(".voice-card-otherInfo .time",0)->innertext,
					"commentNum"=>$element->find(".btn-comment",0)->plaintext,
					"admireNum"=>$element->find(".voice-card-fn .support-num",0)->innertext
					);
				array_push($arr,$a);
			}
			return $arr;
		}
		private static function getNewsGallery($gallery){
			$arr=array();
			foreach ($gallery as $element ) {
				$a=array(
					"img"=>$element->find("img",0)->src,
					"title"=>$element->find(".content-text a",0)->innertext,
					"text"=>$element->find(".content-text .textInfo",0)->innertext
					);
				array_push($arr, $a);
			}
			return $arr;
		}
	}
?>