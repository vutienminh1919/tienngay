<?php
$mydate = getdate(date("U"));
$number_day_loan = !empty($contract->loan_infor->number_day_loan) ? $contract->loan_infor->number_day_loan / 30 : "";
$type_interest = !empty($contract->loan_infor->type_interest) ? $contract->loan_infor->type_interest : "";
$type_interest_name ="";
if($type_interest==1)
{
  $type_interest_name="Thanh toán gốc, lãi và các khoản phí (nếu có) hàng tháng theo thông báo cụ thể của TTC";
}else{
     $type_interest_name="Thanh toán gốc cuối kỳ, lãi và các khoản phí";
}
$customer_name = !empty($contract->customer_infor->customer_name) ? $contract->customer_infor->customer_name : "";
$customer_identify = !empty($contract->customer_infor->customer_identify) ? $contract->customer_infor->customer_identify : "";
$bank_account = !empty($contract->receiver_infor->bank_account) ? $contract->receiver_infor->bank_account : $contract->receiver_infor->atm_card_number;
$bank_branch = !empty($contract->receiver_infor->bank_branch) ? $contract->receiver_infor->bank_branch : "";
$amount_money = !empty($contract->loan_infor->amount_money) ? $contract->loan_infor->amount_money : "";
$number_code_contract = !empty($contract->code_contract) ? $contract->code_contract : "";
$disbursement_date = isset($contract->disbursement_date) ? date('d/m/Y',$contract->disbursement_date) : '';
$date_range = !empty($contract->customer_infor->date_range) ? date('d/m/Y',strtotime($contract->customer_infor->date_range))  : "";
$customer_phone_number = !empty($contract->customer_infor->customer_phone_number) ? $contract->customer_infor->customer_phone_number : "";
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="Generator" content="Microsoft Word 15 (filtered)"/>
	<style>
		@font-face {
			font-family: "Cambria Math";
			panose-1: 2 4 5 3 5 4 6 3 2 4;
		}

		@font-face {
			font-family: Calibri;
			panose-1: 2 15 5 2 2 2 4 3 2 4;
		}

		@font-face {
			font-family: Tahoma;
			panose-1: 2 11 6 4 3 5 4 4 2 4;
		}

		p.MsoNormal,
		li.MsoNormal,
		div.MsoNormal {
			margin-top: 0in;
			margin-right: 0in;
			margin-bottom: 8pt;
			margin-left: 0in;
			line-height: 107%;
			font-size: 11pt;
			font-family: "Calibri", sans-serif;
		}

		p.MsoHeader,
		li.MsoHeader,
		div.MsoHeader {
			mso-style-link: "Header Char";
			margin: 0in;
			margin-bottom: 0.0001pt;
			font-size: 11pt;
			font-family: "Calibri", sans-serif;
		}

		p.MsoFooter,
		li.MsoFooter,
		div.MsoFooter {
			mso-style-link: "Footer Char";
			margin: 0in;
			margin-bottom: 0.0001pt;
			font-size: 11pt;
			font-family: "Calibri", sans-serif;
		}

		p.MsoListParagraph,
		li.MsoListParagraph,
		div.MsoListParagraph {
			mso-style-link: "List Paragraph Char";
			margin-top: 0in;
			margin-right: 0in;
			margin-bottom: 8pt;
			margin-left: 0.5in;
			line-height: 107%;
			font-size: 11pt;
			font-family: "Calibri", sans-serif;
		}

		p.MsoListParagraphCxSpFirst,
		li.MsoListParagraphCxSpFirst,
		div.MsoListParagraphCxSpFirst {
			mso-style-link: "List Paragraph Char";
			margin-top: 0in;
			margin-right: 0in;
			margin-bottom: 0in;
			margin-left: 0.5in;
			margin-bottom: 0.0001pt;
			line-height: 107%;
			font-size: 11pt;
			font-family: "Calibri", sans-serif;
		}

		p.MsoListParagraphCxSpMiddle,
		li.MsoListParagraphCxSpMiddle,
		div.MsoListParagraphCxSpMiddle {
			mso-style-link: "List Paragraph Char";
			margin-top: 0in;
			margin-right: 0in;
			margin-bottom: 0in;
			margin-left: 0.5in;
			margin-bottom: 0.0001pt;
			line-height: 107%;
			font-size: 11pt;
			font-family: "Calibri", sans-serif;
		}

		p.MsoListParagraphCxSpLast,
		li.MsoListParagraphCxSpLast,
		div.MsoListParagraphCxSpLast {
			mso-style-link: "List Paragraph Char";
			margin-top: 0in;
			margin-right: 0in;
			margin-bottom: 8pt;
			margin-left: 0.5in;
			line-height: 107%;
			font-size: 11pt;
			font-family: "Calibri", sans-serif;
		}

		span.ListParagraphChar {
			mso-style-name: "List Paragraph Char";
			mso-style-link: "List Paragraph";
			font-family: "Calibri", sans-serif;
		}

		span.HeaderChar {
			mso-style-name: "Header Char";
			mso-style-link: Header;
			font-family: "Calibri", sans-serif;
		}

		span.FooterChar {
			mso-style-name: "Footer Char";
			mso-style-link: Footer;
			font-family: "Calibri", sans-serif;
		}

		.MsoChpDefault {
			font-size: 12pt;
		}

		.MsoPapDefault {
			margin-bottom: 8pt;
			line-height: 107%;
		}

		@page WordSection1 {

		}

		div.WordSection1 {
			/*size: 595.35pt 842pt;*/
			margin: 0 25pt 0 25pt;
		}
	</style>
	<script>
		function Export2Word(element, filename = ''){
			var preHtml = "<html xmlns:o='urn:schemas-microsoft-com:office:office' xmlns:w='urn:schemas-microsoft-com:office:word' xmlns='http://www.w3.org/TR/REC-html40'><head><meta charset='utf-8'><title>Export HTML To Doc</title></head><body>";
			var postHtml = "</body></html>";

			var html = preHtml+document.getElementById(element).innerHTML+postHtml;

			var blob = new Blob(['\ufeff', html], {
				type: 'application/msword'
			});

			// Specify link url
			var url = 'data:application/vnd.ms-word;charset=utf-8,' + encodeURIComponent(html);

			// Specify file name
			filename = filename?filename+'.doc':'document.doc';

			// Create download link element
			var downloadLink = document.createElement("a");

			document.body.appendChild(downloadLink);

			if(navigator.msSaveOrOpenBlob ){
				navigator.msSaveOrOpenBlob(blob, filename);
			}else{
				// Create a link to the file
				downloadLink.href = url;

				// Setting the file name
				downloadLink.download = filename;

				//triggering the function
				downloadLink.click();
			}

			document.body.removeChild(downloadLink);
		}

		var beforePrint = function() {
			document.getElementById("btn_export_word").style.display = 'none';
		};
		var afterPrint = function() {
			document.getElementById("btn_export_word").style.display = 'block';
		};

		if (window.matchMedia) {
			var mediaQueryList = window.matchMedia('print');
			mediaQueryList.addListener(function(mql) {
				if (mql.matches) {
					beforePrint();
				} else {
					afterPrint();
				}
			});
		}
		window.onbeforeprint = beforePrint;
		window.onafterprint = afterPrint;
	</script>
</head>
<?php
$mydate = getdate(date("U"));
$identify_issued_by = isset($contract->customer_infor->issued_by) ? $contract->customer_infor->issued_by : '';
$dangkycapngay = ($ngaycapdangky) ? date('d/m/Y', strtotime($ngaycapdangky)) : '';
?>
<body lang="EN-US" style="overflow: hidden;">
<?php if (in_array('tbp-thu-hoi-no', $groupRoles)): ?>
	<button style="background: #2b579a; color: white; border-color: white; padding: 10px; margin-left: 30px" id="btn_export_word" onclick="Export2Word('source-html', 'word-content');">Export as (.doc)</button>
<?php endif; ?>
<div id="source-html">
<div align="center" class="WordSection1">
	<table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="714"
		   style="width: 535.25pt; border-collapse: collapse;">
		<tr style="height: 71.5pt;">
			<td width="137" style="width: 320.85pt;height: 71.5pt;">
				<p class="MsoNormal" align="center" style="text-align: left;">
                          <span style="font-size: 10pt; line-height: 107%; font-family: 'Tahoma', sans-serif; color: blue;">
                                  <img style="height:70px;" src="https://tienngay.vn/assets/home/images/logo.png"
									   alt="">
                          </span>
				</p>
			</td>
			<td width="577" valign="top" style="width: 432.4pt;  height: 71.5pt;">
				<p class="MsoNormal">
					<b><span style="font-family: 'Times New Roman', serif;">&nbsp;</span></b> <br>
					<b><span style="font-family: 'Times New Roman', serif;">&nbsp;</span></b>
				</p>

				<p class="MsoNormal" align="center" style="text-align: left;">
					<b><span style="font-family: 'Times New Roman', serif;">CÔNG TY CỔ PHẦN CÔNG NGHỆ TIỆN NGAY</span></b>
				</p>
				<p class="MsoNormal" style="text-align:left;"><b
							style="font-family: 'Times New Roman', serif;">Tầng 15, Khối B, Tòa nhà Sông Đà, đường Phạm Hùng, <br>Phường Mỹ Đình 1, Quận Nam Từ Liêm, Hà Nội</b>
				</p>
				<p class="MsoNormal" style="text-align:left;"><b
							style="font-family: 'Times New Roman', serif;">Website: <a href="https://tienngay.vn/">https://tienngay.vn/</a></b>
				</p>
			</td>
		</tr>
	</table>
	<table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="714"
		   style="width: 535.25pt; border-collapse: collapse;">
		<tr style="height: 71.5pt;">
			<td width="137" style="width: 200.85pt;  height: 71.5pt;">
				<p class="MsoNormal" align="center" style="text-align: center;">
					<b><span style="font-family: 'Times New Roman', serif;">CÔNG TY CỔ PHẦN</span></b>
				</p>
				<p class="MsoNormal" align="center" style="text-align: center;">
					<b><span style="font-family: 'Times New Roman', serif;">CÔNG NGHỆ TIỆN NGAY</span></b>
				</p>
				<p class="MsoNormal" style="text-align:center"><span
							style="font-family: 'Times New Roman', serif;font-size:12px;">Số: <?= empty($code_contract) ? '…………………………………………' : $code_contract ?></span>
				</p>
			</td>
			<td width="137" style="width: 200.85pt;  height: 71.5pt;">
				<p class="MsoNormal" align="center" style="text-align: center;">
					<b><span style="font-family: 'Times New Roman', serif;">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</span></b>
				</p>
				<p class="MsoNormal" align="center" style="text-align: center;">
					<b><span style="font-family: 'Times New Roman', serif;">Độc lập-Tự do-Hạnh phúc</span></b>
				</p>
				<p class="MsoNormal" style="text-align:center"><span
							style="font-family: 'Times New Roman', serif;font-size:12px;">Hôm nay, ngày <?php
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
					?> năm <?= $mydate['year'] ?></span>
				</p>
			</td>
		</tr>
	</table>
</div>
<div class="WordSection1">

	<p class="MsoListParagraphCxSpMiddle" align="center"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: center; line-height: 115%;">
		<b><span style="font-size: 18pt; line-height: 115%; font-family: 'Times New Roman', serif;">THÔNG BÁO HỢP ĐỒNG QUÁ HẠN LẦN……..</span></b>
	</p>

	<p class="MsoListParagraphCxSpMiddle" align="center"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: center; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;font-style: italic;">(V/v: Trễ hạn thanh toán khoản vay)</span>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">&nbsp;</span>
	</p>
	<p class="MsoListParagraphCxSpMiddle" align="left"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: left; line-height: 115%;">
		<b>
			<u><span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Kính gửi</span></u>
		</b>
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;font-style: italic;">: <b>Ông/Bà:</b> <?= ($customer_name) ? $customer_name : '...................................................' ?></span>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; line-height: 115%;font-style: italic;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">CMND/CCCD số: <?= ($customer_identify) ? $customer_identify : '.....................................................' ?> do <?= ($identify_issued_by) ? $identify_issued_by : '…………………........' ?>. Cấp ngày <?= ($date_range) ? $date_range : '…………………' ?></span>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;white-space: nowrap;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;font-style: italic;">Địa chỉ: <?= ($address_house) ? $address_house : '........................................................................................................................................................' ?></span>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;white-space: nowrap;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;font-style: italic;">SĐT liên hệ: <?= ($customer_phone_number) ? $customer_phone_number : '..................................................................................................................................................' ?></span>
	</p>
	<p class="MsoListParagraphCxSpLast"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;"><b>Công ty Cổ phần Công nghệ Tiện Ngay (sau đây gọi là “TTC”) trân trọng thông báo đến Ông/Bà nội dung như sau:</b></span>
	</p>
	<p class="MsoNormal"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 0; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;text-align: justify;">Khoản vay của Ông/bà: <?= ($customer_name) ? $customer_name : '……….…………………..' ?> thông qua TTC theo Thỏa thuận ba bên về việc hỗ trợ tài chính số <?= empty($code_contract) ? '........................................................' : $code_contract ?>, ký ngày <?= ($disbursement_date) ? $disbursement_date : '.....................' ?>, số tiền vay: <?= ($amount_money) ? number_format($amount_money).'VNĐ' : '…….....................' ?>, hình thức thanh toán: <?= ($type_interest_name) ? $type_interest_name : '............................' ?>, số kỳ đã trả: <?= ($ky_thanh_toan) ? $ky_thanh_toan : '.....................' ?> với Tài sản đảm bảo nghĩa vụ thanh toán là: <?= $nhanhieu ?><?= $model ?>, số Đăng ký xe <?= empty($sodangky) ? '..................' :  $sodangky ?> mang tên <?= empty($chuxe) ? '................................................' :  $chuxe ?>
		Khoản vay nêu trên của Ông/Bà đã quá hạn thanh toán <?= empty($ngay_qua_han) ? '….……' :  $ngay_qua_han ?> ngày. TTC đã nhiều lần gọi điện thoại, nhắn tin, gửi thư và liên hệ làm việc trực tiếp nhưng đến nay Ông/bà vẫn không nghiêm túc thực hiện đầy đủ nghĩa vụ thanh toán phí dịch vụ cho TTC cũng như tiền lãi, số tiền vay và nghĩa vụ tài chính khác đối với Bên cho vay.</span></p>
<p class="MsoNormal"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 0; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;text-align: justify;">
		Tạm tính đến hết ngày <?=date('d/m/Y')?>, Ông/Bà phải thực hiện nghĩa vụ thanh toán số tiền: <?= ($amount_payment) ? number_format($amount_payment).'VNĐ' : '……………….' ?> (Bằng chữ: <?= ($amount_payment>0) ? (convert_number_to_words($amount_payment)) : '…………...……………………………..' ?>)

		Trên tinh thần thiện chí, bằng văn bản này, TTC yêu cầu Ông/bà thực hiện đúng, đầy đủ nghĩa vụ thanh toán nêu trên trong vòng ………….. ngày, kể từ ngày nhận được thông báo này. Trường hợp Ông/bà không thực hiện hoặc thực hiện không đúng, không đầy đủ nghĩa vụ theo Thỏa thuận ba bên, TTC sẽ gặp Ông/bà trực tiếp tại nơi cư trú/nơi làm việc của Ông/Bà để yêu cầu giải quyết quyền và lợi ích hợp pháp cho TTC và Bên cho vay theo quy định của pháp luật.

		Để tránh những hậu quả pháp lý không mong muốn, TTC yêu cầu Ông/Bà thực hiện đúng, đầy đủ nghĩa vụ theo Thỏa thuận ba bên đã ký kết.</span></p>
	
	<p class="MsoNormal"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 0; margin-left: 0in; text-align: justify; line-height: 115%;">
                <span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Trong trường hợp Ông/bà đã thực hiện xong toàn bộ nghĩa vụ thanh toán nêu trên vui lòng bỏ qua thông báo này. Mọi thông tin chi tiết về tình trạng khoản vay Ông/Bà vui lòng liên hệ ngay với chúng tôi theo số điện thoại Hotline <b>19006907</b> để được hỗ trợ.
                </span>
	</p>
</div>
<div class="WordSection1">
	<div align="center">
		<table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="665"
			   style="width: 100%; border-collapse: collapse;">
			<tr>
				<td width="373" valign="top" style="width: 279.9pt; ">
					<p class="MsoListParagraphCxSpFirst"
					   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; line-height: 115%;">
						<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;"> <b>Trân trọng!</b></span>
					</p>
				</td>
			</tr>
		</table>
	</div>
</div>

<div class="WordSection1">
	<div align="center">
		<table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="714"
			   style="width: 498.65pt; border-collapse: collapse;">
			<tr>
				<td width="373" valign="top" style="width: 249pt; ">
					<p class="MsoListParagraphCxSpFirst"
					   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; line-height: 115%;">
						<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;"> <b style="font-style: italic;">Nơi nhận:</b><ul style="padding-left: 17px;font-style: italic;"><li>Như kính gửi;</li><li>Lưu VP.</li></ul></span>
					</p>
				</td>
				<td width="373" valign="top" style="width: 360.4pt;">
					<p class="MsoListParagraphCxSpFirst"
					   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; line-height: 115%;text-align: center;">
						<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;"> <b>CÔNG TY CỔ PHẦN CÔNG NGHỆ TIỆN NGAY</b></span>
					</p>
					<p class="MsoListParagraphCxSpFirst"
					   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; line-height: 115%;text-align: center;">
						<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;"> <b>TM. TỔNG GIÁM ĐỐC</b></span>
					</p>
				</td>
			</tr>
		</table>
	</div>
</div>
</div>
</body>
</html>
