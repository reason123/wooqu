<?php

@session_start();


class Permission extends CI_Controller{
    function __construct(){
        parent::__construct();
    }

    function test(){
        $this->load->model('permission_model','per');
        var_dump($this->per->addBasePermission($_REQUEST['ID'],$_REQUEST['name'],$_REQUEST['detail']));
    }
}

?>