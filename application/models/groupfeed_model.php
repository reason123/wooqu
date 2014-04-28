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
                         $sourceID,
                         $deadline,
                         $param1){
        $newFeed = array('type'=>cleanString($type),
                         'title'=>cleanString($title),
                         'userID'=>cleanString($userID),
                         'time'=>cleanString($time),
                         'imgurl'=>cleanString($imgurl),
                         'shortdescription'=>cleanString($shortdescription),
                         'url'=>cleanString($url),
                         'sourceID'=>cleanString($sourceID),
                         'endTime'=>cleanString($deadline),
                         'param1'=>cleanString($param1));
        $this->db->insert('feed_list',$newFeed);
    }

    /**
     * 发送feed
     * @author ca007
     * @param int $type 类型
     * @param int $sourceID 源内容ID
     * @param string $groupID 群组ID
     * @param int $state feed状态
     */
    function sendFeed($type, $sourceID, $groupID, $state = 0){
        $feedList = $this->db->from('feed_list')->where('type',$type)->where('sourceID',$sourceID)->get()->result_array();
        if(!count($feedList)){
            return errorMessage('-1','No such feed');
        }
        $feedID = $feedList[0]['ID'];
        $newRelation = array('groupID'=>$groupID,
                             'newsID'=>$feedID,
                             'state'=>$state);
        $this->db->insert('group_feed',$newRelation);
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

    function getNews($type,$sourceID)
    {
        $sql = "select distinct feed_list.ID, 
                                type, 
                                title, 
                                nickName as userName, 
                                time, 
                                imgurl, 
                                shortdescription, 
                                url, 
                                sourceID,
                                startTime,
                                endTime,
                                total,
                                param1,
                                priority
               from feed_list, user_list
               where feed_list.type = ? AND feed_list.sourceID = ? AND userID = user_list.ID";
        $news = $this->db->query($sql,array($type,$sourceID))->result_array();
        return $news[0];
    }

    /**
     * 获取所有类型新鲜事
     * @author ca007
     */
    function getNewsList(){
        $sql = '';
        if(!isset($_SESSION['loginName'])){
            $sql = "select distinct feed_list.ID, 
                                type, 
                                title, 
                                nickName as userName, 
                                time, 
                                imgurl, 
                                shortdescription, 
                                url, 
                                sourceID,
                                startTime,
                                endTime,
                                total,
                                param1,
                                feed_list.priority
               from feed_list, group_feed, user_list
               where feed_list.ID=group_feed.newsID and userID=user_list.ID
                     and group_feed.state=1 and group_feed.groupID LIKE '_________0000' order by feed_list.priority desc,feed_list.ID desc";
        }else{
            $sql = "select distinct feed_list.ID, 
                                type, 
                                title, 
                                nickName as userName, 
                                time, 
                                imgurl, 
                                shortdescription, 
                                url, 
                                sourceID,
                                startTime,
                                endTime,
                                total,
                                param1, 
                                feed_list.priority
               from feed_list, group_feed, user_list
               where userID=user_list.ID and feed_list.ID=group_feed.newsID 
                     and group_feed.state=1 and (";
            $count = 0;
            foreach($_SESSION['myGroup'] as $groupID => $groupInfo){
                if($count != 0) $sql = $sql."or ";
                $sql = $sql."groupID=".$groupID." ";
                $count += 1;
            }
            $sql = $sql.") order by feed_list.priority desc,feed_list.ID desc";
        }
        $newsList = $this->db->query($sql)->result_array();
        return $newsList;
    }

    /**
     * 获取指定类型的新鲜事
     * @author ca007
     * @param int $type 类型
     */
    function getNewsListByType($type){
        if(!isset($_SESSION['loginName'])){
        $sql = "select distinct feed_list.ID, 
                                type, 
                                title, 
                                nickName as userName, 
                                time, 
                                imgurl, 
                                shortdescription, 
                                url, 
                                sourceID,
                                startTime,
                                endTime,
                                total,
                                param1, 
                                feed_list.priority
               from feed_list, group_feed, user_list
               where userID=user_list.ID and feed_list.ID=group_feed.newsID 
                     and group_feed.state=1 and type=? and group_feed.groupID LIKE '_________0000' order by feed_list.priority desc, feed_list.ID desc";
        }else{
            $sql = "select distinct feed_list.ID, 
                                type, 
                                title, 
                                nickName as userName, 
                                time, 
                                imgurl, 
                                shortdescription, 
                                url, 
                                sourceID,
                                startTime,
                                endTime,
                                total,
                                param1, 
                                feed_list.priority
               from feed_list, group_feed, user_list
               where userID=user_list.ID and feed_list.ID=group_feed.newsID 
                     and group_feed.state=1 and type=? and (";
            $count = 0;
            foreach($_SESSION['myGroup'] as $groupID => $groupInfo){
                if($count != 0) $sql = $sql."or ";
                $sql = $sql."groupID=".$groupID." ";
                $count += 1;
            }
            $sql = $sql.") order by feed_list.priority desc,feed_list.ID desc";
        }
        $newsList = $this->db->query($sql,array($type))->result_array();
        return $newsList;
    }

    /**
     * 审批通过新鲜事
     * @author ca007
     * @param int $relationID
     */
    function passFeed($relationID){
        $tmp = $this->db->from('group_feed')->where('ID',$relationID)->get()->result_array();
        if(!count($tmp)){
            return errorMessage(-1,'No such relation');
        }
        if(!$this->permission_model->manageGroup($tmp[0]['groupID'])){
            return errorMessage(-2,'No permission');
        }
        $updateState = array('state'=>1);
        $this->db->where('ID',$relationID)->update('group_feed',$updateState);
        return errorMessage(1,'OK');
    }
    
    /**
     * 关闭新鲜事
     * @author ca007
     * @param int $relationID
     */
    function closeFeed($relationID){
        $tmp = $this->db->from('group_feed')->where('ID',$relationID)->get()->result_array();
        if(!count($tmp)){
            return errorMessage(-1,'No such relation');
        }
        if(!$this->permission_model->manageGroup($tmp[0]['groupID'])){
            return errorMessage(-2,'No permission');
        }
        $updateState = array('state'=>0);
        $this->db->where('ID',$relationID)->update('group_feed',$updateState);
        return errorMessage(1,'OK');
    }
    
    /**
     * 删除新鲜事
     * @author ca007
     * @param int $feedID
     */
    function delFeed($relationID){
        $tmp = $this->db->from('group_feed')->where('ID',$relationID)->get()->result_array();
        if(!count($tmp)){
            return errorMessage(-1,'No such relation');
        }
        if(!$this->permission_model->manageGroup($tmp[0]['groupID'])){
            return errorMessage(-2,'No permission');
        }
        $this->db->delete('group_feed',array('ID'=>$relationID));
        return errorMessage(1,'OK');
    }
    
    /**
     * 修改feed条目
     * @author LJNanest
     * @param int $type 类型
     * @param string $title 标题
     * @param int $userID 发布者ID
     * @param timestamp $time 发布时间
     * @param string $imgurl 图片链接
     * @param string $shortdescription 简介
     * @param string $url 链接
     * @param int $sourceID 源内容ID
     */
    function modifyFeedItem($type,
                         $title,
                         $imgurl,
                         $shortdescription,
                         $sourceID,
                         $deadline,
                         $param1){
        $sql = "UPDATE feed_list SET title = ?, imgurl = ?,shortdescription = ?,endTime =? , param1 = ? WHERE type = ? AND sourceID = ?";
		$res = $this->db->query($sql, array(cleanString($title),cleanString($imgurl),cleanString($shortdescription),cleanString($deadline),cleanString($param1),cleanString($type),cleanString($sourceID))) or die(mysql_error());
    }

    function initNewFeed(){
        $sql = "select * from feed_list";
        $res = $this->db->query($sql)->result_array();
        $this->load->model('groupbuy_model','gb');
        foreach($res as $key => $feed){
            if($feed['type'] == 1){
                //团购活动
                $g_sql = "select * from groupbuy_list where ID=?";
                $groupbuy_list = $this->db->query($g_sql, array($feed['sourceID']))->result_array();
                $gb = $groupbuy_list[0];
                //echo json_encode($gb);
                $update_sql = "update feed_list set startTime=?,endTime=?,total=? where feed_list.ID=?";
                $tmp_total = $this->gb->getGroupbuyTotalByID($gb['id']);
                $this->db->query($update_sql, array($gb['createTime'], $gb['deadline'], $tmp_total, $feed['ID']));
            }else{
                $a_sql = "select * from activity_list where ID=?";
                $activity_list = $this->db->query($a_sql, array($feed['sourceID']))->result_array();
                $act = $activity_list[0];
                echo json_encode($act);
                $update_sql = "update feed_list set startTime=?,endTime=?,total=? where feed_list.ID=?";
                $this->db->query($update_sql, array($act['sign_start_date'], $act['sign_end_date'], $act['total'], $feed['ID']));
            }
        }
        return $res;
    }

    function clearGroupByFeedID($feedID)
    {
        $sql = "DELETE FROM group_feed WHERE newsID = ?";
        $this->db->query($sql,array($feedID));
    }
}

?>
