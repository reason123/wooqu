<?php

@session_start();
 
class User extends CI_Controller{
	function __construct(){
		parent::__construct();
	}
    
    public function index(){
		if(!isset($_GET['ann'])) {
			$ann = 'all';
		} else {
			$ann = $_GET['ann'];
		}

	//	$this->load->model('groupFeed_model','feed');
		//$annList = $this->feed->getNewsList();
        $annList = array();
        $this->load->view('base/mainnav',array('page'=>'homepage'));
        $this->load->view('user/announcement',array('annList'=>$annList,'ann'=>$ann));
        $this->load->view('base/footer');
    }

    public function test(){
        $this->load->model('sms_model','sms');
        echo $this->sms->getRequest('http://localhost/user/getMyInfo',array());
        return 1;
    }

	/**
	 * 获取紫荆楼号
	 * @author Hewr
	 */
	public function getAddress($address) {
		$len = strlen($address);
		for ($i = 0; $i <= $len; ++$i) {
			if ($i == $len) return "";
			if ($address[$i] == '#') 
				return intval(substr($address, $i + 1, $len));
		}
	}

    /**
     * 生成用户注册页面
     * @author ca007
     */
	public function usereg(){
		//set validation rules
		$this->load->library('form_validation');
		$this->form_validation->set_rules('regusername',"username","required|min_length[4]|max_length[16]|alpha_dash");
		$this->form_validation->set_rules('nickname','nickname','required');
		$this->form_validation->set_rules('regpassword',"password","required|min_length[6]|max_length[20]|matches[repassword]");
		$this->form_validation->set_rules('realname','realname','required');
		$this->form_validation->set_rules('phonenum','phonenum','required|numeric');
		$this->form_validation->set_rules('school','school','callback_school_check');
		$this->form_validation->set_rules('department','department','callback_department_check');
		$this->form_validation->set_rules('class','class','callback_class_check');
		$this->form_validation->set_rules('address','address','required');
		$this->form_validation->set_rules('studentid','studentid','required|alpha_numeric');
		$this->form_validation->set_rules('verificationcode','Verification Code','callback_verificationcode_check');
		$this->form_validation->set_message('verificationcode_check','%s error.');
		$this->form_validation->set_message('school_check','%s not selected.');
		$this->form_validation->set_message('department_check','%s not selected.');
		$this->form_validation->set_message('class_check','%s not selected.');

		$this->load->model('group_model','group');
		$schoolList = $this->group->getSchoolList();
		if($this->form_validation->run() == FALSE){
			//mainnav
			$this->load->view('base/mainnav',array('page'=>'usereg'));			
			$this->load->view('user/usereg',array_merge($_POST,array('schoolList'=>$schoolList)));
			$this->load->view('base/footer');
		}else{
			$this->load->model('user_model');
			$address = $this->getAddress($_REQUEST['address']);
			$res = $this->user_model->addUser(
								$_REQUEST['regusername'],
								$_REQUEST['nickname'],
								$_REQUEST['regpassword'],
								$_REQUEST['realname'],
								$_REQUEST['phonenum'],
								$_REQUEST['school'],
								$_REQUEST['department'],
								$_REQUEST['class'],
								$_REQUEST['studentid'],
								$_REQUEST['address']);
			if($res['error']['code'] == 1){
				gotoHomepage();
			}else{
				//mainnav
                $this->load->view('base/mainnav',array('page'=>'usereg'));
				$this->load->model('user_model','user');
//				$areaList = $this->user->getMyAreas();
				$this->load->view('user/usereg',array_merge($_POST,array('schoolList'=>$schoolList)));
				$this->load->view('base/footer',array('alertInfo'=>$res['error']['message']));
			}
		}
	}

    /**
     * 生成用户登陆页面
     * @author: ca007
     */
	public function login(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username','username','required');
		$this->form_validation->set_rules('password','password','required');

		if($this->form_validation->run() == FALSE){
			//mainnav
			$this->load->model('user_model','user');
//			$areaList = $this->user->getMyAreas();
            $this->load->view('base/mainnav',array('page'=>'loginpage'));
			$this->load->view('user/loginpage',$_POST);
			$this->load->view('base/footer');
		}else{
			$this->load->model('user_model','user');
			$res = $this->user->checkUser($_REQUEST['username'],$_REQUEST['password']);
			if($res['error']['code'] == 1){
				gotoHomepage();
			}else{
/**				$oldLogin = myGet('http://csshenghuo.sinaapp.com/index.php/user/oldLogin',
							array(
								'loginName'=>$_REQUEST['username'],
								'password'=>$_REQUEST['password']));
				$logInfo = json_decode($oldLogin,true);**/
                $logInfo = array('error'=>0);
				if($logInfo['error'] == 1){
					$addOld = $this->user->addOldUser(
											$_REQUEST['username'],
											$logInfo['nickName'],
											$_REQUEST['password'],
											$logInfo['realName'],
											$logInfo['phoneNumber'],
											$logInfo['studentID'],
											$logInfo['address']);
					if($addOld['error']['code'] == 1){
						header('Location: /user/selectArea');
					}else{
						$this->load->view('base/mainnav',array('page'=>'loginpage'));
						$this->load->view('user/loginpage',$_POST);
						$this->load->view('base/footer',array('alertInfo'=>$res['error']['message']));	
					}
				}else{
                    $this->load->view('base/mainnav',array('page'=>'loginpage'));
					$this->load->view('user/loginpage',$_POST);
					$this->load->view('base/footer',array('alertInfo'=>$res['error']['message']));
				}
			}
		}	
	}

    /**
     * 快速登录
     * @author ca007
     */
    public function quicklogin(){
        $this->load->model('user_model','user');
        $res = $this->user->checkUser($_REQUEST['username'], $_REQUEST['password']);
        echo json_encode($res);
    }

    /**
     * 检查本地cookie
     * @author ca007
     */
    public function checkCookie(){
        $this->load->model('user_model', 'user');
        echo json_encode(array('flag'=>$this->user->checkCookie()));
    }

    /**
     * 完善志愿者信息
     * @author ca007
     */
    public function improveVolInfo(){
        $this->load->library('form_validation');
        $this->form_validation->set_rules('politicalStatus','political status','required');
        $this->form_validation->set_rules('phoneNumber','phone number','required');
        $this->form_validation->set_rules('email','email','required');

        if($this->form_validation->run() == FALSE){
            $this->load->view('base/mainnav',array('page'=>'volinfo'));
            $this->load->view('volunteer/volinfo');
            $this->load->view('base/footer');
        }else{
            $this->load->model('user_model','user');
            $res = $this->user->improveVolInfo($_REQUEST['politicalStatus'],
                                               $_REQUEST['phoneNumber'],
                                               $_REQUEST['email']);
            $this->load->view('base/mainnav',array('page'=>'volinfo'));
            $this->load->view('volunteer/volinfo');
            $this->load->view('base/footer');
        }
    }
    
    /**
     * 获取当前登录用户基本信息
     * @author ca007
     */
    public function getMyInfo(){
        if(!isset($_SESSION['userID'])){
            echo json_encode(errorMessage(-1,'未登录'));
            return;
        }
        $this->load->model('user_model','user');
        echo json_encode(array_merge($this->user->getMyInfo(), errorMessage(1,"OK")));
    }

    /**
     * 修改当前用户个人信息
     * @author ca007
     */
    public function modMyInfo(){
        $this->load->model('user_model','user');
		$address = $this->getAddress($_REQUEST['address']);
        echo json_encode($this->user->modMyInfo($_REQUEST['nickName'],
                                                $_REQUEST['phoneNumber'],
												$_REQUEST['studentID'],
												$_REQUEST['address']));
    }

    /**
     * 修改当前用户密码
     * @author ca007
     */
    public function modMyPass(){
        $this->load->model('user_model','user');
        echo json_encode($this->user->modMyPass($_REQUEST['oldPass'],$_REQUEST['newPass']));
    }

    /**
     * 初始化短信功能
     * @author ca007
     */ 
    public function initSms(){
        $this->load->model('sms_model','sms');
        echo json_encode($this->sms->initSmsIfNot());
    }

    public function testSms(){
        $this->load->model('sms_model','sms');
        echo json_encode($this->sms->sendSms(array('15201523220'),'testSms'));
    }
    
    /**
     * 注销登录
     */
    public function logout(){
        $this->load->model('user_model','user');
        $res = $this->user->cleanUserInfo();
        gotoHomePage();
    }
    
  	/**
	 * 检查验证码：use for form_validation
	 * @param string $verificationcode 用户提交验证码
	 */
	public function verificationcode_check($verificationcode){
		if(strtolower($verificationcode) == $_SESSION['code']){
			return TRUE;
		}else {
			return FALSE;
		}
	}

	/**
	 * 检查学校：use for form_validation
	 * @param string $schoolID 学校ID
	 */
	public function school_check($schoolID){
		return !($schoolID == '0');
	}

	/**
	 * 检查院系：use for form_validation
	 * @param string $departID 院系ID
	 */
	public function department_check($departmentID){
		return !($departmentID == '0');
	}


	/**
	 * 检查班级：use for form_validation
	 * @param string $classID 学校ID
	 */
	public function class_check($classID){
		return !($classID == '0');
	}

    /**
     * 无权限页面
     * @authror ca007
     */
    public function nopermission(){
        $this->load->view('base/mainnav',array('page'=>'managegroup'));
        $this->load->view('base/nopermission');
        $this->load->view('base/footer');
    }
}

?>
