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

    function test_alipay() {
        echo $_SERVER['SERVER_NAME'];

//        $this->load->model("alipay_model","alipay");
//        echo $this->alipay->do_alipay("测试1","0.10",123456710);
        echo send_post('https://www.hellothu.com/alipay/do_notify',array('notifi_id' =>0,'out_trade_no'=>'gb5857'));
    }

}
?>
