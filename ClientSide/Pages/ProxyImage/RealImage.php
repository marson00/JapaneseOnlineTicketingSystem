<?php
require_once 'Image.php';

class RealImage implements Image {
    private $filename;

    public function __construct($filename) {
        $this->filename = $filename;
        $this->loadImage();
    }

    public function displayImage() {
        echo "<img src='$this->filename' 
                class='d-block mx-auto' style='height: 600px'/>";
    }

    private function loadImage() {
        echo "<div class='d-none'>Loading Image...</div>";
    }
}



