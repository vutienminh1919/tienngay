
<div id="thelogin" class="body">
    <div id="particles-js" class="main_container">
        <div class="container">
            <div class="row flex">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="header-title row">
                        <div class="col-xs-12 col-md-7 col-lg-7">
                            <img src="https://service.tienngay.vn/uploads/avatar/1669692171-6383a573f411abcb3628546ab7b65d9a.png" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-5" style="max-width:434px">
                    <div class="panel panel-default panel-login">
                        @include('auth.formlogin')
                    </div>
                </div>
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="row footer-title">
                        <div class="col-xs-12 col-md-6 col-lg-6">
                            <div class=" ">
                                <img src="https://service.tienngay.vn/uploads/avatar/1669692252-0c8d6c4b223943a5153f1ff59f3f9de4.png" alt="">
                            </div>
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


<style>
    body {
        overflow: hidden;
    }

    #thelogin {
        background: url('https://service.tienngay.vn/uploads/avatar/1669690248-bfd29bfdefc21bedee55c5c3a3c4c4d2.png') no-repeat;
        overflow: hidden;
        background-size: cover;
    }

    #thelogin .panel-login {
        position: relative;
        z-index: 9999;
        background: url('https://service.tienngay.vn/uploads/avatar/1669690248-bfd29bfdefc21bedee55c5c3a3c4c4d2.png') #fff no-repeat;
        background-size: cover;
        background-position: right;
    }

    .main_container {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 15px;
    }
    .header-title{
        display: flex;
        justify-content: center;
    }
    .footer-title{
        display: flex;
        justify-content: center;
        padding-top: 5%;
    }
</style>