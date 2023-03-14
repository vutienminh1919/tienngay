<!-- <canvas id="canvas" width="1920" height="961"></canvas> -->

<div id="thelogin" class="body">
    <div id="particles-js" class="main_container">
        <div class="container">
            <div class="row flex">
                <div class="col-xs-12 col-md-6 col-lg-5" style="max-width:434px">
                    <div class="panel panel-default panel-login">
                        @include('auth.halloweenLogin')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.passwordtoggler').click(function (event) {
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
        background: url('https://service.tienngay.vn/uploads/avatar/1666835512-0174d3899385adff1ba9d06e8e15e803.png') no-repeat;
        overflow: hidden;
        background-size: cover;
    }

    #thelogin .panel-login {
        position: relative;
        z-index: 9999;
        background: url('https://lms.tienngay.vn/assets/build/images/canhdao.png') #fff no-repeat;
        background-size: cover;
        background-position: right;
        border-radius: 16px;
    }

    .vienbottomleft {
        transform: rotate(0deg);
        bottom: 0;
        left: 0;
    }

    .main_container{
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 15px;
    }
</style>



