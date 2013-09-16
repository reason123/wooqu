<?php

class chat_model extends CI_Model{

	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('base_helper');
	}

	/**
	 * 获取该用户与另一个用户的所有聊天信息
	 * @author daiwentao
	 * @param int $withID 对方用户的ID
	 * @param int $page 页数(Start from 0)
	 * @param int $perPage 每页数量，结果按时间逆序。
	 */
	function getAllChatBetween($withID, $page, $perPage) {
		if (!isset($_SESSION['userID'])) {
			return errorMessage(-1, "未登录");
		}
		$userID = $_SESSION['userID'];
		$sql = "SELECT * FROM chat_list WHERE (fromID=? AND toID=?) OR (fromID=? AND toID=?) ORDER BY createTime DESC LIMIT ?, ?";
		$list = $this->db->query($sql, array($userID, $withID, $withID, $userID, $page * $perPage, $perPage))->result_array();
		return $list;
	}

	/**
	 * 获取该用户与另一个用户的所有聊天信息总数
	 * @author daiwentao
	 * @param int $withID 对方用户的ID
	 */
	function countChatBetween($withID) {
		if (!isset($_SESSION['userID'])) {
			return errorMessage(-1,'未登录');
		}
		$userID = $_SESSION['userID'];
		$sql = "SELECT count(*) as total_row FROM chat_list WHERE (fromID=? AND toID=?) OR (fromID=? AND toID=?)";
		$res = $this->db->query($sql, array($userID, $withID, $withID, $userID))->row_array();
		return $res["total_row"];
	}


	/**
	 * 获取到该用户的所有未读聊天信息
	 * @author daiwentao
	 */
	function getUnreadChat() {
		if (!isset($_SESSION['userID'])) {
			return errorMessage(-1, "未登录");
		}
		$sql = "SELECT chat_list.ID as ID, fromID, createTime, content, nickName FROM chat_list, user_list 
			WHERE toID=? AND isRead=0 AND user_list.ID = chat_list.fromID
			ORDER BY chat_list.createTime";
		$list = $this->db->query($sql, array($_SESSION['userID']))->result_array();

		return $list;
	}

	/**
	 * 获取到该用户的所有未读聊天信息的数量
	 * @author daiwentao
	 */
	function countUnreadChat() {
		if (!isset($_SESSION['userID'])) {
			return errorMessage(-1, "未登录");
		}
		$this->db->where("toID", $_SESSION['userID']);
		$this->db->where("isRead", 0);
		return $this->db->count_all_results('chat_list');
	}

	/**
	 * 发送聊天，成功则在返回信息中附加发送时间
	 * @author daiwentao
	 * @param int toID 接受的用户ID
	 * @param string $content 内容
	 */
	function send($toID, $content) {
		if (!isset($_SESSION['userID'])) {
			return array('error'=>-1, 'msg'=>'未登录');
		}
		$newChat = array(
				'fromID'=>$_SESSION['userID'],
				'toID'=>$toID,
				'content'=>cleanString($content));
		$this->db->insert('chat_list', $newChat);
		$insertID = $this->db->insert_id();
		$this->db->where('ID', $insertID);
		$list = $this->db->get("chat_list")->result_array();
		if(count($list) == 0) {
			return array('error'=>-2, 'msg'=>'发送失败');
		}
		$createTime = $list[0]["createTime"];
		$res = array('error'=>'1', 'createTime'=>$createTime, 'nickName'=>$_SESSION['nickName']);
		return $res;
	}

	/**
	 * 标记聊天为已读
	 * @author daiwentao
	 * @param int $chatID 消息编号
	 */
	function markRead($chatID) {
		if (!isset($_SESSION['userID'])) {
			return errorMessage(-1, '未登录');
		}
		$this->db->where('ID', $chatID);
		$chat = $this->db->get('chat_list')->row_array();
		if($chat['toID'] != $_SESSION['userID']) {
			return errorMessage(-10,"无权限");
		}
		$this->db->where('ID', $chatID);
		$this->db->update('chat_list', array('isRead' => 1));
		return errorMessage(1,"标记成功");
	}

}
?>
