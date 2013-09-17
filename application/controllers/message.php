<?php
@session_start();

class Message extends CI_Controller {

	const PER_PAGE = 20;

	function __construct(){
		parent::__construct();
	}

	/**
	 * 所有消息页面
	 * @param int $page 页数(start from 1)
	 */
	function index($page = 1) {
		if(!isset($_SESSION['userID'])) {
			header('Location: /user/login');
			return;
		}
		$this->load->model('message_model','message');
		$total_rows = $this->message->countMessage();
		$pageLink = $this->makePageLink("/message/index/", $total_rows, self::PER_PAGE);
		
		$msgList = $this->message->getAllMessage($page - 1, self::PER_PAGE);

		$this->mainnav('message');
		$this->load->view('message/message',array('msgList'=>$msgList, 'pageLink'=>$pageLink));
		$this->load->view('base/footer');
	}
	
	/**
	 * 未读消息页面
	 * @param int $page 页数(start from 1)
	 */
	function unread($page = 1) {
		if(!isset($_SESSION['userID'])) {
			header('Location: /user/login');
			return;
		}
		$this->load->model('message_model','message');
		$total_rows = $this->message->countUnreadMessage();
		$pageLink = $this->makePageLink("/message/unread/", $total_rows, self::PER_PAGE);
		$msgList = $this->message->getUnreadMessage($page - 1, self::PER_PAGE);

		$this->mainnav('message');
		$this->load->view('message/message_unread',array('msgList'=>$msgList, 'pageLink'=>$pageLink));
		$this->load->view('base/footer');
	}
	
	/**
	 * 获取未读消息数API
	 */
	function updateUnreadMsgNum() {
		if(!isset($_SESSION['userID'])) {
			echo json_encode(array('error'=>-1));
			return;
		}
		$this->load->model('message_model','message');
		$unreadMsgNum = $this->message->countUnreadMessage();
		echo json_encode(array('error'=>1, 'unreadMsgNum'=>$unreadMsgNum));
	}



	/**
	 * 标记为消息已读的API
	 * @author daiwentao
	 */ 
	function markread() {
		if(!isset($_SESSION['userID'])) {
			echo json_encode(array('error'=>-1));
			return;
		}

		$this->load->model('message_model','message');
		$data  = $_REQUEST;
		echo json_encode($this->message->markRead($data['mesID']));
	}

	/*
	function test() {
		$this->load->model("sms_model", "sms");
		$res = $this->sms->sendSms(array("180"), "啊23456789123456789022345678903234567890423456789052345678906234567");
		echo json_encode($res);
	}*/
	

	/**
	 * 生成导航栏
	 */
	private function mainnav($name,$addArray = array()) {
		$this->load->view('base/mainnav',array_merge(array('name'=>$name, 'page'=>$name),$addArray));
	}

	/**
	 * 生成分页连接
	 */
	private function makePageLink($baseURL, $totalRows, $perPage) {
		$this->load->library('pagination');
		$config['base_url'] = $baseURL;
		$config['total_rows'] = $totalRows;
		$config['per_page'] = $perPage;
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
