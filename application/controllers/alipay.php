<?php
@session_start();

class alipay extends CI_Controller {
       
    //支付宝接口配置信息
    private $alipay_config;

    private $verify_url = 'https://mapi.alipay.com/gateway.do';
    
    //初始化参数
    private  function _init_config(){
        //赵思远帐号            
        //合作身份者id，以2088开头的16位纯数字
        $this->alipay_config['partner']  = '2088202356480752';

        //安全检验码，以数字和字母组成的32位字符
        $this->alipay_config['key'] = '7qymksjstme3lpr5aqedcvu9d4q89a3e';
                                       
        //签约支付宝账号或卖家支付宝帐户
        $this->alipay_config['seller_email'] = 'zsy19900517@qq.com';
/*
        //合作身份者id，以2088开头的16位纯数字
        $this->alipay_config['partner']  = '2088111450606181';

        //安全检验码，以数字和字母组成的32位字符
        $this->alipay_config['key'] = 'zk6oplats4jfpxwluw28u6ac3i9kne3v';
                                       
        //签约支付宝账号或卖家支付宝帐户
        $this->alipay_config['seller_email'] = 'chuangep@163.com';
*/                                               
        $this->alipay_config['notify_url'] = 'http://dev.hellothu.com/alipay/do_notify';
                                                        
        $this->alipay_config['return_url'] = 'https://www.hellothu.com/alipay/do_return';
                                                                        
        //签名方式 不需修改
        $this->alipay_config['sign_type'] = strtoupper('MD5');
                                                            
        //字符编码格式 目前支持 gbk 或 utf-8
        $this->alipay_config['input_charset'] = strtolower('utf-8');
                                                                         
        //ca证书路径地址，用于curl中ssl校验,请保证cacert.pem文件在当前文件夹目录中
        $this->alipay_config['cacert'] = getcwd().'\\cacert.pem';
                                                                                 
        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $this->alipay_config['transport'] = 'http';
                                                     
    }

	function __construct() {
		parent::__construct();
		$this->load->database();
        $this->_init_config();
	}

    private function do_alipay($subject,$price,$out_trade_no){
        include_once APPPATH.'third_party/alipay/alipay_submit.class.php';
        $this->load->model('user_model','user');
        $user = $this->user->getMyInfo();
    	$parameter = array(
	    	"service" => "create_partner_trade_by_buyer",
		    "partner" => trim($this->alipay_config['partner']),
		    "payment_type"	=> "1",
            "notify_url"    =>  trim($this->alipay_config['notify_url']),
            "return_url"    => trim($this->alipay_config['return_url']),
            "seller_email"  => trim($this->alipay_config['seller_email']),//支付宝帐户,
            "out_trade_no" => $out_trade_no,
		    "subject"	=> $subject,
		    "price"	=> $price,
		    "quantity"	=> "1",
		    "logistics_fee"	=> "0.00",
		    "logistics_type"	=> "EXPRESS",
		    "logistics_payment"	=> "SELLER_PAY",
		    "receive_name"	=> $user['realName'],
		    "receive_address"	=> $user['address'],
		    "receive_zip"	=> "528400",
		    "receive_phone"	=> "0571-88158090",
		    "receive_mobile"	=> $user['phoneNumber'],
            "_input_charset"    => trim(strtolower($this->alipay_config['input_charset']))
        );
       // echo json_encode($parameter);
        //建立请求
        $alipaySubmit = new AlipaySubmit($this->alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo "<html><head><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"></head>".$html_text."</body></html>";
    }    

    public function do_alipay_groupbuy()
    {
        if (!isset($_GET['id'])) {
            echo "No order ID!";
            return;
        };               
        
		$this->load->model('groupbuy_model', 'gb');
        $tmp = $this->gb->getOrderByID($_GET['id']);
        $order = $tmp[0];
        if ($order['alipay'] == "FINISHED") {
            echo "the order is finished.";
            return;
        }
        
        $this->do_alipay("Hellothu团购",$order['amount'],"gb".$order['id']);
    }
    
    public function do_return(){
        include_once APPPATH.'third_party/alipay/alipay_notify.class.php';
        $alipayNotify = new AlipayNotify($this->alipay_config);
        $verify_result = $alipayNotify->verifyReturn();
        //$verify_result = $this->check_alipay_request($_GET['notify_id']);
        //if($verify_result) {
        if (true) {
            //商户订单号
            $out_trade_no = $_GET['out_trade_no'];
            //支付宝交易号
            $trade_no = $_GET['trade_no'];
            //交易状态
            $trade_status = $_GET['trade_status'];
            if($_GET['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                $no_sign = substr($out_trade_no,0,2);
                $orderID = substr($out_trade_no,2);
                if ($no_sign == "gb") {
                    header('Location: /userpage/groupbuyOrder');
                }
            } else {
                echo "trade_status=".$_GET['trade_status'];
            }     
        } else {
            //验证失败
            //如要调试，请看alipay_notify.php页面的verifyReturn函数
            echo "verify failed!";
            header('Location: /userpage/groupbuyOrder');
        }
    }
    
    
    //确保公网能访问
    public function do_notify() {
        include_once APPPATH.'third_party/alipay/alipay_notify.class.php';
        $alipayNotify = new AlipayNotify($this->alipay_config);
        //$verify_result = $alipayNotify->verifyNotify();
        $verify_result = $this->check_alipay_request($_POST['notify_id']);
        
//        $this->setOrderAlipay($_POST['out_trade_no'],"GET");

        if($verify_result) {
            //商户订单号
            $out_trade_no = $_POST['out_trade_no'];
            //支付宝交易号
            $trade_no = $_POST['trade_no'];
            //交易状态
            $trade_status = $_POST['trade_status'];
            if (isset($_POST['price']) && !$this->checkPrice($out_trade_no,$_POST['price'])) {
                echo "fail";
                return;
            }
            if($_POST['trade_status'] == 'WAIT_BUYER_PAY') {//该判断表示买家已在支付宝交易管理中产生了交易记录，但没有付款
                $this->setOrderAlipay($out_trade_no,"UNPAID");
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                echo "success";     //请不要修改或删除
                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            } else if($_POST['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
                //该判断表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                $this->setOrderAlipay($out_trade_no,"FINISHED");
                echo "success";     //请不要修改或删除
                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            } else if($_POST['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS') {
                //该判断表示卖家已经发了货，但买家还没有做确认收货的操作
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                echo "success";     //请不要修改或删除
                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            } else if($_POST['trade_status'] == 'TRADE_FINISHED') {
                //该判断表示买家已经确认收货，这笔交易完成
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
                $this->setOrderAlipay($out_trade_no,"FINISHED");
                echo "success";     //请不要修改或删除
                //调试用，写文本函数记录程序运行情况是否正常
                //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
            } else if($_POST['trade_status'] == 'REFUND_SUCCESS') {
                $this->setOrderAlipay($out_trade_no,"REFUNDED");
                echo "success";     //请不要修改或删除
            } else if($_POST['trade_status'] == 'WAIT_SELLER_AGREE') {
                $this->setOrderAlipay($out_trade_no,"REFUND");
                echo "success";     //请不要修改或删除
            } else {
                //其他状态判断
                echo "success";
                //调试用，写文本函数记录程序运行情况是否正常
                //logResult ("这里写入想要调试的代码变量值，或其他运行的结果记录");
            }
               
        } else {
            //验证失败
            echo "fail";

            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");

        }
    }

    private function check_alipay_request($notify_id_tmp){
        return myGet($this->verify_url, array(
                                              'service'=>'notify_verify',
                                              'partner'=>trim($this->alipay_config['partner']),
                                              'notify_id'=>$notify_id_tmp
                                              )) == 'true'?true: false;
    }
    
    private function checkPrice($out_trade_no,$price) {
        $no_sign = substr($out_trade_no,0,2);
        $orderID = substr($out_trade_no,2);
        if ($no_sign == "gb") {
		    $sql = "SELECT * FROM groupbuy_order WHERE ID=?";
    		$res = $this->db->query($sql,array($orderID))->result_array();
            if ($res[0]['amount'] != $price) return FALSE;
        }
        return TRUE;
    }

    private function setOrderAlipay($out_trade_no,$str) {
        $no_sign = substr($out_trade_no,0,2);
        $orderID = substr($out_trade_no,2);
        if ($no_sign == "gb") {
		    $sql = "UPDATE `groupbuy_order` SET alipay =? WHERE `ID`=?";
    		$res = $this->db->query($sql,array($str,$orderID));
        }
    }
}

?>
