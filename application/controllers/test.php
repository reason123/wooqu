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

    function test_alipay() {
        $this->load->model("alipay_model","alipay");
        echo $this->alipay->do_alipay("测试1","0.10",123456710);
    }

}
?>
