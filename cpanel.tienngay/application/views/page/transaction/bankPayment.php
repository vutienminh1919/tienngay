<div class="right_col" role="main">
	<style type="text/css">
		.p-title {
			font-size: 14px;
		}
		.p-underline {
			border-bottom: 1px solid #D4D2D2;
		}
	</style>
	<div class="form-group" style="border: 1px solid #D4D2D2;border-radius: 17px;padding: 20px 30px; margin-top: 100px">
		<h4 style="color: #0E9549">Thông Tin Chuyển Khoản Phiếu Thu: <span style="color: rgba(221, 35, 35, 0.75);"><?php echo $result->transaction->code; ?></span></h4>
		<table class="table">
		  <tbody>
		    <tr>
		      <td style="width: 15%; border-top: none">Ngân hàng nhận</td>
		      <td style="border-top: none;"><img src="<?php echo base_url();?>assets/imgs/vpbank-300x300.png" style="width: 25px"> <span style="color: #00B74F">VPBank</span></td>
		    </tr>
		    <tr>
		      <td>Số tài khoản</td>
		      <td><?php echo $result->van; ?></td>
		    </tr>
		    <tr>
		      <td>Số tiền</td>
		      <td><?php echo number_format($result->transaction->total); ?></td>
		    </tr>
		    <tr>
		      <td>Nội dung</td>
		      <td><?php echo $result->transaction->bank_remark; ?></td>
		    </tr>
		  </tbody>
		</table>

		<p>Quét nội dung chuyển khoản bằng QRCode qua app ngân hàng:</p>
		<p><img style="width: 350px; height:350px;" src="<?php echo $qrCode ?>"></p>
	</div>
</div>