<?php
class wishlist extends Controller
{

    public function index()
    {
		$categories = $this->products->getAllCategories();
        require APP . 'view/_templates/header.php';
        $pwish = $this->wishlisted->getProductsWished($_SESSION["wish"]);
        require APP . 'view/wishlist/view.php';
        require APP . 'view/_templates/footer.php';
    }
    
    public function post(){ 
        $this->wishlisted->actionWishlist($_POST['mail'],$_POST['serial'], $_POST['name'], $_POST['firstname']);
    }

    

}