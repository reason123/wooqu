<?php

class groupFeed_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->helper('base_helper');
    }


	/**
	 * 新增Feed条目
	 * @author LJNanest
	 */
	function addFeedItem_old($type,$groupID,$newsID) {
		$newItem = array(
				'type'=>$type,
				'groupID'=>$groupID,
				'newsID'=>$newsID
			);
		$this->db->insert('group_feed',$newItem);
	}

    /**
     * 新增feed条目
     * @author ca007
     * @param int $type 类型
     * @param string $title 标题
     * @param int $userID 发布者ID
     * @param timestamp $time 发布时间
     * @param string $imgurl 图片链接
     * @param string $shortdescription 简介
     * @param string $url 链接
     * @param int $sourceID 源内容ID
     */
    function addFeedItem($type,
                         $title,
                         $userID,
                         $time,
                         $imgurl,
                         $shortdescription,
                         $url,
                         $sourceID){
        $newFeed = array('type'=>$type,
                         'title'=>$title,
                         'userID'=>$userID,
                         'time'=>$time,
                         'imgurl'=>$imgurl,
                         'shortdescription'=>$shortdescription,
                         'url'=>$url,
                         'sourceID'=>$sourceID);
        $this->bd->insert('feed_list',$newFeed);
    }

    /**
     * 发送feed
     * @author ca007
     * @param 
     */
    function sendFeed(){
        
    }

	/*
	* 获取所有新鲜事
	* @author LJNanest
	*/
	function getNewsList_old() {

		$sql = "SELECT DISTINCT group_news.ID, title, content, createTime, deadline FROM group_feed, group_news WHERE (groupID = 0";
		foreach ($_SESSION['myGroup'] as $key => $value)
		{
			$sql = $sql." or groupID = ".$key;
		}
		$sql = $sql.") and group_news.ID = newsID";

		$newsList = $this->db->query($sql)->result_array();
		return $newsList;
	}

    /**
     * 获取所有类型新鲜事
     * @author ca007
     */
    function getNewsList(){
        $sql = "select distinct type,newsID,title,userID,time,imgurl,shortdescription,url";
    }

	function addNews($title,$content)
	{
		$newNews = array(
				'title'=>$title,
				'content'=>$content
			);
		$this->db->insert('group_news',$newNews);
	}
}

?>
