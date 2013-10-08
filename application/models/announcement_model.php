<?php

class Announcement_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}

	function test(){
		return "OK";
	}

    /**
     * 获取公告详细信息
     * @author cathayandy
     */
    function getAnnInfo($annID){
        $sql = "select announcement_list.ID,nickName,content,data,title,pic,url,publisher from announcement_list,user_list where (user_list.ID=announcement_list.userID) AND (announcement_list.ID=?) ORDER BY announcement_list.ID DESC";
        $annList = $this->db->query($sql,array($annID))->result_array();
        return $annList[0];
    }
    
    /**
     * 获取本群组公告
     * @author cathayandy
     * @param string $groupList 群组List
     */
	function getAnnList($groupList, $annTypeList){
		$annType = array();
		if($annTypeList == 'all')
			for($i = 0; $i < 3; $i ++)
				array_push($annType,$i);
		if($annTypeList == 'activities')
			array_push($annType,0);
		if($annTypeList == 'tuan')
			array_push($annType,1);
		if($annTypeList == 'discussion')
			array_push($annType,2);
		$sql = "select distinct announcement_list.ID,nickName,content,data,title,pic,url,publisher from announcement_list,user_list where (user_list.ID=announcement_list.userID) AND (";
		$arrayID = array();
		foreach($groupList as $i => $group) {
			$sql .= "(groupID=?) OR ";
			array_push($arrayID,$i);
		}
		$sql = substr($sql,0,strlen($sql) - 4);
		$sql .= ") AND (";
		foreach($annType as $i => $type) {
			$sql .= "(type=?) OR ";
			array_push($arrayID,$type);
		}
		$sql = substr($sql,0,strlen($sql) - 4);
		$sql .= ") ORDER BY announcement_list.ID DESC";
		$annList = $this->db->query($sql,$arrayID)->result_array();
		return $annList;
	}

    /**
     * 新增公告
     * @author cathayandy
     * @param string $groupID 群组ID
     * @param string $title 公告标题
     * @param string $content 公告内容
     * @param string $url 公告链接
     * @param string $pic 公告图片
     */
    function newAnnouncement($groupID,$title,$content,$url,$pic,$type){
        $this->load->model('user_model','user');
        /*if(!$this->user->isGroupManager($groupID)){
            return $this->user->test();
            return errorMessage(-10,"没有权限发布该群组公告");
        }*/
        $newAnnouncement = array(
            'userID'=>$_SESSION['userID'],
            'groupID'=>$groupID,
            'title'=>$title,
            'content'=>$content,
            'pic'=>$pic,
            'url'=>$url,
			'type'=>$type);
        $this->db->insert('announcement_list',$newAnnouncement);
        return errorMessage(1,"发布成功");
    }

}

?>