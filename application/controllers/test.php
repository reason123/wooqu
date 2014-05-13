<?php

@session_start();
 
class Test extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    function index(){
        $this->load->view('test',array('error'=>'error'));
    }

    function do_upload(){
        

  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

    if (file_exists("./storage/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "./storage/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "./storage/" . $_FILES["file"]["name"];
      }
    }
  }
    function send_post($url, $post_data) {
        $postdata = http_build_query($post_data);   
        $options = array(   
            'http' => array(   
                'method' => 'POST',   
                'header' => 'Content-type:application/x-www-form-urlencoded',   
                'content' => $postdata,   
                'timeout' => 15 * 60 // 超时时间（单位:s）   
            )   
        );   
        $context = stream_context_create($options);   
        $result = file_get_contents($url, false, $context);   
        return $result;   
    }

    function test_email(){
//        $this->load->model("email_model","email");
//        echo $this->email->sendVerification();
            header("Location: https://mail.qq.com");
    }

    function test_alipay() {
        echo $_SERVER['SERVER_NAME'];

//        $this->load->model("alipay_model","alipay");
//        echo $this->alipay->do_alipay("测试1","0.10",123456710);
    }

    function test_photo()
    {
	    exec("cp storage/goodsPic/pic_594.jpg storage/shopPic/pic_58.jpg");
    }

    function get_csv(){
        $this->load->model('groupbuy_model','gb');
        $order_list = $this->gb->getOrderByGbID(1423);
        $orderMessageList = array();
        foreach ($order_list as $order)
        {
            array_push($orderMessageList,$order['orderMessage']);
        }
        $orderMessageList = array_unique($orderMessageList);
        asort($orderMessageList);
        $groupbuyInfo = $this->gb->getGroupbuyInfoByID(1423);
 /*       $total_counter = array();
        foreach($order_list as $key => $order){
            foreach($order['list'] as $i => $good){
                $goodID = $good[0];
                $goodNum = $good[1];
                $goodName = $good[2];
                if(array_key_exists($goodName,$total_counter)){
                    $total_counter[$goodName]['total'] += $goodNum;
                }else{
                    $total_counter[$goodName] = array();
                    $total_counter[$goodName]['total'] = $goodNum;
                    $total_counter[$goodName]['name'] = $goodName;
                }
            }
        }

        function cmp_counter($a, $b){
            return $b['total'] - $a['total'];
        }
        usort($total_counter, 'cmp_counter');*/
        $str = "订单ID,院系,班级,姓名,地址,联系方式,总金额,详细信息,选项,备注,支付状态\r\n";
        //$str = iconv('utf-8', 'gb2312', $str);
        foreach($order_list as $key => $order) {
            $oid = $order['ID'];

            $odepartment = $order['department'];

            $oclass = $order['class'];
            //$oclass = iconv('utf-8', 'gb2312', $oclass);
            $orealname = $order['realName'];
            //$orealname = iconv('utf-8', 'gb2312', $orealname);
            $oaddress = $order['address'];
            //$oaddress = iconv('utf-8', 'gb2312', $oaddress);
            $ophone = $order['phoneNumber'];
            //$ophone = iconv('utf-8', 'gb2312', $ophone);
            $oamount = $order['amount'];
//            $oamount = $order['alipay'];
            //$oamount = iconv('utf-8', 'gb2312', $oamount);
            $oordermessage = $order['orderMessage'];
            //$oordermessage = iconv('utf-8', 'gb2312', $oordermessage);
            $ocomment = $order['comment'];
            //$ocomment = iconv('utf-8', 'gb2312', $ocomment);
            $oalipay = $order['alipay'];
            $odetail = '';
            foreach($order['list'] as $key => $unit){
                //$odetail = $odetail.$unit[2].":".$unit[1].";";
                for ($i = 0; $i < $unit[1]; $i++) {
                    $str .= $oid.','.$odepartment.','.$oclass.','.$orealname.','.$oaddress.','.$ophone.','.$oamount.','.$unit[2].','.$oordermessage.','.$ocomment.",".$oalipay."\r\n";
                    if ($oamount != 0) $oamount = 0;
                }
            }
            //$odetail = iconv('utf-8', 'gb2312', $odetail);
        }
//        $str .= "\r\n"."\r\n";
//        $str .= "商品名,总量\r\n";
//        foreach($total_counter as $key => $counter){
//            $str .= $counter['name'].','.$counter['total']."\r\n";
//        }
        //echo $str;
        export_csv($groupbuyInfo['title'].'订单统计.csv', $str);
    }
}
?>
