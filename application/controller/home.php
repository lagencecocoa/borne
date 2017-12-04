<?php

class Home extends Controller
{

    public function index()
    {
		$categories = $this->products->getAllCategories();
    $slides = $this->slider->getSlides();

        require APP . 'view/_templates/header.php';
        require APP . 'view/home/index.php';
        require APP . 'view/_templates/footer.php';
    }



}
