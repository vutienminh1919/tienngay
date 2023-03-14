<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Lms Tienngay | </title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url(); ?>assets/build/css/custom.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/build/css/teacup.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/home/images/favicon.png" />

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>assets/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url(); ?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="page_login nav-md">
    <div id="thelogin" class="container body">
        <div id="particles-js" class="main_container">
            <div class="container">
                <div class="row flex">
                    <div class="col-xs-12 md-12 lg-12 " style="text-align: center;">
                        <div class="row title-text-header">
                            <div class="col-xs-12 col-md-6 col-lg-5">
                                <img src="https://service.tienngay.vn/uploads/avatar/1669692171-6383a573f411abcb3628546ab7b65d9a.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6 col-lg-5" style="max-width:434px">
                        <div class="panel panel-default panel-login">
                            <img style="width: auto; margin: 0 auto 0px;display: block" src="<?php echo base_url(); ?>assets/imgs/logo.png" alt="">
                            <form action="<?= base_url('auth/doLogin') ?>" method="post">
                                <?php if ($this->session->flashdata('error')) { ?>
                                    <div class="alert alert-danger alert-result">
                                        <?= $this->session->flashdata('error') ?>
                                    </div>
                                <?php } ?>
                                <?php if ($this->session->flashdata('success')) { ?>
                                    <div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
                                <?php } ?>
                                <?php if (validation_errors()) { ?>
                                    <div class="alert alert-danger">
                                        <?php echo validation_errors(); ?>
                                    </div>
                                <?php } ?>
                                <div class="form-group">
                                    <i class="fa fa-user"></i>
                                    <input type="text" class="form-control" name='email' placeholder="Email" required="">
                                </div>
                                <div class="form-group" style="margin-bottom:12px;">
                                    <i class="fa fa-lock"></i>
                                    <input id="thepasswords" type="password" class="form-control" name='password' placeholder="Password" required="">
                                    <button type="button" class="btn btn-link passwordtoggler">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                <div class="form-group">
                                    <p class="thelinks text-center">
                                        <span>Quên mật khẩu? <a href="<?php echo base_url('auth/forgot') ?>">Lấy lại mật khẩu</a> </span>
                                    </p>
                                </div>
                                <?php echo $widget; ?>
                                <?php echo $script; ?>

                                <div class="g-recaptcha" data-sitekey="<?= $this->config->item("recaptcha_site_key") ?>"></div>
                                <button type="submit" class="btn btn-login">Chúc mừng TienNgay.vn</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-xs-12 md-12 lg-12 " style="text-align: center;">
                        <div class="row title-text-header">
                            <div class="col-xs-12 col-md-6 col-lg-5">
                                <img src="https://service.tienngay.vn/uploads/avatar/1669692252-0c8d6c4b223943a5153f1ff59f3f9de4.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.passwordtoggler').click(function(event) {
            var x = document.getElementById("thepasswords");
            // event.preventDefault();
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
            $(this).children().toggleClass('fa-eye').toggleClass('fa-eye-slash');
        });
    </script>
</body>

</html>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .btn-login {
        background-color: #0E9549 !important;
        font-style: normal;
        font-weight: 600 !important;
        font-size: 16px !important;
        color: #FFFFFF !important;
    }

    .text-center {
        text-align: left;
    }

    body {
        overflow: hidden;
    }

    #canvas {
        position: absolute;
        z-index: 0;
    }

    #thelogin {
        background: url('https://service.tienngay.vn/uploads/avatar/1669690248-bfd29bfdefc21bedee55c5c3a3c4c4d2.png') no-repeat;
        overflow: hidden;
        background-size: cover;
    }


    .vien {
        position: absolute;
        width: 200px;
        z-index: 9;
    }

    .vientoplef {
        transform: rotate(90deg);
    }

    .vientopright {
        right: 0;
        transform: rotate(180deg);
    }

    .vienbottomleft {
        transform: rotate(0deg);
        bottom: 0;
        left: 0;
    }

    .vienbottomright {
        transform: rotate(-90deg);
        bottom: 0;
        right: 0;
    }

    .title-text-header {
        display: flex;
        justify-content: center;
    }

    #thelogin .panel-login {
        padding: 24px;
        margin-top: 20px;
        padding-top: 10px !important;
    }

    .panel-login img {
        width: 80% !important;
        max-width: 80% !important;
    }



    @media screen and (max-width: 1280px) {
        #thelogin .panel-login {
            padding: 24px;
            margin-top: 5px;
        }

        img {
            width: 80% !important;

        }

        .panel-login img {
            width: 80% !important;
            max-width: 70% !important;
        }

        #thelogin .form-control {
            padding: 10px 0 10px 41px;
            height: 40px;
            font-weight: 300;
            font-size: 14px;
            text-align: left;
        }
    }
</style>