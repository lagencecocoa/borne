

<div class="col-xs-12 col-md-9" style="padding:0">
<div class="banner-category" style="background-image:url(/img/header/<?= $category->handle ?>.jpg);background-position: center;background-repeat: no-repeat;background-size: cover;border-bottom: 10px solid #<?= $category->color ?>;">
    <div style="background-color:#<?= $category->color ?>" class="banner-label"><?= $category->ray_web_lib ?></div>
</div><br>
    
<div class="col-xs-12 col-md-12" style="margin-bottom:15px">
    <a href="/category/view/<?= $category->ray_code ?>" class="btn btn-info btn-lg" style="padding: 6px 12px;background-color:#<?= $category->color ?>;border:none">
        <span style="top: 3px;" class="glyphicon glyphicon-arrow-left"></span>
        <span style="margin-left:3px">Retour</span>
    </a>    
</div> 
    
<div class="col-xs-12 col-md-12" style="padding:0;max-height: 630px;overflow-y: scroll;">
<?php
    foreach($products as $p){
?>
    <a class="info" href="http://<?= $_SERVER['HTTP_HOST'] ?>/category/product/<?= $category->ray_code ?>/<?= $p->art_famille ?>/<?= $p->art_seq ?>">
    <div class="col-xs-12 col-sm-6 product-list-li-0 product_thumb" style="margin-bottom: 15px;margin-top:20px:padding-right:0">

        <div class="cadre" style="border-top: 5px solid #<?= $category->color ?>">
            <p class="product-p">
                <span class="imgBlock">
                    <img src="https://prestamed.com/medias/uploads/images/products/thumbs/<?= $p->art_seq ?>_thumb.jpg" height="170" alt="">
                </span>
            </p>
            <div class="product-cadre-lab" style="background-color:#<?= $category->color ?>;">
                <strong class="product-lab" style=""><?= ucfirst(strtolower($p->art_lib)) ?></strong>
            </div>
        </div>
    </div>
    </a>
<?php
    }
?>
</div>
</div>

