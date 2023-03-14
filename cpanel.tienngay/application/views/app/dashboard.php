<!-- page content -->
<div class="right_col" role="main">
    <div class="">
		<?php if ($this->session->flashdata('error')) { ?>
			<div class="alert alert-danger alert-result">
				<?= $this->session->flashdata('error') ?>
			</div>
		<?php } ?>
		<?php if ($this->session->flashdata('success')) { ?>
			<div class="alert alert-success alert-result">
				<?= $this->session->flashdata('success') ?></div>
		<?php } ?>
        <div class="row top_tiles">
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-university"></i></div>
                    <div class="count">179</div>
                    <h3>New Total Fund</h3>
                    <p>The total money for available.</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-files-o"></i></div>
                    <div class="count">179</div>
                    <h3>Contract</h3>
                    <p>The contract available.</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-money"></i></div>
                    <div class="count">179</div>
                    <h3>Loan</h3>
                    <p>Money for loan.</p>
                </div>
            </div>
            <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats">
                    <div class="icon"><i class="fa fa-line-chart"></i></div>
                    <div class="count">179</div>
                    <h3>Profit</h3>
                    <p>Profit per month.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Loan Summary <small>Weekly progress</small></h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="col-md-9 col-sm-12 col-xs-12">
                            <div class="demo-container" style="height:280px">
                                <div id="chart_plot_02" class="demo-placeholder"></div>
                            </div>
                            <div class="tiles">
                                <div class="col-md-4 tile">
                                    <span>Total Contract</span>
                                    <h2>231,809</h2>
                                    <span class="sparkline11 graph" style="height: 160px;">
                               <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                          </span>
                                </div>
                                <div class="col-md-4 tile">
                                    <span>Total Revenue</span>
                                    <h2>$231,809</h2>
                                    <span class="sparkline22 graph" style="height: 160px;">
                                <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                          </span>
                                </div>
                                <div class="col-md-4 tile">
                                    <span>Total Profit</span>
                                    <h2>231,809</h2>
                                    <span class="sparkline11 graph" style="height: 160px;">
                                 <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                          </span>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div>
                                <div class="x_title">
                                    <h2>Bad Debt</h2>
                                    <ul class="nav navbar-right panel_toolbox">
                                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-folder-o"></i></a>
                                            <ul class="dropdown-menu" role="menu">
                                                <li><a href="#">More</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                                        </li>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <ul class="list-unstyled top_profiles scroll-view">
                                    <li class="media event">
                                        <a class="pull-left border-aero profile_thumb">
                                            <i class="fa fa-user aero"></i>
                                        </a>
                                        <div class="media-body">
                                            <a class="title" href="#">Nguyễn Văn A</a>
                                            <p><strong>2,000,000 VNĐ. </strong> Cầm đồ xe máy </p>
                                            <p> <small>12/8/2019 | Pawn | Brach: <a href="">6969 Cầu Giấy</a></small>
                                            </p>
                                        </div>
                                    </li>
                                    <li class="media event">
                                        <a class="pull-left border-aero profile_thumb">
                                            <i class="fa fa-user aero"></i>
                                        </a>
                                        <div class="media-body">
                                            <a class="title" href="#">Nguyễn Văn A</a>
                                            <p><strong>2,000,000 VNĐ. </strong> Cầm đồ xe máy </p>
                                            <p> <small>12/8/2019 | Pawn | Brach: <a href="">6969 Cầu Giấy</a></small>
                                            </p>
                                        </div>
                                    </li>
                                    <li class="media event">
                                        <a class="pull-left border-aero profile_thumb">
                                            <i class="fa fa-user aero"></i>
                                        </a>
                                        <div class="media-body">
                                            <a class="title" href="#">Nguyễn Văn A</a>
                                            <p><strong>2,000,000 VNĐ. </strong> Cầm đồ xe máy </p>
                                            <p> <small>12/8/2019 | Pawn | Brach: <a href="">6969 Cầu Giấy</a></small>
                                            </p>
                                        </div>
                                    </li>
                                    <li class="media event">
                                        <a class="pull-left border-aero profile_thumb">
                                            <i class="fa fa-user aero"></i>
                                        </a>
                                        <div class="media-body">
                                            <a class="title" href="#">Nguyễn Văn A</a>
                                            <p><strong>2,000,000 VNĐ. </strong> Cầm đồ xe máy </p>
                                            <p> <small>12/8/2019 | Pawn | Brach: <a href="">6969 Cầu Giấy</a></small>
                                            </p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>



        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Contract</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-folder-o"></i></a>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>BU</th>
                                <th>Contract available</th>
                                <th>Total contract</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Pawn</td>
                                <td>1</td>
                                <td>10</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Loan</td>
                                <td>1</td>
                                <td>10</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Tontine</td>
                                <td>1</td>
                                <td>10</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Fund <small>of branch</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-folder-o"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">More</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>BU</th>
                                <th>Available(VNĐ)</th>
                                <th>Bad debit(VNĐ)</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Pawn</td>
                                <td>1</td>
                                <td>100</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Loan</td>
                                <td>10</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <th scope="row">3</th>
                                <td>Tontine</td>
                                <td>10</td>
                                <td>20</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
        </div>



        <div class="row">
            <div class="col-md-4">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>New Order <small>100</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-folder-o"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">More</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Nguyễn Văn A</a>
                                <p><strong>2,000,000 VNĐ. </strong> Cầm đồ xe máy </p>
                                <p> <small>12/8/2019 | Pawn | Brach: <a href="">6969 Cầu Giấy</a></small>
                                </p>
                            </div>
                        </article>
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Nguyễn Văn A</a>
                                <p><strong>2,000,000 VNĐ. </strong> Cầm đồ xe máy </p>
                                <p> <small>12/8/2019 | Pawn | Brach: <a href="">6969 Cầu Giấy</a></small>
                                </p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Pending Approve <small>101</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-folder-o"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">More</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Nguyễn Văn A</a>
                                <p><strong>2,000,000 VNĐ. </strong> Cầm đồ xe máy </p>
                                <p> <small>12/8/2019 | Pawn | <strong>Staff: <a href="#">Lê Văn Lương</a></strong> | Brach: <a href="">6969 Cầu Giấy</a></small>
                                </p>
                            </div>
                        </article>
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Nguyễn Văn A</a>
                                <p><strong>2,000,000 VNĐ. </strong> Cầm đồ xe máy </p>
                                <p> <small>12/8/2019 | Pawn | <strong>Staff: <a href="#">Lê Văn Lương</a></strong> | Brach: <a href="">6969 Cầu Giấy</a></small>
                                </p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Peding Disbursement<small>201</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-folder-o"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">More</a>
                                    </li>

                                </ul>
                            </li>
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Nguyễn Văn A</a>
                                <p><strong>2,000,000 VNĐ. </strong> Cầm đồ xe máy </p>
                                <p> <small>12/8/2019 | Pawn | <strong>Manager: <a href="#">Lê Văn Lương</a></strong> | Brach: <a href="">6969 Cầu Giấy</a></small>
                                </p>
                            </div>
                        </article>
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Nguyễn Văn A</a>
                                <p><strong>2,000,000 VNĐ. </strong> Cầm đồ xe máy </p>
                                <p> <small>12/8/2019 | Pawn | <strong>Manager: <a href="#">Lê Văn Lương</a></strong> | Brach: <a href="">6969 Cầu Giấy</a></small>
                                </p>
                            </div>
                        </article>
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Nguyễn Văn A</a>
                                <p><strong>2,000,000 VNĐ. </strong> Cầm đồ xe máy </p>
                                <p> <small>12/8/2019 | Pawn | <strong>Manager: <a href="#">Lê Văn Lương</a></strong> | Brach: <a href="">6969 Cầu Giấy</a></small>
                                </p>
                            </div>
                        </article>
                        <article class="media event">
                            <a class="pull-left date">
                                <p class="month">April</p>
                                <p class="day">23</p>
                            </a>
                            <div class="media-body">
                                <a class="title" href="#">Nguyễn Văn A</a>
                                <p><strong>2,000,000 VNĐ. </strong> Cầm đồ xe máy </p>
                                <p> <small>12/8/2019 | Pawn | <strong>Manager: <a href="#">Lê Văn Lương</a></strong> | Brach: <a href="">6969 Cầu Giấy</a></small>
                                </p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
