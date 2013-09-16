<?php
/**
 * 检查服务器环境是否为sae
 */
function checkSae(){
	return isset($_SERVER['HTTP_APPNAME']);
}

/**
 * 返回checkload
 */
function checkload(){
	return 'checkload';
}

/**
 * 将用户提交内容中的<>转化为&gt;&lt;
 * @param string $str 带清洗字符串
 * @return string 清洗后字符串
 */
function cleanString($str){
	return str_replace('>', '&gt;', str_replace('<', '&lt;', $str));
}

/**
 * 检查用户登录状态
 * @return boolean 是否已登录
 */
function checkState(){
	if(isset($_SESSION['loginName'])){
		return TRUE;
	}else{
		return FALSE;
	}
}

/**
 * 返回错误信息数组
 */
function errorMessage($code, $message){
	return array('error'=>array('code'=>$code,'message'=>$message));
}

/**
 * 跳转到主页
 */
function gotoHomepage(){
	header('Location: /');
}

/**
 * 修改sesson
 * @param string $sessionKey 
 * @param string $sessionValue
 */
function setSession($sessionKey, $sessionValue){
	if(isset($_SESSION[$sessionKey])){
		unset($_SESSION[$sessionKey]);
	}
	$_SESSION[$sessionKey] = $sessionValue;
}

/**
 * http post
 * @param string $url url to fetch
 * @param array $param area
 * @return data url return
 */
function myPost($url,$param){
	if(!checkSae()){
		$paramString = "";
		foreach ($param as $key => $value) {
			$paramString = $paramString.$key."=".$value."&";
		}
		if($paramString != "")
			$paramString[strlen($paramString) - 1] = '';
		$res = http_post_data($url,$paramString);
		return http_parse_message($res)->body;
		//return $paramString;
	}else{
		$saePost = new SaeFetchurl();
		$saePost->setMethod("post");
		$saePost->setPostData($param);
		$content = $saePost->fetch($url);
		if($saePost->errno() == 0) return $content;
		else return $saePost->errmsg();
	}
}

/**
 * http get
 * @param string $url url to get
 * @return data url return
 */
function myGet($url,$param){
	$paramString = "?";
	foreach ($param as $key => $value) {
		$paramString = $paramString.$key."=".$value."&";
	}
	if($paramString != "")
		$paramString[strlen($paramString) - 1] = '';

	if(!checkSae()){
		$res = http_get($url.$paramString);
		return http_parse_message($res)->body;
		//return $paramString;
	}else{
		$saePost = new SaeFetchurl();
		$content = $saePost->fetch($url.$paramString);
		if($saePost->errno() == 0) return $content;
		else return $saePost->errmsg();
	}
}

/**
 * 返回当前时间
 */
function nowTime(){
	return date("Y-m-d H:i:s");
}

function isGID($groupID){
    return strlen($groupID) == 13;
}

/**
 * 检查用户是否登录
 * @author ca007
 */
function isLogin(){
    return isset($_SESSION['userID']);
}

?>