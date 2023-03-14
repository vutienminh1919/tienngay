<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="Generator" content="Microsoft Word 15 (filtered)"/>
	<title>CAM KẾT XE</title>
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
</head>
<?php
$mydate = getdate(date("U"));
$date_document = '';
$month_document = '';

if ($mydate['mday'] < 10) {
	$date_document = "0" . $mydate['mday'];
} else {
	$date_document = $mydate['mday'];
}

if ($mydate['mon'] < 3) {
	$month_document = "0" . $mydate['mon'];
} else {
	$month_document = $mydate['mon'];
}
$identify_issued_by = isset($contract->customer_infor->issued_by) ? $contract->customer_infor->issued_by : '';
$dangkycapngay = ($ngaycapdangky) ? date('d/m/Y', strtotime($ngaycapdangky)) : '';
?>
<body lang="EN-US">
<div align="center">
	<table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="714"
		   style="width: 535.25pt; border-collapse: collapse;">
		<tr style="height: 71.5pt;">
			<td width="137" style="width: 102.85pt;  height: 71.5pt;">
				<p class="MsoNormal" align="center" style="text-align: center;">
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

				<p class="MsoNormal" align="center" style="text-align: center;">
					<b><span style="font-family: 'Times New Roman', serif;">CÔNG TY CỔ PHẦN CÔNG NGHỆ TIỆN NGAY ĐÔNG BẮC</span></b>
				</p>
				<p class="MsoNormal" style="text-align:center"><span
							style="font-family: 'Times New Roman', serif;font-size:12px;">Địa chỉ: Tầng 15, Khối B, Tòa nhà Sông Đà, đường Phạm Hùng, <br>Phường Mỹ Đình 1, Quận Nam Từ Liêm, Hà Nội</span>
				</p>
			</td>
		</tr>
	</table>
</div>
<div class="WordSection1">

	<p class="MsoListParagraphCxSpFirst" align="center"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: center; line-height: 115%;">
		&nbsp;</p>
	<p class="MsoListParagraphCxSpMiddle" align="center"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: center; line-height: 115%;">
		<b><span style="font-size: 11pt; line-height: 115%; font-family: 'Times New Roman', serif;">&nbsp;</span></b>
	</p>
	<p class="MsoListParagraphCxSpMiddle" align="center"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: center; line-height: 115%;">
		<b><span style="font-size: 18pt; line-height: 115%; font-family: 'Times New Roman', serif;">GIẤY CAM KẾT</span></b>
	</p>

	<p class="MsoListParagraphCxSpMiddle" align="center"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: center; line-height: 115%;">
		<b>
			<u><span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Kính gửi</span></u>
		</b>
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">: <b>CÔNG TY CỔ PHẨN CÔNG NGHỆ TIỆN NGAY ĐÔNG BẮC</b></span>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">&nbsp;</span>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Tên tôi là: <strong
					style="text-transform: uppercase"><?= $contract->customer_infor->customer_name ?></strong></span>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">CMND số: <?= $contract->customer_infor->customer_identify ?> do <?= ($identify_issued_by) ? $identify_issued_by : '…………………' ?>. Cấp ngày <?= ($identify_date_range) ? $identify_date_range : '…………………' ?></span>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Hộ khẩu thường trú: <?= $address_house ?></span>
	</p>
	<p class="MsoListParagraphCxSpMiddle"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">SĐT liên hệ: <?= $customerPhone ?></span>
	</p>
	<p class="MsoListParagraphCxSpLast"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Tôi xin cam kết chiếc xe máy với thông tin sau là thuộc quyền sở hữu hợp pháp của Tôi cụ thể:</span>
	</p>
	<p class="MsoNormal"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;"> Tên chủ xe: <strong><?= !empty($chuxe) ? $chuxe : "………………………………………………………………………………" ?></strong></span>
	</p>
	<p class="MsoNormal"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
		<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;"> Địa chỉ: <?= ($diachidangky) ? $diachidangky : '………………………………………………………………………………….' ?></span>
	</p>
	<table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="635"
		   style="width: 476.45pt; border-collapse: collapse;">
		<tr style="height: 23.05pt;">
			<td width="332" valign="top" style="width: 248.95pt;  height: 23.05pt;">
				<p class="MsoListParagraphCxSpFirst"
				   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
					<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif; text-transform: capitalize">Hãng xe:  <?= ($nhanhieu) ? $nhanhieu : '………………………….' ?></span>
				</p>
			</td>
			<td width="303" valign="top" style="width: 227.5pt;  height: 23.05pt;">
				<p class="MsoListParagraphCxSpLast"
				   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
					<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif; text-transform: capitalize">Loại xe: <?= ($model) ? $model : '………………………….' ?></span>
				</p>
			</td>
		</tr>
		<tr style="height: 22.15pt;">
			<td width="332" valign="top" style="width: 248.95pt;  height: 22.15pt;">
				<p class="MsoListParagraphCxSpFirst"
				   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
					<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Màu sơn: ………………………….</span>
				</p>
			</td>
			<td width="303" valign="top" style="width: 227.5pt;  height: 22.15pt;">
				<p class="MsoListParagraphCxSpLast"
				   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
					<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Biển số đăng ký: <?= ($bienkiemsoat) ? $bienkiemsoat : '………………………….' ?></span>
				</p>
			</td>
		</tr>
		<tr style="height: 20.8pt;">
			<td width="332" valign="top" style="width: 248.95pt;  height: 20.8pt;">
				<p class="MsoListParagraphCxSpFirst"
				   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
					<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Công suất: ………………………...</span>
				</p>
			</td>
			<td width="303" valign="top" style="width: 227.5pt;  height: 20.8pt;">
				<p class="MsoListParagraphCxSpLast"
				   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
					<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Dung tích:…………………………….</span>
				</p>
			</td>
		</tr>
		<tr style="height: 18.55pt;">
			<td width="332" valign="top" style="width: 248.95pt;  height: 18.55pt;">
				<p class="MsoListParagraphCxSpFirst"
				   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
					<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Số giấy đăng ký: <?= ($sodangky) ? $sodangky : '…………………..' ?></span>
				</p>
			</td>
			<td width="303" valign="top" style="width: 227.5pt;  height: 18.55pt;">
				<p class="MsoListParagraphCxSpLast"
				   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
					<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Ngày cấp: <?= ($dangkycapngay) ? $dangkycapngay : '……/…………/……………' ?></span>
				</p>
			</td>
		</tr>
		<tr style="height: 26.25pt;">
			<td width="332" valign="top" style="width: 248.95pt;  height: 26.25pt;">
				<p class="MsoListParagraphCxSpFirst"
				   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
					<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Số khung: <?= ($sokhung) ? $sokhung : '…………………..' ?> </span>
				</p>
			</td>
			<td width="303" valign="top" style="width: 227.5pt;  height: 26.25pt;">
				<p class="MsoListParagraphCxSpLast"
				   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
					<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">Số máy: <?= ($somay) ? $somay : '…………………..' ?></span>
				</p>
			</td>
		</tr>
	</table>
	<p class="MsoNormal"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; line-height: 115%;">
                <span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">
                    Đây là chiếc xe Tôi mua và đã thanh toán đầy đủ 100% tiền mua chiếc xe này cho …………………………….. Chiếc xe này của Tôi không phải là đối tượng đã và đang hứa bán, tặng, cho, trao đổi, chuyển nhượng và không có bất kỳ tranh chấp nào. Tôi đang không
                    dùng chiếc xe này để cầm cố, thế chấp hoặc để đảm bảo cho bất kỳ nghĩa vụ tài chính nào.
                </span>
	</p>
	<p class="MsoNormal"
	   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: justify; line-height: 115%;">
                <span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">
                    Những lời cam kết của Tôi tại văn bản này là đúng sự thật, nếu có bất kỳ thông tin nào không đúng sự thật Tôi xin hoàn toàn chịu trách nhiệm trước pháp luật và các bên liên quan.
                </span>
	</p>
	<div align="center">
		<table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="665"
			   style="width: 498.65pt; border-collapse: collapse;">
			<tr>
				<td width="373" valign="top" style="width: 279.9pt; ">
					<p class="MsoListParagraphCxSpFirst"
					   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; line-height: 115%;">
						<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;"> Trân trọng!</span><span
								style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;"></span>
					</p>
				</td>
				<td width="292" valign="top" style="width: 218.75pt; ">
					<p class="MsoListParagraphCxSpMiddle" align="center"
					   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: center; line-height: 115%;">
						<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">&nbsp;</span>
					</p>
					<p class="MsoListParagraphCxSpMiddle" align="center"
					   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: center; line-height: 115%;">
						<span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">&nbsp;</span>
					</p>
					<p class="MsoListParagraphCxSpMiddle" align="center"
					   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: center; line-height: 115%;">
						<i><span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">….….….…. Ngày <?= $date_document ?> tháng <?= $month_document ?> năm <?= $mydate['year'] ?></span></i>
					</p>
					<p class="MsoListParagraphCxSpMiddle" align="center"
					   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: center; line-height: 115%;">
						<b><span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">NGƯỜI CAM KẾT</span></b>
					</p>
					<p class="MsoListParagraphCxSpMiddle" align="center"
					   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; text-align: center; line-height: 115%;">
						<i><span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">(Ký và ghi rõ họ tên)</span></i>
					</p>
					<p class="MsoListParagraphCxSpLast"
					   style="margin-top: 6pt; margin-right: 0in; margin-bottom: 6pt; margin-left: 0in; line-height: 115%;">
						<b><span style="font-size: 12pt; line-height: 115%; font-family: 'Times New Roman', serif;">&nbsp;</span></b>
					</p>
				</td>
			</tr>
		</table>
	</div>
	<p class="MsoNormal">&nbsp;</p>
</div>
</body>
</html>
