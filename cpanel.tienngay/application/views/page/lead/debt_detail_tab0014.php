
<br>
<div class="row">
	<?php
	$fdate = !empty($_GET['fdate']) ? $_GET['fdate'] : "";
	$tdate = !empty($_GET['tdate']) ? $_GET['tdate'] : "";
	$sdt = !empty($_GET['sdt']) ? $_GET['sdt'] : "";
	$fullname = !empty($_GET['fullname']) ? $_GET['fullname'] : "";
	$cskh = !empty($_GET['cskh']) ? $_GET['cskh'] : "";
	$status_sale = !empty($_GET['status_sale_1']) ? $_GET['status_sale_1'] : "";
	?>
	<?php if (in_array('tbp-cskh', $groupRoles) || in_array('supper-admin', $groupRoles) || in_array('van-hanh', $groupRoles)) {
	?>
	<?php } ?>
	<div class="col-lg-2 text-right">
		<a style="background-color: #18d102;"
		   target="_blank"
		   href="<?= base_url() ?>excel/missed_call_excel?fdate=<?= $fdate . '&tdate=' . $tdate . '&sdt=' . $sdt?>"
		   class="btn btn-primary w-100"><i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;
			Xuất excel</a>
		<?php if ($this->session->flashdata('error')) { ?>
			<div class="alert alert-danger alert-result">
				<?= $this->session->flashdata('error') ?>
			</div>
		<?php } ?>
		<?php if ($this->session->flashdata('success')) { ?>
			<div class="alert alert-success alert-result"><?= $this->session->flashdata('success') ?></div>
		<?php } ?>
	</div>
</div>
<div class="table-responsive">
	<div><?php echo $result_count16; ?></div>
	<table id="datatablebutton" class="table table-striped datatablebutton hide-show-column">
		<thead>
		<tr>
			<th>#</th>
			<th>CHỌN</th>
			<th class="hide-show-note-lead">GHI CHÚ</th>
			<th class="hide-show-date-lead">NGÀY THÁNG</th>
			<th class="hide-show-name-lead">TÊN KHÁCH HÀNG</th>
			<th class="hide-show-phone-lead">SỐ ĐIỆN THOẠI</th>
			<th class="hide-show-missed-call-lead">CUỘC GỌI</th>

		</tr>
		</thead>
		<tbody name="list_lead">
		<?php
		if (!empty($leadsData16)) {
			$n = 1;
			foreach ($leadsData16 as $key => $lead) {
				$cskh_one = !empty($lead->cskh) ? $lead->cskh : '';
				?>
				<tr>
					<td><?php echo $n++ ?></td>
					<td><input type="checkbox" value="<?= $lead->_id->{'$oid'} ?>" class="checkbox_cskh_all"
							data-email="<?= $cskh_one ?>"   name="checkQuantity"/></td>
					<td class="text-left">
						<a href="javascript:void(0)" onclick="showModal_note('<?= $lead->_id->{'$oid'} ?>','<?= !empty($lead->fromNumber) ? encrypt($lead->fromNumber) : "" ?>')"  class="btn btn-info btn-sm callmodal">
							Ghi chú
						</a>
					</td>
					<td class="hide-show-date-lead"><?= !empty($lead->created_at) ? date('d/m/Y H:i:s', $lead->created_at) : "" ?></td>
					<td class="hide-show-name-lead"><?= !empty($lead->name) ? ($lead->name) : "" ?></td>
					<td class="hide-show-phone-lead"><?= !empty($lead->fromNumber) ? hide_phone($lead->fromNumber) : "" ?></td>
					<td class="hide-show-missed-call-lead">
						<a href="javascript:void(0)" onclick="call_for_customer('<?= !empty($lead->fromNumber) ? encrypt($lead->fromNumber) : "" ?>')"
						class="btn btn-success call_for_customer">
							<i class="fa fa-phone  size18" aria-hidden="true"></i>
							Gọi
						</a>
					</td>
				</tr>
			<?php }
		} ?>
		</tbody>
	</table>
	<div class="pagination pagination-sm">
		<?php echo $pagination14 ?>
	</div>
</div>
<script>
	$(document).ready(function () {
		$("#btnQty").on('click', function () {

			let quantity = document.getElementById('quantityInput').value;
			let checkboxes = document.getElementsByName('checkQuantity');

			for (let i = 0; i < checkboxes.length; i++) {
				checkboxes[i].checked = false;

			}
			$('.datatablebutton input').each(function(item){
				if($(this).data('email')=="" && quantity >0)
				{
			     quantity--;
			     $(this).prop('checked', true);
				}
			});
		})
	});
</script>


<div class="modal fade" id="approve_call" tabindex="-1" role="dialog" aria-labelledby="ContractRejectModal"
   aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <button id="call" class="btn btn-success"><i class="fa fa-phone" aria-hidden="true"></i>Gọi</button>
        <button id="end" class="btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i> Dừng</button>
        <input id="number" name="phone_number" type="hidden" value=""/>
        <p id="status" style="margin-left: 125px;"></p>
        <h3 class="modal-title title_modal_approve"></h3>
      </div>
    </div>
  </div>
</div>



<script>
	function call_for_customer(phone_number, contract_id, type) {
		console.log(phone_number);
		if (phone_number == undefined || phone_number == '') {
			alert("Không có số");
		} else {
			if (type == "customer") {
				$(".title_modal_approve").text("Gọi cho khách hàng");
			}
			if (type == "rel1") {
				$(".title_modal_approve").text("Gọi cho tham chiếu 1");
			}
			if (type == "rel2") {
				$(".title_modal_approve").text("Gọi cho tham chiếu 2");
			}
			$("#number").val(phone_number);
			$(".contract_id").val(contract_id);
			$("#approve_call").modal("show");
		}
	}
</script>
<script>
	function call_for_customer(phone_number) {
	console.log(phone_number);
	if (phone_number == undefined || phone_number == '') {
		alert("Không có số");
	} else {

		$(".title_modal_approve").text("Gọi cho khách hàng");

		$("#number").val(phone_number);

		$("#approve_call").modal("show");
	}
}
</script>

