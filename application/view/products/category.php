<div class="col-xs-12 col-md-9" style="padding:0">
<div class="banner-category" style="background-image:url(/img/header/<?= $category->handle ?>.jpg);background-position: center;background-repeat: no-repeat;background-size: cover;border-bottom: 10px solid #<?= $category->color ?>;">
    <div style="background-color:#<?= $category->color ?>" class="banner-label"><?= $category->ray_web_lib ?></div>
</div><br>

<div class="col-xs-12 col-md-12">
    <a href="/" class="btn btn-info btn-lg" style="padding: 6px 12px;background-color:#<?= $category->color ?>;border:none">
        <span style="top: 3px;" class="glyphicon glyphicon-arrow-left"></span>
        <span style="margin-left:3px">Accueil</span>
    </a>    
</div>   
    
<div class="col-xs-12 col-md-12" style="padding:0;max-height: 630px;overflow-y: scroll;">
     
<?php
    foreach($subCat as $sc){
?>
    <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/category/subcategory/<?= $category->ray_code ?>/<?= $sc->fam_code ?>">
      <div class="col-xs-12 col-sm-6 product-list-li-0 product_thumb" style="margin-bottom: 15px;margin-top:20px">
        <div class="cadre" style="border-top: 5px solid #<?= $category->color ?>">
          <p class="product-p">
              <span class="imgBlock">
                  <img src="https://prestamed.com/medias/uploads/images/products/thumbs/<?= $sc->image ?>_thumb.jpg" height="170" alt="">
              </span>
          </p>
          <div class="product-cadre-lab" style="background-color:#<?= $category->color ?>;">
              <strong class="product-lab" style=""><?= ucfirst(strtolower($sc->fam_lib)) ?></strong>
          </div>
        </div>
    </div>
    </a>
<?php
    }

?>
</div>
</div>

