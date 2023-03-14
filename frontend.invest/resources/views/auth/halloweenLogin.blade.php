<form class="card card-md login-form" action="{{ route('auth_login_post') }}" method="post" autocomplete="off">
    @csrf
    <div class="card-body">
        <!-- <h2 class="card-title text-center mb-4 login-head">Đăng nhập</h2> -->
        <img src="https://service.tienngay.vn/uploads/avatar/1666835807-30d3852da2b7d2e96ff98250fdc46941.png" alt="">
        @if( isset($error) && $error )
            <div class="mb-3">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-title">{{ $error }}</h4>
                </div>
            </div>
        @endif
        <div class="mb-3 mt-3" >
            <div class="input-icon mb-3">
                                <span class="input-icon-addon">
                                    <i class="fas fa-user"></i>
                                </span>
                <input type="text" class="form-control" placeholder="Tên đăng nhập" name="username">
            </div>
            <div class="input-icon mb-2">
                                <span class="input-icon-addon">
                                    <i class="fas fa-lock"></i>
                                </span>
                <input type="password" class="form-control" placeholder="Mật khẩu" name="password">
            </div>
            <div class="mb-3">
                <label class="form-check float-left d-inline-block">
                    <input type="checkbox" class="form-check-input" name="remember">
                    <span class="form-check-label">Lưu thông tin đăng nhập</span>
                </label>
                <a class="float-right d-inline-block text-right" href="#">
                    Quên mật khẩu
                </a>
                <div class="clearfix"></div>
            </div>
            <div class="mb-3 text-center">
                <div class="g-recaptcha" data-sitekey="6Le8HfAaAAAAAPE8bLRlD9lDZNTvSHb_n2PVbBG4"></div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary login-btn">Cho kẹo hay bị ghẹo</button>
            </div>
        </div>
    </div>
</form>
<style>
    .card {
        border-radius:16px ;
    }
    .card-body{
        background-color: #2A0101;
        border-radius: 16px;
    }
    .form-check-label{
        color: #FFF1C0;
    }
    .float-right{
        color: #57D18A;
    }
    .btn{
        background: #FEE89C;
        color: #2A0101;
        width: 100%;

    }
</style>
