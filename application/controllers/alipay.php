<?php
@session_start();

class alipay extends CI_Controller {
       
    //支付宝接口配置信息
    private $alipay_config;
    
    //初始化参数
    private  function _init_config(){
        //合作身份者id，以2088开头的16位纯数字
        $this->alipay_config['partner']  = '2088202356480752';

        //安全检验码，以数字和字母组成的32位字符
        $this->alipay_config['key'] = '7qymksjstme3lpr5aqedcvu9d4q89a3e';
                                       
        //签约支付宝账号或卖家支付宝帐户
        $this->alipay_config['seller_email'] = 'zsy19900517@qq.com';
                                               
        //页面跳转路径
        $this->alipay_config['notify_url'] = 'https://www.hellothu.com/alipay/do_notify';
                                                        
        //服务器异步通知路径
        $this->alipay_config['return_url'] = 'https://www.hellothu.com/alipay/do_return';
                                                                        
        //签名方式 不需修改
        $this->alipay_config['sign_type'] = strtoupper('MD5');
                                                            
        //字符编码格式 目前支持 gbk 或 utf-8
        $this->alipay_config['input_charset'] = strtolower('utf-8');
                                                                         
        //ca证书路径地址，用于curl中ssl校验,请保证cacert.pem文件在当前文件夹目录中
        $this->alipay_config['cacert'] = getcwd().'\\cacert.pem';
                                                                                 
        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $this->alipay_config['transport'] = 'https';
                                                     
    }

	function __construct() {
		parent::__construct();
        $this->_init_config();
	}

    private function do_alipay($subject,$price,$out_trade_no){
        
        include_once APPPATH.'third_party/alipay/alipay_submit.class.php';
        
        
        //构造要请求的参数数组，无需改动
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
            "_input_charset"    => trim(strtolower($this->alipay_config['input_charset']))
        );
        //return json_encode($parameter);
        //建立请求
        $alipaySubmit = new AlipaySubmit($this->alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo $html_text;
    }    

    public function do_alipay_groupbuy()
    {
        if (!isset($_GET['id'])) {
            echo "No order ID!";
            return;
        };               
        
		$this->load->model('groupbuy_model', 'gb');
        $order = $this->gb->getOrderByID($_GET['id']);
        if ($order['alipay'] == "FINISHED") {
            echo "the order is finished.";
            return;
        }
        do_alipay("hellothu网团购支付",$order['amount'],"gb".$order['ID']);
    }
    
    public function do_return(){
        
        include_once APPPATH.'third_party/alipay/alipay_notify.class.php';
        $alipayNotify = new AlipayNotify($this->alipay_config);
        $verify_result = $alipayNotify->verifyReturn();
        
        //商户订单号
        $out_trade_no = $this->input->get('out_trade_no');
        //支付宝交易号
        $trade_no = $this->input->get('trade_no');
        //交易状态
        $trade_status = $this->input->get('trade_status'); 
        //交易时间
        $notify_time = strtotime($this->input->get('notify_time'));
        //防止重复提交
        
      
        if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
 
            //根据订单号（out_trade_no）更新订单状态
            
        }else {
            //订单失败   
            
        }
    }
    
    
    //确保公网能访问
    public function do_notify() {
        include_once APPPATH.'third_party/alipay/alipay_submit.class.php';
        return $alipaySubmit = new AlipaySubmit($this->alipay_config);
 
//        include_once APPPATH.'third_party/alipay/alipay_notify.class.php';  
//        return APPPATH.'third_party/alipay/alipay_notify.class.php';  
    }
		
}

?>
