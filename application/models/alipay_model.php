<?php

class alipay_model extends CI_Model{
        

    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->helper('base_helper');
    }
    
}

?>
