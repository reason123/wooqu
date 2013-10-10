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
            $this->goods->addGoods($goodsInfo);
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
        if($this->form_validation->run() == FALSE){
            $this->load->view('base/mainnav',array('page'=>'newgoods'));
            $this->load->view('manager/goods/modgoods',array('goodsInfo'=>$_REQUEST,'goodsID'=>$_GET['goodsID']));
            $this->load->view('base/footer');
        }else{
             $goodsInfo = array('name'=>$_REQUEST['name'],'detail'=>$_REQUEST['detail'],'price'=>$_REQUEST['price'],'priceType'=>$_REQUEST['priceType'],'pic'=>'');
            $this->goods->modGoods($goodsInfo,$_GET['goodsID']);
            header('Location: /manager/goods'); 
        }
    }
}

?>
