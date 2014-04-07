<?php
/**
* CURL
* @param $url;
*        $folocation(followlocation);启用时 服务器返回的"Location: "放在header中递归的返回给服务器，使用CURLOPT_MAXREDIRS可以限定递归返回的数量。
*		 $timeOut //设置cURL允许执行的最长秒数。
*		 $maxRed(maxRedirects) //指定最多的HTTP重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的。
*		 $noBody 启用时将不对HTML中的BODY部分进行输出。
*		 $includeHeader 
*
*/		
class CurlUtil{
	private $_useragent="Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)"; 
	private $_url;
	private $_followlocation;
	private $_timeOut;
	private $_maxRedirects;
	private $_cookieFileLocation = "/cookie.txt"; 
	private $_post;
	private $_noBody;
	private $_session;
	private $_includeHeader;
	private $_binaryTransfer;
	private $_webPage;
	private $_status;
	private $_referer="http://www.hupu.com";
	public $authentication = 0;
	public $auth_name	   = '';
	public $auth_pwd       = '';

	public function useAuth($use=false){
		if($use)
			$this->authentication = 1;
		else
			$this->authentication = 0;
	}
	public function setName($name){
		if(!is_null($name))
			$this->auth_name = $name;
		else
			throw new Exception("name is null");
	}
	public function setPwd($pwd){
		if(!is_null($pwd))
			$this->pwd = $pwd;
		else
			throw new Exception("password is null");
	}
	function __construct($arr){
		$this->_url = $arr['url'];
		$this->_followlocation = $arr['folocation'];
		$this->_timeOut = $arr['timeOut'];
		$this->_maxRedirects = $arr['maxRed'];
		$this->_noBody = $arr['noBody'];
		$this->_includeHeader = $arr['includeHeader'];
		$this->_binaryTransfer = $arr['binaryTrans'];
		$this->_cookieFileLocation = dirname(__FILE__)."/cookie.txt";
	}

	function __destruct(){
		unset($arr);
	}
     public function setReferer($referer){ 
       $this->_referer = $referer; 
     } 

     public function setCookieFileLocation($path) 
     { 
     	 $fp=fopen("./".$path.".txt","w+");
     	 chmod("./".$path.".txt", 0777);
     	 if(!is_writable("./".$path.".txt"))
     	 	die("file not is_writable");
         $this->_cookieFileLocation = "./".$path.".txt"; 
     } 

     public function setPost($postFields) 
     { 
        $this->_post = true; 
        $this->_postFields = $postFields; 
     } 

     public function setUserAgent($userAgent) 
     { 
         $this->_useragent = $userAgent; 
     } 

	public function createCURL($url = NULL){
		if(!is_null($url))
			$this->_url = $url;
		$ch=curl_init();
		$options=array(
					  CURLOPT_URL => $this->_url,
					  CURLOPT_HTTPHEADER => array('Expect:'),
					  CURLOPT_TIMEOUT => $this->_timeOut,
					  CURLOPT_MAXREDIRS => $this->_maxRedirects,
					  CURLOPT_RETURNTRANSFER => $this->_followlocation,
					  CURLOPT_COOKIEJAR => $this->_cookieFileLocation,
					  CURLOPT_COOKIEFILE => $this->_cookieFileLocation
					);
		curl_setopt_array($ch, $options);
		if($this->authentication)
			curl_setopt($ch, CURlOPT_USERPWD,$this->auth_name.":".$this->auth_pwd);
		if($this->_post){
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$this->_postFields);
		}
		if($this->_includeHeader)
			curl_setopt($ch, CURLOPT_HEADER, true);
		if($this->_noBody)
			curl_setopt($ch, CURLOPT_NOBODY, true);
		//curl_setopt($ch,CURlOPT_USERAGENT, $this->_useragent);
		curl_setopt($ch,CURLOPT_REFERER, $this->_referer);
		$this->_webPage=curl_exec($ch);
		$this->_status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
		curl_close($ch);
	}
	public function getHttpStatus(){
		return $this->_status;
	}
	public function getPage(){
		return $this->_webPage;
	}	
}
?>