<?php

class alipay_model extends CI_Model{
    
        
        
    //支付宝接口配置信息
    private $alipay_config;


    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->helper('base_helper');
        //include_once APPPATH.'third_party/alipay/alipay_submit.class.php';

    }

    //初始化参数
    private  function _init_config(){
        //合作身份者id，以2088开头的16位纯数字
        $this->alipay_config['partner']  = '2088202356480752';

        //安全检验码，以数字和字母组成的32位字符
        $this->alipay_config['key'] = '7qymksjstme3lpr5aqedcvu9d4q89a3e';
                                       
        //签约支付宝账号或卖家支付宝帐户
        $this->alipay_config['seller_email'] = 'zsy19900517@qq.com';
                                               
        //页面跳转路径
        $this->alipay_config['notify_url'] = '';
                                                        
        //服务器异步通知路径
        $this->alipay_config['return_url'] = '';
                                                                        
        //签名方式 不需修改
        $this->alipay_config['sign_type'] = strtoupper('MD5');
                                                            
        //字符编码格式 目前支持 gbk 或 utf-8
        $this->alipay_config['input_charset'] = strtolower('utf-8');
                                                                         
        //ca证书路径地址，用于curl中ssl校验,请保证cacert.pem文件在当前文件夹目录中
        $this->alipay_config['cacert'] = APPPATH.'third_party/alipay/cacert.pem';
                                                                                 
        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $this->alipay_config['transport'] = 'https';
                                                     
    }


    public function do_alipay($subject,$body,$price,$out_trade_no){
        
        include_once APPPATH.'third_party/alipay/alipay_submit.class.php';
        
        
        //构造要请求的参数数组，无需改动
    	$parameter = array(
	    	"service" => "create_partner_trade_by_buyer",
		    "partner" => trim($this->alipay_config['partner']),
		    "payment_type"	=> "1",
            "notify_url"    =>  trim($this->alipay_config['notify_url']),
            "return_url"    => trim($this->alipay_config['return_url']),
            "seller_email"  => trim($this->alipay_config['seller_email']),//支付宝帐户,
		    "subject"	=> $subject,
		    "price"	=> $price,
		    "quantity"	=> "1",
		    "logistics_fee"	=> "0.00",
		    "logistics_type"	=> "EXPRESS",
		    "logistics_payment"	=> "SELLER_PAY",
		    "body"	=> $body,
            "show_url"    => "",//商品展示地址
		    "receive_name"	=> "张三",
		    "receive_address"	=> "清华大学",
		    "receive_zip"	=> "528400",
		    "receive_phone"	=> "0571-88158090",
		    "receive_mobile"	=> "13312341234",
            "_input_charset"    => trim(strtolower($this->alipay_config['input_charset']))
        );
       /* $parameter = array(
            "service" => "create_partner_trade_by_buyer",
            "partner" => trim($this->alipay_config['partner']),
            "payment_type"    => '1',
            "notify_url"    =>  trim($this->alipay_config['notify_url']),
            "return_url"    => trim($this->alipay_config['return_url']),
            "seller_email"    => trim($this->alipay_config['seller_email']),//支付宝帐户,
            "out_trade_no"    => $out_trade_no,//商户订单号
            "subject"    => $subject,//订单名称
            "body"    => $body,//必填,订单描述
            "total_fee"    => $total_fee,//必填,付款金额
            "show_url"    => SITE_URL . '/member/pay/order',//商品展示地址
            "anti_phishing_key"    => '',//防钓鱼时间戳
            "exter_invoke_ip"    => get_client_ip(),//客户端的IP地址
            "_input_charset"    => trim(strtolower($this->alipay_config['input_charset']))
        );*/
        //建立请求
        $alipaySubmit = new AlipaySubmit($this->alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        return $html_text;
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
