<?php
@session_start();

class Chat extends CI_Controller {

	const PER_PAGE = 20;

	function __construct() {
		parent::__construct();
	}

	/**
	 * 查看聊天历史记录页面
	 * @param int $withID 所要查询的聊天记录的对方用户ID
	 * @param int $page 页数
	 */
	function history($withID = 0, $page = 1) {
		if(!isset($_SESSION['userID'])) {
			header('Location: /user/login');
			return;
		}
		if ($withID == 0) {
			header('Location: /');
			return;
		} else {
			$this->db->where("ID", $withID);
			$toUser = $this->db->get("user_list")->row_array();

			$this->load->model("chat_model", "chat");
			$total_rows = $this->chat->countChatBetween($withID);
			$pageLink = $this->makePageLink("/chat/history/".$withID, $total_rows, self::PER_PAGE, 4);
			$list = $this->chat->getAllChatBetween($withID, $page - 1, self::PER_PAGE);
			$this->mainnav('chat');
			$this->load->view("chat/history", array("list"=>$list, "toNickName"=>$toUser['nickName'], 'pageLink'=>$pageLink));
		}
	}

	/**
	 * 获取聊天所需的基本信息API
	 */
	function basicInfo() {
		if(!isset($_SESSION['userID'])) {
			echo json_encode(array('error'=>-1));
			return;
		}
		$data  = $_REQUEST;
		$this->db->where("ID", $data['toID']);
		$list = $this->db->get("user_list")->result_array();
		if(count($list) == 0) {
			echo json_encode(array('error'=>-2, 'msg'=>"没有该用户"));
		} else {
			echo json_encode(array('error'=>1, 'toID'=>$data['toID'], 'toNickName' => $list[0]['nickName']));
		}
	}


	/**
	 * 发送聊天API
	 */
	function send() {
		if(!isset($_SESSION['userID'])) {
			echo json_encode(array('error'=>-1));
			return;
		}
		$data  = $_REQUEST;
		$this->load->model("chat_model", "chat");
		$res = $this->chat->send($data['toID'], $data['content']);
		echo json_encode($res);
	}

	/**
	 * 标记聊天为已读API
	 */
	function markRead() {
		if(!isset($_SESSION['userID'])) {
			echo json_encode(array('error'=>-1));
			return;
		}
		$data  = $_REQUEST;
		
		$IDs = explode("|", $data["IDs"]);
		$this->load->model("chat_model", "chat");
		foreach ($IDs as $ID) {
			$this->chat->markRead($ID);
		}
		echo json_encode(array('error'=>1));
	}

	/**
	 * 获取新聊天信息API，如果没有则一直查询到有
	 */
	function getNewOrWait() {
        return;
		session_write_close(); // 防止session独占阻塞
		$this->load->model("chat_model", "chat");
		while (true) {
			if ($this->chat->countUnreadChat() > 0) {
				$list = $this->chat->getUnreadChat();
				echo json_encode($list);
				return;
			}
			usleep(3000000);
		}
	}

	/**
	 * 生成导航栏
	 */
	public function mainnav($name,$addArray = array()) {
		$this->load->view('base/mainnav',array_merge(array('name'=>$name, 'page'=>$name),$addArray));
	}

	/**
	 * 生成分页连接
	 * @param string $baseURL URL前缀
	 * @param int $totalRows 总条数
	 * @param int $perPage 每页条数
	 * @param int $uriSegment uri段数
	 */
	public function makePageLink($baseURL, $totalRows, $perPage, $uriSegment = 3) {
		$this->load->library('pagination');
		$config['base_url'] = $baseURL;
		$config['total_rows'] = $totalRows;
		$config['per_page'] = $perPage;
		$config['uri_segment'] = $uriSegment;
		$config['use_page_numbers'] = TRUE;
		$config['first_link'] = '第一页';
		$config['last_link'] = '最后一页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';
		$this->pagination->initialize($config);
		return $this->pagination->create_links();
	}

}
?>

