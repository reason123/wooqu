<?php

class groupFeed_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->helper('base_helper');
    }


	/**
	 * 新增Feed条目
	 * author LJNanest
	 */
	function addFeedItem($type,$groupID,$newsID) {
		$newItem = array(
				'type'=>$type,
				'groupID'=>$groupID,
				'newsID'=>$newsID
			);
		$this->db->insert('group_feed',$newItem);
	}

	/*
	* 获取所有新鲜事
	* author LJNanest
	*/
	function getNewsList() {

		$sql = "SELECT DISTINCT group_news.ID, title, content, createTime, deadline FROM group_feed, group_news WHERE (groupID = 0";
		foreach ($_SESSION['myGroup'] as $key => $value)
		{
			$sql = $sql." or groupID = ".$key;
		}
		$sql = $sql.") and group_news.ID = newsID";

		$newsList = $this->db->query($sql)->result_array();
		return $newsList;
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
