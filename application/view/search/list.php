<div class="col-xs-12 col-md-9" style="padding:0">
<div class="banner-category" style="background-image:url(/img/slider/2.jpg);border-bottom: 10px solid #318dde;height:200px">
    <div style="background-color:#318dde;top: 140px;" class="banner-label">Recherche</div>
</div><br>
    
<div class="col-xs-12 col-md-12" style="padding:0;max-height: 630px;overflow-y: scroll;">

<?php

    if($products == new \stdClass()){
        echo '<center><p>Aucun article trouvé.</p></center>';
    }

    foreach($products as $p){
    
        $catNumber = explode("-", $p->art_famille);
        
?>
    <a class="info" href="http://<?= $_SERVER['HTTP_HOST'] ?>/category/product/<?= $catNumber[0] ?>/<?= $p->art_famille ?>/<?= $p->art_seq ?>">
    <div class="col-xs-12 col-sm-6 product-list-li-0 product_thumb" style="margin-bottom: 15px;margin-top:20px;padding-right:0">

        <div class="cadre" style="border-top: 5px solid #318dde;">
            <p class="product-p">
                <span class="imgBlock">
                    <img src="https://prestamed.com/medias/uploads/images/products/thumbs/<?= $p->art_seq ?>_thumb.jpg" height="170" alt="">
                </span>
            </p>
            <div class="product-cadre-lab" style="background-color:#318dde">
                <strong class="product-lab" style="color:#fff"><?= ucfirst(strtolower($p->art_lib)) ?></strong>
            </div>
        </div>
    </div>
    </a>
<?php
    }
    
    
?>
</div>
</div>