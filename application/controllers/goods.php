<?php

@session_start();
 
class Goods extends CI_Controller{
    function __construct(){
        parent::__construct();
    }


    function index(){
    }

    function newGoods()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name','name','required');
        $this->form_validation->set_rules('price','price','required|numeric');
        $this->form_validation->set_rules('priceType','priceType','required');
        $this->load->model('goods_model','goods');
        if($this->form_validation->run() == FALSE){
            $this->load->view('base/mainnav',array('page'=>'newgoods'));
            $this->load->view('manager/goods/newgoods',array('goodsInfo'=>$_REQUEST));
            $this->load->view('base/footer');
        }else{
            $goodsInfo = array('name'=>$_REQUEST['name'],'detail'=>$_REQUEST['detail'],'price'=>$_REQUEST['price'],'priceType'=>$_REQUEST['priceType'],'pic'=>'');
            $goodsID = $this->goods->addGoods($goodsInfo);
			$picPath = "/storage/goodsPic/pic_".$goodsID.".jpg";
			$goodsInfo['pic'] = $picPath;
			$this->goods->modGoods($goodsInfo,$goodsID);
			if ($_FILES['pic']['size'] > 0) {
				$photo = $_FILES['pic'];
				move_uploaded_file($photo['tmp_name'], substr($picPath, 1, strlen($picPath)));
			}
            if (isset($_GET['id'])) {
                $this->goods->addGoodsAtGroupbuy($_GET['id'], $goodsID, $_REQUEST['price']);
                header('Location: /manager/groupbuy_goods?id='.$_GET['id']); 
                return;
            }
            header('Location: /manager/goods'); 
        }
    }

    function modGoods()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name','name','required');
        $this->form_validation->set_rules('price','price','required|numeric');
        $this->form_validation->set_rules('priceType','price type','required');
        $this->load->model('goods_model','goods');
        $goodsInfo = $this->goods->getGoodsInfo($_GET['goodsID']);
        if (!isset($_REQUEST['name'])) $_REQUEST['name'] = $goodsInfo['name'];
        if (!isset($_REQUEST['price'])) $_REQUEST['price'] = $goodsInfo['price'];
        if (!isset($_REQUEST['priceType'])) $_REQUEST['priceType'] = $goodsInfo['priceType'];
        if (!isset($_REQUEST['detail'])) $_REQUEST['detail'] = $goodsInfo['detail'];
		if (!isset($_REQUEST['pic'])) $_REQUEST['pic'] = $goodsInfo['pic'];
        if($this->form_validation->run() == FALSE){
            $this->load->view('base/mainnav',array('page'=>'newgoods'));
            $this->load->view('manager/goods/modgoods',array('goodsInfo'=>$_REQUEST,'goodsID'=>$_GET['goodsID']));
            $this->load->view('base/footer');
        }else{
			$picPath = "http://www.wooqu.org/storage/goodsPic/pic_".$_GET['goodsID'].".jpg";
            $goodsInfo = array('name'=>$_REQUEST['name'],'detail'=>$_REQUEST['detail'],'price'=>$_REQUEST['price'],'priceType'=>$_REQUEST['priceType'],'pic'=>$picPath);
            $this->goods->modGoods($goodsInfo,$_GET['goodsID']);

			if ($_FILES['pic']['size'] > 0) {
				$photo = $_FILES['pic'];
				move_uploaded_file($photo['tmp_name'], substr($picPath, 1, strlen($picPath)));
			}

            header('Location: /manager/goods'); 
        }
    }

    function delGoods()
    {
        $this->load->model('goods_model','goods');
        $this->goods->delGoods($_GET['goodsID']);
        header('Location: /manager/goods'); 
    }

}

?>
