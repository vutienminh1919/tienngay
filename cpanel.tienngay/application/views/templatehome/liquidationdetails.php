<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css"/>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<section id="thebreadcrumb">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Library</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
      </ol>
    </nav>
  </div>
</section>


<div id="theProduct" class="container pt-5 pb-5">
  <div class="row">
    <div class="col-xs-12 ">
      <h1 class="singleProduct_title">Xe máy HONDA Air Blade 125cc VN Fi </h1>
    </div>

    <div class="col-xs-12  col-lg-6 col-xl-5 mb-3">
      <div class="ProductSlider ProductSlider-for">
        <?php for ($i=0; $i < 5 ; $i++) { ?>


        <div class="item">
          <img src="https://via.placeholder.com/550x45<?php echo $i?>" alt="">
        </div>
        <?php } ?>
      </div>
      <div class="ProductSlider ProductSlider-nav">
        <?php for ($i=0; $i < 5 ; $i++) { ?>


        <div class="item">
          <img src="https://via.placeholder.com/550x45<?php echo $i?>" alt="">
        </div>
        <?php } ?>
      </div>
    </div>
    <div class="col-xs-12  col-lg-6 col-xl-7">

      <div class="productinfo">
        <div class="productready">
          <span>Sản phẩm đang có tại phòng giao dịch</span>

          <div class="social">
            <!-- -Code chia sẻ social vào đây- -->
          </div>
        </div>
        <hr>
        <p class="theaddress">TIEN NGAY Hà Nội - 23A Phan Đăng Lưu</p>

        <div class="theprice">
          <span>Giá: </span>
          <div class="price">
            12.000.000 vnđ
          </div>

          <div class="oldprice">
            30.000.000 vnđ
          </div>
        </div>

        <button class="btn btn-teacup shadows">
          MUA NGAY
        </button>

        <p class="theguide">(Gọi đặt mua: 1800 6868 | chát với tư vấn viên <a class="f500" href="#">Tại đây</a> )</p>


        <ul class="productMetaData">
          <li class="thetitle">Thông tin sản phẩm</li>

          <li><strong>Tình trạng:</strong>  Xe đã qua sử dụng SERIAL:00000</li>
          <li><strong>Biển kiểm soát:</strong>  29L3 - 567.89</li>
          <li><strong>Số khung:</strong>  326489</li>
          <li><strong>Số máy:</strong>  3215864</li>
          <li><strong>Serial:</strong>  Không có</li>
        </ul>
      </div>
    </div>
  </div>
</div>


<script>
$('.ProductSlider-for').slick({
slidesToShow: 1,
slidesToScroll: 1,
arrows: false,
fade: true,
asNavFor: '.ProductSlider-nav',
infinite: true,
});
$('.ProductSlider-nav').slick({
slidesToShow: 3,
slidesToScroll: 1,
asNavFor: '.ProductSlider-for',
dots: false,
centerMode: true,
focusOnSelect: true,
infinite: true,
margin:5,
responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
      }
    },
    {
      breakpoint: 767,
      settings: {
        slidesToShow: 2,
      }
    },
  ]
});

$('.ProductSlider-nav').on('click', 'div', function(e)
{
    e.stopPropagation();

    var currentIndex = $('.ProductSlider-nav').slickCurrentSlide();
    var slideIndex = $(this).data("slide-index");

    if(currentIndex == slideIndex)
    {
        return;
    }
    else if(currentIndex - 1 == slideIndex)
    {
        $('.ProductSlider-nav').slickPrev();
    }
    else if(currentIndex + 1 == slideIndex)
    {
        $('.ProductSlider-nav').slickNext();
    }
    else if(currentIndex == 0)
    {
        $('.ProductSlider-nav').slickPrev();
    }
    else
    {
        $('.ProductSlider-nav').slickNext();
    }
});
</script>
