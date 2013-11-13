<?php

class message_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('base_helper');
	}

	/**
	 * 获取当前用户所有信息(包括历史消息)
	 * @author daiwentao
	 * @param int $page 页数(Start from 0)
	 * @param int $perPage 每页个数
	 */
	function getAllMessage($page, $perPage) {
		if (!isset($_SESSION['userID'])) {
			return errorMessage(-1,'未登录');
		}
		$this->db->where("userID", $_SESSION['userID']);
		$this->db->order_by("createTime", "desc");
		$list = $this->db->get('message_list', $perPage, $page * $perPage)->result_array();
		return $list;
	}

	/**
	 * 获取当前用户所有信息总数
	 * @author daiwentao
	 */
	function countMessage() {
		if (!isset($_SESSION['userID'])) {
			return errorMessage(-1,'未登录');
		}
		$this->db->where("userID", $_SESSION['userID']);
		return $this->db->count_all_results('message_list');
	}


	/**
	 * 获取当前用户所有未读信息总数
	 * @author daiwentao
	 */
	function countUnreadMessage() {
		if (!isset($_SESSION['userID'])) {
			return errorMessage(-1,'未登录');
		}
		$this->db->where("userID", $_SESSION['userID']);
		$this->db->where("isRead", 0);
		return $this->db->count_all_results('message_list');
	}


	/**
	 * 获取当前用户所有未读信息
	 * @author daiwentao
	 * @param int $page 页数(Start from 0)
	 * @param int $perPage 每页个数
	 */
	function getUnreadMessage($page, $perPage) {
		if (!isset($_SESSION['userID'])) {
			return errorMessage(-1,'未登录');
		}
		$this->db->where("userID", $_SESSION['userID']);
		$this->db->where("isRead", 0);
		$this->db->order_by("createTime", "desc");
		$list = $this->db->get('message_list', $perPage, $page * $perPage)->result_array();
		return $list;
	}

	/**
	 * 添加消息
	 * @author daiwentao
	 * @param int userID 接收用户的ID
	 * @param int type 消息的类型(1: 留言板回复)
	 * @param string $content 留言内容
	 * @param string $url 点击消息进入的url
	 */
	function addMessage($userID, $type, $content, $url) {
		if (!isset($_SESSION['userID'])) {
			return errorMessage(-1,'未登录');
		}
		$newMes = array(
				'userID'=>$userID,
				'type'=>$type,
				'content'=>cleanString($content),
				'url'=>$url);
		$this->db->insert('message_list', $newMes);
		return errorMessage(1,'消息发送成功');
	}

	/**
	 * 标记消息为已读
	 * @author daiwentao
	 * @param int $mesID 消息编号
	 */
	function markRead($mesID) {
		if (!isset($_SESSION['userID'])) {
			return errorMessage(-1,'未登录');
		}
		$this->db->where('ID', $mesID);
		$msg = $this->db->get('message_list')->row_array();
		if($msg['userID'] != $_SESSION['userID']) {
			return errorMessage(-10,"无权限");
		}
		$this->db->where('ID', $mesID);
		$this->db->update('message_list', array('isRead' => 1));
		return errorMessage(1,"标记成功");
	}
}
?>
