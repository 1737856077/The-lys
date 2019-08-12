<?php
class lib_makeimg {

    private $imagePath;         //图片路径
    private $outputDir;             //输出文件夹
    public function __construct($imagePath, $outputDir = null)
    {
        $this->imagePath = $imagePath;
        $this->outputDir = $outputDir;
        $this->memoryImg = null;
    }


        //两张图片合成一张
    public function setpu_img($imagePath,$qrcode){
        $path    = './static/image/85ef0a516734f7f6e0b3a7a6d5b52b9.jpg';
        $qrcode  = './static/image/e52d36151182c6a52bc5c45c8e993e56.png';
        $bigImg = imagecreatefromstring(file_get_contents($path));
        $qCodeImg = imagecreatefromstring(file_get_contents($qrcode));
        list($qCodeWidth, $qCodeHight, $qCodeType) = getimagesize($qrcode);
        imagecopymerge($bigImg, $qCodeImg, 225, 500, 0, 0, $qCodeWidth, $qCodeHight, 100);
        $img = imagejpeg($bigImg,'./static/'.rand('1000','9999').'.jpg');
        return $img;
    }

    //生成水印
    public function addTextmark($content,$size,$font,$output = false)
    {
        $info = getimagesize($this->imagePath);
        $type = image_type_to_extension($info[2], false);
        $fun = "imagecreatefrom{$type}";
        $image = $fun($this->imagePath);
        $color = imagecolorallocatealpha($image, 0, 0, 0, 80);
        $posX = imagesx($image) - strlen($content) * $size / 2;
        $posY = imagesy($image) - $size / 1.5;
        imagettftext($image, $size, 0, $posX, $posY, $color, $font, $content);
        if ($output) {
            $this->saveImage($image);
        }
        $this->memoryImg = $image;
        return $this;
    }

    /**将图片以文件形式保存
     * @param $image
     */
    private function saveImage($image)
    {
        $info = getimagesize($this->imagePath);
        $type = image_type_to_extension($info[2], false);
        $funs = "image{$type}";
        if (empty($this->outputDir)) {
            $funs($image, md5($this->imagePath) . '.' . $type);
        } else {
            $funs($image, $this->outputDir . md5($this->imagePath) . '.' . $type);
        }
    }



}