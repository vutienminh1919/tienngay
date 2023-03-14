<div class="modal fade" id="update_address_contract" tabindex="-1" aria-labelledby="exampleModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"></h5>
			</div>
			<div class="modal-body">
				<div class="modal-item">
					<p>Khách hàng</p>
					<input type="text" name="customer_name"
						   value="" disabled>
				</div>
				<div class="modal-item">
					<p>Mã hợp đồng</p>
					<input type="text"
						   name="code_contract_disbursement"
						   value="" disabled>
				</div>
				<div class="modal-item">
					<p>Tỉnh/Thành phố</p>
					<select name="province" class="province">
						<option value="">Chọn Tỉnh/Thành phố</option>
						<?php foreach ($cities as $c => $city) : ?>
							<option value="<?php echo $city->code ?>"> <?php echo $city->name ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="modal-item">
					<p>Quận/Huyện</p>
					<select name="district" class="district">
						<option value="">Chọn Quận/Huyện</option>
					</select>
				</div>
				<div class="modal-item">
					<p>Xã/Phường</p>
					<select name="ward" class="ward">
						<option value="">Chọn Xã/Phường</option>
					</select>
				</div>
				<div class="modal-item">
					<p>Nơi ở</p>
					<input type="text" placeholder="Nhập thông tin nơi ở" name="current_stay"
						   value="">
				</div>
				<div class="modal-item">
					<input type="hidden" name="code_contract"
						   value="">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy
				</button>
				<button type="submit" class="btn btn-primary btn_update_address_contract" data-dismiss="modal">Cập nhập
				</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="note-contract" tabindex="-1" aria-labelledby="exampleModalLabel"
	 aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"></h5>
			</div>
			<div class="modal-body">
				<div class="modal-item">
					<p>Khách hàng</p>
					<input type="text" name="customer_name"
						   value="" disabled>
				</div>
				<div class="modal-item">
					<p>Mã hợp đồng</p>
					<input type="text"
						   name="code_contract_disbursement"
						   value="" disabled>
				</div>
				<div class="modal-item">
					<p>Ghi chú</p>
					<textarea type="text" placeholder="Nhập ghi chú" name="note" class="form-control"
							  value=""></textarea>
				</div>
				<div class="modal-item">
					<input type="hidden" name="code_contract"
						   value="">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy
				</button>
				<button type="submit" class="btn btn-primary btn_update_note_contract" data-dismiss="modal">Cập nhập
				</button>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		$('.province').change(function () {
			$('.district option').remove()
			$('.ward option').remove()
			let code = $(this).val();
			$.ajax({
				url: _url.base_url + 'assetLocation/district?code=' + code,
				type: "GET",
				dataType: 'json',
				success: function (data) {
					$(".theloading").hide();
					if (data.status == 200) {
						$('.district').append($('<option>', {value: '', text: 'Chọn Quận/Huyện'}));
						$.each(data.data, function (k, v) {
							$('.district').append($('<option>', {value: v.code, text: v.name}));
						})
					} else {
						$('.district').append($('<option>', {value: '', text: 'Chọn Quận/Huyện'}));
					}
				},
				error: function (data) {
					$('.district').append($('<option>', {value: '', text: 'Chọn Quận/Huyện'}));
				}
			});
		})

		$('.district').change(function () {
			$('.ward option').remove()
			let code = $(this).val();
			$.ajax({
				url: _url.base_url + 'assetLocation/ward?code=' + code,
				type: "GET",
				dataType: 'json',
				success: function (data) {
					$(".theloading").hide();
					if (data.status == 200) {
						$('.ward').append($('<option>', {value: '', text: 'Chọn Quận/Huyện'}));
						$.each(data.data, function (k, v) {
							$('.ward').append($('<option>', {value: v.code, text: v.name}));
						})
					} else {
						$('.ward').append($('<option>', {value: '', text: 'Chọn Quận/Huyện'}));
					}
				},
				error: function (data) {
					$('.ward').append($('<option>', {value: '', text: 'Chọn Quận/Huyện'}));
				}
			});
		})

		$('.btn_update_address_contract').click(function (event) {
			event.preventDefault();
			let code_contract = $("input[name='code_contract']").val()
			let province = $("select[name='province']").val()
			let district = $("select[name='district']").val()
			let ward = $("select[name='ward']").val()
			let current_stay = $("input[name='current_stay']").val()

			var formData = new FormData();
			formData.append('code_contract', code_contract);
			formData.append('province', province);
			formData.append('district', district);
			formData.append('ward', ward);
			formData.append('current_stay', current_stay);

			$.ajax({
				url: _url.base_url + 'assetLocation/update_address_contract',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					$(".theloading").hide();
					if (data.status == 200) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.message);
						setTimeout(function () {
							window.location.reload();
						}, 2000);
					} else {
						$("#errorModal").modal("show");
						$(".msg_error").text(data.message);
					}
				},
				error: function () {
					$(".theloading").hide();
					console.log('error')
				}
			});
		})

		$('.btn_update_address_contract').click(function (event) {
			event.preventDefault();
			let code_contract = $("input[name='code_contract']").val()
			let province = $("select[name='province']").val()
			let district = $("select[name='district']").val()
			let ward = $("select[name='ward']").val()
			let current_stay = $("input[name='current_stay']").val()

			var formData = new FormData();
			formData.append('code_contract', code_contract);
			formData.append('province', province);
			formData.append('district', district);
			formData.append('ward', ward);
			formData.append('current_stay', current_stay);

			$.ajax({
				url: _url.base_url + 'assetLocation/update_address_contract',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					$(".theloading").hide();
					if (data.status == 200) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.message);
						setTimeout(function () {
							window.location.reload();
						}, 2000);
					} else {
						$("#errorModal").modal("show");
						$(".msg_error").text(data.message);
					}
				},
				error: function () {
					$(".theloading").hide();
					console.log('error')
				}
			});
		})

		$('.btn_update_note_contract').click(function (event) {
			event.preventDefault();
			let code_contract = $("input[name='code_contract']").val()
			let note = $("textarea[name='note']").val()

			var formData = new FormData();
			formData.append('code_contract', code_contract);
			formData.append('note', note);

			$.ajax({
				url: _url.base_url + 'assetLocation/update_note_contract',
				type: "POST",
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false,
				beforeSend: function () {
					$(".theloading").show();
				},
				success: function (data) {
					$(".theloading").hide();
					if (data.status == 200) {
						$('#successModal').modal('show');
						$('.msg_success').text(data.message);
						setTimeout(function () {
							window.location.reload();
						}, 2000);
					} else {
						$("#errorModal").modal("show");
						$(".msg_error").text(data.message);
					}
				},
				error: function () {
					$(".theloading").hide();
					console.log('error')
				}
			});
		})
	})
</script>
