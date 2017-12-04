<?php

class Admin extends Controller
{

    public function index()
    {
		    $categories = $this->products->getAllCategories();
        $slides = $this->slider->getSlides();
        require APP . 'view/_templates/header.php';
        require APP . 'view/admin/index.php';
        require APP . 'view/_templates/footer.php';
    }

    public function updateSlides() {
      if(isset($_POST['upload_slides'])) {
        //$this->slider->setSlides($_FILES);
        foreach($_FILES as $key => $slide) {
          $dossier = $_SERVER['DOCUMENT_ROOT'].'/public/img/slider/';
          $fichier = $key . '.jpg';
          echo file_exists($dossier . $fichier);
          echo $dossier . $fichier;
          //unlink($dossier . $fichier);
          move_uploaded_file($slide['tmp_name'], $dossier . $fichier);
        }
      }
      //header('Location: /admin');
    }

    public function wishlist()
    {

        $categories = $this->products->getAllCategories();
        require APP . 'view/_templates/header.php';
        $allWishlist = $this->wishlisted->getAllWishlist();
        $slides = $this->slider->getSlides();
        require APP . 'view/admin/wishlist.php';
        require APP . 'view/_templates/footer.php';
    }

}
