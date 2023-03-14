
<div class="modal-dialog modal_missed_call" style="
    width: 80%;
">
	<div class="modal-content">
		<div class="modal-body">

			<button id="call2" class="btn btn-success"><i class="fa fa-phone" aria-hidden="true"></i>Gọi</button>
			<button id="end2" class="btn btn-danger"><i class="fa fa-ban" aria-hidden="true"></i> Dừng</button>

			<input id="number2" name="phone_number" type="hidden" value=""/>
			<p id="status" style="margin-left: 125px;"></p>
			 <h5 id="status2" class="modal-title title_modal_approve2" style="color: red"></h5>
			<div class="row">

				<div class="col-xs-12">
					<input type="hidden" value=""   name="idMissCall"/>

					<div class="form-group">
						<label class="control-label col-md-3">Họ và Tên :</label>
						<div class="col-md-9">
							<input name="name" placeholder="Họ và tên khách hàng" class="form-control"
								   id="ho_va_ten"
								   type="text">
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Chứng Minh Thư :</label>
						<div class="col-md-9">
							<input name="cmt" placeholder="Chứng Minh Thư" class="form-control"
								   type="number">
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Ngày sinh :</label>
						<div class="col-md-9">
							<input name="date" id="date" placeholder="Ngày sinh khách hàng" class="form-control"
								   type="date" max="2022-12-31" min="1900-01-01">
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Địa chỉ :</label>
						<div class="col-md-9">
							<input name="address" id="address" placeholder="Địa chỉ" class="form-control"
								   type="text">
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Nội dung phản ánh</label>
						<div class="col-md-3">
							<textarea name="noteMissedCall" rows="4" cols="100" placeholder=""
									  class="form-control"></textarea>
							<span class="help-block"></span>
						</div>
					</div>
<!--					<div class="form-group">-->
<!--						<div class="col-md-9">-->
<!--							<input name="phone" id="phone" class="form-control"-->
<!--								   type="text">-->
<!--							<span class="help-block"></span>-->
<!--						</div>-->
<!--					</div>-->

					<br>

					<div class="row ">
						<div style="text-align: center" id="group-button" class="col-md-12">
							<button type="button" class="btn btn-primary btnSaveMissedCall">Lưu</button>
							<button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">
								Thoát
							</button>
						</div>
					</div>
				</div>


			</div>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<style>
	#history-note{
		display: none;
	}
</style>
<script>
	$('#status').on('DOMSubtreeModified', function(){
	  $("#status2").text($('#status').text());
	  if ($("#status2").text() == "Điện thoại sẵn sàng") {
	  	$("#call2").removeAttr("disabled");
	  }
	});

	$("#call2").on("click", function(id) {
		$("#call2").attr("disabled", "disabled");
		var phone = $("#number2").val();
		if (phone == undefined || phone == '') {
			alert("Không có số");
		} else {
			$("#number").val(phone);
			$("#call").trigger("click");
		}
		
	})
	$("#end2").on("click", function(){
		$("#end").trigger("click");
	})
</script>



