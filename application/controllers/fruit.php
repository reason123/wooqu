<?php
@session_start();

class Fruit extends CI_Controller {
	function __construct() {
		parent::__construct();
	}

	/**
	 * 生成商店列表
	 * @author xanda
	 * 
	 */
	function shoplist() {
		$this->load->model('fruit_model','fruit');

		$this->load->view('base/mainnav',array('page'=>'shoplist'));
		if (isset($_SESSION['myGroup']))
			$list = $this->fruit->getShopListByGroup($_SESSION['myGroup']);
		else
			$list = array();
		$this->load->view('shop/shoplist', array('title'=>'水果团购','link'=>'fruit','list'=>$list));
        $this->load->view('base/footer');
	}

	/**
	 * 生成商店详情页面
	 * @author ca007
	 * @author xanda
	 */
	public function showShop(){
		$this->load->model('fruit_model','fruit');
		
		$fruitList = $this->fruit->getFruitListByShop($_GET['ID']);
		$actList = $this->fruit->getActListByShop($_GET['ID']);
		$shopInfo = $this->fruit->getShopInfoByID($_GET['ID']);

		$this->load->view('base/mainnav',array('page'=>'showshop'));

		$this->load->view('shop/showshop',array('shopInfo'=>$shopInfo,'goodsList'=>$fruitList,'actList'=>$actList));
		$this->load->view('base/footer');
	}
}

?>