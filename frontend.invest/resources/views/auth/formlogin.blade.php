<form class="card card-md login-form" action="{{ route('auth_login_post') }}" method="post" autocomplete="off">
    @csrf
    <div class="card-body">
        <!-- <h2 class="card-title text-center mb-4 login-head">Đăng nhập</h2> -->
        <img src="{{asset('images/Logo_new_2.png')}}" alt="" width="100%" style="margin: auto;">
        @if( isset($error) && $error )
            <div class="mb-3">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-title">{{ $error }}</h4>
                </div>
            </div>
        @endif
        <div class="mb-3">
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
                <button type="submit" class="btn btn-primary login-btn">Đăng nhập</button>
            </div>
        </div>
    </div>
</form>

<style>
    .card-body{
        padding-top: 5px !important;
    }

    .text-center button {
        width: 100%;
    }
</style>
