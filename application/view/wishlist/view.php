<?php
   if(isset($_GET['unset'])){
        $ref = $_GET['unset'];
        $key = array_search($ref, $_SESSION['wish']);
        unset($_SESSION['wish'][$key]);
        echo '<SCRIPT LANGUAGE="JavaScript">document.location.href="/wishlist/index"</SCRIPT>';
    }

?>
<div class="col-xs-12 col-md-9" style="padding:0">
<div class="banner-category" style="background-image:url(/img/slider/2.jpg);background-repeat: no-repeat;background-size: cover;border-bottom: 10px solid #318dde;height:200px">
    <div style="background-color:#318dde;top: 140px;" class="banner-label">Ma liste</div>
</div><br>

<div class="col-xs-12 col-md-12" style="max-height: 630px;overflow-y: scroll;">

    <table class="table">
    <thead>
      <tr>
        <th>Produit</th>
        <th>Nom</th>
        <th>Catégorie</th>
        <!--<th>Référence</th>-->
      </tr>
    </thead>
    <tbody>
<?php
    foreach($pwish as $p){

        $catNumber = explode("-", $p->art_famille);

?>
    <a class="info" href="http://<?= $_SERVER['HTTP_HOST'] ?>/category/product/<?= $catNumber[0] ?>/<?= $p->art_famille ?>/<?= $p->art_seq ?>">

      <tr>
        <td style="vertical-align: middle;"><a  href="http://<?= $_SERVER['HTTP_HOST'] ?>/category/product/<?= $catNumber[0] ?>/<?= $p->art_famille ?>/<?= $p->art_seq ?>"><img style="padding-top: 20px;max-height: 100px;" src="https://prestamed.com/medias/uploads/images/products/thumbs/<?= $p->art_seq ?>_thumb.jpg" alt="<?= $p->art_lib ?>" height="350" title="<?= $p->art_lib ?>"></a></td>
        <td style="vertical-align: middle;"><?= $p->art_lib ?></td>
        <td style="vertical-align: middle;"><?= $p->art_famille ?></td>
        <!--<td style="vertical-align: middle;"><?= !empty($p->condref_autreref) ?$p->condref_autreref : '-'; ?></td>-->
        <td style="vertical-align: middle;"><a href="/wishlist/index?unset=<?= $p->art_seq ?>">Retirer le produit</a></td>
      </tr>

    </a>
<?php
    }

    if(!$pwish){
        echo '<p>Aucun article dans la liste.</p>';
    }
?>
    </tbody>
  </table>

  <form action="/wishlist/post" method="POST">
    <textarea name="serial" style="display:none"><?= serialize($pwish) ?></textarea>
	  <input type="text" name="name" placeholder="Entrez votre nom" class="form-control" style="width:20%;float:left;margin-right:15px;">
	  <input type="text" name="firstname" placeholder="Entrez votre prénom" class="form-control" style="width:20%;float:left;margin-right:15px;">
    <input type="email" name="mail" value="" placeholder="Entrez une adresse mail" class="form-control" style="width:20%;float:left;">
	  <input type="submit" name="saveWishlist" class="btn btn-primary" style="float:left;margin-left:15px" value="Envoyer la liste">

  </form>
</div>
</div>
