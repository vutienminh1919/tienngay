<link href="<?php echo base_url();?>assets/teacupplugin/magnify/css/jquery.magnify.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/teacupplugin/magnify/js/jquery.magnify.js"></script>
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
              <a class="magnifyitem" data-magnify="gallery" data-src="" data-caption="Mi Fuego by albert dros" data-group="thegallery" href="https://upload.wikimedia.org/wikipedia/commons/e/e0/Long_March_2D_launching_VRSS-1.jpg">
                <img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Long_March_2D_launching_VRSS-1.jpg" alt="">
              </a>
            </div>
            <div class="col-xs-6 col-md-4 col-lg-3 mb-3">
              <a class="magnifyitem" data-magnify="gallery" data-src="" data-caption="Mi Fuego by albert dros" data-group="thegallery" href="https://helpx.adobe.com/content/dam/help/en/stock/how-to/visual-reverse-image-search/jcr_content/main-pars/image/visual-reverse-image-search-v2_intro.jpg">
                <img src="https://helpx.adobe.com/content/dam/help/en/stock/how-to/visual-reverse-image-search/jcr_content/main-pars/image/visual-reverse-image-search-v2_intro.jpg" alt="">
              </a>
            </div>

          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $("[data-magnify=gallery]").magnify({
   initMaximized: true
  });
</script>
