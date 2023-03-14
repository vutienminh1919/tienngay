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
$disbursement_date = isset($contract->disbursement_date) ? date('d/m/Y',$contract->disbursement_date) : '';
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
<body lang="EN-US">
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
		<b><span style="font-size: 18pt; line-height: 115%; font-family: 'Times New Roman', serif;">QUYẾT ĐỊNH CỦA TỔNG GIÁM ĐỐC</span></b>
	</p>
	<p class="MsoListParagraphCxSpMiddle" align="center"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: center; line-height: 115%;">
		<b><span style="font-size: 18pt; line-height: 115%; font-family: 'Times New Roman', serif;">CÔNG TY CỔ PHẦN CÔNG NGHỆ TIỆN NGAY</span></b>
	</p>
	<p class="MsoListParagraphCxSpMiddle" align="center"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: center; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;font-style: italic;">(V/v: Thu hồi tài sản đảm bảo)</span>
	</p>
	<ul style="padding-left: 17px">
		<li style="margin-bottom: 10px;">Căn cứ vào “Thỏa thuận ba bên” số <?= empty($code_contract) ? '.................................................' : $code_contract ?> ký ngày <?= empty($disbursement_date) ? '......................................' : $disbursement_date ?></li>	
		<li style="margin-bottom: 10px;">Căn cứ vào “Giấy biên nhận bàn giao tài sản” ký ngày <?= empty($disbursement_date) ? '.....................................................................' : $disbursement_date ?></li>	
		<li style="margin-bottom: 10px;">Căn cứ vào “Giấy xác nhận lưu giữ giấy tờ” ký ngày <?= empty($disbursement_date) ? '.......................................................................' : $disbursement_date ?></li>	
	
		<li>Căn cứ trên tình hình thực tế.</li>
	</ul>
	<p class="MsoListParagraphCxSpMiddle" align="center"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: center; line-height: 115%;">
		<b><span style="font-size: 18pt; line-height: 115%; font-family: 'Times New Roman', serif;">QUYẾT ĐỊNH:</span></b>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">&nbsp;</span>
	</p>
	<p class="MsoListParagraphCxSpMiddle" align="left"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: left; line-height: 115%;">
		<b>
			<u><span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Điều 1</span></u>
		</b>
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">: Thu hồi tài sản là tài sản bảo đảm nghĩa vụ thanh toán (Biện pháp cầm cố tài sản) theo Thỏa thuận ba bên về việc hỗ tợ tài chính số: <?= empty($code_contract) ? '........................................................' : $code_contract ?> ký ngày: <?= empty($disbursement_date) ? '.........../............/.........' : $disbursement_date ?></span>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Thông tin tài sản bảo đảm cần thu hồi như sau:</span>
	</p>

	<table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="780"
		   style="border-collapse: collapse;">
		<tr style="height: 23.05pt;">
			<td width="332" valign="top" style="width: 248.95pt;  height: 23.05pt;">
				<p class="MsoListParagraphCxSpFirst"
				   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: left; line-height: 115%;">
					<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif; text-transform: capitalize">Loại tài sản: <?= $nhanhieu ?><?= $model ?></span>
				</p>
			</td>
			<td width="303" valign="top" style="width: 227.5pt;  height: 23.05pt;">
				<p class="MsoListParagraphCxSpLast"
				   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: left; line-height: 115%;">
					<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif; ">Giấy đăng ký xe số: <?= empty($sodangky) ? '………………........................' :  $sodangky ?></span>
				</p>
			</td>
		</tr>
		<tr style="height: 22.15pt;">
			<td width="332" valign="top" style="width: 248.95pt;  height: 22.15pt;">
				<p class="MsoListParagraphCxSpFirst"
				   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: left; line-height: 115%;">
					<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Ngày cấp: <?= empty($ngaycapdangky) ? '……………………………… …............' :  $ngaycapdangky ?></span>
				</p>
			</td>
			<td width="303" valign="top" style="width: 227.5pt;  height: 22.15pt;">
				<p class="MsoListParagraphCxSpLast"
				   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: left; line-height: 115%;">
					<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Nơi cấp:  <?= empty($diachidangky) ? '………………..........................................' :  $diachidangky ?></span>
				</p>
			</td>
		</tr>
		<tr style="height: 20.8pt;">
			<td width="332" valign="top" style="width: 248.95pt;  height: 20.8pt;">
				<p class="MsoListParagraphCxSpFirst"
				   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: left; line-height: 115%;">
					<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Tên chủ xe: <?= empty($chuxe) ? '……………… ……… …....................' :  $chuxe ?></span>
				</p>
			</td>
			<td width="303" valign="top" style="width: 227.5pt;  height: 20.8pt;">
				<p class="MsoListParagraphCxSpLast"
				   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: left; line-height: 115%;">
					<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Biển kiểm soát: <?= empty($bienkiemsoat) ? '………………..............................' :  $bienkiemsoat ?></span>
				</p>
			</td>
		</tr>
		<tr style="height: 18.55pt;">
			<td width="332" valign="top" style="width: 248.95pt;  height: 18.55pt;">
				<p class="MsoListParagraphCxSpFirst"
				   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: left; line-height: 115%;">
					<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Số khung: <?= empty($sokhung) ? '………………..............................' :  $sokhung ?></span>
				</p>
			</td>
			<td width="303" valign="top" style="width: 227.5pt;  height: 18.55pt;">
				<p class="MsoListParagraphCxSpLast"
				   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: left; line-height: 115%;">
					<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Số máy: <?= empty($somay) ? '…………………………………………..' :  $somay ?></span>
				</p>
			</td>
		</tr>
	</table>


	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Tài sản nêu trên thuộc quyền quản lý của Công ty Cổ phần Công nghệ Tiện Ngay, hiện tại đang giao cho ông/bà <?= ($customer_name) ? $customer_name : '………………………………………' ?> mượn để sử dụng, nay Công ty cổ phần Công nghệ Tiện Ngay tiến hành thu hồi Tài sản có thông tin nêu trên để quản lý.</span>
	</p>
	<p class="MsoListParagraphCxSpMiddle" align="left"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: left; line-height: 115%;">
		<b>
			<u><span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Điều 2</span></u>
		</b>
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">: Giao cho Phòng quản lý hồ sơ sau vay tiến hành các thủ tục và quản lý đối với tài sản đảm bảo nêu trên cho đến khi có Quyết định mới của Tổng giám đốc.</span>
	</p>
	<p class="MsoListParagraphCxSpMiddle" align="left"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: left; line-height: 115%;">
		<b>
			<u><span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Điều 3</span></u>
		</b>
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">: Ban điều hành, các Trưởng bộ phận và cá nhân có liên quan chịu trách nhiệm thi hành quyết định này.</span>
	</p>
	<p class="MsoListParagraphCxSpMiddle" align="left"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: left; line-height: 115%;">
		<b>
			<u><span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Điều 4</span></u>
		</b>
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">: Quyết định này có hiệu lực kể từ ngày ký <?= date('d/m/Y') ?></span>
	</p>
	<p class="MsoNormal">&nbsp;</p>
</div>
<div class="WordSection1">
	<div align="center">
		<table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="714"
			   style="width: 100%; border-collapse: collapse;">
			<tr>
				<td width="373" valign="top" style="width: 249pt; ">
					<p class="MsoListParagraphCxSpFirst"
					   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; line-height: 115%;">
						<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;"> <b style="font-style: italic;">Nơi nhận:</b><ul style="padding-left: 17px;font-style: italic;"><li>Như Điều 3;</li><li>Lưu VP.</li></ul></span>
					</p>
				</td>
				<td width="373" valign="top" style="width: 348.4pt;">
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
