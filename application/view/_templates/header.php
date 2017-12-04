<?php
session_start();

if(!isset($_SESSION['wish'])){
    $_SESSION['wish'] = array();
}


?>
<!DOCTYPE html>
<html style="min-height: 100vh;">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Borne MediKiosk</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" type="text/css" href="/public/assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="/public/css/style.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" type="text/css" href="/public/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" type="text/css" href="/public/dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" type="text/css" href="/public/plugins/iCheck/flat/blue.css">
  <!-- Morris chart -->
  <link rel="stylesheet" type="text/css" href="/public/plugins/morris/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" type="text/css" href="/public/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" type="text/css" href="/public/plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" type="text/css" href="/public/plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" type="text/css" href="/public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.css" />

  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
  <link rel="stylesheet" type="text/css" href="/public/js/jq-ui/jquery-ui.min.css">
</head>

<body class="hold-transition skin-blue sidebar-mini" style="min-height: 100vh;">
    <div class="container-fluid" style="min-height: 100vh;">
<?php if(!isset($_SESSION['auth'])){?>
    <a href="/">
          <div style="width: 55px;text-align: center;height: 70px;border-radius: 5px;background-color: white;margin-left: 5px;;z-index: 1;display: table;float: right;">
            <span class="glyphicon glyphicon-home" aria-hidden="true" style="vertical-align: middle;display: table-cell;font-size: xx-large;"></span>
          </div>
    </a>

<?php }?>


<?php if(isset($_SESSION['auth'])){?>

  <a href="/connexion/disconnect">
      <div style="width: 70px;text-align: center;height: 70px;border-radius: 5px;background-color: white;margin-left: 5px;display: table;float: right;">
        <span class="glyphicon glyphicon-off" aria-hidden="true" style="vertical-align: middle;display: table-cell;font-size: xx-large;"></span>
      </div>
  </a>
  <button style="width: 70px;text-align: center;height: 70px;border-radius: 5px;background-color: white;margin-left: 5px;display: table;float: right;border:none" type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
    <span class="glyphicon glyphicon-cog" aria-hidden="true" style="vertical-align: middle;display: table-cell;padding-left: 2px;color: #3c8dbc;font-size: xx-large;"></span>
  </button>
  <a href="/admin/wishlist">
      <div style="width: 70px;text-align: center;height: 70px;border-radius: 5px;background-color: white;margin-left: 5px;display: table;float: right;">
        <span class="glyphicon glyphicon-list-alt" aria-hidden="true" style="vertical-align: middle;display: table-cell;font-size: xx-large;"></span>
      </div>
  </a>
<?php }?>

<?php
    if($_SERVER['REQUEST_URI'] != '/admin'){
        if($_SERVER['REQUEST_URI'] != '/'){
?>

<div class="col-xs-12 col-md-3 menu-shadow" style="padding:0;min-height: 100vh;">
    <div class="col-xs-12" style="background-color:white;padding-top:30px">

        <a id="wishlist" style="padding: 10px 15px 10px 15px;border: 2px solid #308BE6;text-transform: uppercase;color: #308BE6;background-color: white;margin: 0px;font-weight: 700;letter-spacing: 1px;" href="/wishlist/index">Consulter ma liste (<?php echo count($_SESSION['wish'])?>)</a><br>
        <form action="/category/search" style="">
            <input style="width:70%;float:left;margin-top: 30px;margin-bottom: 20px;" class="form-control" type="text" name="term" id="recherche" placeholder="Entrez le nom d'un produit"/>
            <button type="submit" style="float:left;margin-bottom: 15px;margin-left:15px;margin-top: 30px;" class="btn btn-primary">
                <i class="glyphicon glyphicon-search"></i>
            </button>
        </form>
    </div>

    <?php

    foreach($categories as $cat){
        if(isset($cat->image) && !empty($cat->image)){

    ?>
            <div class="col-xs-12 lateral-menu-item menu-<?= $cat->id ?>" style="background-color:rgba(<?= $cat->backgroundcolor ?>);">
                <a class="subitem-link" href="http://<?= $_SERVER['HTTP_HOST'] ?>/category/view/<?= $cat->id ?>" style="color:white"><?= $cat->label ?></a>
            </div>

            <div class="lateral-menu-subitem submenu-<?= $cat->id ?>" style="<?php if(isset($category) && $category->ray_code != $cat->id){ echo "display:none;";} ?> <?php  if(!isset($category)){echo "display:none;";} ?>background-color:rgba(<?= $cat->backgroundcolor_sub ?>);">
    <?php
            foreach($cat->items as $sub){
    ?>
                <div class="subitem-container"><a class="subitem-link" style="color:rgb(99, 99, 99)" href="http://<?= $_SERVER['HTTP_HOST'] ?>/category/subcategory/<?= $cat->id ?>/<?= $sub->id ?>"><?= ucfirst(strtolower($sub->label))?></a></div>
    <?php
            }
    ?>
            </div>
    <?php
        }
    }
    ?>
</div>
<?php
    }}
?>
