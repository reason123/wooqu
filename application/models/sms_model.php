<?php

class sms_model extends CI_Model {

	private $accesskey = "30";
	private $secretkey = "b1114fe4391a8e5021d1fb2eb01c4e64be5c6c54";
	private $baseUrl = "sms.bechtech.cn/Api/send/data/json";
	private $prefix = "";
	private $suffix = "【helloTHU提醒】";

	function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/**
	 * 获取当前用户剩余短信条数
	 * @return 一条errorMessage，若成功，则其error->code为1，amount为剩余短信条数
	 */
	function getMyAmount() {
		if (!isset($_SESSION['userID'])) {
			return errorMessage(-1,'未登录');
		}
		$this->initSmsIfNot();

		$recordList = $this->db->from('sms_list')->where('userID',$_SESSION['userID'])->get()->result_array();
		return array_merge(errorMessage(1, 'ok'), array('amount'=>(int)$recordList[0]['amount']));
	}
	
	/**
	 * 向目标用户列表发送短信，并扣除用户短信余量
	 * @param array $numberList 目标号码列表，以字符串数组传入
	 * @param string $message 短信内容，按每条67字计费(包括前缀和后缀)
	 * @return 一条errorMessage，若成功，则其error->code为1，num为成功发出短信的条数
	 */
	function sendSms($numberList, $message) {
		if (!isset($_SESSION['userID'])) {
			return errorMessage(-1,'未登录');
		}
		$this->initSmsIfNot();
        $numberList = array_unique($numberList);
		$message = $this->prefix.$message.$this->suffix;
		$recordList = $this->db->from('sms_list')->where('userID',$_SESSION['userID'])->get()->result_array();
		$myAmount = (int)$recordList[0]['amount'];
		$messageLength = mb_strlen($message);
		$cost = (int)($messageLength / 67) + (($messageLength % 67 == 0) ? 0 : 1);

		if($myAmount < count($numberList) * $cost) {
			return errorMessage(-3,'短信余额不足,您只能发送'.$myAmount."条！");
		}

		$count = 0;
		$error = 1;
		foreach ($numberList as $number) {
            if (strlen($number) != 11) continue;
			$url = "$this->baseUrl?accesskey=$this->accesskey&secretkey=$this->secretkey&mobile=$number&content=".urlencode($message);
			$res = $this->getRequest($url);
			if ($res->result == "01") {
				$count ++;
			} else {
				$error = $res->result;
			}
		}
        $num = $count * $cost;
        $myAmount = $myAmount - $num;
		$this->db->where('userID',$_SESSION['userID'])->update('sms_list',array('amount'=>($myAmount)));

		if ($error == 1) {
			return array_merge(errorMessage(1,"发送成功。已发送".$num."条，还能发送".$myAmount."条！"),array('num'=>$num));
		} else {
			return array_merge(errorMessage(-1,"发送失败:$error 。发送条数:".$num),array('num'=>$num));
		}
	}
	
	/**
	 * 向目标用户列表发送短信，并扣除用户短信余量, new
	 * @param array $numberList 目标号码列表，以字符串数组传入
	 * @param string $message 短信内容，按每条67字计费(包括前缀和后缀)
	 * @return 一条errorMessage，若成功，则其error->code为1，num为成功发出短信的条数
	 */
	function sendSms_new($numberList, $message) {
		if (!isset($_SESSION['userID'])) {
			return errorMessage(-1,'未登录');
		}
		$this->initSmsIfNot();
        $numberList = array_values(array_unique($numberList));
		$message = $this->prefix.$message.$this->suffix;
		$recordList = $this->db->from('sms_list')->where('userID',$_SESSION['userID'])->get()->result_array();
		$myAmount = (int)$recordList[0]['amount'];
		$messageLength = mb_strlen($message);
		$cost = (int)($messageLength / 67) + (($messageLength % 67 == 0) ? 0 : 1);

		if($myAmount < count($numberList) * $cost) {
			return errorMessage(-3,'短信余额不足,您只能发送'.$myAmount."条！");
		}

		$counter = 0;
		$error = 1;
        $url = '166.111.135.69:3030/common/simple_sms?content='.urlencode($message).'&mobiles='.json_encode($numberList);
        $res = $this->getRequest($url);
        $counter = count($numberList);
        /*
		foreach ($numberList as $number) {
            if (strlen($number) != 11) continue;
			$url = "$this->baseUrl?accesskey=$this->accesskey&secretkey=$this->secretkey&mobile=$number&content=".urlencode($message);
			$res = $this->getRequest($url);
			if ($res->result == "01") {
				$count ++;
			} else {
				$error = $res->result;
			}
        }*/
        $num = $counter * $cost;
        $myAmount = $myAmount - $num;
		$this->db->where('userID',$_SESSION['userID'])->update('sms_list',array('amount'=>($myAmount)));

		if ($error == 1) {
			return array_merge(errorMessage(1,"发送成功。已发送".$num."条，还能发送".$myAmount."条！"),array('num'=>$num));
		} else {
			return array_merge(errorMessage(-1,"发送失败:$error 。发送条数:".$num),array('num'=>$num));
		}
	}

	/**
	 * get请求，用于调用远程的sms的api
	 */
	private function getRequest($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		$output = curl_exec($ch);
		curl_close($ch);
		return json_decode($output);
	}

	/**
	 * 初始化当前用户短信服务
	 * 若用户在sms_list中无对应记录，则添加记录并初始化剩余条数为0
	 */
	private function initSmsIfNot() {
		$userList = $this->db->from('sms_list')->where('userID',$_SESSION['userID'])->get()->result_array();
		if(count($userList) == 0) {
			$newRecord = array(
				'userID'=>$_SESSION['userID'],
				'amount'=>0);
			$this->db->insert('sms_list',$newRecord);
		}
		return errorMessage(1,'初始化成功');
	}

}

?>
