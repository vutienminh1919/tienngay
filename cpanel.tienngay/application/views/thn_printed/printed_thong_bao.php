<?php
$mydate = getdate(date("U"));
$number_day_loan = !empty($contract->loan_infor->number_day_loan) ? $contract->loan_infor->number_day_loan / 30 : "";
$type_interest = !empty($contract->loan_infor->type_interest) ? $contract->loan_infor->type_interest : "";
$customer_name = !empty($contract->customer_infor->customer_name) ? $contract->customer_infor->customer_name : "";
$customer_identify = !empty($contract->customer_infor->customer_identify) ? $contract->customer_infor->customer_identify : "";
$bank_account = !empty($contract->receiver_infor->bank_account) ? $contract->receiver_infor->bank_account : $contract->receiver_infor->atm_card_number;
$bank_branch = !empty($contract->receiver_infor->bank_branch) ? $contract->receiver_infor->bank_branch : "";
$amount_money = !empty($contract->loan_infor->amount_money) ? $contract->loan_infor->amount_money : "";
$number_code_contract = !empty($contract->code_contract) ? $contract->code_contract : "";
$date_range = !empty($contract->customer_infor->date_range) ? date('d/m/Y',strtotime($contract->customer_infor->date_range))  : "";
$issued_by = !empty($contract->customer_infor->issued_by) ? $contract->customer_infor->issued_by : "";
$address_store = !empty($store->address) ? $store->address : "";
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
$disbursement_date = isset($contract->disbursement_date) ? date('d/m/Y',$contract->disbursement_date) : '';
?>
<body lang="EN-US" >
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
							style="font-family: 'Times New Roman', serif;font-size:12px;">
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
					?> năm <?= $mydate['year'] ?></span>
				</p>
			</td>
		</tr>
	</table>
</div>
<div class="WordSection1" style="overflow: hidden;" >
	<p class="MsoListParagraphCxSpMiddle" align="center"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: center; line-height: 115%;">
		<b><span style="font-size: 18pt; line-height: 115%; font-family: 'Times New Roman', serif;">THÔNG BÁO</span></b>
	</p>
	<p class="MsoListParagraphCxSpMiddle" align="center"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: center; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;font-style: italic;">(V/v: Chấm dứt việc sử dụng tài sản là Tài sản đảm bảo)</span>
	</p>
<p class="MsoNormal">&nbsp;</p>
	<p class="MsoListParagraphCxSpMiddle" align="left"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: center; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Kính gửi: Ông/bà: <?= ($customer_name) ? $customer_name : '…………………………………………………………………………………' ?></span>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">&nbsp;</span>
	</p>
	<p class="MsoListParagraphCxSpMiddle" align="left"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: left; line-height: 115%;">
	
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Năm sinh: <?= ($customerDOB) ? $customerDOB : '………………...........' ?> CMND/CCCD số: <?= ($customer_identify) ? $customer_identify : '…………………………… …..............................' ?></span>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Cấp ngày: <?= ($date_range) ? $date_range : '………………… …..' ?> Do: <?= ($issued_by) ? $issued_by : '………………………………………………................................' ?></span>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Địa chỉ thường trú: <?= ($address_house) ? $address_house : '………………………………………………………………………………………..' ?></span>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Ngày <?= ($disbursement_date) ? $disbursement_date : '…………' ?> Ông/bà ký Thỏa thuận ba bên số <?= ($code_contract) ? $code_contract : '…………........................….' ?> ngày <?= ($disbursement_date) ? $disbursement_date : '…………' ?>, (sau đây gọi là Thỏa thuận ba bên) giá trị Thỏa thuận: <?= ($amount_money) ? number_format($amount_money) : '………………' ?>VNĐ (Bằng chữ: <?= (convert_number_to_words($amount_money)) ? (convert_number_to_words($amount_money)) : '………………………………' ?>) có biện pháp bảo đảm là Cầm cố tài sản theo quy định của Bộ luật Dân sự.
		</span>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">
		Theo nội dung thỏa thuận giữa các bên, Ông/bà <?= ($customer_name) ? $customer_name : '…………………..………..' ?> được mượn lại tài sản là Tài sản đảm bảo thực hiện nghĩa vụ để sử dụng. Tuy nhiên căn cứ trên tình hình thực tế, ông/bà <?= ($customer_name) ? $customer_name : '…………………..………..' ?> không thực hiện, thực hiện không đúng, không đầy đủ các nội dung đã cam kết và vi phạm thỏa thuận của các bên.</span>
	</p>
	<ul style="list-style: none;">
	    <li>Căn cứ vào thỏa thuận Ba Bên <?= empty($code_contract) ? '…………………………………………' : $code_contract ?> ngày <?= ($disbursement_date) ? $disbursement_date : '……./……./..……' ?></li>
		<li>Căn cứ vào Giấy biên nhận bàn giao tài sản ngày <?= ($disbursement_date) ? $disbursement_date : '……./……./..……' ?></li>
		<li>Căn cứ vào Giấy xác nhận lưu giữ giấy tờ ngày <?= ($disbursement_date) ? $disbursement_date : '……./……./..……' ?></li>
		<li>Căn cứ vào Biên bản làm việc ngày <?= ($disbursement_date) ? $disbursement_date : '……./……./..……' ?></li>
	</ul>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">và nhận sự ủy quyền của Bên cho vay về việc quản lý Tài sản đảm bảo, Công ty cổ phần Công nghệ Tiện Ngay (sau đây gọi là “TTC”) thông báo về việc ông/bà <?= ($customer_name) ? $customer_name : '…………………………………..' ?> phải giao lại Tài sản đảm bảo để TTC quản lý, thông tin tài sản như sau:</span>
	</p>
	<table style="width:100%;">
	  <tr style="display: inline-flex;width: 100%;">
	    <td style="padding: 10px; ;border: 1px solid;border-bottom: none;" width="140" align="left"><p style="margin: 0;"><b>LOẠI TÀI SẢN</b></p></td>
	    <td style="padding: 10px; ;border: 1px solid;border-bottom: none;border-left: none;" width="160" align="center"><p style="margin: 0;"><b>BIỂN KIỂM SOÁT</b></p></td>
	    <td style="padding: 10px; ;border: 1px solid;border-bottom: none;border-left: none;" width="160" align="center"><p style="margin: 0;"><b>SỐ MÁY</b></p></td>
	    <td style="padding: 10px; ;border: 1px solid;border-bottom: none;border-left: none;" width="160" align="center"><p style="margin: 0;"><b>SỐ KHUNG</b></p></td>
	  </tr>
	  <tr style="display: inline-flex;width: 100%;">
	    <td width="140" style="padding: 10px; ;border: 1px solid;"><?= $nhanhieu ?><?= $model ?> </td>
	    <td width="160" style="padding: 10px; ;border: 1px solid;border-left: none;" align="center">
	    	<?= $bienkiemsoat ?></td>
	    <td width="160" style="padding: 10px; ;border: 1px solid;border-left: none;" align="center"><?= $somay ?></td>
	    <td width="160" style="padding: 10px; ;border: 1px solid;border-left: none;" align="center"><?= $sokhung ?></td>
	  </tr>
	</table>
	<p class="MsoNormal">&nbsp;</p>
</div>
<div class="WordSection1">
	<div align="center">
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Thời gian bàn giao: …………………………………………………………...……………………………</span>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Địa điểm bàn giao: <?= ($address_store) ? $address_store : '……………………………………………………………………………………….' ?> </span>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Trường hợp Ông/bà <?= ($customer_name) ? $customer_name : '………………………………………….' ?> không bàn giao tài sản đảm bảo như thông tin nêu trên cho TTC quản lý, để bảo vệ quyền và lợi ích hợp pháp của mình và Bên cho vay, TTC sẽ yêu cầu sự vào cuộc của Cơ quan điều tra có thẩm quyền tiến hành điều tra hành vi có dấu hiệu cấu thành tội Lạm dụng tín nhiệm chiếm đoạt tài sản theo quy định tại Điều 175 Bộ Luật Hình sự 2015.</span>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Trên tinh thần thiện chí hợp tác, TTC mong muốn ông/bà <?= ($customer_name) ? $customer_name : '……………………………….……….' ?> phối hợp để giải quyết vụ việc nhanh chóng, thuận tiện, đôi bên cùng có lợi.</span>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;"><b>Trường hợp cần được hỗ trợ Ông/bà vui lòng liên hệ……………………………….............................</b></span>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 0; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;"><b>Điện thoại liên hệ:………………………………….</b></span>
	</p>	
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
<p class="MsoNormal">&nbsp;</p>
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
