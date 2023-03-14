<style>
	#thelogin {
		background: url('https://service.tienngay.vn/uploads/avatar/1675071854-7c3b3e1e49ce84ab35b8678657d099ce.png');
		overflow: hidden;
		background-size: cover;
	}

	#thelogin .form-group i.fa {

		color: #fff;
	}

	#thelogin .main_container {
		min-height: 100vh;
		display: flex;
		justify-content: center;
		align-items: center;
		padding: 15px;
	}

	#thelogin .panel-login {
		padding: 0;
		margin-top: 0;
	}

	.cat {
		background-image: url(https://service.tienngay.vn/uploads/avatar/1675067702-5e81029427ae96704ccb7c8bd1fc2af9.png);
		border-radius: 50px;
		width: 350px;
		height: 350px;
		background-size: contain;
		position: relative;
		margin-top: 30px;
	}

	.cat img {
		width: 295px;
		height: 382px;
		position: absolute;
		top: -55px;
		left: 35px;
	}

	.cat-left {
		-moz-transform: scaleX(-1);
		-o-transform: scaleX(-1);
		-webkit-transform: scaleX(-1);
		transform: scaleX(-1);
		filter: FlipH;
		-ms-filter: "FlipH";
	}

	.style-login {
		background-color: #FFFFFF;
		padding: 0px 24px 24px 24px;
		border-radius: 16px;
		border: 1px solid #E8E8E8;
		box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.15);
	}

	.panel {
		margin-bottom: 0;
		background-color: transparent;
		border: transparent;
		border-radius: unset;
		-webkit-box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
		box-shadow: unset;
	}

	#thelogin .form-group p.thelinks {
		color: #B8B8B8;
	}

	#thelogin .form-control::placeholder {
		/* Chrome, Firefox, Opera, Safari 10.1+ */
		color: #B8B8B8;
		opacity: 1;
		/* Firefox */
	}

	#thelogin .form-control:-ms-input-placeholder {
		/* Internet Explorer 10-11 */
		color: #B8B8B8;
	}

	#thelogin .form-control::-ms-input-placeholder {
		/* Microsoft Edge */
		color: #B8B8B8;
	}

	.form-check-label {
		color: red;
	}

	img.img_tiger {
		transform: rotateY(178deg) rotateZ(10deg);
	}

	#thelogin .panel-login form .form-group {
		margin-bottom: 20px;
	}

	#thelogin .btn:not(.passwordtoggler) {
		margin-top: 20px;
	}

	@media screen and (max-width:900px) {
		#cat1 {
			display: none;
		}
	}
</style>
<div id="thelogin" class="body">
	<div id="particles-js" class="main_container">
		<div class="container" style="max-width: 1920px;">
			<div class="title-2023" style=" text-align: center;">
				<img src="https://service.tienngay.vn/uploads/avatar/1675071903-deb58bf5a92dd7f1c60c7c83c98b9acf.png" alt="">
			</div>
			<div class="row flex">
				<div class="col-xs-12 col-md-12 col-lg-12">

					<div class="panel panel-default panel-login" style="display: flex; justify-content: space-evenly; padding-top: 60px">
						<div class="cat cat-left" id="cat1">
							<img src="https://service.tienngay.vn/uploads/avatar/1675067579-39d42a1866d06f591e6fa44aeb39f511.gif" alt="">
						</div>
						<div style="max-width:400px">
							@include('auth.formlogindf')
						</div>
						<div class="cat">
							<img src="https://service.tienngay.vn/uploads/avatar/1675067579-39d42a1866d06f591e6fa44aeb39f511.gif" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
