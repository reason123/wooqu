<?php

class message_board_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('base_helper');
	}

	/**
	 * 获取所有的公共留言
	 * @author daiwentao
	 */
	function getPublicMessage($page, $perPage) {
		$sql = "SELECT message_board.ID, message_board.userID, createTime, content, nickName 
			FROM user_list, message_board 
			WHERE user_list.ID = message_board.userID 
			ORDER BY message_board.ID DESC LIMIT ?, ?";
		$publicList = $this->db->query($sql, array($page * $perPage, $perPage))->result_array();
		return $publicList;
	}

	/**
	 * 返回所有的记录数
	 */
	function countPublicMessage() {
		return $this->db->count_all_results('message_board');
	}


	/**
	 * 留言板留言函数
	 * @author daiwentao
	 * @param string $mesContent 留言内容
	 * @param int $repID 所回复留言的ID
	 */
	function leaveMes($mesContent, $repID = 0) {
		if(!isset($_SESSION['userID'])) {
			return errorMessage(-1,'未登录');
		}
		$newMes = array(
				'userID'=>$_SESSION['userID'],
				'content'=>cleanString($mesContent),
				'replyID'=>$repID);
		$this->db->insert('message_board',$newMes);
		return errorMessage(1,'留言成功');
	}

	/**
	 * 获取一条留言
	 * @author daiwentao
	 * @param int $ID 要获取的留言的ID
	 */
	function get($ID) {
		$sql = "select message_board.ID, message_board.userID, createTime, content, nickName 
			from user_list, message_board 
			where user_list.ID = message_board.userID 
			AND message_board.ID = ?";
		$list = $this->db->query($sql, array($ID))->result_array();
		if(count($list) == 0) {
			return false;
		}
		return $list[0];
	}

	/**
	 * 删除留言
	 * @author daiwentao
	 * @param int $mesID 留言编号
	 */
	function delMes($mesID) {
		if(!isset($_SESSION['userID'])) {
			return errorMessage(-1,'未登录');
		}
		$sql = "select * 
			from message_board
			where ID=?
			limit 20";
		$mesList = $this->db->query($sql,array($mesID))->result_array();
		if(count($mesList) == 0){
			return errorMessage(-2,"无对应ID");
		}
		if($mesList[0]['userID'] != $_SESSION['userID']){
			return errorMessage(-10,"无删除权限");
		}
		$this->db->where('ID',$mesID)->delete('message_board');
		return errorMessage(1,"删除成功");
	}
}
?>
