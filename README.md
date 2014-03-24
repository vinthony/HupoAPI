HupoAPI
=======
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
	+ public getBBSItem($type) 				