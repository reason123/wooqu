<?php

class preferential_model extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->database();
	}

    function add_pre_record($userid, $preid, $value){
        $newRecord = array(
                           'user_id'=>$userid,
                           'preferential_id'=>$preid,
                           'state'=>1,
                           'value'=>$value
                           );
        $this->db->insert('user_preferential', $newRecord);
        return errorMessage(1, 'OK.');
    }

    function add_pre_record_by_name($username, $preid, $value){
        $user_list = $this->db->from('user_list')->where('realName', $username)->get()->result_array();
        echo json_encode($user_list);
        foreach($user_list as $key => $userinfo){
            $newRecord = array(
                               'user_id'=>$userinfo['ID'],
                               'preferential_id'=>$preid,
                               'state'=>1,
                               'value'=>$value
                               );
            $this->db->insert('user_preferential', $newRecord);
        }
        return errorMessage(1, 'OK.');
    }

    function get_user_preferential($preid, $userid){
        $sql = 'select preferential_list.title, user_id, preferential_id, state, value from user_preferential,preferential_list where preferential_id=preferential_list.id and user_id=? and preferential_id=?';
        $user_pre_list = $this->db->query($sql, array($userid, $preid))->result_array();
        //echo json_encode($user_pre_list);
        if(!count($user_pre_list)){
            return false;
        }
        return $user_pre_list[0];
    }

    function check_user_preferential($preid, $userid){
        $user_pre = $this->get_user_preferential($preid, $userid);
        if(!$user_pre || $user_pre['state'] == 0){
            return false;
        }
        return true;
    }

    function use_user_preferential($preid, $userid){
        if(!$this->check_user_preferential($preid, $userid)){
            return errorMessage(-2, '没有可用优惠券');
        }
        $used_preferential = array('state'=>0);
        $this->db->where('user_id', $userid)->where('preferential_id', $preid)->update('user_preferential', $used_preferential);
        $_SESSION['preferential'] = false;
        return errorMessage(1, '修改成功');
    }

    function init_preferential_state($preid){
        if(!isset($_SESSION['userID'])){
            return errorMessage(-1, '尚未登录。');
        }
        if(!$this->check_user_preferential($preid, $_SESSION['userID'])){
            return errorMessage(-2, '没有可用优惠券');
        }
        $user_pre = $this->get_user_preferential($preid, $_SESSION['userID']);
        $_SESSION['preferential'] = true;
        $_SESSION['preferential_name'] = $user_pre['title'];
        $_SESSION['preferential_value'] = $user_pre['value'];
        return errorMessage(1, 'ok');
    }
}

?>
