<?php
@session_start();

class Preferential extends CI_Controller {
    function __construct(){
        parent::__construct();
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

    function add_preferential_by_name(){
        if(!isset($_GET['tmp_security']) || $_GET['tmp_security'] != 'wooqupreferential'){
            echo json_encode(errorMessage(-1, 'Error security code.'));
            return;
        }
        if(!(isset($_GET['username']) && isset($_GET['preferential_id']) && isset($_GET['preferential_value']))){
            echo json_encode(errorMessage(-2, 'Parameter error.'));
            return;
        }
        $this->load->model('preferential_model', 'pre');
        echo json_encode($this->pre->add_pre_record_by_name($_GET['username'], $_GET['preferential_id'], $_GET['preferential_value']));
    }
}
?>
