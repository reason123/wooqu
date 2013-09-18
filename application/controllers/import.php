<?php

@session_start();
 
class Import extends CI_Controller{
	function __construct(){
		parent::__construct();
	}

    function index(){
        return true;
        $file_content = file(dirname(__FILE__).'/tmp.csv');
        $this->load->model('shop_model','shop');
        foreach($file_content as $key => $line){
            $bookInfo = explode(',',$line);
            $this->shop->addGoods(29,$bookInfo[2],$bookInfo[3],'作者：'.$bookInfo[4].' 出版社：'.$bookInfo[0],'元/本');
        }
    }
    
}
?>