<?php

class goods_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	}


	function getGoodsInfo($goodsID)
	{
		$tmp = $this->db->from('goods_list')->where('ID', $goodsID)->get()->result_array();
		return $tmp[0];
	}

	function getGoodsListByUser()
	{
		$tmp = $this->db->from('goods_list')->where('userID', $_SESSION['userID'])->where('available',1)->get()->result_array();
		return $tmp;	
	}


	/*
	*  新增商品
	*  @author LJNanest
	*  $name,$detail,$price,$priceType,$pic
	*/
	function addGoods($goodsInfo)
	{
		if (isset($_SESSION["userID"]))
		{
			$newItem = array(
				'userID' => $_SESSION["userID"],
				'name' => $goodsInfo['name'],
				'detail' => $goodsInfo['detail'],
				'price' => $goodsInfo['price'],
				'priceType' => $goodsInfo['priceType'],
				'pic' => $goodsInfo['pic']
				);
			$this->db->insert('goods_list',$newItem);
			return $this->db->insert_id();
		}
	}

	function modGoods($goodsInfo,$goodsID)
	{
		$tmp = $this->db->from('goods_list')->where('ID', $goodsID)->get()->result_array();
		$user = $tmp[0]['userID'];
		if (isset($_SESSION["userID"]) && $user == $_SESSION["userID"]) {
			$newItem = array('name' => $goodsInfo['name'],
				'detail' => $goodsInfo['detail'],
				'price' => $goodsInfo['price'],
				'priceType' => $goodsInfo['priceType'],
				'pic' => $goodsInfo['pic']);
			$this->db->where('ID',$goodsID)->update('goods_list', $newItem);
		} else
			$this->permission_model->noPermission(1);
	}
		

	function delGoods($goodsID)
	{
		$tmp = $this->db->from('goods_list')->where('ID', $goodsID)->get()->result_array();
		$user = $tmp[0]['userID'];
		if (isset($_SESSION["userID"]) && $user == $_SESSION["userID"]) {
			$this->db->where('ID',$goodsID)->update('goods_list', array('available'=>0));
		} else
			$this->permission_model->noPermission(1);
	}

	function addGoodsAtOBJ($goodsListByJSon,$goodsInfo)	
	{
		$goodsList = json_decode($goodsListByJSon,true);
		$goodsList[$goodsInfo['ID']] = $goodsInfo['price'];
		return json_encode($goodsList);
	}

	function delGoodsAtOBJ($goodsListByJSon,$goodsID)
	{
		$goodsList = json_decode($goodsListByJSon,true);
		if (isset($goodsList[$goodsID])) 
			unset($goodsList[$goodsID]);
		return json_encode($goodsList);
	}
}

?>
