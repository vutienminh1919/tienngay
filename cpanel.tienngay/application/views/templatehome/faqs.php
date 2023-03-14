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


<section id="theFAQs">
  <div class="container pt-5 pb-5">
    <div class="col-xs-12  d-lg-none">
      <h2 class="sectiontitle">Câu hỏi thường gặp</h2>
    </div>

    <div class="row">
      <div class="col-xs-12  col-lg-8">
        <?php for ($i=0; $i < 5; $i++) { ?>
          <div class="card faqs">
            <div class="card-header">
              <span>
              SẢN PHẨM/ DỊCH VỤ
              </span>
            </div>
            <div class="card-body">


          <div id="accordion<?php echo $i ?>">
            <div class="card">
              <div class="card-header" id="headingOne<?php echo $i ?>">
                <h5 class="mb-0">
                  <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne<?php echo $i ?>" aria-controls="collapseOne<?php echo $i ?>">
                    Collapsible Group Item #1
                  </button>
                </h5>
              </div>

              <div id="collapseOne<?php echo $i ?>" class="collapse" aria-labelledby="headingOne<?php echo $i ?>" data-parent="#accordion<?php echo $i ?>">
                <div class="card-body">
                  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header" id="headingTwo<?php echo $i ?>">
                <h5 class="mb-0">
                  <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo<?php echo $i ?>" aria-controls="collapseTwo<?php echo $i ?>">
                    Collapsible Group Item #2
                  </button>
                </h5>
              </div>
              <div id="collapseTwo<?php echo $i ?>" class="collapse" aria-labelledby="headingTwo<?php echo $i ?>" data-parent="#accordion<?php echo $i ?>">
                <div class="card-body">
                  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                </div>
              </div>
            </div>
            <div class="card">
              <div class="card-header" id="headingThree<?php echo $i ?>">
                <h5 class="mb-0">
                  <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree<?php echo $i ?>" aria-controls="collapseThree<?php echo $i ?>">
                    Collapsible Group Item #3
                  </button>
                </h5>
              </div>
              <div id="collapseThree<?php echo $i ?>" class="collapse" aria-labelledby="headingThree<?php echo $i ?>" data-parent="#accordion<?php echo $i ?>">
                <div class="card-body">
                  Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        <?php } ?>
      </div>

      <div class="col-xs-12  col-lg-4 d-none d-lg-block">
        <?php $this->load->view('templatehome/thesidebar', (isset($data))?$data:NULL); ?>
      </div>
    </div>


  </div>
</section>
