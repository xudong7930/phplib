<?php 
/**
  * ===========================================
  * Project: phplib
  * Function: 像素验证码
  * Time: 2015-5-20 15:22:16 @ Create
  * Copyright (c) 2007 - 2015 phplib Studio
  * Github: https://github.com/xudong7930/phplib
  * Developer: phplib
  * E-mail: xudong7930@gmail.com
  * //如何使用?
	$code = new SimPixelCaptcha();
	$code->output();
  * ===========================================
  */
class SimPixelCaptcha {
	private $dicts = array(
		0=>"2345678abcdefghjkmnprstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ",
		1=>"0123456789",
		2=>"abcdefghijklmnopqrstuvwxyz",
		3=>"ABCDEFGHIJKLMNOPQRSTUVWXYZ",
	);

	private $length = 4;  //验证码字符长度
	private $type = 2; //验证码字典类型
	private $zoom = 5; //放大倍数
	private $density = 6; //像素点密度
	private $noise = 4; //噪点密度

	private $text; //验证码文本
	private $font = 5; //验证码字体
	private $index = array(); //字符位置索引信息
	private $im = null; //图像资源
	private $width = 200; //图像宽度
	private $height = 100; //图像高度
	private $color = "green"; //前景色

	public function __construct($length=4,$type=1,$zoom=4,$density=160,$noise=2,$width=200,$height=100,$color='#FFF') {
		$this->length = $length;
		$this->type = $type;
		$this->zoom = $zoom;
		$this->density = $density;
		$this->noise = $noise;
		$this->width = $width;
		$this->height = $height;
		$this->color = $color;
	}


	public function output($session_name=null) {
		$this->createText()->ParseCode()->imageBackground()->imageText()->imageNoise();
		header("Content-type:image/png");
		imagepng($this->im);
		imagedestroy($this->im);
		if (!is_null($session_name)) {
			isset($_SESSION) or session_start();
			$_SESSION[$session_name] = $this->text;
		}
	}

	public function getCode() {
		return $this->text;
	}

	public function createText() {
		$dict = isset($this->dicts[$this->type]) ? $this->dicts[$this->type] : $this->dicts[0];
		$text = substr(str_shuffle($dict), 0, $this->length);
    	$this->text = $text;
    	return $this;
	}

	private function parseCode() {
	    $len = strlen($this->text);
	    $this->width = imagefontwidth($this->font) * $len;
	    $this->height = imagefontheight($this->font);
	    $im = imagecreatetruecolor($this->width, $this->height);
	    $color = imagecolorallocate($im, 255, 255, 255);
	    imagestring($im, $this->font, 0, 0, $this->text, $color);
	    for($x = 0; $x < $this->width; $x++) {
	      for($y = 0; $y < $this->height; $y++) {
	        $arr = imagecolorsforindex($im, imagecolorat($im, $x, $y));
	        $arr['red'] == 255 && $this->index[] = ($x + 1) . ',' . $y;
	      }
	    }
	    imagedestroy($im);
	    return $this;
  	}


  	private function imageBackground() {
	    $zoom = $this->zoom;
	    $this->width *= $zoom;
	    $this->height *= $zoom;
	    $this->im = imagecreatetruecolor($this->width, $this->height);
	    $bgcolor = imagecolorallocate($this->im, rand(0, 100), rand(0, 100), rand(0, 100));
	    imagefilledrectangle($this->im, 0, 0, $this->width, $this->height, $bgcolor);
	    return $this;
  	}


  	/**
   	 * 绘制字符
     * @access private
     * @return SimPixelCaptcha
     */
	private function imageText() {
	    $zoom = $this->zoom;
	    $density = $this->density;
	    $this->color = imagecolorallocate($this->im, rand(150, 255), rand(150, 255), rand(150, 255));
	    foreach ($this->index as $val) {
	     	list($x, $y) = explode(',', $val);
	     	$xx = $x * $zoom;
	     	$yy = $y * $zoom;
	     	$of = intval($zoom / 2);
	     	for($i = 0; $i < $density; $i++) {
	       		imagesetpixel($this->im, $xx + rand(-$of, $of), $yy + rand(-$of, $of), $this->color);
	     	}
	    }
	    return $this;
	}



	/**
     * 绘制噪点
     * @access private
     * @return SimPixelCaptcha
     */
    private function imageNoise() {
	    $noise = $this->noise;
	    $count = intval($this->width * $this->height * $noise / 100);
	    for($i = 0; $i < $count; $i++) {
	      imagesetpixel($this->im, rand(1, $this->width), rand(1, $this->height), $this->color);
	    }
	    return $this;
  	}

  	/**
     * 析构函数
     */
	public function __destruct() {
	    unset($this->ini);
	}
}
?>