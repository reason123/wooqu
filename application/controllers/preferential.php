<?php
@session_start();

class Preferential extends CI_Controller {
    function __construct(){
        parent::__construct();
    }

    function test(){
        $this->load->model('preferential_model', 'pre');
        echo json_encode($this->pre->get_user_preferential(1, 0));
    }

    function test1(){
        $this->load->model('preferential_model', 'pre');
        echo json_encode($this->pre->use_user_preferential(1, 0));
    }

    function test2(){
        $this->load->model('preferential_model', 'pre');
        echo json_encode($this->pre->init_preferential_state(1, 0));
    }

    function add_preferential(){
        if(!isset($_GET['tmp_security']) || $_GET['tmp_security'] != 'wooqupreferential'){
            echo json_encode(errorMessage(-1, 'Error security code.'));
            return;
        }
        if(!(isset($_GET['user_id']) && isset($_GET['preferential_id']) && isset($_GET['preferential_value']))){
            echo json_encode(errorMessage(-2, 'Parameter error.'));
            return;
        }
        $this->load->model('preferential_model', 'pre');
        echo json_encode($this->pre->add_pre_record($_GET['user_id'], $_GET['preferential_id'], $_GET['preferential_value']));
    }
}
?>
