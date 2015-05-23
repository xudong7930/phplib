<?php
/**
 * 验证码类
 * how tu use?
 * $cap = new Mycaptcha();
 * $cap->showImg(160,40,1,"msyh.ttc");
 * $word = $cap->getCode();
 */
class Mycaptcha {
    private $width; //图片宽度
    private $height; //图片高度
    private $codeNum; //验证码字符个数
    private $code; //验证码图片
    private $im; //生成验证码的对象实例
    private $typeNum = array(
        0=>"ABCDEFGHKLMNPQRSTUVWXYZ",
        1=>"1234567890",
        2=>"1234567890ABCDEFGHKLMNPQRSTUVWXYZ"
    );
    private $Num;
    private $fontPath;

	
    /**
     * 构造函数     
     * @param integer $width   [description]
     * @param integer $height  [description]
     * @param integer $codeNum [description]
     * @param integer $type    [description]
     */
    function __construct($width=160, $height=40, $codeNum=4,$type=1, $fontpath="")
    {
        $this->width = $width;
        $this->height = $height;
        $this->codeNum = $codeNum;
        $this->Num = $this->typeNum[$type];
        $this->fontPath = $fontpath;
    }

 
    function showImg()
    {
        $this->createImg(); //创建图片
        $this->setDisturb(); //设置干扰元素
        $this->setCaptcha(); //设置验证码
        $this->outputImg(); //输出图片
    }
 

	function getCaptcha()
    {
        return $this->code;
    }

	
    private function createImg()
    {
        $this->im = imagecreatetruecolor($this->width, $this->height);
        $bgColor = imagecolorallocate($this->im, 250, 250, 250);
        imagefill($this->im, 0, 0, $bgColor);
    }

	
    private function setDisturb()
    {
        /*
        $area = ($this->width * $this->height) / 20;
        $disturbNum = ($area > 250) ? 250 : $area;
        //加入点干扰
        for ($i = 0; $i < $disturbNum; $i++) {
            $color = imagecolorallocate($this->im, rand(0, 255), rand(0, 255), rand(0, 255));
            imagesetpixel($this->im, rand(1, $this->width - 2), rand(1, $this->height - 2), $color);
        }
        //加入弧线
        for ($i = 0; $i <= 5; $i++) {
            $color = imagecolorallocate($this->im, rand(128, 255), rand(125, 255), rand(100, 255));
            imagearc($this->im, rand(0, $this->width), rand(0, $this->height), rand(30, 300), rand(20, 200), 50, 30, $color);
        }
        */
    }
 
 
    private function createCode()
    {
        $str = $this->Num;
        for ($i = 0; $i < $this->codeNum; $i++) {
            $this->code .= $str{rand(0, strlen($str) - 1)};
        }
    }


    public function make_rand($length=4)
    {
        $str = $this->Num;
        $result="";
        for($i=0;$i<$length;$i++){
            $num[$i]=rand(0,25);
            $result.=$str[$num[$i]];
        }
        return $result;
    }
 
 
    private function setCaptcha()
    {
        $this->createCode();
        for ($i = 0; $i < $this->codeNum; $i++) {
            $size = rand(floor($this->height / 5), floor($this->height / 3));
            $angle = rand(-10,10);
            $x = floor($this->width / $this->codeNum) * $i + 5;
            $y = rand(0, $this->height - 20);
            $color = imagecolorallocate($this->im, rand(50, 250), rand(100, 250), rand(128, 250));

            if($this->fontPath) {
                imagettftext($this->im, $size, $angle, $x, $y, $color, $this->fontPath, $this->code{$i});        
            }
            else {
                imagechar($this->im, $size, $x, $y, $this->code{$i}, $color);
            }
        }
    }
 
 
    private function outputImg()
    {
        if (imagetypes() & IMG_JPG) {
            header('Content-type:image/jpeg');
            imagejpeg($this->im);
        } elseif (imagetypes() & IMG_GIF) {
            header('Content-type: image/gif');
            imagegif($this->im);
        } elseif (imagetype() & IMG_PNG) {
            header('Content-type: image/png');
            imagepng($this->im);
        } else {
            die("Don't support image type!");
        }
    }
}