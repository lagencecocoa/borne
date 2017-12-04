<div class="col-xs-12 col-md-9" style="padding:0">
  <div class="banner-category" style="background-image:url(/img/slider/2.jpg);background-repeat: no-repeat;background-size: cover;border-bottom: 10px solid #318dde;height:200px">
      <div style="background-color:#318dde;top: 140px;" class="banner-label">Ma liste</div>
  </div><br>

  <div class="col-xs-12 col-md-12" style="max-height: 630px;overflow-y: scroll;">

      <table class="table">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Liste des produits</th>
          <th>Email</th>
          <th>Date de création de la wishlist</th>
        </tr>
      </thead>
      <tbody>
  <?php
    foreach($allWishlist as $w){
        $productsWished = unserialize($w->products);



  ?>


        <tr>
		  <td><?php echo $w->name?></td>
          <td><?php echo $w->firstname?></td>
          <td>
              <?php
                  $list ='';

                  foreach($productsWished as $p){
                      $list .= $p->art_seq.', ';
                  }

                  $list = rtrim($list, ", ");
                  echo $list;
              ?>
          </td>
          <td><?php echo $w->email ?></td>
          <td><?php echo date("d-m-Y H:i:s",strtotime($w->creation_date)) ?></td>
        </tr>

  <?php
    }
  ?>
      </tbody>
    </table>
  </div>
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
