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
	}
?>