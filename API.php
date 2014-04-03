<?php
	require_once 'simple_html_dom.php';
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
		public static function getBBSItem($type,$item='zt'){
			/**
			* $item : 主题$type, 精华 $type."-digest", 亮了"/highlight", 视频"/video" 
			**/
			$url="http://bbs.hupu.com/".$type;
			switch ($type) {
				case 'jh':
					$url=$url."-digest";
					break;
				case 'll':
					$url=$url."/highlight";
					break;
				case 'sp':
					$url=$url."/video";
					break;
				case 'zt':
				default:
					$html=file_get_html($url);
					$return=HupoAPI::getBBSzt($html->find('#content tr[mid]'));
					break;
			}
			return $return;
			
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