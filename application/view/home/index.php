<div class="row">
  <a href="/connexion">
      <div style="width: 70px;text-align: center;height: 70px;border-radius: 5px;background-color: white;margin-left: 5px;;z-index: 1;display: table;float: right;">
         <span class="glyphicon glyphicon-user" aria-hidden="true" style="vertical-align: middle;display: table-cell;    font-size: xx-large;"></span>
      </div>
  </a>
  <div class="home-search" style="cursor:pointer;width: 70px;text-align: center;height: 70px;border-radius: 5px;background-color: white;margin-left: 5px;display: table;float: right;">
      <span class="glyphicon glyphicon-search none" aria-hidden="true" style="color:#3c8dbc;vertical-align: middle;display: table-cell;font-size: xx-large;"></span>
      <form action="/category/search" class="home-search-form" style="display:none;padding:10px;position: absolute;top: 60px;z-index: 9999;right: 0;background-color: white;">
          <input style="width:70%;float:left;margin-top: 20px;margin-bottom: 20px;" class="form-control ui-autocomplete-input" type="text" name="term" id="recherche" placeholder="Entrez le nom d'un produit" autocomplete="off">
          <button type="submit" style="float:left;margin-bottom: 15px;margin-left:15px;margin-top: 20px;" class="btn btn-primary">
              <i class="glyphicon glyphicon-search"></i>
          </button>
      </form>
  </div>

  <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <?php foreach ($slides as $slide): ?>
        <?php if ($slide === reset($slides)): ?>
        <li data-target="#carousel-example-generic" data-slide-to="<?= $slide->id ?>" class="active"></li>
        <?php else: ?>
        <li data-target="#carousel-example-generic" data-slide-to="<?= $slide->id ?>"></li>
        <?php endif; ?>
      <?php endforeach ?>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <?php foreach ($slides as $slide2): ?>
        <?php if ($slide2 === reset($slides)): ?>
        <div class="item active">
          <center><img src="http://<?= $_SERVER['HTTP_HOST'] .'/img/slider/'. $slide2->url ?>" alt="..."></center>
        </div>
        <?php else: ?>
        <div class="item">
          <center><img src="http://<?= $_SERVER['HTTP_HOST'] .'/img/slider/'. $slide2->url ?>" alt="..."></center>
        </div>
        <?php endif; ?>
     <?php endforeach; ?>
    </div>

  </div>
</div>

<div class="row">
<?php

foreach($categories as $cat){
  if(isset($cat->image) && !empty($cat->image)){

?>
  <a href="category/view/<?= $cat->id ?>">
    <div class="col-md-2 col-xs-12" style="padding:0;background-image: url(https://prestamed.com//medias/uploads/images/category/new_photos/<?= $cat->image ?>); background-size: cover; background-position: center center;min-height:200px;display:table">
      <div style="display:table-cell;vertical-align:middle;">
        <h2 style="text-align:center;background-color:rgba(<?= $cat->backgroundcolor ?>);font-size: 15px;color:white;height:50px;padding:5px 0px;vertical-align: middle;display: table-cell;width: 1%;"><?= $cat->label ?></h2>
      </div>
    </div>
  </a>
<?php
  }
}
?>
</div>
