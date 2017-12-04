
</div>
<!-- Bootstrap 3.3.6 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.0.47/jquery.fancybox.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>

<script src="/public/js/timer.js"></script>
<script src="/public/js/application.js"></script>
<script src="/public/dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/public/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/public/dist/js/demo.js"></script>
<script src="/public/js/jq-ui/jquery-ui.min.js"></script>
<script src="/public/assets/js/bootstrap-confirmation.js"></script>
   <script>
       var url = "<?php echo URL; ?>";
       $(document).ready(function(){

        $.urlParam = function(name){
            var results = new RegExp('[\?&]' + name + '=([^]*)').exec(window.location.href);
            if (results==null){
               return null;
            }
            else{
               return results[1] || 0;
            }
        }

        if($.urlParam('add') == 1) {
          $( "#wishlist" ).effect( "bounce", { direction: 'right', distance: 100, times: 5 }, "slow" );
        }

        $('.similar-products').slick({
          infinite: true,
          slidesToShow: 3,
          slidesToScroll: 3,
          arrows: true,
          prevArrow: '<i class="fa fa-3x fa-angle-left slick-prev" style="color: #273481;float: left;cursor: pointer;position: absolute;left: -5%;top: 10%;"></i>',
          nextArrow: '<i class="fa fa-3x fa-angle-right slick-next" style="color: #273481;float: right;cursor: pointer;position: absolute;right: -5%;top: 10%;"></i>',
          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
          ]
        });
      });
   </script>
<script>
jQuery('#recherche').autocomplete({
    source : '/liste.php'
});

jQuery('.ui-menu-item-wrapper ').click(function(){
   console.log('ok')
});

jQuery('.home-search').click(function(){
   jQuery('.glyphicon-search.none').hide()
   jQuery('.home-search-form').show()
   jQuery('.removed').show()
});

</script>

</body>
</html>

