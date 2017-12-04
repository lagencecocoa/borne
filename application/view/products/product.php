<?php
    //add item to wishlist
    if(isset($_POST["addWish"]))
    {
        array_push($_SESSION["wish"],$product->art_seq);
        $_SESSION["wish"] = array_unique($_SESSION["wish"]);
        echo '<script type="text/javascript">window.location.href = "/category/product/'.$category->ray_code.'/'.$product->art_famille.'/'.$product->art_seq.'?add=1";</script>';

    }
?>


<div class="col-xs-12 col-md-9" style="padding:0">
<div class="banner-category" style="background-image:url(/img/header/<?= $category->handle ?>.jpg);background-position: center;background-repeat: no-repeat;background-size: cover;border-bottom: 10px solid #<?= $category->color ?>;">
    <div style="background-color:#<?= $category->color ?>" class="banner-label"><?= $category->ray_web_lib ?></div>
</div>
 <br>
    <div class="col-xs-12 col-md-12" style="margin-bottom:15px">
    <a href="/category/subcategory/<?= $category->ray_code ?>/<?= $product->art_famille ?>" class="btn btn-info btn-lg" style="padding: 6px 12px;background-color:#<?= $category->color ?>;border:none">
        <span style="top: 3px;" class="glyphicon glyphicon-arrow-left"></span>
        <span style="margin-left:3px">Retour</span>
    </a>

</div>
<?php

?>

    <div class="col-xs-11 product_fiche" style="margin: 15px 0 30px 35px;">
        <div class="col-xs-12 col-md-6" style="text-align:center">
          <a data-fancybox="gallery" href="https://prestamed.com/medias/uploads/images/products/bigs/<?= $product->art_seq ?>.jpg"><img style="padding-top: 20px;max-width: 100%;" src="https://prestamed.com/medias/uploads/images/products/bigs/<?= $product->art_seq ?>.jpg" alt="<?= $product->art_lib ?>" height="350" title="<?= $product->art_lib ?>"></a>
        </div>
        <div class="col-xs-12 col-md-6" style="">
          <h2 style="color:#<?= $category->color ?>;font-size:25px"><?= $product->art_lib ?></h2>
            <?php if(!in_array($product->art_seq, $_SESSION["wish"])){ ?>
          <form method="post">
              <button type="submit" name="addWish" class="btn btn-secondary" style="color:#505050;border:1px solid #3c8dbc;background-color:white"><img style="width: 35px;" src="/public/img/wishlist_add.png" alt=""></button>
          </form>
            <?php }else{ ?>
               <button class="btn btn-success" style="color:#00a65a;border:1px solid #00a65a;background-color:white"><span style="color:#00a65a" class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>

            <?php } ?>
          <hr>
          <p style="margin-bottom: 15px;"><strong>FABRICANT : </strong><span style="color: #505050;"><?= !empty($product->frs_nom) ?$product->frs_nom : '-'; ?></span>
          <p style="margin-bottom: 15px;"><?= !empty($product->art_comment) ?ucfirst($product->art_comment) : ''; ?></p>
          <div style=" float: right;margin-bottom: 15px;background-color:#<?= $category->color ?>;max-width: 150px;padding: 5px;color: white;">

            <strong>RÉFÉRENCE : <?= !empty($product->condref_autreref) ?$product->condref_autreref : '-'; ?></strong>
          </div>
        </div>
    </div>
<br>
    <div class="col-xs-1"></div>
    <div class="col-xs-10"  style="margin: 0 0 15px 0">
      <div class="similar-products" style="">
        <?php foreach ($products as $similar_product): ?>
        <?php if($similar_product->art_seq != $product->art_seq): ?>
          <div class="product_fiche" style="background-color: #FFFFFF;border-radius: 5px;margin-left: 10px;margin-bottom: 15px;margin-right: 10px;padding: 10px;">
            <a href="http://<?= $_SERVER['HTTP_HOST'] ?>/category/product/<?= $category->ray_code ?>/<?= $similar_product->art_famille ?>/<?= $similar_product->art_seq ?>">
              <div class=""><img src="https://prestamed.com/medias/uploads/images/products/bigs/<?= $similar_product->art_seq ?>.jpg" alt="" style="height: 40px;float: left;margin-left: 20px;margin-right:20px;"></div>
              <div class=""><p style="color:#<?= $category->color ?>;font-size:15px;padding-top: 10px;"><?= substr(ucfirst(strtolower($similar_product->art_lib)), 0, 25) ?></p></div>
            </a>
          </div>
        <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
<br>
<?php

?>

</div>
