<?php
@session_start();

class Messageboard extends CI_Controller {

	const REP_PREFIX = "回复";
	const REP_SUFFIX = ":";
	const PER_PAGE = 10;

	function __construct(){
		parent::__construct();
	}

	/**
	 * 公共留言板页面
	 */
	function index($id = -1) {
		if ($id < 0) {
			Header("Location: /messageboard/page/1");
		} else {
			$this->load->model('message_board_model','message');
			$msg = $this->message->get($id);

			$this->header('messageboard');
            $this->load->view('homepage/nav',array('type'=>'feedback'));
			$this->load->view('message/messageboard_single',array('message'=>$msg));
			$this->load->view('base/footer');
		}
	}

	function page($p = 1) {
		$this->load->model('message_board_model','message');

		// make page link
		$total_rows = $this->message->countPublicMessage();
		$this->load->library('pagination');
		$config['base_url'] = "/messageboard/page/";
		$config['total_rows'] = $total_rows;
		$config['per_page'] = self::PER_PAGE;
		$config['use_page_numbers'] = TRUE;
		$config['first_link'] = '第一页';
		$config['last_link'] = '最后一页';
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';
		$this->pagination->initialize($config);
		$page_link = $this->pagination->create_links();
		
		$publicList = $this->message->getPublicMessage($p - 1, self::PER_PAGE);

		$this->header('messageboard');
        $this->load->view('homepage/nav',array('type'=>'feedback'));
		$this->load->view('message/messageboard',array('publicList'=>$publicList, 'pageLink'=>$page_link));
		$this->load->view('base/footer');
	}


	/**
	 * 留言板留言API
	 * @author daiwentao
	 */ 
	function leaveMes() {
		if(!isset($_SESSION['userID'])){
			echo json_encode(array('error'=>-1));
			return;
		}

		$this->load->model('message_board_model','message_board');
		$data  = $_REQUEST;
		echo json_encode($this->message_board->leaveMes($data['mesContent'], $data['repID']));

		if (intval($data['repID']) > 0) { // reply
			$repHead = self::REP_PREFIX.$_SESSION['nickName'].self::REP_SUFFIX;
			if(strpos($data['mesContent'], $repHead) == 0) {
				$msg = $this->message_board->get($data['repID']);
				$this->load->model('message_model', 'message');
				$this->message->addMessage($msg['userID'], 1, $_SESSION['nickName']."在留言板回复了你的留言\"".$msg['content']."\"", "/messageboard/index/".$this->db->insert_id());
			}
		}
	}

	/**
	 * 删除留言API
	 * @author daiwentao
	 */
	function delMes() {
		if(!isset($_SESSION['userID'])) {
			echo json_encode(array('error'=>-1));
			return;
		}

		$this->load->model('message_board_model','message');
		echo json_encode($this->message->delMes($_REQUEST['mesID']));
	}

	/**
	 * 生成导航栏
	 */
	public function header($name,$addArray = array()) {
		$this->load->model('user_model','user');
		//$areaList = $this->user->getMyAreas();
		$this->load->view('base/header',array_merge(array('name'=>$name, 'page'=>$name),$addArray));
	}

}

?>
