<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" />
<!-- page content -->
<div class="right_col" role="main">
  <div class="row">
    <div class="col-xs-12">
      <div class="page-title">
        <h3>Add Friends</h3>
      </div>

      <div class="col-xs-12">
        <div class="row">
          <!-- MP3 -->
          <!-- <div class="col-xs-6 col-md-4 col-lg-3 mb-3">
            <a href="https://upload.wikimedia.org/wikipedia/commons/e/e0/Long_March_2D_launching_VRSS-1.jpg" target="_blank">
              <img class="w-100" src="https://image.flaticon.com/icons/png/512/81/81281.png" alt="">
            </a>
          </div> -->
          <!-- MP4 -->
          <!-- <div class="col-xs-6 col-md-4 col-lg-3 mb-3">
            <a href="https://upload.wikimedia.org/wikipedia/commons/e/e0/Long_March_2D_launching_VRSS-1.jpg" target="_blank" >
              <img class="w-100" src="<?php echo base_url(); ?>assets/imgs/mp4.jpg" alt="">
            </a>
          </div> -->
          <?php for ($i=0; $i < 50 ; $i++) { ?>
            <div class="col-xs-6 col-md-4 col-lg-3 mb-3">
              <a href="https://upload.wikimedia.org/wikipedia/commons/e/e0/Long_March_2D_launching_VRSS-1.jpg" data-toggle="lightbox"  data-gallery="thegallery" data-max-width="992" data-type="image" data-title="A random title <?php echo $i ?>" >
                <img class="w-100" src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Long_March_2D_launching_VRSS-1.jpg" alt="">
              </a>
            </div>
            <div class="col-xs-6 col-md-4 col-lg-3 mb-3">
              <a href="https://helpx.adobe.com/content/dam/help/en/stock/how-to/visual-reverse-image-search/jcr_content/main-pars/image/visual-reverse-image-search-v2_intro.jpg" data-toggle="lightbox"  data-gallery="thegallery" data-max-width="992" data-type="image" data-title="A random title <?php echo $i ?>" >
                <img class="w-100" src="https://helpx.adobe.com/content/dam/help/en/stock/how-to/visual-reverse-image-search/jcr_content/main-pars/image/visual-reverse-image-search-v2_intro.jpg" alt="">
              </a>
            </div>

          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
var delta = 0;


$(document).on('click', '*[data-toggle="lightbox"]', function(event) {
  event.preventDefault();
  return $(this).ekkoLightbox({
    onShow: function(elem) {
      var html = '<button type="button" class="rotate btn btn-link" ><i class="fa fa-repeat"></i></button>';
      console.log(html);
      $(elem.currentTarget).find('.modal-header').prepend(html);
      var delta = 0;
    },
    onNavigate: function(direction, itemIndex) {
      var delta = 0;
      if (window.console) {
        return console.log('Navigating '+direction+'. Current item: '+itemIndex);
      }
    }
  });
});
$('body').on('click', 'button.rotate', function() {
  delta = delta + 90;
    $('.ekko-lightbox-item img').css({
        '-webkit-transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)',
        '-moz-transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)',
        'transform': 'translateX(-50%)translateY(-50%)rotate(' + delta + 'deg)'
    });

});

</script>
