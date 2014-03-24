HupoAPI
=======
How to use:
---
	require_once("simple_html_dom.php");
	require_once("API.php");
	echo HupoAPI::getNewsPage("http://voice.hupu.com/china/1652736.html");
	//就能获得单个界面数据
	
####simple_html_dom.php :DOM相关操作
####Curl.class.php ： 存放相关curl处理的类
    + public useAuth 用户授权信息
    + public setName 设置用户名
    + public setPwd  设置密码
    + public setReferer 设置获取方式
    + public setCookieFileLocation 设置cookie文件存放位置
    + public setPost 设置Post方式
    + public setUserAgent 设置用户代理
    + public createCURL 创建一个curl服务
    + public getHttpStatus 得到当前连接的http状态码
    + public getPage 得到当前url下的网页内容
####API.php: 静态类 实现API

    + public getIndexPageNews() 获取当前主页的新闻，抓取的是class=focusNews (utf-8)
    + public getItemNews($type,$page) 获取虎扑新声内容 newlist;
	    - @param $type=["china","soccer","cba","nba","sports","tennis","wcba","f1"] 
	    - @param $page=[1,2,3,.....] 实现分页
	    - @return $list dom对象	
    + public getNewsInfo($list); 获得数据，返回数组 
	    - @param $list getItemNews返回的list
	    - @return (array)
		    * title
		    * readNum
		    * shortContent
		    * link
		    * time
		    * commentNum 	
	+ public getNewsPage($url) 获得新闻界面具体信息
		- @param $url
		- @return (array)
			* title
			* article
			* img
			* comment
			* supportNum
	+ private getComment($commentList) 获得新闻评论列表信息
		- @param $commentList
		- @return (array)
			* userImg
			* userLink
			* supportNum
			* replyContent
			* time
	+ private getItemVoice($type) 获取新声内容
		- @param $type  同getItemNews的type
		- @return (array)
			* news /*array*/ 同 getNewsInfoAndImg 的返回值
			* gallery /*array*/ 同 getNewsGallery 的返回值
	+ public getBBSItem($type) 				
		//todo
	+ private getNewsInfoAndImg($list) 获取新声的主页内容
		- @param $list 取到新声首页数据
		- @return (array)
			* title
			* content
			* photo
			* commentNum
			* admireNum
	+ private getNewsGallery($gallery) 获取新声主页的gallery
		- @param gallery 获取新声首页gallery
		- @return (array)
			* img
			* title
			* text
					