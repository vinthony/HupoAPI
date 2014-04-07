HupoAPI
=======
todo:
-----
	1.登录->服务器端存储 用户名文件
	2.获取登陆后数据->调用cookie
	3.回帖
	4.引用获取不到url（替代方案？）
	5.亮了功能实现
	6.other
	
How to use:
---
	require_once("simple_html_dom.php");
	require_once("API.php");
	echo HupoAPI::getNewsPage("http://voice.hupu.com/china/1652736.html");
	//就能获得单个界面数据
	
####simple_html_dom.php :DOM相关操作
[点击这里查看](http://www.ecartchina.com/php-simple-html-dom/manual.htm#section_quickstart)
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
	+ public getBBSItem($type,$items,$page) 
		- @param $type=["vote","rockets","lakers","knicks","heat","celtics","nba","shenlan","mavericks","bulls","clippers","spurs","thunder","zhidao","caipan","suns","magic","pelicans","wizards","nets","blazers","warriros","pistons","grizzlies","pacers","sixers","timberwolves","jazz","nuggets","cavaliers","bobcats","kings","raptors","bucks","hawks","nba-draft-ncaa","fiba","wnba","Spinacia","fba","games","photo"] //nba 
				 $type=["cba","cbatalk","dongguan","zhejiang","guangdong","shanghai","jiangsu","beijing","liaoning","xinjiang","bayi","guangsha","shanxi","3893","shandong","3895","jilin","fujian","tianjin","foshan","qingdao","sichuan","cuba","asiabasket","nbl","wcba","cba-feedback"] //cba
				 $type=["national","zuqiushizhan","soccer","china-soccer","topic","yingchao","xijia","yijia","dejia","frfootball","yaoren","soccer-gear","knowing","soccer-rumors","euroleagues","meizhouzuqiu","gys","soccer-media","soccer-game","fyt-soccer","soccer-gm","soccer-feedback","fresh","2857"] //足球
				 $type=["bxj","kfq","ent","acg","nba2k","NBA2Konline","game","music","love","job","cate","lady","1233","digital","letswork","finance","3995"]	//甘比亚
				 $type=["sports","REDBULLTVC","nfl","mma","billiards","xgames","cycling","hockey","yumaoqiu","tennis","federer","djokovic","nadal","andymurray","tsonga","tennisgear","tennisvideo","tplayer","fyt-tennis","running","3829-2","outdoors","outdoorgear","fyt-sport"]//综合体育
				 $type=["gear","jersey","in","kixDesign","qanda","jianding","c2c","2","qiugou","paimai","brandfeedback","shihuo","gearfeedback"]//运动装备
				 $type=["f1","ferrari","mclaren","redbull","benz","msc","renault","iceman","williams","fyt-f1","f1-video","fernandoalonso","cars","f1-topic","wrc","motogp","autoracing","cars","roc","fia","f1-games"]//f1赛车
				 $type=["streetball","freestyle","home","fit","hccares"]//实战健身
				 $type=["lancai","zucai","shuzicai","caipiao"]//彩票中心
				 $type=["feedback"]	    //站务中心 
		- @param $items=["zt","jh","hl","sp"]/分别对应 主题，精华，亮了，视频
		- @param $page /* int */ 页数
		- @return /*array*/
			(getBBSzt,getBBShl,getBBSsp)返回值其中之一	+ public getBBSpage($url) 获得帖子详细界面
		- @param $url 帖子链接
		- @return (array)
			* title
			* bbsInfo
			* main /*array*/ see return getBBSFloor
			* highlight /*array*/ see return getBBSFloor
			* floors /*array*/ see return getReFloor
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
	
	+ private getNewsInfoAndImg($list) 获取新声的主页内容
		- @param $list 取到新声首页数据
		- @return (array)
			* title
			* content
			* photo
			* commentNum
			* admireNum
	+ private getNewsGallery($gallery) 获取新声主页的gallery
		- @param $gallery 获取新声首页gallery
		- @return (array)
			* img
			* title
			* text
	+ private getBBSzt($trs) 获取到帖子列表信息
		- @param $trs 帖子页table 中tr
		- @return (array)
			* title
			* href
			* author
			* authorLink
			* authorAndTime
			* replyAndScan
			* lastReTime
	+ private getBBShl($floors) 获取亮了的每个楼
		- @param $floors 亮了页 class=floor
		- @return (array)
			* authorIMG
			* authorLink
			* authorName
			* time
			* admireNum
			* itemTitle
			* itemLink
			* contentText
			* contentImg				
	- private getBBSsp($videos) 获得视频页列表
		- @param $videos 视频页 class=p_video
		- @return (array)
			* link
			* src
			* title 				
			* time
	- getImgs($imgs) //imgs标签
		- @param $imgs
		- @return (array)
			* src 		
	- getLinks($links) //a 标签
		- @param $links
		- @return 		