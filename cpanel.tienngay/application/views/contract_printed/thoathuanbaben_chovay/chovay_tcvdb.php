<!DOCTYPE html>

<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>THỎA THUẬN BA BÊN - CHO VAY</title>

	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">

</head>
<?php
$mydate = getdate(date("U"));
$number_day_loan = !empty($contract->loan_infor->number_day_loan) ? $contract->loan_infor->number_day_loan / 30 : "";
$type_interest = !empty($contract->loan_infor->type_interest) ? $contract->loan_infor->type_interest : "";
$customer_name = !empty($contract->customer_infor->customer_name) ? $contract->customer_infor->customer_name : "";
$customer_identify = !empty($contract->customer_infor->customer_identify) ? $contract->customer_infor->customer_identify : "";
$bank_account = !empty($contract->receiver_infor->bank_account) ? $contract->receiver_infor->bank_account : $contract->receiver_infor->atm_card_number;
$bank_branch = !empty($contract->receiver_infor->bank_branch) ? $contract->receiver_infor->bank_branch : "";
$dangkycapngay = ($ngaycapdangky) ? date('d/m/Y', strtotime($ngaycapdangky)) : '';
$dangkyotocapngay = ($ngaycapdangkyoto) ? $ngaycapdangkyoto : '';
$number_code_contract = !empty($contract->code_contract) ? $contract->code_contract : "";
$identify_issued_by = isset($contract->customer_infor->issued_by) ? $contract->customer_infor->issued_by : '';
$customer_phone = !empty($contract->customer_infor->customer_phone_number) ? $contract->customer_infor->customer_phone_number : "";

$start_loan = !empty($contract->disbursement_date) ? date('d/m/Y', intval($contract->disbursement_date) + 7 * 60 * 60) : "";
$end_loan = !empty($contract->expire_date) ? date("d/m/Y", intval($contract->expire_date) + 7 * 60 * 60) : "";
$fee_advisory = !empty($contract->fee->percent_advisory) ? $contract->fee->percent_advisory : "";
$master_account_name = !empty($contract->vpbank_van->master_account_name) ? $contract->vpbank_van->master_account_name : "";
$bank_name = !empty($contract->vpbank_van->bank_name) ? $contract->vpbank_van->bank_name : "";
$van = !empty($contract->vpbank_van->van) ? $contract->vpbank_van->van : "";
$lai_suat_ndt = !empty($contract->fee->percent_interest_customer) ? $contract->fee->percent_interest_customer : '';
?>

<body>


<!-- Page Content -->
<section>
	<div class="container">

		<div class="row">
			<div class="col-lg-4">
				<div class="divHeader"><img src="https://tienngay.vn/assets/home/images/logo.png" alt="">
				</div>
			</div>
			<!-- Header -->
			<div class="col-lg-8 text-center mb-3">
				<h1 style="font-weight:bold;font-size:18px;">THỎA THUẬN BA BÊN</h1>
				<p class="text-center"><strong> Về việc hỗ trợ tài chính</strong>
				</p>
				<p class="text-center"><i>Số: <b><?= empty($code_contract) ? '…………………………………………' : $code_contract ?></b>
					</i>
				</p>
			</div>

			<div class="col-12 ">
				<p>
					Hôm nay, ngày <?php
					if ($mydate['mday'] < 10) {
						echo "0" . $mydate['mday'];
					} else {
						echo $mydate['mday'];
					}

					?> tháng <?php if ($mydate['mon'] < 3) {
						echo "0" . $mydate['mon'];
					} else {
						echo $mydate['mon'];
					}
					?> năm <?= $mydate['year'] ?>,
					tại <?= ($contract->store->address) ? $contract->store->address : '………………………………………' ?></p>
				<p>Các Bên gồm:</p>
			</div>

			<div class="col-12">
				<table class="table table-sm table-borderless table-fixed">
					<tbody>
					<tr>
						<td colspan="5">
							<p>
								<b> <span> Bên Vay: </span> </b>
							</p>
						</td>
						<td colspan="5">
							<p>
								<b> <span> Bên Cho Vay: </span> </b>
							</p>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<p>
								<span>Họ và tên</span>
							</p>
						</td>
						<td colspan="3">
							<p>
                                        <span>: <strong><?= ($customer_name) ? $customer_name : '………………………………………' ?></strong>
                                        </span>
							</p>
						</td>
						<td colspan="2">
							<p>
								<span>Họ và tên</span>
							</p>
						</td>
						<td colspan="3">
							<p>
								<span>: .................................................</span>
							</p>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<p>
								<span>Ngày sinh</span>
							</p>
						</td>
						<td colspan="3">
							<p>
								<span>: <?= ($customerDOB) ? $customerDOB : '………………………………………' ?></span>
							</p>
						</td>
						<td colspan="2">
							<p>
								<span>Ngày sinh</span>
							</p>
						</td>
						<td colspan="3">
							<p>
								<span>: .................................................</span>
							</p>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<p>
								<span>Số CMND/CCCD/Hộ chiếu</span>
							</p>
						</td>
						<td colspan="3">
							<p>
								<span>: <?= ($customer_identify) ? $customer_identify : '………………………………………' ?></span>
							</p>
						</td>
						<td colspan="2">
							<p>
								<span>Số CMND/CCCD/Hộ chiếu</span>
							</p>
						</td>
						<td colspan="2">
							<p>
								<span colspan="3">: .................................................</span>
							</p>
						</td>
					</tr>


					<tr>
						<td colspan="2">
							<p>
								<span>Ngày cấp</span>
							</p>
						</td>
						<td colspan="3">
							<p>
								<span>: <?= ($identify_date_range) ? $identify_date_range : '…………………' ?></span>
							</p>
						</td>
						<td colspan="2">
							<p>
								<span>Ngày cấp</span>
							</p>
						</td>
						<td colspan="2">
							<p>
								<span colspan="3">: .................................................</span>
							</p>
						</td>
					</tr>

					<tr>
						<td colspan="2">
							<p>
								<span>Cơ quan cấp</span>
							</p>
						</td>
						<td colspan="3">
							<p>
								<span>: <?= ($identify_issued_by) ? $identify_issued_by : '…………………' ?></span>
							</p>
						</td>
						<td colspan="2">
							<p>
								<span>Cơ quan cấp</span>
							</p>
						</td>
						<td colspan="2">
							<p>
								<span colspan="3">: .................................................</span>
							</p>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<p>
								<span>Số điện thoại</span>
							</p>
						</td>
						<td colspan="3">
							<p>
								<span>: <?= ($customer_phone) ? $customer_phone : '…………………' ?></span>
							</p>
						</td>
						<td colspan="2">
							<p>
								<span>Số điện thoại</span>
							</p>
						</td>
						<td colspan="2">
							<p>
								<span colspan="3">: .................................................</span>
							</p>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<p>
								<span>Địa chỉ nơi ở hiện tại</span>
							</p>
						</td>
						<td colspan="3">
							<p>
								<span>: <?= ($address) ? $address : '………………………………………' ?></span>
							</p>
						</td>
						<td colspan="2">
							<p>
								<span>Địa chỉ nơi ở hiện tại</span>
							</p>
						</td>
						<td colspan="2">
							<p>
								<span colspan="3">: .................................................</span>
							</p>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<p>
								<span>Địa chỉ thường trú</span>
							</p>
						</td>
						<td colspan="7">
							<p>
								<span>: <?= ($address_house) ? $address_house : '………………………………………' ?></span>
							</p>
						</td>

					</tr>

					<tr>
						<td colspan="2">
							<p>
								<span>Số tài khoản/Số thẻ</span>
							</p>
						</td>
						<td colspan="3">
							<p>
								<span>: <?= ($bank_account) ? $bank_account : '………………………………………' ?></span>
							</p>
						</td>
						<td>
							<p>
								<span></span>
							</p>
						</td>
						<td>
							<p>
								<span></span>
							</p>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<p>
								<span>Tại Ngân hàng</span>
							</p>
						</td>
						<td colspan="3">
							<span>: <?= ($bank_name_nganluong) ? $bank_name_nganluong : '………………………………………………' ?></span>
						</td>
						<td colspan="2">
							<p>
								<span colspan="3">Chi nhánh</span>
							</p>
						</td>
						<td colspan="3">
							<span>: <?= ($bank_branch) ? $bank_branch : '…………………………' ?></span>
						</td>
					</tr>
					<tr>
						<td colspan="5">
							<p>
								<i>
                        <span>Sau đây gọi tắt là <b>“Bên Vay” </b>
                        </span>
								</i>
							</p>
						</td>
						<td colspan="5">
							<p>
								<i>
                        <span>Sau đây gọi tắt là <b>“Bên Cho Vay”</b>
                        </span>
								</i>
							</p>
						</td>
					</tr>
					</tbody>
				</table>
			</div>

			<div class="col-12">

				<p><b>Bên cung cấp dịch vụ: CÔNG TY CỔ PHẦN CÔNG NGHỆ TIỆN NGAY ĐÔNG BẮC</b>
				</p>

				<p>Địa chỉ trụ sở chính: Tầng 15, Khối B, Tòa nhà Sông Đà, đường Phạm Hùng, Phường Mỹ Đình 1, Quận Nam
					Từ Liêm, thành phố Hà Nội.</p>

				<p>Địa điểm giao
					dịch: <?= ($contract->store->address) ? $contract->store->address : '…………………………………..' ?></p>

				<p>Đại diện bởi: <strong><?= isset($store->representative) ? $store->representative : '…………' ?></strong>.
					Giấy ủy quyền số: .......................................</p>

				<p>Sau đây gọi tắt là <strong>“Đông Bắc”</strong>
				</p>

				<p>Các Bên đồng ý và thống nhất ký kết thỏa thuận ba bên này (Sau đây gọi tắt là <strong>“Thỏa
						Thuận”</strong>) với các điều khoản và điều kiện cụ thể như sau:</p>
			</div>

			<div class="col-5">
				<p>
					<b>I. NỘI DUNG HỢP ĐỒNG</b>
				</p>
				<p>
					<b>1. Thông tin khoản vay</b>
				</p>
				<table class="table table-bordered">
					<tbody>
					<tr>
						<td>
							Số tiền đề nghị vay
						</td>
						<td>
							<?= (number_format($contract->loan_infor->amount_money, 0, '.', '.') . ' đ') ? (number_format($contract->loan_infor->amount_money, 0, '.', '.') . ' đ') : '' ?>
						</td>
					</tr>
					<tr>
						<td>
							Số tiền vay
						</td>
						<td>

						</td>
					</tr>
					<tr>
						<td>
							Bằng chữ
						</td>
						<td>

						</td>
					</tr>
					<tr>
						<td>
							Mục đích vay
						</td>
						<td>
							Tiêu dùng
						</td>
					</tr>
					<tr>
						<td>
							Thiết bị định vị toàn cầu GPS
						</td>
						<td style="padding: 0;">
							<div style="display: flex; padding: 7px;justify-content: center; <?= $start_loan ? '' : 'height: 50px' ?>">
								<p style="border-right: 1px solid;margin-right: 20px;padding-right: 20px;">
									Có
									<?php if (!empty($contract->loan_infor->device_asset_location->code)): ?>
										&#x2611;
									<?php else: ?>
										<?php if (isset($contract->loan_infor->gan_dinh_vi) && $contract->loan_infor->gan_dinh_vi == '1'): ?>
											&#x2611;
										<?php else: ?>
											☐
										<?php endif; ?>
									<?php endif; ?>
								</p>
								<p>
									Không
									<?php if (isset($contract->loan_infor->gan_dinh_vi) && $contract->loan_infor->gan_dinh_vi == '1'): ?>
										☐
									<?php else: ?>
										<?php if (!empty($contract->loan_infor->device_asset_location->code)): ?>
											☐
										<?php else: ?>
											&#x2611;
										<?php endif; ?>
									<?php endif; ?>
								</p>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							Thời hạn vay
						</td>
						<td style="padding: 0;">
							<div style="display: flex;    padding: 7px;justify-content: center; <?= $start_loan ? '' : 'height: 50px' ?>">
								<p style="border-right: 1px solid;margin-right: 20px;padding-right: 20px;">
									Từ ngày <br/>
									<?= $start_loan ? $start_loan : '' ?>
								</p>

								<p>
									Đến ngày <br/>
									<?= $end_loan ? $end_loan : '' ?>
								</p>
							</div>

						</td>
					</tr>
					<tr>
						<td>
							Phương thức thanh toán
						</td>
						<td>
							<?= ($type_interest == 2) ? "Thanh toán gốc cuối kỳ, lãi và các khoản phí" : "Thanh toán gốc, lãi và các khoản phí" ?>
						</td>
					</tr>
					<tr>
						<td>
							Chi phí vay tháng
						</td>
						<td>

						</td>
					</tr>
					<tr>
						<td>
							Lãi suất
						</td>
						<td>
							<?= $lai_suat_ndt ? $lai_suat_ndt : 1.5 ?>%/tháng
						</td>
					</tr>
					<tr>
						<td>
							Phí tư vấn quản lý
						</td>
						<td>
							<?= ($fee_advisory) ? $fee_advisory . '%' : '' ?>
						</td>
					</tr>
					<tr>
						<td>
							Các phí tư vấn khác (nếu có)
						</td>
						<td>

						</td>
					</tr>
					</tbody>
				</table>

				<p style="margin-top: 10px;">
					<b>2. Phí tư vấn</b>
				</p>

				<ol style="list-style: none;">
					<li>2.1. Phí trả nợ trước hạn: Theo thông báo của Đông Bắc tại từng thời điểm.
					</li>
					<li>2.2. Phí quản lý số tiền vay chậm trả: Theo thông báo của Đông Bắc tại từng thời điểm.</li>
					<li>2.3. Phí tư vấn gia hạn số tiền vay: Theo thông báo của Đông Bắc tại từng thời điểm.</li>
					<li>2.4. Phí tư vấn quản lý: Theo thông báo của Đông Bắc tại từng thời điểm.</li>
				</ol>
				<p style="margin-top: 10px;">
					<b>3. Tài khoản nhận thanh toán khoản vay</b>
				</p>
				<p>
					<b>
						- Chủ tài khoản: CTCP Công nghệ Tiện Ngay Đông Bắc
					</b>
				</p>
				<p>
					<b>
						- Số tài khoản: <?= ($van) ? $van : '' ?>
					</b>
				</p>
				<p>
					<b>
						- Ngân hàng: NHTM Việt Nam Thịnh Vượng (VP Bank)
					</b>
				</p>
				<p>
					<b>II. THÔNG TIN TÀI SẢN ĐẢM BẢO</b>
				</p>
				<p>
					Bên Vay cam kết Tài Sản Đảm Bảo thuộc sở hữu và/hoặc quyền sử dụng, quyền định đoạt hợp pháp của Bên
					Vay và có thông tin cụ thể như sau:
				</p>
				<table class="table table-bordered" style="margin-bottom: 10px">
					<thead>
					<th colspan="4">Tên tài sản đảm bảo</th>
					<th colspan="4"></th>
					</thead>
					<tbody>
					<tr>
						<td colspan="2">Số khung</td>
						<td colspan="2"><?= ($sokhung) ? $sokhung : '..........' ?></td>
						<td colspan="2">Biển kiểm soát</td>
						<td colspan="2"><?= ($bienkiemsoat) ? $bienkiemsoat : '..........' ?></td>
					</tr>
					<tr>
						<td colspan="2">Số máy</td>
						<td colspan="2"><?= ($somay) ? $somay : '..........' ?></td>
						<td colspan="2">Cấp ngày</td>
						<td colspan="2"><?= ($dangkycapngay) ? $dangkycapngay : $dangkyotocapngay ?></td>
					</tr>
					<tr>
						<td colspan="2">Số đăng ký</td>
						<td colspan="2"><?= ($sodangky) ? $sodangky : '..........' ?></td>
						<td colspan="2"></td>
						<td colspan="2"></td>
					</tr>

					</tbody>
				</table>
			</div>

			<div class="col-7">
				<p>
					<b>III. THÔNG TIN DỊCH VỤ BẢO HIỂM</b>
				</p>
				<table class="table table-bordered">
					<tbody>
					<tr>
						<td>
							<p>
								<b><span>1. Bảo hiểm Tai nạn người vay</span></b>
							</p>
							<p>
								<span>Bên vay đồng thời là Người được bảo hiểm đồng ý thứ tự về quyền thụ hưởng như sau:</span>
							</p>
							<ul>
								<li>
									<b><span>Người thụ hưởng thứ I:</span></b>
									<br>
									<span> Đông Bắc - được ưu tiên thanh toán trước tiền bảo hiểm bằng tổng khoản phí tư vấn quản lý chưa thanh toán còn lại của Thỏa Thuận vay.</span>
								</li>
								<li>
									<b><span>Người thụ hưởng thứ II:</span></b>
									<br>
									<span>
										Bên Cho Vay - được ưu tiên thanh toán trước tiền bảo hiểm bằng tổng dư nợ còn lại theo Thỏa Thuận vay nhưng không quá số tiền bảo hiểm sau khi trừ đi phần đã thanh toán cho Đông Bắc.
									</span>
								</li>
								<li>
									<b><span>Người thụ hưởng thứ III:</span></b>
									<br>
									<span>
										Người được bảo hiểm hoặc Người thừa kế hợp pháp – được thanh toán số tiền bảo hiểm còn lại sau khi trừ đi phần đã thanh toán cho Đông Bắc và Bên Cho Vay.
									</span>
								</li>
							</ul>
							<p>
                                        <span>
									Bên Vay thừa nhận quyền và nghĩa vụ của mình theo Quy tắc bảo hiểm tai nạn nhóm người vay tín dụng (truy cập link: <a
													href="<?= ($contract->loan_infor->insurrance_contract == '1' && $contract->loan_infor->loan_insurance == '1' && $contract->loan_infor->amount_GIC > 0) ? "https://bit.ly/2GKEMFj" : (($contract->loan_infor->insurrance_contract == '1' && $contract->loan_infor->loan_insurance == '2' && $contract->loan_infor->amount_MIC > 0) ? "https://bit.ly/373BUhE" : "https://bit.ly/2GKEMFj"); ?>"><span
														style="color: black"><?= ($contract->loan_infor->insurrance_contract == '1' && $contract->loan_infor->loan_insurance == '1' && $contract->loan_infor->amount_GIC > 0) ? "https://bit.ly/2GKEMFj" : (($contract->loan_infor->insurrance_contract == '1' && $contract->loan_infor->loan_insurance == '2' && $contract->loan_infor->amount_MIC > 0) ? "https://bit.ly/373BUhE" : "https://bit.ly/2GKEMFj"); ?></span>
                                        </a>) cùng các tài liệu sửa đổi, bổ sung (nếu có).
                                        </span>
							</p>
						</td>
						<td>
							<p>
								<span style="color: black"> <?= (($contract->loan_infor->insurrance_contract == '1' && $contract->loan_infor->loan_insurance == '1' && $contract->loan_infor->amount_GIC > 0) || ($contract->loan_infor->insurrance_contract == '1' && $contract->loan_infor->loan_insurance == '2' && $contract->loan_infor->amount_MIC > 0)) ? "&#x2611;" : "☐" ?> Xác nhận tham gia</span>
							</p>
							<p>
								<span style="color: black;">   <?= (($contract->loan_infor->insurrance_contract == '1' && $contract->loan_infor->loan_insurance == '1' && $contract->loan_infor->amount_GIC > 0) || ($contract->loan_infor->insurrance_contract == '1' && $contract->loan_infor->loan_insurance == '2' && $contract->loan_infor->amount_MIC > 0)) ? "☐" : "&#x2611;" ?> Không đồng ý tham gia</span>
							</p>
						</td>
					</tr>
					</tbody>
				</table>
				<table class="table table-bordered">
					<tbody>
					<tr>
						<td>
							<p>

								<b><span>2. Bảo hiểm Xe máy GIC Easy</span></b>
							</p>
							<p>
                                        <span>
									Bên Vay thừa nhận quyền và nghĩa vụ của mình theo Thông tư Bảo hiểm Trách nhiệm dân sự bắt buộc của chủ xe cơ giới (truy cập link: <a
													href="https://bit.ly/3uGkX5U"><span style="color: black">https://bit.ly/3uGkX5U</span>
                                        </a>), Quy tắc Tai nạn người ngồi trên xe máy (truy cập link: <a
													href="https://bit.ly/3e2NyeS"><span style="color: black">https://bit.ly/3e2NyeS</span></a>), Quy tắc tổn thất, mất cắp, mất cướp toàn bộ xe (truy cập link: <a
													href="https://bit.ly/3th9FET"><span style="color: black">https://bit.ly/3th9FET</span></a>) cùng các tài liệu sửa đổi, bổ sung (nếu có).
                                        </span>
							</p>
						</td>
						<td style="min-width:170px;">
							<p>
								<span style="color: black"><?= (isset($contract->loan_infor->code_GIC_easy) && isset($contract->loan_infor->amount_GIC_easy) && in_array($contract->loan_infor->code_GIC_easy, array('GIC_EASY_20'))) ? "&#x2611;" : "☐" ?> Xác nhận tham gia Gói 20</span>
							</p>
							<p>
								<span style="color: black"><?= (isset($contract->loan_infor->code_GIC_easy) && isset($contract->loan_infor->amount_GIC_easy) && in_array($contract->loan_infor->code_GIC_easy, array('GIC_EASY_40'))) ? "&#x2611;" : "☐" ?> Xác nhận tham gia Gói 40</span>
							</p>
							<p>
								<span style="color: black"><?= (isset($contract->loan_infor->code_GIC_easy) && isset($contract->loan_infor->amount_GIC_easy) && in_array($contract->loan_infor->code_GIC_easy, array('GIC_EASY_70'))) ? "&#x2611;" : "☐" ?> Xác nhận tham gia Gói 70</span>
							</p>
							<p>
								<span style="color: black"><?= (isset($contract->loan_infor->code_GIC_easy) && isset($contract->loan_infor->amount_GIC_easy) && in_array($contract->loan_infor->code_GIC_easy, array('GIC_EASY_20', 'GIC_EASY_40', 'GIC_EASY_70'))) ? "☐" : "&#x2611;" ?> Không đồng ý tham gia</span>
							</p>
						</td>
					</tr>
					</tbody>
				</table>


				<p>
                        <span>
						<strong>Cam kết:</strong>
						Bên Vay cam kết rằng những kê khai là đầy đủ và trung thực. Bên Vay đang trong tình trạng sức khỏe bình thường, không đang trong quá trình điều trị bất kỳ bệnh tật nào, không có bệnh có sẵn, bệnh đặc biệt. Trường hợp, mắc bệnh bẩm sinh, khuyết tật, thương tật, thần kinh, động kinh, phong cùi, HIV hoặc đã từng mắc/đang điều trị các bệnh ung thư, u, bướu, cao/hạ huyết áp, các bệnh về tim mạch, các bệnh mạch máu não, đột quỵ, viêm gan, xơ gan, suy gan, suy tủy lao/suy phổi/tràn khí phổi, bệnh đái tháo đường, viêm thận, suy thận/tụy mãn tính, Parkinson, Lupus ban đỏ, Bên vay có trách nhiệm thông báo với Bên cho vay, Đông Bắc và Bên Bảo Hiểm để Bên Bảo Hiểm xem xét nhận bảo hiểm.</span>
				</p>

				<p><span>Hợp đồng bảo hiểm sẽ bị vô hiệu lực khi Bệnh lý của Bên Vay đã tồn tại trước ngày bắt đầu bảo hiểm mà Bên Vay không thông báo cho Bên Bảo hiểm.</span>
				</p>


			</div>


			<div class="col-12 mb-3">
				<i>* Các quy định chi tiết về Số Tiền Vay và quyền và nghĩa vụ của Các Bên trong Thỏa Thuận này sẽ được
					quy định tại Điều Khoản Chung. Điều Khoản Chung này là một phần không thể tách rời khỏi Thỏa Thuận
					và đã được Các Bên đọc, hiểu và đồng ý cam kết thực hiện.</i>
			</div>

			<div class="col-4">
				<p class=" text-center"><strong> BÊN CHO VAY</strong>
				</p>
			</div>
			<div class="col-4">
				<p class=" text-center"><strong>BÊN VAY</strong>
				</p>
			</div>
			<div class="col-4">
				<p class=" text-center"><strong>ĐẠI DIỆN CÔNG TY ĐÔNG BẮC</strong>
				</p>
			</div>
		</div>
	</div>

</section>

<section>

	<div class="container">
		<div class="divHeader"><img src="https://tienngay.vn/assets/home/images/logo.png" alt="">
		</div>
		<div class="row">
			<div class="col-12 mt-3">
				<h1 style="font-weight:bold;font-size:18px;">ĐIỀU KHOẢN CHUNG</h1>
			</div>

			<div class="col-12">
				<div class="dieukhoan">
					<p class="p-0">
						<b><span>MỤC I. QUY ĐỊNH CHUNG MỤC ĐÍCH CỦA THỎA THUẬN</span></b>
					</p>
					<p>
						<span><b>Điều 1. Mục đích của Thỏa Thuận</b> <br> Các Bên đồng ý rằng, dựa trên sự tư vấn của Đông Bắc, Bên Cho Vay cho Bên Vay vay Số Tiền Vay. Bên Vay đồng ý đồng thời mua bảo hiểm liên quan đến Khoản Vay của Bên Bảo Hiểm thông qua Đông Bắc với quy định cụ thể tại Thỏa Thuận này. Theo đó, mối quan hệ độc lập giữa hai trong Các Bên tại Thỏa Thuận này được thể hiện như sau:</span>
					</p>
					<p>
						<span>1.1.</span>
						<span>Bên Cho Vay đồng ý cho Bên Vay vay một khoản tiền bằng Số Tiền Vay. Quy định chi tiết về Số Tiền Vay tại Mục II Điều Khoản Chung này.</span>
					</p>
					<p>
						<span>1.2.</span>
						<span>Bên Vay chỉ định sử dụng Dịch Vụ Tư Vấn Quản Lý của Đông Bắc theo quy định chi tiết tại Mục III Điều Khoản Chung này.</span>
					</p>
					<p>
						<span>1.3.</span>
						<span>Bên Cho Vay chỉ định Đông Bắc đại diện Bên Cho Vay: Nhận, bảo quản, xử lý Tài Sản Đảm Bảo (nếu có) và các giấy tờ liên quan đến Tài Sản Đảm Bảo từ Bên Vay. Thỏa thuận về việc hợp tác này chi tiết tại hợp đồng hợp tác giữa hai bên.</span>
					</p>
					<p>
						<span>1.4.</span>
						<span>Bên Vay đồng ý và không hủy ngang trách nhiệm cho Đông Bắc lắp đặt thiết bị định vị toàn cầu (GPS) vào Tài Sản Đảm Bảo để quản lý hoạt động của tài sản trong trường hợp vay qua hình thức lắp thiết bị định vị trong suốt thời gian thực hiện Thỏa thuận này. Thiết bị GPS là tài sản thuộc sở hữu của Đông Bắc. Theo đó, Bên Vay không phải sử dụng dịch vụ Thẩm định của Đông Bắc đã được quy định tại Điều 8 của Thỏa thuận này.</span>
					</p>
					<p class="p-0">
						<b><span>MỤC II. THỎA THUẬN GIỮA BÊN CHO VAY VÀ BÊN VAY</span></b>
					</p>
					<p class="p-0">
						<b><span>Điều 2. Thỏa thuận vay</span></b>
					</p>
					<p>
						<span>2.1.</span>
						<span> Bên Cho Vay đồng ý và Bên Vay đồng ý vay một số tiền tương ứng Số Tiền Vay từ Bên Cho Vay.
                         </span>
					</p>
					<p>
						<span>2.2.</span>
						<span>Tiền lãi được tính theo công thức sau:
                            Tiền lãi = ∑ (Dư nợ thực tế từng thời điểm của Số Tiền Vay x Lãi Suất/365 x Số ngày vay tương ứng Dư nợ thực tế từng thời điểm)
                            </span>
					</p>
					<p>
						<span>2.3.</span>
						<span>Nghĩa vụ thanh toán: Bên Vay có nghĩa vụ thanh toán đầy đủ Số Tiền Phải Thanh Toán cho Bên Cho Vay thông qua Đông Bắc (theo chỉ định của Bên Cho Vay). Bên Vay thanh toán theo tờ Hướng dẫn thanh toán đính kèm Thỏa Thuận này.
                    </span>
					</p>
					<p>
						<span>2.4.</span>
						<span>Gia hạn Số Tiền Vay: Trường hợp Bên Vay muốn gia hạn Số Tiền Vay thì Bên Vay phải gửi đề nghị gia hạn cho Đông Bắc để Đông Bắc thông báo cho Bên Cho Vay. Số Tiền Vay chỉ được gia hạn khi có sự chấp thuận bằng Thông Báo đến Bên Vay của Bên Cho Vay.
                    </span>
					</p>
					<p>
						<span>2.5.</span>
						<span>Phí Trả Nợ Trước Hạn: Tại bất kỳ thời điểm nào của Thỏa Thuận, Bên Vay có thể trả trước một phần hoặc toàn bộ Số Tiền Vay kèm phí trả nợ trước hạn bằng […]% Nợ Gốc Trả Trước Hạn. Phí Trả Nợ Trước Hạn được thanh toán cùng thời điểm Bên Vay thanh toán Số Tiền Vay trước hạn cho Bên Cho Vay.
                    </span>
					</p>
					<p class="p-0">
						<b><span>Điều 3. Quyền và nghĩa vụ của Bên Cho Vay</span></b>
					</p>
					<p>
						<span>3.1.</span>
						<span>Quyết định việc giải ngân Số Tiền Vay theo đề nghị của Bên Vay thông qua cách thức mà Bên Cho Vay cho là phù hợp tùy từng thời điểm. Khi thực hiện các công việc liên quan đến giải ngân Số Tiền Vay, Bên Cho Vay/Bên được ủy quyền của Bên Cho Vay được toàn quyền ghi âm lại bất kỳ nội dung nào trao đổi qua điện thoại giữa Bên Cho Vay và Khách Hàng, và Khách Hàng tại đây thừa nhận và đồng ý rằng dữ liệu ghi âm đó là bằng chứng chứng minh việc Khách Hàng cam kết thực hiện các nghĩa vụ liên quan đến Thỏa Thuận này. </span>
					</p>
					<p>
						<span>3.2.</span>
						<span>Tiền lãi Bên Cho Vay được hưởng là tiền lãi chưa bao gồm thuế, Bên cho vay tự thực hiện kê khai và nộp thuê thu nhập cá nhân theo đúng quy định của pháp luật. </span>
					</p>
					<p>
						<span>3.3.</span>
						<span>Yêu cầu Bên Vay hoặc bên nhận thực hiện nghĩa vụ thanh toán cho Bên Vay (nếu có) phải thanh toán đầy đủ và đúng hạn Số Tiền Phải Thanh Toán theo Thỏa Thuận này.</span>
					</p>
					<p>
						<span>3.4.</span>
						<span>Tuân thủ các quy định đã cam kết trong Thỏa Thuận.
                    </span>
					</p>
					<p class="p-0">
						<b><span>Điều 4. Quyền và nghĩa vụ của Bên Vay</span></b>
					</p>
					<p>
						<span>4. 1.</span>
						<span>Được đề nghị gia hạn Số Tiền Vay với điều kiện thanh toán đầy đủ và đúng hạn tiền lãi và các khoản phí phát sinh từ Thỏa Thuận này theo Thông Báo.
                    </span>
					</p>
					<p>
						<span>4. 2.</span>
						<span>Cung cấp đầy đủ, chính xác, trung thực thông tin Bên Vay đã nêu tại hợp đồng này.
                    </span>
					</p>
					<p>
						<span>4. 3.</span>
						<span>Thực hiện đầy đủ nghĩa vụ thanh toán khi đến hạn theo quy định tại Thỏa Thuận.
                    </span>
					</p>
					<p>
						<span>4. 4.</span>
						<span>Trong trường hợp lắp đặt thiết bị định vị toàn cầu (GPS), Bên vay cam kết vô điều kiện và không hủy ngang việc chịu trách nhiệm bồi thường thiệt hại 700.000 VNĐ (Bảy trăm nghìn đồng) cho Đông Bắc trong trường hợp phát sinh bất kỳ thiệt hại liên quan đến thiết bị định vị toàn cầu (GPS) là tài sản thuộc sở hữu của Đông Bắc.</span>
					</p>
					<p>
						<span>4. 5.</span>
						<span>Được chuyển giao cho bên thứ ba thực hiện một phần hoặc toàn bộ thuận của Bên Cho Vay.</span>
					</p>
					<p>
						<span>4. 6.</span>
						<span>Tuân thủ các quy định của pháp luật hiện hành liên quan đến việc thực hiện các nghĩa vụ của Bên Vay.</span>
					</p>
					<p class="p-0">
						<b>
							<br>
							<span>Điều 5. Sự Kiện Vi Phạm</span></b>
					</p>
					<p>
						<span>5.1.</span>
						<span>Mỗi sự kiện hoặc trường hợp trong các sự kiện/trường hợp quy định sau đây được xem là một Sự Kiện Vi Phạm:
                    </span>
					</p>
					<p>a. Bên Vay không tuân thủ bất kỳ quy định nào của Thỏa Thuận này hoặc Thông Báo hoặc văn bản, tài
						liệu khác liên quan đến Thỏa Thuận;</p>
					<p>b. Bên Vay cung cấp các thông tin hoặc giấy tờ liên quan đến Số Tiền Vay không đúng, không chính
						xác, không trung thực; </p>
					<p>c. Bên Vay không thanh toán đúng hạn bất kỳ khoản đến hạn nào trong Số Tiền Phải Thanh Toán.</p>


					<p>
						<span>5.2.</span>
						<span>Ngay khi và sau khi xảy ra một Sự Kiện Vi Phạm, Bên Cho Vay có quyền:

                            </span>
					</p>
					<p>a. Tuyên bố đến hạn thanh toán ngay Số Tiền Phải Thanh Toán; </p>
					<p>b. Thu giữ và tiến hành xử lý Tài Sản Bảo Đảm (nếu có) theo quy định tại Thỏa Thuận;</p>
					<p>c. Chấm dứt tất cả các nghĩa vụ của Bên Cho Vay đối với Bên Vay theo Thỏa Thuận; </p>
					<p>d. Thực hiện tất cả các quyền và chế tài hợp lý của Bên Cho Vay theo quy định tại Thỏa Thuận
						này. </p>
					<p class="p-0">
						<b><span>Điều 6. Thỏa thuận về biện pháp bảo đảm</span></b>
					</p>
					<p>
						<span>6. 1.</span>
						<span>Bên Vay và Bên Cho Vay đồng ý lựa chọn biện pháp bảo đảm là cầm cố tài sản thuộc sở hữu của Bên Vay để đảm bảo nghĩa vụ thanh toán Số Tiền Vay của Bên Vay đối với Bên Cho Vay (“Tài Sản Đảm Bảo”).</span>
					</p>

					<p>
						<span>6. 2.</span>
						<span>Ngay sau khi Bên Cho Vay đã giải ngân Số Tiền Vay cho Bên Vay, Bên Vay chuyển giao Tài Sản Đảm Bảo và các giấy tờ liên quan đến Tài Sản Đảm Bảo (bản gốc) cho Bên Cho Vay hoặc cho bên được Bên Cho Vay chỉ định. </span>
					</p>
					<p>
						<span>6.3.</span>
						<span> Trong trường hợp Tài Sản Đảm Bảo là xe máy, ô tô hoặc các phương tiện di chuyển cá nhân khác, Bên Vay có thể giữ lại Tài Sản Đảm Bảo để sử dụng (nếu có nhu cầu) và sẽ bàn giao lại toàn bộ bản gốc các giấy tờ liên quan đến Tài Sản Đảm Bảo cho Bên Cho Vay.</span>
					</p>
					<p>
						<span>6.4.</span>
						<span> Bên Cho Vay sẽ chuyển giao lại Tài Sản Đảm Bảo cùng các giấy tờ mà Bên Cho Vay đã nhận cho Bên Vay khi Bên Vay hoàn thành tất cả nghĩa vụ tài chính theo Thỏa Thuận này hoặc Bên Vay có nhu cầu thay thế một Tài Sản Đảm Bảo khác cho Số Tiền Vay.</span>
					</p>
					<p>
						<span>6.5.</span>
						<span>Xử lý Tài Sản Bảo Đảm:
Ngay khi và sau khi xảy ra một Sự Kiện Vi Phạm (bao gồm nhưng không giới hạn: chậm thực hiện, thực hiện không đúng, không đầy đủ nghĩa vụ thanh toán,…) được quy định tại Thỏa Thuận này Đông Bắc  có toàn quyền xử lý Tài Sản Bảo Đảm theo quy định của pháp luật (như Tự bán tài sản bảo đảm,...) để trừ vào Số Tiền Phải Thanh Toán của Bên Vay.
</span>
					</p>
					<p class="p-0">
						<b><span>Điều 7. Cam kết của Bên Vay về Tài Sản Bảo Đảm </span></b>
					</p>
					<p>
						<span>7.1.</span>
						<span>Bên Vay cam kết tại thời điểm ký Thỏa Thuận này, Tài Sản Bảo Đảm thuộc quyền sở hữu và/hoặc quyền sử dụng, quyền định đoạt hợp pháp của Bên Vay, có nguồn gốc hợp pháp, không bị cơ quan nhà nước có thẩm quyền xử lý theo quy định của pháp luật, đang không bị tranh chấp, thế chấp, cầm cố, bảo lãnh với bên thứ ba nào.</b>
							.
                    </span>
					</p>
					<p>
						<span>7.2.</span>
						<span> Cam kết vô điều kiện và không hủy ngang việc chịu trách nhiệm bồi thường thiệt hại cho Bên Cho Vay hoặc bên thứ ba trong trường hợp phát sinh bất kỳ thiệt hại, kiện đòi, mất mát, hư tổn, chi phí nào liên quan đến Tài Sản Bảo Đảm và việc giao Tài Sản Bảo Đảm; và đồng ý rằng Bên Cho Vay được loại trừ khỏi tất cả các trách nhiệm nêu trên.
                    </span>
					</p>
					<p>
						<span>7.3.</span>
						<span>Cam kết cung cấp và/hoặc bổ sung và/hoặc xuất trình bằng chứng về quyền sở hữu và/hoặc quyền sử dụng, quyền định đoạt của Bên Vay đối với Tài Sản Bảo Đảm và/hoặc nguồn gốc của Tài Sản Bảo Đảm theo yêu cầu của Bên Cho Vay; Cam kết bổ sung, thay thế bất kỳ tài sản nào khác Tài Sản Bảo Đảm để bảo đảm nghĩa vụ thanh toán Số Tiền Vay theo Thỏa Thuận tại bất kỳ thời điểm nào mà Bên Cho Vay cho là cần thiết.
                    </span>
					</p>

					<p class="p-0">
						<b><span>MỤC III. THỎA THUẬN GIỮA BÊN VAY VÀ CÔNG TY ĐÔNG BẮC</span></b>
					</p>
					<p class="p-0">
						<b><span>Điều 8. Dịch Vụ Tư Vấn Quản Lý</span></b>
					</p>
					<p>
						<span>8.1.</span>
						<span>Bên Vay chỉ định và Đông Bắc đồng ý cung cấp Dịch Vụ Tư Vấn Quản Lý với nội dung cụ thể của Dịch Vụ như sau:
                            </span>
					</p>
					<p>
						<span>a</span>
						<span>Tư Vấn Quản lý;
                            </span>
					</p>
					<p>
						<span>b</span>
						<span>Thẩm định và lưu trữ Tài Sản Đảm Bảo/giầy tờ của Tài Sản Đảm Bảo;
                            </span>
					</p>
					<p>
						<span>c</span>
						<span>Quản lý khoản vay
                            </span>
					</p>
					<p>
						<span>d</span>
						<span>Các dịch vụ khác theo thỏa thuận giữa Bên Vay và Đông Bắc nếu Bên Vay có nhu cầu.
                            </span>
					</p>
					<p>
						<span>8.2.</span>
						<span>Bên Vay sẽ thanh toán Phí Tư Vấn Quản Lý, Phí Quản Lý Số Tiền Vay Chậm Trả (nếu có) cho Đông Bắc theo quy định tại Thỏa Thuận này và chính sách cụ thể của Đông Bắc.
                    </span>
					</p>

					<p class="p-0">
						<b><span>Điều 9. Phí Tư Vấn Quản Lý và Phí Quản Lý Số Tiền Vay Chậm Trả</span></b>
					</p>
					<p>
						<span>9.1.</span>
						<span>Phí Tư Vấn Quản Lý đối với Số Tiền Vay được quy định tại Thỏa Thuận này đã bao gồm VAT. Bên Vay và Đông Bắc đồng ý rằng Phí Tư Vấn Quản Lý cụ thể sẽ được quy định cụ thể tại Thông Báo Đến Bên Vay theo chính sách phí do Đông Bắc áp dụng tại từng thời điểm.</span>
					</p>
					<p>
						<span>9.2.</span>
						<span>Điều kiện thu Phí Tư Vấn Quản Lý: Phí Tư Vấn Quản Lý được thu khi Số Tiền Vay được giải ngân thành công cho Bên Vay.
                    </span>
					</p>
					<p>
						<span>9.3.</span>
						<span>Thanh toán Phí Tư Vấn Quản Lý: Bên Vay thanh toán Phí Tư Vấn Quản Lý hàng tháng cho Đông Bắc. Phí Tư Vấn Quản Lý sẽ được Đông Bắc tính vào Số Tiền Phải Thanh Toán của Bên Vay hàng tháng và Bên Vay sẽ tiến hành thanh toán vào ngày được nêu tại Thông Báo của Đông Bắc.
                    </span>
					</p>
					<p>
						<span>9.4.</span>
						<span>Phí Quản Lý Số Tiền Vay Chậm Trả: Phí Quản Lý Số Tiền Vay Chậm Trả được tính là […] cho mỗi lần Bên Vay thanh toán không đúng hạn Số Tiền Phải Thanh Toán quy định tại Thỏa Thuận này. Phí Quản Lý Số Tiền Vay Chậm Trả sẽ áp dụng cho đến khi Bên Vay hoàn thành các nghĩa vụ thanh toán.
                    </span>
					</p>
					<p class="p-0">
						<b><span>Điều 10. Cam kết dịch vụ bảo hiểm</span></b>
					</p>
					<p>
						<span>10.1.</span>
						<span>Bên Vay sau đây đồng ý Đông Bắc là đại lý của Bên Bảo Hiểm, Đông Bắc có nghĩa vụ: (a) Tư vấn cho Bên Vay sản phẩm bảo hiểm, Phí Bảo Hiểm, các thông tin liên quan; (b) Hỗ trợ Bên Vay chuẩn bị hồ sơ bảo hiểm và thu, nộp Phí Bảo Hiểm cho Bên Bảo Hiểm; (c) Các công việc khác theo quy định của pháp luật thuộc nghĩa vụ của đại lý bảo hiểm cũng như thỏa thuận giữa Đông Bắc và Bên Bảo Hiểm.
                    </span>
					</p>
					<p>
						<span>10.2.</span>
						<span>Phí Bảo Hiểm được xác định tại Ngày Giải Ngân. Bên Vay chỉ định Đông Bắc được quyền khấu trừ khoản Phí Bảo Hiểm tương ứng với Số Tiền Vay để thanh toán cho Bên Bảo Hiểm ngay tại thời điểm Giải ngân Khoản Vay.</span>
					</p>
					<p class="p-0">
						<b><span>Điều 11. Cam kết chuyển giao nghĩa vụ thanh toán</span></b>
					</p>
					<p>
						<span>11.1.</span>
						<span>Trường hợp Bên Vay thực hiện không đúng, không đầy đủ nghĩa vụ thanh toán Số Tiền Vay đối với Bên Cho Vay, Đông Bắc chịu trách nhiệm thực hiện nghĩa vụ này nếu hai bên có thỏa thuận mà không cần sự chấp thuận của Bên cho vay.
                    </span>
					</p>
					<p>
						<span>11.2.</span>
						<span>Thỏa thuận giữa Đông Bắc và Bên Vay phải lập thành văn bản, được đóng dóng, ký bởi người hai bên hoặc người đại diện hợp pháp của các bên.
                    </span>
					</p>
					<p class="p-0">
						<b><span>MỤC IV. QUY ĐỊNH KHÁC</span></b>
					</p>
					<p class="p-0">
						<b><span>Điều 12. Thông Báo đến Bên Vay</span></b>
					</p>
					<p>
						<span>12.1.</span>
						<span>Bên Vay tại đây xác nhận đồng ý chịu sự ràng buộc và tuân thủ các Thông Báo đến Bên Vay trong mọi trường hợp. Bất kỳ Thông Báo nào được gửi bằng hình thức tin nhắn đến số điện thoại đã đăng ký của Bên Vay sẽ được coi là đã gửi và Bên Vay đã nhận được.
                    </span>
					</p>
					<p>
						<span>12.2.</span>
						<span>Thông Báo là phần không thể tách rời của Thỏa Thuận này. Trong trường hợp Thông Báo vì lý do nào đó có một hoặc một vài thông tin bị lỗi và/hoặc sai sót, Đông Bắc và/hoặc Bên Cho Vay được quyền đính chính, chỉnh sửa thông tin đó bằng việc gửi một Thông Báo khác đến Bên Vay.
                    </span>
					</p>
					<p>
						<b><span>Điều 13. Thuế, Phí</span></b>
					</p>
					<p>
                            <span>Mỗi Bên sẽ tự chịu trách nhiệm kê khai, nộp các khoản thuế, phí phát sinh thuộc trách nhiệm của mình liên quan đến việc thực hiện Thỏa Thuận này tại cơ quan nhà nước có thẩm quyền.
                    </span>
					</p>
					<p class="p-0">
						<b><span>Điều 14. Bồi thường thiệt hại, Phạt vi phạm</span></b>
					</p>
					<p>
						<span>14.1.</span>
						<span>Trừ khi xảy ra Sự kiện bất khả kháng theo Thỏa Thuận này, trường hợp một Bên không thực hiện, thực hiện không đúng, không đầy đủ bất kỳ nghĩa vụ nào đến hạn theo quy định tại Thỏa Thuận, Bên vi phạm ngay lập tức phải chấm dứt vi phạm của mình, khắc phục những hậu quả do hành vi vi phạm trong một thời gian nhất định được yêu cầu bởi Bên bị vi phạm, đồng thời chịu phạt với mức tối đa 8% (tám phần trăm) giá trị phần nghĩa vụ bị vi phạm;
                    </span>
					</p>
					<p>
						<span>14.2.</span>
						<span>Trường hợp có thiệt hại, Bên vi phạm phải bồi thường toàn bộ thiệt hại phát sinh cho Bên bị vi phạm.
                            </span>
					</p>
					<p class="p-0">
						<b><span>Điều 15. Các điều khoản khác</span></b>
					</p>
					<p>
						<span>15.1. </span>
						<span>Đông Bắc được quyền gửi thông báo tới khách hàng đã và đang sử dụng dịch vụ của Đông Bắc thông tin về sản phẩm hay bất kể dịch vụ nào của Đông Bắc thông qua các phương tiện truyền tải thông tin, bao gồm nhưng không giới hạn: tin nhắn, cuộc gọi, thư điện tử,…trong khung giờ từ 08 giờ 00 tới 21 giờ 00 hàng ngày.
                    </span>
					</p>
					<p>
						<span>15.2. </span>
						<span>Bên Vay cam kết và thừa nhận rằng bất kỳ thông tin nào do Bên Vay cung cấp trong quá trình giao kết và thực hiện Thỏa Thuận là chính xác, trung thực. Bên Vay có trách nhiệm thông báo cho Bên Cho Vay và Đông Bắc ngay khi có thay đổi về bất kỳ thông tin nào của Bên Vay.</span>
					</p>
					<p>
						<span>15.3.</span>
						<span>Bên Vay bằng văn bản này đồng ý và cho phép Bên Cho Vay và/hoặc Đông Bắc được sử dụng, mã hóa, truyền tải, lưu trữ; chuyển giao và tiết lộ bất cứ thông tin nào liên quan đến Bên Vay và/hoặc do Bên Vay cung cấp và/hoặc vấn đề, tài liệu liên quan đến Thỏa Thuận này cho bất kỳ bên thứ ba nào tại bất cứ thời điểm nào mà Bên Cho Vay và/hoặc Đông Bắc cho là phù hợp và cần thiết trong phạm vi pháp luật cho phép mà không phải có thêm một sự chấp thuận nào khác của Bên Vay, đồng thời không phải chịu trách nhiệm với Bên Vay liên quan đến các hành vi này.</span>
					</p>
					<p>
						<span>15.4.</span>
						<span>Toàn bộ các quyền, nghĩa vụ của Đông Bắc và Bên cho vay được hai bên đảm bảo thực thiện theo quy định chi tiết tại Hợp đồng hợp tác giữa hai bên.
                    </span>
					</p>
					<p>
						<span>15.5.</span>
						<span>Trong quá trình thực hiện Thỏa Thuận, Các Bên có thể yêu cầu sửa đổi, bổ sung Thỏa Thuận. Việc sửa đổi, bổ sung Thỏa Thuận này phải được Các Bên đồng ý và lập thành văn bản dưới hình thức phụ lục và phải được xác nhận bằng chữ ký của đại diện Các Bên.
                    </span>
					</p>
					<p>
						<span>15.6.</span>
						<span>Thỏa Thuận được chấm dứt khi các Bên đã hoàn thành tất cả các nghĩa vụ của hoặc tự động chấm dứt khi Bên Cho Vay hoặc Bên ủy quyền của Bên Cho Vay không thực hiện giải ngân và/hoặc Thông Báo đến Bên Vay về việc không giải ngân Số Tiền Vay.
                    </span>
					</p>
					<p>
						<span>15.7.</span>
						<span>Nếu bất kỳ điều khoản nào của Thỏa Thuận này trở thành bất hợp pháp hoặc không thể thi hành theo quy định của pháp luật Việt Nam, thì tính hợp pháp hoặc tính bắt buộc của những điều khoản còn lại của Thỏa Thuận này sẽ không vì thế mà bị ảnh hưởng hay mất hiệu lực và Các Bên vẫn có nghĩa vụ thực hiện.
                    </span>
					</p>
					<p>
						<span>15.8.</span>
						<span>Các Bên thừa nhận rằng việc giao kết Thỏa Thuận này là hoàn toàn tự nguyện, không bị lừa dối hoặc ép buộc.
                    </span>
					</p>
				</div>
			</div>
		</div>
	</div>
</section>
</body>


<style>
	html,
	body {
		font-family: "Times New Roman", sans-serif;
		font-size: 14px;
		line-height: 1.281;
		color: #000;
	}

	p {
		margin: 0;
	}

	ul {
		padding-left: 15px;
		text-align: justify;
		margin: 0
	}

	ol {
		padding-left: 10px;
	/ / text-align: justify;
		margin: 0
	}

	ol li,
	ul li {
	/ / text-align: justify;
	}

	ul {
		list-style:
	}

	section {
		page-break-after: always;
	}

	.row-no-gutter {
		margin: 0;
	}

	.row-no-gutter > * {
		padding: 0;
	}

	.row-small-gutter {
		margin-left: -7.5px;
		margin-right: -7.5px;
	}

	.row-small-gutter > * {
		padding-left: 7.5px;
		padding-right: 7.5px;
	}

	.row-large-gutter {
		margin-left: -50px;
		margin-right: -50px;
	}

	.row-large-gutter > * {
		padding-left: 50px;
		padding-right: 50px;
	}

	.table-fixed {
		table-layout: fixed;
		width: 100%;
	}

	table p {
		text-align: initial;
	}

	table,
	.table {
		margin: 0;
		border-color: #000 !important;
	}

	.table-sm td,
	.table-sm th {
		padding-top: 0;
		padding-bottom: 0;
	}

	.table-bordered td,
	.table-bordered th,
	.table-bordered p {
		border-color: #000 !important;
		text-align: justify;
	}

	td, tr, th {
		padding-top: 0 !important;
		padding-bottom: 0 !important;
	}

	.dieukhoan {
		column-gap: 40px;
		display: list-item;
		list-style: none;
		column-count: 3;
		font-size: 10px;
		text-align: justify;
	}

	.dieukhoan > p {
		margin-bottom: 10px;
	}

	/*.qcont {*/
	/*  display: inline-block*/
	/*}*/
	/*.qcont:first-letter {*/
	/*  text-transform: capitalize*/
	/*}*/
</style>

</html>
