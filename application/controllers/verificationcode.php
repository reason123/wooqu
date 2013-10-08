<?php

class VerificationCode extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->load->helper("base");
	}
    /**
     * 生成验证码，通过Session检查输入是否正确
     * @param GET $data 
     *  field 设置的Session域<br>
     *  bordercolor 边框颜色<br>
     *  bgcolor 北京颜色<br>
     *  height 验证码高度<br>
     *  png 验证码图片<br>
     */ 
	function index(){
        $path_parts = pathinfo($_SERVER['PHP_SELF']);    //$_SERVER['PHP_SELF']是相对于根目录而言的路径。
		ob_start();
		error_reporting(7);
		ini_get('session.auto_start') || @session_start();
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
		define('R_P', dirname(__FILE__));
		$field =  isset($_GET['field']) ?  trim($_GET['field']) : 'code';
		if(function_exists('imageCreate') && function_exists('imageFilledRectangle') && function_exists('imagettftext')){
		//	echo "hehe";
			$len = isset($_GET['len']) ? intval($_GET['len']) : 4;
			$height = min(50, isset($_GET['height']) ? intval($_GET['height']) : 22);
			$bgcolor = isset($_GET['bgcolor']) ? '#' . $_GET['bgcolor'] : '#ffffff';
			$bordercolor = isset($_GET['bordercolor']) ? '#' . $_GET['bordercolor'] : '#000000';
			$width = 18 * $len;
			$noise = true;
			$noisenum = 200;
			$border = true;
			$image = imageCreate($width, $height);
			$back = $this->getcolor($bgcolor,$image);
			imageFilledRectangle($image, 0, 0, $width, $height, $back);
			$size = $width / $len;
			if ($size > $height) $size = $height;
			$left = ($width - $len * ($size + $size / 10)) / $size;
			$code = $this->random($len);
            $font = "./page/code/bombard.ttf";
			$textColor = imageColorAllocate($image, rand(0, 100), rand(0, 100), rand(0, 100));
			for($i=0;$i<strlen($code);$i++){
				imagettftext($image, 18, 0, 18 * $i + 2, 20, $textColor, $font, $code[$i]);
			}
			if ($noise == true) $this->setnoise($image,$width,$height,$back,$noisenum);
			unset($_SESSION[$field]);
			$_SESSION[$field] = strtolower($code);
			$bordercolor = $this->getcolor($bordercolor,$image);
			if ($border == true) imageRectangle($image, 0, 0, $width-1, $height-1, $bordercolor);
			header("Content-type: image/png");
			imagePng($image);
			imagedestroy($image);
		}else{
			if(function_exists('imageCreate')) echo 'Exist imageCreate';
			if(function_exists('imageFilledRectangle')) echo 'Exist imageFilledRectangle';
			if(function_exists('imagettftext')) echo 'Exist imagettftext';
		}
	}
    /**
     * 获取颜色
     * @access private
     * @param string $color 颜色代码
     * @param image $image 传入图片
     * @return color $color 代码对应颜色
     */
	private function getcolor($color,$image){
		$color = eregi_replace ("^#", "", $color);
		$r = $color[0] . $color[1];
		$r = hexdec ($r);
		$b = $color[2] . $color[3];
		$b = hexdec ($b);
		$g = $color[4] . $color[5];
		$g = hexdec ($g);
		$color = imagecolorallocate ($image, $r, $b, $g);
		return $color;
	}
    /**
     * 设置噪点
     * @access private
     * @param image $image 对应图片
     * @param int $width 宽度
     * @param int $height 高度
     * @param string $back 背景颜色
     * @param int $noisenum 噪点个数
     */
	private function setnoise($image,$width,$height,$back,$noisenum){
		for ($i = 0; $i < $noisenum; $i++)
		{
			$randColor = imageColorAllocate($image, rand(0, 255), rand(0, 255), rand(0, 255));
			imageSetPixel($image, rand(0, $width), rand(0, $height), $randColor);
		}
	}

    /**
     * 生成随机字符串
     * @access private
     * @param int $length 生成字符串长度
     * @return string $hash 字符串
     */
	private function random($length) {
		$chars = '2346789ABCDEGH2346789KLMNPRTJabcdefghjkmprtxyz';
		$max = strlen($chars) - 1;
		mt_srand((double)microtime() * 1000000);
		for($i = 0; $i < $length; $i ++) {
			$hash .= $chars[mt_rand(0, $max)];
		} 
		return $hash;
	} 
} 

?>