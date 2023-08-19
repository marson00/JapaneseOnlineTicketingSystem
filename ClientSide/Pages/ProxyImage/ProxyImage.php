<?php
require_once 'Image.php';
require_once 'RealImage.php';

class ProxyImage implements Image {
    private $image;
    private $filename;

    public function __construct($filename) {
        $this->filename = $filename;
    }

    public function displayImage() {
        if (!$this->image) {
            $this->image = new RealImage($this->filename);
            
        }
        $this->image->displayImage();
    }

}


