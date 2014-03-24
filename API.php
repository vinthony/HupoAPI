<?php
	require_once 'simple_html_dom.php';
	/**
	* API
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
				"comment"=>HupoAPI::getComment($html->find(".comment-list dl")),
				"supportNum"=>$html->find(".fn-fl .J_supportNum")->innertext
				);		
		}
		public static function getBBSItem($type){
			$html=file_get_html("http://bbs.hupu.com/".$type);

		}
		private static function getComment($commentList){
			$arr=array();
			foreach ($commentList as $element) {
				$a=array(
					"userImg"=>$element->find(".userAvatar img")->src,
					"userLink"=>$element->find(".userAvatar  a")->href,
					"userName"=>$element->find(".userInfo-hd a")->innertext,
					"supportNum"=>$element->find(".userInfo-hd .fraction .fraction-num")->innertext,
					"replyContent"=>$element->find(".comm-bd .J_reply_content")->innertext,
					"time"=>$element->find(".comm-bt .time")->innertext
					);
			}
		}
	}
?>