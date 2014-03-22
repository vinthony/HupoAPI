<?php
	/**
	* 静态类
	*/
	class StringTools 
	{
		public static function getHotNews($news){
			$titles=array();
			$re=array();
			if(ereg("(cFtMiddle)*(focusNews)", $news)){
				$news=strip_tags($news,'<em>,<a>');
				$dls=explode("em",$news);
				foreach ($dls as $key => $value) {
					if(ereg("titIcon", $value)){
						$title=explode(">",$value);
						$ti = explode("<", $title[1]);
						array_push($titles, $ti[0]);													
					}
					if($key%2 == 0 && $key > 0){
						$links=explode("href=", $value);
						for ($i=0; $i <count($links) ; $i++) { 
							$vals=explode(">",$links[$i]);
							$newsName = strip_tags($vals[1]);
							if($vals[0]!=''&&$vals[1]!=''){
								$newsItem = array(
									"type"=>StringTools::url2Type($vals[0]),
									"url" =>$vals[0],
									"belong"=>end($titles),	
									"title"=>$newsName
								);
								array_push($re,$newsItem);
							}
						}						
					}
				}
			}
			return $re;
		}
		private static function url2Type($url){
			$items=explode('//', $url);
			if(ereg("bbs.hupu.com",$items[1])){
				return "bbs";
			}
			if(ereg("voice.hupu.com",$items[1])){
				return "voice";
			}
			if(ereg("v.hupu.com", $items[1])){
				return "video";
			}
		}
		public static function getGalleryImgs($items){
			$array=array();
			$url="www.hupu.com";
			if(ereg("bigImg", $items)){
				$imgsLink=strip_tags($items,'<a>,<img>');
				$is=explode("<a",$imgsLink);
				for ($i=1; $i <count($is) ; $i++){ 
					$src=explode("\"",$is[$i]);
					$arr=array(
						"link"=>$src[5],
						"img"=>$url.$src[7]
						);
					array_push($array,$arr);			
				}
			}
			return $array;
		}
		
	}

?>