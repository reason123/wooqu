<?php

class volUserCareer_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->helper('base_helper');
    }

    function getUserInfo($userID)
    {
    	$sql = "SELECT DISTINCT realName, studentID, careerLength, valuing FROM user_list, vol_user_career WHERE user_list.ID = ? and vol_user_career.userID = ?";
    	$tmp = $this->db->query($sql, array($userID,$userID))->result_array();
    	return $tmp[0];
    }
		
	function getUserCareerList($userID)
	{
		$sql = "SELECT sign_list.actID, activity_list.title, sign_list.time FROM sign_list, activity_list WHERE sign_list.userID = ? and sign_list.actID = activity_list.ID and activity_list.baseType = 1";
	//return $sql;
	//	$sql = "SELECT sign_list.actID FROM sign_list,activity_list  WHERE sign_list.userID = ? and activity_list.ID = sign_list.actID and activity_list.baseType = 1";
		return $this->db->query($sql, array($userID))->result_array();
	}

	function getUserHonorList($userID)
	{
		$sql = "SELECT DISTINCT honorDetail FROM vol_user_career WHERE userID = ?";
		$tmp = $this->db->query($sql, array($userID))->result_array();
		$list = json_decode($tmp[0]['honorDetail']);
		$sql = "SELECT DISTINCT name, time,type,org,expiration FROM vol_honor_list WHERE ID = 0";
		foreach ($list as $i)
		{
			$sql .= " OR ID = ".$i;
		}
		//return $sql;
		$honorList = $this->db->query($sql)->result_array();
		return $honorList;
	}
}

?>
