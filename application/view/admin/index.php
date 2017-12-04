<div class="row">
        

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

<!-- Button trigger modal -->


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

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Listes des slides</h4>
      </div>
      <form action="admin/updateSlides" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <?php foreach ($slides as $slide3): ?>
              <img class="img-responsive" src="http://<?= $_SERVER['HTTP_HOST'] .'/img/slider/'. $slide3->url ?>" alt="...">
              <div class="form-group">
                <label for="">Slide <?= $slide3->id ?></label>
                <input type="file" accept="image/*" class="form-control" name="<?= $slide3->id ?>" value="" /><br/>
              </div>
          <?php endforeach; ?>
        </div>
        <div class="modal-footer" style="text-align: center;">
          <button type="submit" name="upload_slides" class="btn btn-primary">Enregistrer les modifications</button>
        </div>
      </form>
    </div>
  </div>
</div>
