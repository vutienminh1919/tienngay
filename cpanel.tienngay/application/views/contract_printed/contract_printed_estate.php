<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title></title>

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
$ngay_cap = ($ngay_cap) ? date('d/m/Y', strtotime($ngay_cap)) : '';
?>
<body>


<!-- Page Content -->
<section>

	<div class="container">
		<div class="divHeader"><img src="https://tienngay.vn/assets/home/images/logo.png" alt=""></div>
		<div class="row">

			<!-- Header -->
			<div class="col-lg-12 text-center mb-3">
				<h1 style="font-weight:bold;font-size:18px;">THỎA THUẬN BA BÊN</h1>
				<p class="text-center "><strong><i> Về việc hỗ trợ tài chính </i></strong></p>
				<p class="text-center">
					<strong><i>Số: <?= empty($code_contract) ? '…………………………………………' : $code_contract ?></i></strong></p>
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
						<td colspan="3">
							<p>
								<span>: <?= ($address_house) ? $address_house : '………………………………………' ?></span>
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

				<p><b>Bên cung cấp dịch vụ: CÔNG TY CỔ PHẦN CÔNG NGHỆ TÀI CHÍNH VIỆT</b></p>

				<p>Địa chỉ trụ sở chính: Tầng 15, Khối B, Tòa nhà Sông Đà, đường Phạm Hùng, Phường Mỹ Đình 1, Quận Nam
					Từ Liêm, thành phố Hà Nội.</p>

				<p>Địa điểm giao
					dịch: <?= ($contract->store->address) ? $contract->store->address : '…………………………………..' ?></p>

				<p>Đại diện bởi: <strong><?= isset($store->representative) ? $store->representative : '…………' ?></strong>.
					Giấy ủy quyền số: .......................................</p>

				<p>Sau đây gọi tắt là <strong>“VFC”</strong></p>

				<p>Các Bên đồng ý và thống nhất ký kết thỏa thuận ba bên này (Sau đây gọi tắt là <strong>“Thỏa
						Thuận”</strong>) với các điều khoản và điều kiện cụ thể như sau:</p>
			</div>

			<div class="col-6">
				<p>
					<b>I. THÔNG TIN SỐ TIỀN VAY</b>
				</p>
				<ol>
					<li>Số Tiền Đề Nghị Vay:
						<b><?= (number_format($contract->loan_infor->amount_money, 0, '.', '.') . ' đ') ? (number_format($contract->loan_infor->amount_money, 0, '.', '.') . ' đ') : '…………………….... …………………..' ?></b>
						<br>
						(Bằng chữ: <b
								class="qcont"><?= (convert_number_to_words($contract->loan_infor->amount_money)) ? (convert_number_to_words($contract->loan_infor->amount_money)) : '………………………………………………….…' ?></b>)
					</li>
					<li>Số Tiền Vay:<strong>
							...............................................................................................</strong>
						<br>
						(Bằng chữ: <strong>..................................................................................................</strong><br>
						<strong>...................................................................................................................</strong>)<br>
						<i style="font-size: 12px">(<strong>Lưu ý</strong>: Số Tiền Vay luôn luôn bé hơn hoặc bằng với
							Số Tiền Đề Nghị Vay)</i>
					</li>
					<li>
						Lãi Suất: <strong>1.5%/tháng</strong>
					</li>
					<li>
						Mục đích vay: Tiêu dùng cá nhân. <br>
						Bên Vay cam kết sử dụng Số Tiền Vay theo đúng mục đích mà Bên Vay đã nêu. Bên Vay hoàn toàn chịu
						trách nhiệm trước pháp luật và Bên Cho Vay về việc sử dụng Số Tiền Vay đúng mục đích, đồng thời,
						miễn trừ mọi trách nhiệm pháp lý liên quan đối với Bên Cho Vay và VFC nếu Bên Vay vi phạm điều
						khoản này.
					</li>
					<li>
						Ngày Giải Ngân:
						<strong> <?= !empty($contract->disbursement_date) ? date('d/m/Y', intval($contract->disbursement_date) + 7 * 60 * 60) : '.................................' ?></strong>
					</li>
					<li>
						Hình thức giải ngân:
						<span style="padding-left: 32px"><?= ($contract->code_transaction_bank_disbursement != "") ? "&#x2611;" : "☐" ?> Tiền mặt</span><br>
						<span style="padding-left: 151px"><?= ($contract->code_transaction_bank_disbursement == "") ? "&#x2611;" : "☐" ?> Qua số thẻ/tài khoản ngân hàng</span>
					</li>
					<li>
						Thời hạn vay:
						<span style="font-family: 'Segoe UI Symbol', sans-serif; padding-left: 69px"><?= ($number_day_loan == 1) ? "&#9745;" : "☐" ?></span>
						01 tháng
						<span style="font-family: 'Segoe UI Symbol', sans-serif;"><?= ($number_day_loan == 3) ? "&#9745;" : "☐" ?></span>
						03 tháng
						<span style="font-family: 'Segoe UI Symbol', sans-serif;"><?= ($number_day_loan == 6) ? "&#9745;" : "☐" ?></span>
						06 tháng
						<span style="font-family: 'Segoe UI Symbol', sans-serif;"><?= ($number_day_loan == 9) ? "&#9745;" : "☐" ?></span>
						09 tháng <br>
						<span style="font-family: 'Segoe UI Symbol', sans-serif; padding-left: 151px"><?= ($number_day_loan == 12) ? "&#9745;" : "☐" ?></span>
						12 tháng
						<span style="font-family: 'Segoe UI Symbol', sans-serif;"><?= ($number_day_loan == 18) ? "&#9745;" : "☐" ?></span>
						18 tháng
						<span style="font-family: 'Segoe UI Symbol', sans-serif;"><?= ($number_day_loan == 24) ? "&#9745;" : "☐" ?></span>
						24 tháng
						<span style="font-family: 'Segoe UI Symbol', sans-serif;"><?= ($number_day_loan == 36) ? "&#9745;" : "☐" ?></span>
						36 tháng
					</li>
					<li>
						Kỳ thanh toán: <b>Hàng tháng</b>
					</li>
					<li>
						Phương thức thanh toán: <br>
						<?= ($type_interest == 2) ? "&#9745; " : "☐ " ?> 1.Thanh toán gốc cuối kỳ, lãi và các khoản phí
						(nếu có) hàng tháng<br>
						<?= ($type_interest == 1) ? "&#9745; " : "☐ " ?> 2.Thanh toán gốc, lãi và các khoản phí (nếu có)
						hàng tháng theo thông báo cụ thể của VFC
					</li>
					<li>
						Tổng số tiền phải trả hàng tháng: <strong>...............................................................</strong>
						<br>
						(Bằng chữ: <strong>..................................................................................................</strong><br>
						<strong>...................................................................................................................</strong>)
					</li>
					<li>
						Phí Trả Nợ Trước Hạn: Theo thông báo của VFC tại từng thời điểm
					</li>
					<li>
						Phí Quản Lý Số Tiền Vay Chậm Trả: Theo thông báo của VFC tại từng thời điểm
					</li>
					<li>
						Phí Thẩm Định và Lưu Trữ Tài Sản Đảm Bảo (nếu có): Theo thông báo của VFC tại từng thời điểm
					</li>
					<li>
						Phí Tư Vấn Gia Hạn Số Tiền Vay: Theo thông báo của VFC tại từng thời điểm
					</li>
				</ol>
				<p>
					<b>II. THANH TOÁN PHÍ TƯ VẤN QUẢN LÝ</b>
				</p>

				<ol>
					<li>Phí Tư Vấn Quản Lý là khoản phí mà Bên Vay phải thanh toán cho VFC khi VFC cung cấp Dịch Vụ Tư
						Vấn Quản Lý (quy định cụ thể tại Điều Khoản Chung) cho Bên Vay.
					</li>
					<li>Kỳ thanh toán Phí Tư Vấn Quản Lý: Hàng tháng.</li>
					<li>Phí Tư Vấn Quản Lý: Thanh toán theo chính sách chung của VFC tại từng thời điểm.</li>
				</ol>

			</div>

			<div class="col-6">
				<p>
					<b>III. THÔNG TIN DỊCH VỤ BẢO HIỂM</b>
				</p>
				<table class="table table-bordered">
					<tbody>
					<tr>
						<td>
							<p>
								<b><span>Bảo hiểm Tai nạn người vay</span></b>
							</p>
							<p>
								<span>Bên vay đồng thời là Người được bảo hiểm đồng ý thứ tự về quyền thụ hưởng như sau:</span>
							</p>
							<ul>
								<li>
									<b><span>Người thụ hưởng thứ I:</span></b> <br>
									<span> VFC - được ưu tiên thanh toán trước tiền bảo hiểm bằng tổng khoản phí tư vấn quản lý chưa thanh toán còn lại của Thỏa Thuận vay.</span>
								</li>
								<li>
									<b><span>Người thụ hưởng thứ II:</span></b> <br>
									<span>
										Bên Cho Vay - được ưu tiên thanh toán trước tiền bảo hiểm bằng tổng dư nợ còn lại theo Thỏa Thuận vay nhưng không quá số tiền bảo hiểm sau khi trừ đi phần đã thanh toán cho VFC.
									</span>
								</li>
								<li>
									<b><span>Người thụ hưởng thứ III:</span></b> <br>
									<span>
										Người được bảo hiểm hoặc Người thừa kế hợp pháp – được thanh toán số tiền bảo hiểm còn lại sau khi trừ đi phần đã thanh toán cho VFC và Bên Cho Vay.
									</span>
								</li>
							</ul>
							<p>
								<span>
									Bên Vay thừa nhận quyền và nghĩa vụ của mình theo Quy tắc bảo hiểm tai nạn nhóm người vay tín dụng (truy cập link: <a
											href="<?= ($contract->loan_infor->insurrance_contract == '1' && $contract->loan_infor->loan_insurance == '1' && $contract->loan_infor->amount_GIC > 0) ? "https://bit.ly/2GKEMFj" : (($contract->loan_infor->insurrance_contract == '1' && $contract->loan_infor->loan_insurance == '2' && $contract->loan_infor->amount_MIC > 0) ? "https://bit.ly/373BUhE" : "https://bit.ly/2GKEMFj"); ?>"><span
												style="color: black"><?= ($contract->loan_infor->insurrance_contract == '1' && $contract->loan_infor->loan_insurance == '1' && $contract->loan_infor->amount_GIC > 0) ? "https://bit.ly/2GKEMFj" : (($contract->loan_infor->insurrance_contract == '1' && $contract->loan_infor->loan_insurance == '2' && $contract->loan_infor->amount_MIC > 0) ? "https://bit.ly/373BUhE" : "https://bit.ly/2GKEMFj"); ?></span></a>) cùng các tài liệu sửa đổi, bổ sung (nếu có).
								</span>
							</p>
						</td>
						<td style="min-width:170px;">
							<p>
								<span style="color: black"> <?= (($contract->loan_infor->insurrance_contract == '1' && $contract->loan_infor->loan_insurance == '1' && $contract->loan_infor->amount_GIC > 0) || ($contract->loan_infor->insurrance_contract == '1' && $contract->loan_infor->loan_insurance == '2' && $contract->loan_infor->amount_MIC > 0) || (isset($contract->loan_infor->code_GIC_easy) && isset($contract->loan_infor->amount_GIC_easy) && $contract->loan_infor->amount_GIC_easy > 0)) ? "&#x2611;" : "☐" ?> Xác nhận tham gia</span>
							</p>
							<p>
								<span style="color: black;">   <?= (($contract->loan_infor->insurrance_contract == '1' && $contract->loan_infor->loan_insurance == '1' && $contract->loan_infor->amount_GIC > 0) || ($contract->loan_infor->insurrance_contract == '1' && $contract->loan_infor->loan_insurance == '2' && $contract->loan_infor->amount_MIC > 0) || (isset($contract->loan_infor->code_GIC_easy) && isset($contract->loan_infor->amount_GIC_easy) && $contract->loan_infor->amount_GIC_easy > 0)) ? "☐" : "&#x2611;" ?> Không đồng ý tham gia</span>
							</p>
						</td>
					</tr>

					<tr>
						<td>
							<p>

								<b><span>Bảo hiểm Phúc Lộc Thọ</span></b>
							</p>
							<p>
								<span>
									Bên Vay thừa nhận quyền và nghĩa vụ của mình theo Quy tắc bảo hiểm Sinh mạng cá nhân và bản Tóm lược nội dung bảo hiểm Phuc Lộc Thọ (ưu tiên áp dụng) (truy cập link: <a
											href="https://bit.ly/3iiSH3y"><span style="color: black">https://bit.ly/3iiSH3y</span></a>).
								</span>
							</p>
						</td>
						<td>
							<p>
								<span style="color: black"><?= (isset($contract->loan_infor->code_GIC_plt) && isset($contract->loan_infor->amount_GIC_plt) && in_array($contract->loan_infor->code_GIC_plt, array('COPPER'))) ? "&#x2611;" : "☐" ?> Xác nhận tham gia gói PHÚC</span>
							</p>
							<p>
								<span style="color: black"><?= (isset($contract->loan_infor->code_GIC_plt) && isset($contract->loan_infor->amount_GIC_plt) && in_array($contract->loan_infor->code_GIC_plt, array('SILVER'))) ? "&#x2611;" : "☐" ?> Xác nhận tham gia gói LỘC</span>
							</p>
							<p>
								<span style="color: black"><?= (isset($contract->loan_infor->code_GIC_plt) && isset($contract->loan_infor->amount_GIC_plt) && in_array($contract->loan_infor->code_GIC_plt, array('COPPER', 'SILVER', 'GOLD'))) ? "☐" : "&#x2611;" ?> Không đồng ý tham gia</span>
							</p>
						</td>
					</tr>

					</tbody>
				</table>


				<p>
					<span>
						<strong>Cam kết:</strong>
						Bên Vay cam kết rằng những kê khai là đầy đủ và trung thực. Bên Vay đang trong tình trạng sức khỏe bình thường, không đang trong quá trình điều trị bất kỳ bệnh tật nào, không có bệnh có sẵn, bệnh đặc biệt. Trường hợp, mắc bệnh bẩm sinh, khuyết tật, thương tật, thần kinh, động kinh, phong cùi, HIV hoặc đã từng mắc/đang điều trị các bệnh ung thư, u, bướu, cao/hạ huyết áp, các bệnh về tim mạch, các bệnh mạch máu não, đột quỵ, viêm gan, xơ gan, suy gan, suy tủy lao/suy phổi/tràn khí phổi, bệnh đái tháo đường, viêm thận, suy thận/tụy mãn tính, Parkinson, Lupus ban đỏ, Bên vay có trách nhiệm thông báo với Bên cho vay, VFC và Bên Bảo Hiểm để Bên Bảo Hiểm xem xét nhận bảo hiểm.</span>
				</p>

				<p><span>Hợp đồng bảo hiểm sẽ bị vô hiệu lực khi Bệnh lý của Bên Vay đã tồn tại trước ngày bắt đầu bảo hiểm mà Bên Vay không thông báo cho Bên Bảo hiểm.</span>
				</p>

				<p>
					<b>IV. THÔNG TIN TÀI SẢN ĐẢM BẢO (Nếu có)</b>
				</p>
				<p>
					Loại tài sản: <?= ($loai_tai_san) ? $loai_tai_san : '………………………..' ?> </br>
					Thửa đất số: <?= ($thua_dat_so) ? $thua_dat_so : '………………………..' ?>&nbsp; Tờ bản đồ
					số: <?= ($to_ban_do_so) ? $to_ban_do_so : '………………………..' ?> </br>
					Địa chỉ thửa đất: <?= ($dia_chi_thua_dat) ? $dia_chi_thua_dat : '………………………..' ?> </br>
					Diện tích: <?= ($dien_tich) ? $dien_tich : '………………………..' ?> m2 Hình thức sử dụng:
					riêng <?= ($hinh_thuc_su_dung_rieng) ? $hinh_thuc_su_dung_rieng : '………………………..' ?> m2,
					chung <?= ($hinh_thuc_su_dung_chung) ? $hinh_thuc_su_dung_chung : '………………………..' ?> m2 </br>
					Mục đích sử dụng: <?= ($muc_dich_su_dung) ? $muc_dich_su_dung : '………………………..' ?> </br>
					Thời hạn sử dụng: <?= ($thoi_han_su_dung) ? $thoi_han_su_dung : '………………………..' ?> năm</br>
					Nhà ở (nếu có): <?= ($nha_o) ? $nha_o : '………………………..' ?> </br>
					Giấy chứng nhận số: <?= ($giay_chung_nhan_so) ? $giay_chung_nhan_so : '………………………..' ?>
					do <?= ($noi_cap) ? $noi_cap : '………………………..' ?> </br>
					Cấp ngày: <?= ($ngay_cap) ? $ngay_cap : '………………………..' ?>&nbsp; Số vào
					sổ <?= ($so_vao_so) ? $so_vao_so : '………………………..' ?>
				</p>

			</div>


			<div class="col-12 mb-3">
				<i>* Các quy định chi tiết về Số Tiền Vay và quyền và nghĩa vụ của Các Bên trong Thỏa Thuận này sẽ được
					quy định tại Điều Khoản Chung. Điều Khoản Chung này là một phần không thể tách rời khỏi Thỏa Thuận
					và đã được Các Bên đọc, hiểu và đồng ý cam kết thực hiện.</i>
			</div>

			<div class="col-4">
				<p class=" text-center"><strong> BÊN CHO VAY</strong></p>
			</div>
			<div class="col-4">
				<p class=" text-center"><strong>BÊN VAY</strong></p>
			</div>
			<div class="col-4">
				<p class=" text-center"><strong>ĐẠI DIỆN VFC</strong></p>
			</div>
		</div>
	</div>

</section>

<section>

	<div class="container">
		<div class="divHeader"><img src="https://tienngay.vn/assets/home/images/logo.png" alt=""></div>
		<div class="row">
			<div class="col-12 mt-3">
				<h1 style="font-weight:bold;font-size:18px;">ĐIỀU KHOẢN CHUNG</h1>
			</div>

			<div class="col-12">
				<div class="dieukhoan">
					<p class="p-0">
						<b><span>MỤC I. QUY ĐỊNH CHUNG</span></b>
					</p>
					<p class="p-0">
						<b><span>Điều 1. Định nghĩa</span></b>
					</p>
					<p>
						<span>1.1.</span>
						<span>“Số Tiền Đề Nghị Vay”: Là số tiền mà Bên Vay mong muốn vay được từ Bên Cho Vay.</span>
					</p>
					<p>
						<span>1.2.</span>
						<span>“Số Tiền Vay”: Là số tiền mà Bên Cho Vay đồng ý cho Bên Vay vay và tiến hành giải ngân cho Bên Vay thông qua VFC.</span>
					</p>
					<p>
						<span>1.3.</span>
						<span>“Ngày Giải Ngân”: Là ngày Bên Cho Vay hoặc Bên ủy quyền của Bên Cho Vay chuyển toàn bộ Số Tiền Vay cho Bên Vay.</span>
					</p>
					<p>
						<span>1.4.</span>
						<span>
                      “Số Tiền Giải Ngân”: Là số tiền thực tế Bên Cho Vay và/hoặc VFC  chuyển khoản cho Bên Vay sau khi trừ đi Phí Bảo Hiểm theo quy định tại Thỏa Thuận này.
                    </span>
					</p>
					<p>
						<span>1.5.</span>
						<span>
                      “Lãi Suất”: Là lãi suất áp dụng cho Số Tiền Vay theo một tỷ lệ được quy định tại Thỏa Thuận này. Lãi Suất được tính theo năm với cơ sở một năm có 365 ngày.
                    </span>
					</p>
					<p>
						<span>1.6.</span>
						<span>
                      “Tiền Lãi”: Là số tiền lãi được tính dựa trên dư nợ thực tế của Số Tiền Vay, được tính dựa trên Lãi Suất và số ngày vay thực tế đối với phần Số Tiền Vay chưa thanh toán kể từ Ngày Giải Ngân.
                    </span>
					</p>
					<p>
						<span>1.7.</span>
						<span>
                      “Phí Trả Nợ Trước Hạn”: Là khoản phí Bên Vay phải trả cho Bên Cho Vay, áp dụng tại mọi thời điểm Bên Vay thanh toán vượt quá số tiền gốc phải trả theo lịch trả nợ và/hoặc Thông Báo. Số tiền vượt quá đó được coi là Nợ Gốc
                      Trả Trước Hạn.
                    </span>
					</p>
					<p>
						<span>1.8.</span>
						<span>
                      “Phí Quản Lý Số Tiền Vay Chậm Trả”: Là khoản phí Bên Vay phải trả cho VFC, áp dụng trong trường hợp Bên Vay không thanh toán đúng hạn các nghĩa vụ cần thanh toán phát sinh theo quy định tại Thỏa Thuận này.
                    </span>
					</p>
					<p>
						<span>1.9.</span>
						<span>
                      “Phí Thẩm Định và Lưu Trữ Tài Sản Đảm Bảo”: Là khoản phí Bên Vay phải trả cho VFC, áp dụng trọng trường hợp có Tài Sản Đảm Bảo và VFC được Bên Cho Vay chỉ định nhận, quản lý và bảo quản Tài Sản Đảm Bảo.
                    </span>
					</p>
					<p>
						<span>1.10.</span>
						<span>
                      “Phí Tư Vấn Gia Hạn Số Tiền Vay”: Là khoản phí Bên Vay phải trả cho VFC, áp dụng trong trường hợp Bên Vay có nhu cầu gia hạn thời hạn vay Số Tiền Vay theo Thỏa Thuận này.
                    </span>
					</p>
					<p>
						<span>1.11.</span>
						<span>"Dịch Vụ Tư Vấn Quản Lý”: Là các dịch vụ tư vấn quản lý mà VFC cung cấp cho Bên Vay theo quy định tại Thỏa Thuận này.</span>
					</p>
					<p>
						<span>1.12.</span>
						<span>
                      “Phí Tư Vấn Quản Lý”: Là khoản phí mà Bên Vay phải trả cho VFC để VFC cung cấp Dịch Vụ Tư Vấn Quản Lý cho Bên Vay. Khoản Phí này được thanh toán hàng tháng.
                    </span>
					</p>
					<p>
						<span>1.13.</span>
						<span>
                      “Số Tiền Phải Thanh Toán”: Là tổng số tiền mà Bên Vay phải thanh toán đúng hạn cho Bên Cho Vay theo Thỏa Thuận, bao gồm nhưng không giới hạn Số Tiền Vay, tiền lãi và các chi phí khác phát sinh.
                    </span>
					</p>
					<p>
						<span>1.14.</span>
						<span>
                      “Thông Báo”: Là bất kỳ thông báo hoặc cách thể hiện nào cung cấp thông tin từ Bên Cho Vay/VFC đến Bên Vay liên quan đến việc thực hiện Thỏa Thuận này. Thông Báo có thể thể hiện dưới dạng tin nhắn điện thoại hoặc email
                      hoặc văn bản tùy từng trường hợp.
                    </span>
					</p>
					<p>
						<span>1.15.</span>
						<span>“Bên Bảo Hiểm”: Là đơn vị kinh doanh dịch vụ bảo hiểm hợp tác với VFC để cung cấp cho Bên Vay các sản phẩm bảo hiểm.</span>
					</p>
					<p>
						<span>1.16.</span>
						<span>
                      “Phí Bảo Hiểm”: Là khoản tiền Bên Vay phải trả khi mua bảo hiểm liên quan đến Khoản Vay của Bên Bảo Hiểm thông qua VFC, bằng cách chỉ định cho VFC khấu trừ Phí Bảo Hiểm từ Khoản Vay tại Ngày Giải Ngân để thanh toán cho
                      Bên Bảo Hiểm.
                    </span>
					</p>
					<p class="p-0">
						<b><span>Điều 2. Mục đích của Thỏa Thuận</span></b>
					</p>
					<p>
						<span></span>
						<span>
                      Các Bên đồng ý rằng, dựa trên sự tư vấn của VFC, Bên Cho Vay cho Bên Vay vay Số Tiền Vay. Bên Vay đồng ý đồng thời mua bảo hiểm liên quan đến Khoản Vay của Bên Bảo Hiểm thông qua VFC với quy định cụ thể tại Thỏa Thuận
                      này. Theo đó, mối quan hệ độc lập giữa hai trong Các Bên tại Thỏa Thuận này được thể hiện như sau:
                    </span>
					</p>
					<p>
						<span>2.1.</span>
						<span>
                      Bên Cho Vay đồng ý cho Bên Vay vay một khoản tiền bằng Số Tiền Vay. Quy định chi tiết về Số Tiền Vay tại Mục II Điều Khoản Chung này.
                    </span>
					</p>
					<p>
						<span>2.2.</span>
						<span>Bên Vay chỉ định sử dụng Dịch Vụ Tư Vấn Quản Lý của VFC theo quy định chi tiết tại Mục III Điều Khoản Chung này.</span>
					</p>
					<p>
						<span>2.3.</span>
						<span>
                      Bên Cho Vay chỉ định VFC đại diện Bên Cho Vay nhận, bảo quản Tài Sản Đảm Bảo (nếu có) và các giấy tờ liên quan đến Tài Sản Đảm Bảo từ Bên Vay. Thỏa thuận về việc hợp tác này chi tiết tại hợp đồng hợp tác giữa hai bên.
                    </span>
					</p>
					<p class="p-0">
						<b><span>MỤC II. THỎA THUẬN GIỮA BÊN CHO VAY VÀ BÊN VAY</span></b>
					</p>
					<p class="p-0">
						<b><span>Điều 3. Thỏa thuận vay</span></b>
					</p>
					<p>
						<span>3.1.</span>
						<span>Bên Cho Vay đồng ý và Bên Vay đồng ý vay một số tiền tương ứng Số Tiền Vay từ Bên Cho Vay. </span>
					</p>
					<p>
						<span>3.2.</span>
						<span>Tiền lãi được tính theo công thức sau:</span>
						<span>Tiền lãi = ∑ (Dư nợ thực tế từng thời điểm của Số Tiền Vay x Lãi Suất/365 x Số ngày vay tương ứng Dư nợ thực tế từng thời điểm)</span>
					</p>
					<p>
						<span>3.3.</span>
						<span>Nghĩa vụ thanh toán: Bên Vay có nghĩa vụ thanh toán đầy đủ Số Tiền Phải Thanh Toán cho Bên Cho Vay thông qua VFC (theo chỉ định của Bên Cho Vay). Bên Vay thanh toán theo tờ Hướng dẫn thanh toán đính kèm Thỏa Thuận này.</span>
					</p>
					<p>
						<span>3.4.</span>
						<span>
                      Gia hạn Số Tiền Vay: Trường hợp Bên Vay muốn gia hạn Số Tiền Vay thì Bên Vay phải gửi đề nghị gia hạn cho VFC để VFC thông báo cho Bên Cho Vay. Số Tiền Vay chỉ được gia hạn khi có sự chấp thuận bằng Thông Báo đến Bên Vay
                      của Bên Cho Vay.
                    </span>
					</p>
					<p>
						<span>3.5.</span>
						<span>
                      Phí Trả Nợ Trước Hạn: Tại bất kỳ thời điểm nào của Thỏa Thuận, Bên Vay có thể trả trước một phần hoặc toàn bộ Số Tiền Vay kèm phí trả nợ trước hạn bằng […]% Nợ Gốc Trả Trước Hạn. Phí Trả Nợ Trước Hạn được thanh toán cùng
                      thời điểm Bên Vay thanh toán Số Tiền Vay trước hạn cho Bên Cho Vay.
                    </span>
					</p>
					<p class="p-0">
						<b><span>Điều 4. Quyền và nghĩa vụ của Bên Cho Vay</span></b>
					</p>
					<p>
						<span>4. 1.</span>
						<span>
                      Quyết định việc giải ngân Số Tiền Vay theo đề nghị của Bên Vay thông qua cách thức mà Bên Cho Vay cho là phù hợp tùy từng thời điểm. Khi thực hiện các công việc liên quan đến giải ngân Số Tiền Vay, Bên Cho Vay/Bên được
                      ủy quyền của Bên Cho Vay được toàn quyền ghi âm lại bất kỳ nội dung nào trao đổi qua điện thoại giữa Bên Cho Vay và Khách Hàng, Khách Hàng tại đây thừa nhận và đồng ý rằng dữ liệu ghi âm đó là bằng chứng chứng minh
                      việc Khách Hàng cam kết thực hiện các nghĩa vụ liên quan đến Thỏa Thuận này.
                    </span>
					</p>
					<p>
						<span>4. 2.</span>
						<span>
                      Tiền lãi Bên Cho Vay được hưởng là tiền lãi chưa bao gồm thuế, Bên Cho Vay tự thực hiện kê khai và nộp thuê thu nhập cá nhân theo đúng quy định của pháp luật.
                    </span>
					</p>
					<p>
						<span>4. 3.</span>
						<span>Yêu cầu Bên Vay phải thanh toán đầy đủ và đúng hạn Số Tiền Phải Thanh Toán theo Thỏa Thuận này.</span>
					</p>
					<p>
						<span>4. 4.</span>
						<span>Tuân thủ các quy định đã cam kết trong Thỏa Thuận.</span>
					</p>
					<p class="p-0">
						<b>
							<br>
							<br>
							<br>
							<br>
							<span>Điều 5. Quyền và nghĩa vụ của Bên Vay</span></b>
					</p>
					<p>
						<span>5.1.</span>
						<span>
                      Được đề nghị gia hạn Số Tiền Vay với điều kiện thanh toán đầy đủ và đúng hạn tiền lãi và các khoản phí phát sinh từ Thỏa Thuận này theo Thông Báo.
                    </span>
					</p>
					<p>
						<span>5.2.</span>
						<span>Thực hiện đầy đủ nghĩa vụ thanh toán khi đến hạn theo quy định tại Thỏa Thuận.</span>
					</p>
					<p>
						<span>5.3.</span>
						<span>Được chuyển giao cho bên thứ ba thực hiện một phần hoặc toàn bộ nghĩa vụ thanh toán nếu hai bên có thỏa thuận mà không cần sự chấp thuận của Bên Cho Vay.</span>
					</p>
					<p>
						<span>5.4.</span>
						<span>Tuân thủ các quy định của pháp luật hiện hành liên quan đến việc thực hiện các nghĩa vụ của Bên Vay.</span>
					</p>
					<p class="p-0">
						<b><span>Điều 6. Sự Kiện Vi Phạm</span></b>
					</p>
					<p>
						<span>6. 1.</span>
						<span>Mỗi sự kiện hoặc trường hợp trong các sự kiện/ trường hợp quy định sau đây được xem là một Sự Kiện Vi Phạm:</span>
					</p>
					<p>
						<span>a.</span>
						<span>
                      Bên Vay không tuân thủ bất kỳ quy định nào của Thỏa Thuận này hoặc Thông Báo hoặc văn bản, tài liệu khác liên quan đến Thỏa Thuận;
                    </span>
					</p>
					<p>
						<span>b.</span>
						<span>Bên Vay cung cấp các thông tin hoặc giấy tờ liên quan đến Số Tiền Vay không đúng, không chính xác, không trung thực; </span>
					</p>
					<p>
						<span>c.</span>
						<span>Bên Vay không thanh toán đúng hạn bất kỳ khoản đến hạn nào trong Số Tiền Phải Thanh Toán.</span>
					</p>
					<p>
						<span>6. 2.</span>
						<span>Ngay khi và sau khi xảy ra một Sự Kiện Vi Phạm, Bên Cho Vay có quyền:</span>
					</p>
					<p>
						<span>a.</span>
						<span>Tuyên bố đến hạn thanh toán ngay Số Tiền Phải Thanh Toán; </span>
					</p>
					<p>
						<span>b.</span>
						<span>Thu giữ và tiến hành xử lý Tài Sản Đảm Bảo (nếu có) theo quy định tại Thỏa Thuận;</span>
					</p>
					<p>
						<span>c.</span>
						<span>Chấm dứt tất cả các nghĩa vụ của Bên Cho Vay đối với Bên Vay theo Thỏa Thuận; </span>
					</p>
					<p>
						<span>d.</span>
						<span>Thực hiện tất cả các quyền và chế tài hợp lý của Bên Cho Vay theo quy định tại Thỏa Thuận này.</span>
					</p>
					<p class="p-0">
						<b><span>Điều 7. Thỏa thuận về biện pháp đảm bảo</span></b>
					</p>
					<p>
						<span>7.1.</span>
						<span>
                      Bên Vay và Bên Cho Vay đồng ý lựa chọn biện pháp đảm bảo là cầm cố tài sản thuộc sở hữu của Bên Vay để đảm bảo nghĩa vụ thanh toán Số Tiền Vay của Bên Vay đối với Bên Cho Vay <b>(“Tài Sản Đảm Bảo”)</b>.
                    </span>
					</p>
					<p>
						<span>7.2.</span>
						<span>
                      Ngay sau khi Bên Cho Vay đã giải ngân Số Tiền Vay cho Bên Vay, Bên Vay chuyển giao Tài Sản Đảm Bảo và các giấy tờ liên quan đến Tài Sản Đảm Bảo (bản gốc) cho Bên Cho Vay hoặc cho bên được Bên Cho Vay chỉ định. Trong Thời Hạn
                      Vay, Bên Cho Vay hoặc bên được Bên Cho Vay chỉ định giữ Tài Sản Đảm Bảo cho Bên Vay.
                    </span>
					</p>
					<p>
						<span>7.3.</span>
						<span>
                      Trong trường hợp Tài Sản Đảm Bảo là xe máy, ô tô hoặc các phương tiện di chuyển cá nhân khác, Bên Vay có thể giữ lại Tài Sản Đảm Bảo để sử dụng (nếu có nhu cầu) và sẽ bàn giao lại toàn bộ bản gốc các giấy tờ liên quan
                      đến Tài Sản Đảm Bảo cho Bên Cho Vay.
                    </span>
					</p>
					<p>
						<span>7.4.</span>
						<span>
                      Bên Cho Vay sẽ chuyển giao lại Tài Sản Đảm Bảo cùng các giấy tờ mà Bên Cho Vay đã nhận cho Bên Vay khi Bên Vay hoàn thành tất cả nghĩa vụ tài chính theo Thỏa Thuận này hoặc Bên Vay có nhu cầu thay thế một Tài Sản Đảm Bảo
                      khác cho Số Tiền Vay.
                    </span>
					</p>
					<p>
						<span>7.5.</span>
						<span>Xử lý Tài Sản Đảm Bảo:</span>
					</p>
					<p>
						<span></span>
						<span>
                      Ngay khi và sau khi xảy ra một Sự Kiện Vi Phạm (bao gồm nhưng không giới hạn: chậm thực hiện, thực hiện không đúng, không đầy đủ nghĩa vụ thanh toán,…) được quy định tại Thỏa Thuận này
                    <ins cite="mailto:LAN" datetime="2020-10-14T22:38"> </ins>VFC có toàn quyền xử lý Tài Sản Đảm Bảo theo quy định của pháp luật

                    (như Tự bán tài sản Đảm Bảo,...) để trừ vào Số Tiền Phải Thanh Toán của Bên Vay.</span>

					</p>
					<p class="p-0">
						<b><span>Điều 8. Cam kết của Bên Vay về Tài Sản Đảm Bảo</span></b>
					</p>
					<p>
						<span>8.1.</span>
						<span>
                      Bên Vay cam kết tại thời điểm ký Thỏa Thuận này, Tài Sản Đảm Bảo thuộc quyền sở hữu và/hoặc quyền sử dụng, quyền định đoạt hợp pháp của Bên Vay, có nguồn gốc hợp pháp, không bị cơ quan nhà nước có thẩm quyền xử lý theo quy định của pháp luật, đang không bị
                      tranh chấp, thế chấp, cầm cố, bảo lãnh với bên thứ ba nào.
                    </span>
					</p>
					<p>
						<span>8.2.</span>
						<span>
                      Cam kết vô điều kiện và không hủy ngang việc chịu trách nhiệm bồi thường thiệt hại cho Bên Cho Vay hoặc bên thứ ba trong trường hợp phát sinh bất kỳ thiệt hại, kiện đòi, mất mát, hư tổn, chi phí nào liên quan đến Tài Sản
                      đảm bảo và việc giao Tài Sản Đảm Bảo; và đồng ý rằng Bên Cho Vay được loại trừ khỏi tất cả các trách nhiệm nêu trên.
                    </span>
					</p>
					<p>
						<span>8.3.</span>
						<span>
                      Cam kết cung cấp và/hoặc bổ sung và/hoặc xuất trình bằng chứng về quyền sở hữu và/hoặc quyền sử dụng, quyền định đoạt của Bên Vay đối với Tài Sản Đảm Bảo và/hoặc nguồn gốc của Tài Sản Đảm Bảo theo yêu cầu của Bên Cho Vay; Cam kết bổ sung, thay thế bất kỳ tài
                      sản nào khác Tài Sản Đảm Bảo để đảm bảo nghĩa vụ thanh toán Số Tiền Vay theo Thỏa Thuận tại bất kỳ thời điểm nào mà Bên Cho Vay cho là cần thiết.
                    </span>
					</p>
					<p class="p-0">
						<b><span>MỤC III. THỎA THUẬN GIỮA BÊN VAY VÀ VFC</span></b>
					</p>
					<p class="p-0">
						<b><span>Điều 9. Dịch Vụ Tư Vấn Quản Lý</span></b>
					</p>
					<p>
						<span>9.1.</span>
						<span>Bên Vay chỉ định và VFC đồng ý cung cấp Dịch Vụ Tư Vấn Quản Lý với nội dung cụ thể của Dịch Vụ như sau:</span>
					</p>
					<p>
						<span>a.</span>
						<span>Tư Vấn Quản Lý;</span>
					</p>
					<p>
						<span>b.</span>
						<span>Thẩm định và lưu trữ Tài Sản Đảm Bảo/giầy tờ của Tài Sản Đảm Bảo;</span>
					</p>
					<p>
						<span>c.</span>
						<span>Quản lý khoản vay</span>
					</p>
					<p>
						<span>d.</span>
						<span>Các dịch vụ khác theo thỏa thuận giữa Bên Vay và VFC nếu Bên Vay có nhu cầu.</span>
					</p>
					<p>
						<span>9.2.</span>
						<span>
                      Bên Vay sẽ thanh toán Phí Tư Vấn Quản Lý, Phí Quản Lý Số Tiền Vay Chậm Trả (nếu có) cho VFC theo quy định tại Thỏa Thuận này và chính sách cụ thể của VFC.
                    </span>
					</p>
					<p class="p-0">
						<b><span>Điều 10. Phí Tư Vấn Quản Lý và Phí Quản Lý Số Tiền Vay Chậm Trả</span></b>
					</p>
					<p>
						<span>10.1.</span>
						<span>
                      Phí Tư Vấn Quản Lý đối với Số Tiền Vay được quy định tại Thỏa Thuận này đã bao gồm VAT. Bên Vay và VFC đồng ý rằng Phí Tư Vấn Quản Lý cụ thể sẽ được quy định cụ thể tại Thông Báo Đến Bên Vay theo chính sách phí do VFC áp
                      dụng tại từng thời điểm.
                    </span>
					</p>
					<p>
						<span>10.2.</span>
						<span>Điều kiện thu Phí Tư Vấn Quản Lý: Phí Tư Vấn Quản Lý được thu khi Số Tiền Vay được giải ngân thành công cho Bên Vay.</span>
					</p>
					<p>
						<span>10.3.</span>
						<span>
                      Thanh toán Phí Tư Vấn Quản Lý: Bên Vay thanh toán Phí Tư Vấn Quản Lý hàng tháng cho VFC. Phí Tư Vấn Quản Lý sẽ được VFC tính vào Số Tiền Phải Thanh Toán của Bên Vay hàng tháng và Bên Vay sẽ tiến hành thanh toán vào ngày
                      được nêu tại Thông Báo của VFC.
                    </span>
					</p>
					<p>
						<span>10.4.</span>
						<span>
                      Phí Quản Lý Số Tiền Vay Chậm Trả: Phí Quản Lý Số Tiền Vay Chậm Trả được tính là […] cho mỗi lần Bên Vay thanh toán không đúng hạn Số Tiền Phải Thanh Toán quy định tại Thỏa Thuận này. Phí Quản Lý Số Tiền Vay Chậm Trả sẽ
                      áp dụng cho đến khi Bên Vay hoàn thành các nghĩa vụ thanh toán.
                    </span>
					</p>
					<p class="p-0">
						<b><span>Điều 11. Cam kết dịch vụ bảo hiểm</span></b>
					</p>
					<p>
						<span>11.1.</span>
						<span>
                      Bên Vay sau đây đồng ý VFC là đại lý của Bên Bảo Hiểm, VFC có nghĩa vụ: (a) Tư vấn cho Bên Vay sản phẩm bảo hiểm, Phí Bảo Hiểm, các thông tin liên quan; (b) Hỗ trợ Bên Vay chuẩn bị hồ sơ bảo hiểm và thu, nộp Phí Bảo Hiểm cho Bên Bảo Hiểm; (c) Các công việc khác theo quy định của pháp luật thuộc nghĩa vụ của đại lý bảo hiểm cũng như thỏa thuận giữa VFC và Bên Bảo Hiểm.
                    </span>
					</p>
					<p>
						<span>11.2.</span>
						<span>
                       Phí Bảo Hiểm được xác định tại Ngày Giải Ngân. Bên Vay chỉ định VFC được quyền khấu trừ khoản Phí Bảo Hiểm tương ứng với Số Tiền Vay để thanh toán cho Bên Bảo Hiểm ngay tại thời điểm Giải ngân Khoản Vay.
                    </span>
					</p>
					<p class="p-0">
						<b><span>Điều 12. Cam kết dịch vụ bảo hiểm</span></b>
					</p>
					<p>
						<span>12.1.</span>
						<span>
                      Trường hợp Bên Vay thực hiện không đúng, không đầy đủ nghĩa vụ thanh toán Số Tiền Vay đối với Bên Cho Vay, VFC chịu trách nhiệm thực hiện nghĩa vụ này nếu hai bên có thỏa thuận mà không cần sự chấp thuận của Bên cho vay.
                    </span>
					</p>
					<p>
						<span>12.2.</span>
						<span>
                       Thỏa thuận giữa VFC và Bên Vay phải lập thành văn bản, được đóng dấu, ký bởi người đại diện hợp pháp của các bên.
                    </span>
					</p>
					<p>
						<b><span>MỤC IV. QUY ĐỊNH KHÁC</span></b>
					</p>
					<p>
						<b><span>Điều 13. Thông Báo đến Bên Vay</span></b>
					</p>
					<p>
						<span>13.1.</span>
						<span>
                      Bên Vay tại đây xác nhận đồng ý chịu sự ràng buộc và tuân thủ các Thông Báo đến Bên Vay trong mọi trường hợp. Bất kỳ Thông Báo nào được gửi bằng hình thức tin nhắn đến số điện thoại đã đăng ký của Bên Vay sẽ được coi là
                      đã gửi và Bên Vay đã nhận được.
                    </span>
					</p>
					<p>
						<span>13.2.</span>
						<span>
                      Thông Báo là phần không thể tách rời của Thỏa Thuận này. Trong trường hợp Thông Báo vì lý do nào đó có một hoặc một vài thông tin bị lỗi và/hoặc sai sót, VFC và/hoặc Bên Cho Vay được quyền đính chính, chỉnh sửa thông tin
                      đó bằng việc gửi một Thông Báo khác đến Bên Vay.
                    </span>
					</p>
					<p class="p-0">
						<b><span>Điều 14. Thuế, Phí</span></b>
					</p>
					<p>
						<span></span>
						<span>
                      Mỗi Bên sẽ tự chịu trách nhiệm kê khai, nộp các khoản thuế, phí phát sinh thuộc trách nhiệm của mình liên quan đến việc thực hiện Thỏa Thuận này tại cơ quan nhà nước có thẩm quyền.
                    </span>
					</p>
					<p class="p-0">
						<b><span>Điều 15. Sự kiện bất khả kháng</span></b>
					</p>
					<p>
						<span></span>
						<span>
                      Sự kiện bất khả kháng là sự kiện xảy ra một cách khách quan không thể lường trước được và không thể khắc phục được mặc dù đã áp dụng mọi biện pháp cần thiết và khả năng cho phép. Trường hợp Bên có nghĩa vụ không thực
                      hiện nghĩa vụ do sự kiện bất khả kháng thì không phải bồi thường thiệt hại đối với Bên có quyền, trừ trường hợp pháp luật có quy định khác. Bên có nghĩa vụ phải lập tức thông báo ngay cho Bên có quyền biết về việc không
                      thực hiện được nghĩa vụ do sự kiện bất khả kháng. Trường hợp sự kiện bất khả kháng không ảnh hưởng đối với Bên nào thì Bên đó vẫn phải tiếp tục thực hiện các nghĩa vụ, cam kết của mình đối với Bên có quyền theo quy định
                      tại Thỏa Thuận này.
                    </span>
					</p>
					<p class="p-0">
						<b><span>Điều 16. Bồi thường thiệt hại, Phạt vi phạm</span></b>
					</p>
					<p>
						<span>16.1.</span>
						<span>
                       Trừ khi xảy ra Sự kiện bất khả kháng theo Thỏa Thuận này, trường hợp một Bên không thực hiện, thực hiện không đúng, không đầy đủ bất kỳ nghĩa vụ nào đến hạn theo quy định tại Thỏa Thuận, Bên vi phạm ngay lập tức
                      phải chấm dứt vi phạm của mình, khắc phục những hậu quả do hành vi vi phạm trong một thời gian nhất định được yêu cầu bởi Bên bị vi phạm, đồng thời chịu phạt với mức tối đa 8% (tám phần trăm) giá trị phần nghĩa vụ bị vi phạm;
                    </span>
					</p>
					<p>
						<span>16.2. </span>
						<span>Trường hợp có thiệt hại, Bên vi phạm phải bồi thường toàn bộ thiệt hại phát sinh cho Bên bị vi phạm.</span>
					</p>
					<p class="p-0">
						<b><span>Điều 17. Luật áp dụng, giải quyết tranh chấp</span></b>
					</p>
					<p>
						<span>17.1.</span>
						<span>Thỏa Thuận này được điều chỉnh theo quy định của pháp luật Việt Nam.</span>
					</p>
					<p>
						<span>17.2.</span>
						<span>
                      Bất kỳ tranh chấp nào phát sinh từ hoặc liên quan đến Thỏa Thuận này trước tiên phải được giải quyết trên cơ sở thương lượng, hòa giải. Nếu không giải quyết được bằng thương lượng, hòa giải, Các Bên có thể đưa tranh chấp
                      ra Tòa án có thẩm quyền của Việt Nam để giải quyết, án phí do bên thua chịu trách nhiệm chi trả.
                    </span>
					</p>
					<p class="p-0">
						<b><span>Điều 18. Các điều khoản khác</span></b>
					</p>
					<p>
						<span>18.1.</span>
						<span>
                      VFC được quyền gửi thông báo tới khách hàng đã và đang sử dụng dịch vụ của VFC thông tin về sản phẩm hay bất kể dịch vụ nào của VFC thông qua các phương tiện truyền tải thông tin, bao gồm nhưng không giới hạn: tin nhắn,
                      cuộc gọi, thư điện tử,... trong khung giờ từ 08 giờ 00 tới 21 giờ 00 hàng ngày.
                    </span>
					</p>
					<p>
						<span>18.2.</span>
						<span>
                      Bên Vay cam kết và thừa nhận rằng bất kỳ thông tin nào do Bên Vay cung cấp trong quá trình giao kết và thực hiện Thỏa Thuận là chính xác, trung thực. Bên Vay có trách nhiệm thông báo cho Bên Cho Vay và VFC ngay khi có
                      thay đổi về bất kỳ thông tin nào của Bên Vay.
                    </span>
					</p>
					<p>
						<span>18.3.</span>
						<span>
                      Bên Vay bằng văn bản này đồng ý và cho phép Bên Cho Vay và/hoặc VFC được sử dụng, mã hóa, truyền tải, lưu trữ; chuyển giao và tiết lộ bất cứ thông tin nào liên quan đến Bên Vay và/hoặc do Bên Vay cung cấp và/hoặc vấn đề,
                      tài liệu liên quan đến Thỏa Thuận này cho bất kỳ bên thứ ba nào tại bất cứ thời điểm nào mà Bên Cho Vay và/hoặc VFC cho là phù hợp và cần thiết trong phạm vi pháp luật cho phép mà không phải có thêm một sự chấp thuận nào
                      khác của Bên Vay, đồng thời không phải chịu trách nhiệm với Bên Vay liên quan đến các hành vi này.
                    </span>
					</p>
					<p>
						<span>18.4.</span>
						<span>
                      Toàn bộ các quyền, nghĩa vụ của VFC và Bên cho vay được hai bên đảm bảo thực thiện theo quy định chi tiết tại Hợp đồng hợp tác giữa hai bên.
                    </span>
					</p>
					<p>
						<span>18.5.</span>
						<span>
                      Trong quá trình thực hiện Thỏa Thuận, Các Bên có thể yêu cầu sửa đổi, bổ sung Thỏa Thuận. Việc sửa đổi, bổ sung Thỏa Thuận này phải được Các Bên đồng ý và lập thành văn bản dưới hình thức phụ lục và phải được xác nhận
                      bằng chữ ký của đại diện Các Bên.
                    </span>
					</p>
					<p>
						<span>18.6.</span>
						<span>
                      Thỏa Thuận được chấm dứt khi các Bên đã hoàn thành tất cả các nghĩa vụ của hoặc tự động chấm dứt khi Bên Cho Vay hoặc Bên ủy quyền của Bên Cho Vay không thực hiện giải ngân và/hoặc Thông Báo đến Bên Vay về việc không
                      giải ngân Số Tiền Vay.
                    </span>
					</p>
					<p>
						<span>18.7.</span>
						<span>
                      Nếu bất kỳ điều khoản nào của Thỏa Thuận này trở thành bất hợp pháp hoặc không thể thi hành theo quy định của pháp luật Việt Nam, thì tính hợp pháp hoặc tính bắt buộc của những điều khoản còn lại của Thỏa Thuận này sẽ
                      không vì thế mà bị ảnh hưởng hay mất hiệu lực và Các Bên vẫn có nghĩa vụ thực hiện.
                    </span>
					</p>
					<p>
						<span>18.8.</span>
						<span>Các Bên thừa nhận rằng việc giao kết Thỏa Thuận này là hoàn toàn tự nguyện, không bị lừa dối hoặc ép buộc.</span>
					</p>
				</div>
			</div>
		</div>
	</div>
</section>

<section style="font-size:17pt">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-6">
				<div class="divHeader"><img src="https://tienngay.vn/assets/home/images/logo.png" alt=""></div>
			</div>

			<div class="col-6" style="font-size:16px">
				<strong>Công ty Cổ phần Công nghệ Tài chính Việt</strong> <br>
				Tầng 15, khối B, toà nhà Sông Đà, đường Phạm Hùng, Nam Từ Liêm, Hà Nội <br>
				Website: https://tienngay.vn/
			</div>


		</div>
		<hr style="border-top:2px solid #000">
		<div class="row justify-content-center">

			<div class="col-12 text-center mb-3">
				<p align=center style='margin:0in;margin-bottom:.0001pt;text-align:center'><strong><span
								style='font-size:16.0pt;color:black'>&nbsp;</span></strong></p>

				<p align=center style='margin:0in;margin-bottom:.0001pt;text-align:center'><b><span
								style='font-size:28pt;color:black'>HƯỚNG DẪN THANH TOÁN VFC</span></b></p>

				<p class=MsoNormal style='margin-bottom:6.0pt;text-align:justify'><b><span
								lang=VI style='font-size:17pt;line-height:115%;font-family:"Times New Roman",serif'>&nbsp;</span></b>
				</p>

				<p class=MsoNormal style='text-align:justify'><span lang=VI style='font-size:
																17pt;line-height:115%;font-family:"Times New Roman",serif'>Khi đến hạn thanh
																toán, quý khách có thể thanh toán khoản vay qua những hình thức sau:  </span>
				</p>

				<p class=MsoNormal style='margin-top:5.0pt;margin-left:64px;margin-bottom:10.0pt;
																margin-left:64px;line-height:normal'><b><i><span lang=VI
																												 style='font-size:
																	17pt;font-family:"Times New Roman",serif'>1. <u>Thanh toán tiền mặt tại quầy
																		giao dịch của Tienngay.vn</u> </span></i></b>
				</p>

				<p class=MsoNormal style='margin-top:5.0pt;margin-right:64px;margin-bottom:10.0pt;
																		margin-left:64px;line-height:normal'>
					<b><i><u><span lang=VI style='font-size:
																			17pt;font-family:"Times New Roman",serif'>2. Thanh toán qua chuyển khoản
																			online bằng e banking, mobile banking, ATM online</span></u></i></b>
				</p>

				<p class=MsoNormal style='margin-top:5.0pt;margin-right:64px;margin-bottom:10.0pt;
																			margin-left:64px;line-height:normal'>
					<b><i><u><span lang=VI style='font-size:
																				17pt;font-family:"Times New Roman",serif'>3. Thanh toán tại các ngân hàng vào
																				tài khoản của VFC</span></u></i></b></p>
				<p class=MsoNormal style='margin-top:5.0pt;margin-right:64px;margin-bottom:10.0pt;
																			margin-left:64px;line-height:normal'>
					<b><i><u><span lang=VI style='font-size:
																				17pt;font-family:"Times New Roman",serif'>4. Thanh toán qua MoMo App</span></u></i></b></p>
				<p class=MsoNormal style='text-align:justify;line-height:22.5pt'><span lang=VI
																					   style='font-size:17pt;font-family:"Times New Roman",serif;color:#212529'>Chủ
																					Tài Khoản:  <b>Công Ty Cổ Phần Công Nghệ Tài Chính Việt</b> (VFC)</span>
				</p>

				<p class=MsoNormal style='text-align:justify;line-height:22.5pt;margin:15px 0;'><b><u><span
									lang=VI style='font-size:17pt;font-family:"Times New Roman",serif;color:#212529'>Nội
																						dung chuyển khoản theo cú pháp</span></u></b><span
							lang=VI style='font-size:
																						17pt;font-family:"Times New Roman",serif;color:#212529'> : </span><span
							style='font-size:17pt;font-family:"Times New Roman",serif;color:#212529;
																						background:yellow'>VFC<?= !empty($contract->number_contract) ? (int)$contract->number_contract : ""; ?>VFC</span><span
							style='font-size:17pt;
																						font-family:"Times New Roman",serif;color:#212529;background:yellow'> </span><span
							style='font-size:17pt;font-family:"Times New Roman",serif;color:#212529;
																						background:yellow'></span></p>

				<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
					   style='border-collapse:collapse;border:none;width:100%;'>
					<tr>
						<td width=40 valign=top style='width:29.7pt;border:solid windowtext 1.0pt;
																							padding:0in 5.4pt 0in 5.4pt'>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																							justify;line-height:115%'>
								<b><span lang=VI style='font-size:17pt;
																								line-height:115%;font-family:"Times New Roman",serif'>STT</span></b>
							</p>
						</td>
						<td width=650 valign=top style='width:487.45pt;border:solid windowtext 1.0pt;
																							border-left:none;padding:0in 5.4pt 0in 5.4pt'>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																							justify;line-height:115%'>
								<b><span lang=VI style='font-size:17pt;
																								line-height:115%;font-family:"Times New Roman",serif'>Tài khoản Ngân hàng</span></b>
							</p>
						</td>
					</tr>
					<tr>
						<td width=40 valign=top style='width:29.7pt;border:solid windowtext 1.0pt;
																							border-top:none;padding:0in 5.4pt 0in 5.4pt'>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																							justify;line-height:115%'>
								<b><span lang=VI style='font-size:17pt;
																								line-height:115%;font-family:"Times New Roman",serif'>1</span></b>
							</p>
						</td>
						<td width=650 valign=top style='width:487.45pt;border-top:none;border-left:
																							none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
																							padding:0in 5.4pt 0in 5.4pt'>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																							justify;line-height:115%'><span
										lang=VI style='font-size:17pt;line-height:
																							115%;font-family:"Times New Roman",serif'>Chủ tài khoản: Công ty Cổ phần Công
																							nghệ Tài Chính Việt </span>
							</p>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																							justify;line-height:115%'><span
										lang=VI style='font-size:17pt;line-height:
																							115%;font-family:"Times New Roman",serif'>Số tài khoản: 19134928058015</span>
							</p>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																							justify;line-height:115%'><span
										lang=VI style='font-size:17pt;line-height:
																							115%;font-family:"Times New Roman",serif'>Ngân hàng TMCP Kỹ Thương Việt Nam –
																							Techcombank</span></p>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																							justify;line-height:115%'><span
										lang=VI style='font-size:17pt;line-height:
																							115%;font-family:"Times New Roman",serif'>Chi nhánh: Trung tâm Giao dịch Hội sở</span>
							</p>
						</td>
					</tr>
					<tr>
						<td width=40 valign=top style='width:29.7pt;border:solid windowtext 1.0pt;
																						border-top:none;padding:0in 5.4pt 0in 5.4pt'>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																						justify;line-height:115%'>
								<b><span lang=VI style='font-size:17pt;
																							line-height:115%;font-family:"Times New Roman",serif'>2</span></b>
							</p>
						</td>
						<td width=650 valign=top style='width:487.45pt;border-top:none;border-left:
																						none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
																						padding:0in 5.4pt 0in 5.4pt'>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																						justify;line-height:115%'><span
										lang=VI style='font-size:17pt;line-height:
																						115%;font-family:"Times New Roman",serif'>Chủ tài khoản: Công ty Cổ phần Công
																						nghệ Tài Chính Việt</span></p>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																						justify;line-height:115%'><span
										lang=VI style='font-size:17pt;line-height:
																						115%;font-family:"Times New Roman",serif'>Số tài khoản: 0851000040363 </span>
							</p>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																						justify;line-height:115%'><span
										lang=VI style='font-size:17pt;line-height:
																						115%;font-family:"Times New Roman",serif'>Ngân hàng TMCP Ngoại Thương Việt
																						Nam – Vietcombank</span></p>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																						justify;line-height:115%'><span
										lang=VI style='font-size:17pt;line-height:
																						115%;font-family:"Times New Roman",serif'>Chi nhánh: Hà Thành</span>
							</p>
						</td>
					</tr>
					<tr>
						<td width=40 valign=top style='width:29.7pt;border:solid windowtext 1.0pt;
																					border-top:none;padding:0in 5.4pt 0in 5.4pt'>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																					justify;line-height:115%'><b><span
											lang=VI style='font-size:17pt;
																						line-height:115%;font-family:"Times New Roman",serif'>3</span></b>
							</p>
						</td>
						<td width=650 valign=top style='width:487.45pt;border-top:none;border-left:
																					none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
																					padding:0in 5.4pt 0in 5.4pt'>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																					justify;line-height:115%'><span
										lang=VI style='font-size:17pt;line-height:
																					115%;font-family:"Times New Roman",serif'>Chủ tài khoản: Công ty Cổ phần Công
																					nghệ Tài Chính Việt</span></p>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																					justify;line-height:115%'><span
										lang=VI style='font-size:17pt;line-height:
																					115%;font-family:"Times New Roman",serif'>Số tài khoản: 1508201028472</span>
							</p>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																					justify;line-height:115%'><span
										lang=VI style='font-size:17pt;line-height:
																					115%;font-family:"Times New Roman",serif'>Ngân hàng Nông nghiệp và Phát triển
																					nông thôn Việt Nam – Agribank</span>
							</p>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																					justify;line-height:115%'><span
										lang=VI style='font-size:17pt;line-height:
																					115%;font-family:"Times New Roman",serif'>Chi nhánh: Tam Trinh</span>
							</p>
						</td>
					</tr>
					<tr>
						<td width=40 valign=top style='width:29.7pt;border:solid windowtext 1.0pt;
																				border-top:none;padding:0in 5.4pt 0in 5.4pt'>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																				justify;line-height:normal'><b><span
											lang=VI style='font-size:17pt;
																					font-family:"Times New Roman",serif'>4</span></b>
							</p>
						</td>
						<td width=650 valign=top style='width:487.45pt;border-top:none;border-left:
																				none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
																				padding:0in 5.4pt 0in 5.4pt'>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																				justify;line-height:115%'><span lang=VI
																												style='font-size:17pt;line-height:
																				115%;font-family:"Times New Roman",serif'>Chủ tài khoản: Công ty Cổ phần Công
																				nghệ Tài Chính Việt</span></p>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																				justify;line-height:115%'><span lang=VI
																												style='font-size:17pt;line-height:
																				115%;font-family:"Times New Roman",serif'>Số tài khoản: 03601010368705</span>
							</p>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																				justify;line-height:115%'><span lang=VI
																												style='font-size:17pt;line-height:
																				115%;font-family:"Times New Roman",serif'>Ngân hàng Thương mại Cổ phần Hàng Hải
																				Việt Nam – MSB</span></p>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																				justify;line-height:normal'><span
										lang=VI style='font-size:17pt;font-family:
																				"Times New Roman",serif'>Chi nhánh: Hà Nội</span>
							</p>
						</td>
					</tr>
					<tr>
						<td width=40 valign=top style='width:29.7pt;border:solid windowtext 1.0pt;
																			border-top:none;padding:0in 5.4pt 0in 5.4pt'>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																			justify;line-height:normal'><b><span lang=VI
																												 style='font-size:17pt;
																				font-family:"Times New Roman",serif'>5</span></b>
							</p>
						</td>
						<td width=650 valign=top style='width:487.45pt;border-top:none;border-left:
																			none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
																			padding:0in 5.4pt 0in 5.4pt'>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																			justify;line-height:115%'><span lang=VI
																											style='font-size:17pt;line-height:
																			115%;font-family:"Times New Roman",serif'>Chủ tài khoản: Công ty Cổ phần Công
																			nghệ Tài Chính Việt</span></p>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																			justify;line-height:115%'><span lang=VI
																											style='font-size:17pt;line-height:
																			115%;font-family:"Times New Roman",serif'>Số tài khoản: 21610000636902</span>
							</p>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																			justify;line-height:115%'><span lang=VI
																											style='font-size:17pt;line-height:
																			115%;font-family:"Times New Roman",serif'>Ngân hàng Đầu tư và Phát triển Việt
																			Nam - BIDV</span></p>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																			justify;line-height:normal'><span lang=VI
																											  style='font-size:17pt;font-family:
																			"Times New Roman",serif'>Chi nhánh: Đống Đa</span>
							</p>
						</td>
					</tr>
					<tr>
						<td width=40 valign=top style='width:29.7pt;border:solid windowtext 1.0pt;
																		border-top:none;padding:0in 5.4pt 0in 5.4pt'>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																		justify;line-height:normal'><b><span lang=VI
																											 style='font-size:17pt;
																			font-family:"Times New Roman",serif'>6</span></b>
							</p>
						</td>
						<td width=650 valign=top style='width:487.45pt;border-top:none;border-left:
																		none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
																		padding:0in 5.4pt 0in 5.4pt'>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																		justify;line-height:115%'><span lang=VI style='font-size:17pt;line-height:
																		115%;font-family:"Times New Roman",serif'>Chủ tài khoản: Công ty Cổ phần Công
																		nghệ Tài Chính Việt</span></p>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																		justify;line-height:115%'><span lang=VI style='font-size:17pt;line-height:
																		115%;font-family:"Times New Roman",serif'>Số tài khoản: 222973988</span>
							</p>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																		justify;line-height:115%'><span lang=VI style='font-size:17pt;line-height:
																		115%;font-family:"Times New Roman",serif'>Ngân hàng Việt Nam Thịnh Vượng -
																		VPBANK</span></p>
							<p class=MsoNormal style='margin-bottom:0in;margin-bottom:.0001pt;text-align:
																		justify;line-height:normal'><span lang=VI
																										  style='font-size:17pt;font-family:
																		"Times New Roman",serif'>Chi nhánh: Hội Sở Chính</span>
							</p>
						</td>
					</tr>
				</table>

				<p class=MsoNormal style='margin-bottom:6.0pt;text-align:justify'><b><i><span
									lang=VI style='font-size:17pt;line-height:115%;font-family:"Times New Roman",serif'>Lưu
																ý: </span></i></b></p>

				<ol style="padding-left:64px;">

					<li> Quý khách vui lòng chụp lại hóa đơn/ sao kê lưu lại để đối chiếu trong trường hợp giao dịch bị
						lỗi
					</li>

					<li> Quý khách không thanh toán cho bất kỳ số tài khoản nào khác ngoài các số tài khoản trên để
						phòng tránh bị lừa đảo gây thiệt hại cho bản thân.
					</li>
				</ol>
			</div>
		</div>
	</div>
</section>
</body>


<style>
	html, body {

		font-family: "Times New Roman", sans-serif;
		font-size: 14px;
		line-height: 1.281;
		color: #000;
	}

	p {
		margin: 0;
		text-align: justify;
	}


	ul {
		padding-left: 15px;
		text-align: justify;
	}

	ol {
		padding-left: 30px;
		text-align: justify;
	}

	ol {
		list-style: none;
		counter-reset: my-awesome-counter;
	}

	ol li {
		counter-increment: my-awesome-counter;
		position: relative;
	}

	ol li::before {
		content: counter(my-awesome-counter) ". ";
		position: absolute;
		left: -30px;
		display: block;
		width: 30px;
		text-align: left;
	}

	ol li,
	ul li {
		text-align: justify;
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
		margin: 0
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

	.dieukhoan {
		column-gap: 40px;
		display: list-item;
		list-style: none;
		column-count: 3;
		font-size: 10px;
		text-align: justify;
	}

	.dieukhoan > p {
		padding-left: 30px;
		position: relative;
	}

	.dieukhoan > p > span {
		display: block;
	}

	.dieukhoan > p > span:first-child {
		position: absolute;
		left: 0;
		top: 0;
	}

	/*.qcont {*/
	/*	display: inline-block*/
	/*}*/
	/*.qcont:first-letter {*/
	/*	text-transform: capitalize*/
	/*}*/


</style>

</html>
