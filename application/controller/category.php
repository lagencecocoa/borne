<?php

class category extends Controller
{
	function view($cat_id){
        //all categories: menu
        $categories = $this->products->getAllCategories();
        //sub category of current category
        $subCat = $this->products->getSubCatCurrentCategory($cat_id);
        //current category
        $category = $this->products->getCurrentCategory($cat_id);
        //add subbategory thumbnail
        $subCat = $this->products->addThumbnail($subCat);

        require APP . 'view/_templates/header.php';
        require APP . 'view/products/category.php';
        require APP . 'view/_templates/footer.php';
    }

    function subcategory($cat_id,$code){
        //all categories: menu
        $categories = $this->products->getAllCategories();
        //products
        $products = $this->products->ProductGetListByFamilleCode($code);
        //current category
        $category = $this->products->getCurrentCategory($cat_id);

        require APP . 'view/_templates/header.php';
        require APP . 'view/products/subcategory.php';
        require APP . 'view/_templates/footer.php';

    }

    function product($cat_id,$code,$num_article){
        //all categories: menu
        $categories = $this->products->getAllCategories();
        //products
        $products = $this->products->ProductGetListByFamilleCode($code);
        //current product
        $product = $this->products->ProductGetBySeq($num_article);
        //current category
        $category = $this->products->getCurrentCategory($cat_id);

        require APP . 'view/_templates/header.php';
        require APP . 'view/products/product.php';
        require APP . 'view/_templates/footer.php';

    }
    
    function search(){
        //all categories: menu
        $categories = $this->products->getAllCategories();
        $term = $_GET['term']; 
        $products = $this->search->rechercher($term);
        
        require APP . 'view/_templates/header.php';
        require APP . 'view/search/list.php';
        require APP . 'view/_templates/footer.php';
    }

}
