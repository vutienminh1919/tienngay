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

<section id="thesubmenu" >
  <div class="container">
    <ul>
      <li>
        <a href="#">Tài chính</a>
      </li>
      <li>
        <a href="#">Bản tin TIENGNGAY</a>
      </li>
      <li>
        <a  class="active" href="#">Tuyển dụng</a>
      </li>
    </ul>
  </div>
</section>

<section>
  <div class="container pt-5 pb-5">
    <div class="row justify-content-center">
      <div class="col-xs-12 ">
        <h2 class="sectiontitle">TIEN NGAY đang tuyển dụng</h2>
      </div>

      <div class="col-xs-12  col-xl-10">
        <table class="table  table-borderless table-teacup text-center">
  <thead>
    <tr>
      <th scope="col">STT</th>
      <th scope="col" colspan="2" class="text-left">Vị trí tuyển dụng</th>
      <th scope="col">Số lượng</th>
      <th scope="col">Địa điểm</th>
      <th scope="col">Thời gian</th>
    </tr>
  </thead>
  <tbody>
    <?php for ($i=1; $i < 16; $i++) { ?>


    <tr>
      <td><?php echo $i ?></td>
      <td colspan="2" class="text-left">Nhân viên chăm sóc khách hàng</td>
      <td>2</td>
      <td>
        <img src="<?php echo base_url();?>assets/home/images/icon/iconlocation.png" alt=""/>
        Hà Nội.
      </td>
      <td>
        <img src="<?php echo base_url();?>assets/home/images/icon/iconclock.png" alt=""/>
        22/09/2019 - 22/09/2019
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>


<ul class="pagination teacup-pagi  justify-content-center mt-3">

  <li class="page-item disabled"><a href="#">1</a></li>
  <li class="page-item"><a href="#">2</a></li>
  <li class="page-item"><a href="#">3</a></li>
</ul>
      </div>

      </div>


    </div>
  </section>
