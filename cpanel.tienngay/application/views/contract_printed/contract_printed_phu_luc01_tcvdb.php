<!DOCTYPE html>
<html lang="en">

<head>

	<meta http-equiv=Content-Type content="text/html; charset=utf-8">
	<meta name=Generator content="Microsoft Word 15 (filtered)">
	<style>

		@font-face
		{font-family:Wingdings;
			panose-1:5 0 0 0 0 0 0 0 0 0;}
		@font-face
		{font-family:"Cambria Math";
			panose-1:2 4 5 3 5 4 6 3 2 4;}
		@font-face
		{font-family:Calibri;
			panose-1:2 15 5 2 2 2 4 3 2 4;}
		@font-face
		{font-family:"Segoe UI";
			panose-1:2 11 5 2 4 2 4 2 2 3;}
		@font-face
		{font-family:"Segoe UI Symbol";
			panose-1:2 11 5 2 4 2 4 2 2 3;}
		/* Style Definitions */
		p.MsoNormal, li.MsoNormal, div.MsoNormal
		{margin-top:0in;
			margin-right:0in;
			margin-bottom:8.0pt;
			margin-left:0in;
			line-height:107%;
			font-size:11.0pt;
			font-family:"Calibri",sans-serif;}
		p.MsoHeader, li.MsoHeader, div.MsoHeader
		{mso-style-link:"Header Char";
			margin:0in;
			font-size:11.0pt;
			font-family:"Calibri",sans-serif;}
		p.MsoListParagraph, li.MsoListParagraph, div.MsoListParagraph
		{mso-style-name:"List Paragraph\,bullet 1\,bullet\,List Paragraph1\,List Paragraph11\,Thang2\,Dot 1\,a\)\,abc";
			mso-style-link:"List Paragraph Char\,bullet 1 Char\,bullet Char\,List Paragraph1 Char\,List Paragraph11 Char\,Thang2 Char\,Dot 1 Char\,a\) Char\,abc Char";
			margin-top:0in;
			margin-right:0in;
			margin-bottom:8.0pt;
			margin-left:.5in;
			line-height:107%;
			font-size:11.0pt;
			font-family:"Calibri",sans-serif;}
		p.MsoListParagraphCxSpFirst, li.MsoListParagraphCxSpFirst, div.MsoListParagraphCxSpFirst
		{mso-style-name:"List Paragraph\,bullet 1\,bullet\,List Paragraph1\,List Paragraph11\,Thang2\,Dot 1\,a\)\,abcCxSpFirst";
			mso-style-link:"List Paragraph Char\,bullet 1 Char\,bullet Char\,List Paragraph1 Char\,List Paragraph11 Char\,Thang2 Char\,Dot 1 Char\,a\) Char\,abc Char";
			margin-top:0in;
			margin-right:0in;
			margin-bottom:0in;
			margin-left:.5in;
			line-height:107%;
			font-size:11.0pt;
			font-family:"Calibri",sans-serif;}
		p.MsoListParagraphCxSpMiddle, li.MsoListParagraphCxSpMiddle, div.MsoListParagraphCxSpMiddle
		{mso-style-name:"List Paragraph\,bullet 1\,bullet\,List Paragraph1\,List Paragraph11\,Thang2\,Dot 1\,a\)\,abcCxSpMiddle";
			mso-style-link:"List Paragraph Char\,bullet 1 Char\,bullet Char\,List Paragraph1 Char\,List Paragraph11 Char\,Thang2 Char\,Dot 1 Char\,a\) Char\,abc Char";
			margin-top:0in;
			margin-right:0in;
			margin-bottom:0in;
			margin-left:.5in;
			line-height:107%;
			font-size:11.0pt;
			font-family:"Calibri",sans-serif;}
		p.MsoListParagraphCxSpLast, li.MsoListParagraphCxSpLast, div.MsoListParagraphCxSpLast
		{mso-style-name:"List Paragraph\,bullet 1\,bullet\,List Paragraph1\,List Paragraph11\,Thang2\,Dot 1\,a\)\,abcCxSpLast";
			mso-style-link:"List Paragraph Char\,bullet 1 Char\,bullet Char\,List Paragraph1 Char\,List Paragraph11 Char\,Thang2 Char\,Dot 1 Char\,a\) Char\,abc Char";
			margin-top:0in;
			margin-right:0in;
			margin-bottom:8.0pt;
			margin-left:.5in;
			line-height:107%;
			font-size:11.0pt;
			font-family:"Calibri",sans-serif;}
		span.HeaderChar
		{mso-style-name:"Header Char";
			mso-style-link:Header;}
		span.ListParagraphChar
		{mso-style-name:"List Paragraph Char\,bullet 1 Char\,bullet Char\,List Paragraph1 Char\,List Paragraph11 Char\,Thang2 Char\,Dot 1 Char\,a\) Char\,abc Char";
			mso-style-link:"List Paragraph\,bullet 1\,bullet\,List Paragraph1\,List Paragraph11\,Thang2\,Dot 1\,a\)\,abc";}
		.MsoChpDefault
		{font-family:"Calibri",sans-serif;}
		.MsoPapDefault
		{margin-bottom:8.0pt;
			line-height:107%;}
		/* Page Definitions */
		@page WordSection1
		{size:8.5in 11.0in;
			margin:.2in .3in .3in 12.25pt;}
		div.WordSection1
		{page:WordSection1; margin: 0 25pt 0 25pt;}
		@page WordSection2
		{size:8.5in 11.0in;
			margin:85.1pt 42.55pt 28.4pt 56.7pt;}
		div.WordSection2
		{page:WordSection2;}

		ol
		{margin-bottom:0in;}
		ul
		{margin-bottom:0in;}

	</style>

</head>

<body lang=EN-US >
<?php
$mydate = getdate(date("U"));
$number_day_loan = (!empty($logs->new->number_day_loan) && $logs->new->number_day_loan >0) ? $logs->new->number_day_loan  : $contract->loan_infor->number_day_loan/30;
$type_interest = (!empty($logs->new->type_interest) && $logs->new->type_interest>0) ? $logs->new->type_interest : $contract->loan_infor->type_interest;
$amount_money = (!empty($logs->new->amount_money) && $logs->new->amount_money>0) ? (int)$logs->new->amount_money : (int)$contract->loan_infor->amount_money;
$customer_name = !empty($contract->customer_infor->customer_name) ? $contract->customer_infor->customer_name : "";
$customer_identify = !empty($contract->customer_infor->customer_identify) ? $contract->customer_infor->customer_identify : "";
$bank_account = !empty($contract->receiver_infor->bank_account) ? $contract->receiver_infor->bank_account : $contract->receiver_infor->atm_card_number;
$bank_branch = !empty($contract->receiver_infor->bank_branch) ? $contract->receiver_infor->bank_branch : "";
$dangkycapngay = ($ngaycapdangky) ? date('d/m/Y', strtotime($ngaycapdangky)) : '';
$created_at = !empty($contract->created_at) ? $contract->created_at : "";
?>
<div class=WordSection1>
	<div align="center">
		<table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="714" style="width: 535.25pt; border-collapse: collapse;">
			<tr style="height: 71.5pt;">
				<td width="137" style="width: 102.85pt;  height: 71.5pt;">
					<p class="MsoNormal" align="center" style="text-align: center;">
                          <span style="font-size: 10pt; line-height: 107%; font-family: 'Tahoma', sans-serif; color: blue;">
                                  <img style="height:70px;" src="https://tienngay.vn/assets/home/images/logo.png" alt="">
                          </span>
					</p>
				</td>
				<td width="577" valign="top" style="width: 432.4pt;  height: 71.5pt;">

				</td>
			</tr>
		</table>
	</div>
	<p class=MsoNormal align=center style='margin-bottom:0in;text-align:center'><b><span
				style='font-size:11.0pt;line-height:107%;font-family:"Times New Roman",serif'>PHỤ
LỤC 01</span></b></p>

	<p class=MsoNormal align=center style='margin-bottom:0in;text-align:center'><b><i><span
					style='font-size:10.0pt;line-height:107%;font-family:"Times New Roman",serif'>Về
việc: Điều chỉnh thông tin số tiền vay</span></i></b></p>

	<p class=MsoNormal align=center style='margin-bottom:0in;text-align:center'><b><i><span
					style='font-size:10.0pt;line-height:107%;font-family:"Times New Roman",serif'>&nbsp;</span></i></b></p>

	<p class=MsoListParagraphCxSpFirst style='margin-top:0in;margin-right:0in;
margin-bottom:0in;margin-left:45.0pt;text-indent:-.25in'><span
			style='font-size:10.0pt;line-height:107%;font-family:"Times New Roman",serif'>-<span
				style='font:7.0pt "Times New Roman"'>
</span></span><i><span style='font-size:10.0pt;line-height:107%;font-family:
"Times New Roman",serif'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Căn cứ Thỏa thuận ba bên về việc hỗ trợ tài chính số <?= empty($code_contract) ? '…………………………………………' : $code_contract ?>
ngày <?=  date('d',$created_at); ?> tháng <?=  date('m',$created_at); ?> năm <?= date('Y',$created_at) ?>;
    </span></i></p>

	<p class=MsoListParagraphCxSpLast style='margin-top:0in;margin-right:0in;
margin-bottom:0in;margin-left:45.0pt;text-indent:-.25in'><span
			style='font-size:10.0pt;line-height:107%;font-family:"Times New Roman",serif'>-<span
				style='font:7.0pt "Times New Roman"'>
</span></span><i><span style='font-size:10.0pt;line-height:107%;font-family:
"Times New Roman",serif'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Căn cứ nhu cầu, khả năng của các bên.</span></i></p>

	<table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width=720
		   style='margin-left:22.5pt;border-collapse:collapse;border:none'>
		<tr style='height:582.7pt'>
			<td width=720 valign=top style='width:7.5in;padding:0in 5.4pt 0in 5.4pt;
  height:582.7pt'>
				<p class=MsoNormal style='margin-bottom:3.0pt;line-height:normal'><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'>Hôm nay, ngày <?php
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
						?> năm <?= $mydate['year'] ?>, tại <?=  ($contract->store->address) ? $contract->store->address : '………………………………………' ?></span></p>
				<p class=MsoNormal style='margin-bottom:3.0pt;line-height:normal'><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'>Các Bên gồm:</span></p>

				<table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 width=743
					   style='border-collapse:collapse;border:none'>
					<tr style='height:12.5pt'>
						<td width=161 valign=top style='width:120.9pt;
    height:12.5pt'>
							<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><b><span
										style='font-size:11.0pt;font-family:"Times New Roman",serif'>Bên Vay:</span></b></p>
						</td>
						<td width=209 valign=top style='width:156.55pt;padding:0in 5.4pt 0in 5.4pt;
    height:12.5pt'>

						</td>
						<td width=163 valign=top style='width:122.45pt;padding:0in 5.4pt 0in 5.4pt;
    height:12.5pt'>
							<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><b><span
										style='font-size:11.0pt;font-family:"Times New Roman",serif'>Bên Cho Vay:</span></b></p>
						</td>
						<td width=210 valign=top style='width:157.5pt;padding:0in 5.4pt 0in 5.4pt;
    height:12.5pt'>
							<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>: ……………………………………</span></p>
						</td>
					</tr>
					<tr style='height:12.5pt'>
						<td width=161 valign=top style='width:120.9pt;padding:0in 5.4pt 0in 5.4pt;
    height:12.5pt'>
							<p class=MsoNormal style='margin-bottom:0in;text-indent:-6.0pt;line-height:
    normal'><span style='font-size:10.0pt;font-family:"Times New Roman",serif'>Họ
    và tên</span></p>
						</td>
						<td width=209 valign=top style='width:156.55pt;padding:0in 5.4pt 0in 5.4pt;
    height:12.5pt'>
							<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>:
    <?=($customer_name) ? $customer_name : '………………………………………' ?></span></p>
						</td>
						<td width=163 valign=top style='width:122.45pt;padding:0in 5.4pt 0in 5.4pt;
    height:12.5pt'>
							<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>Họ và tên</span></p>
						</td>
						<td width=210 valign=top style='width:157.5pt;padding:0in 5.4pt 0in 5.4pt;
    height:12.5pt'>
							<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>: ……………………………………</span></p>
						</td>
					</tr>
					<tr style='height:12.5pt'>
						<td width=161 valign=top style='width:120.9pt;padding:0in 5.4pt 0in 5.4pt;
    height:12.5pt'>
							<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:
    0in;margin-left:-2.4pt;text-indent:-.05in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>Ngày sinh</span></p>
						</td>
						<td width=209 valign=top style='width:156.55pt;padding:0in 5.4pt 0in 5.4pt;
    height:12.5pt'>
							<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>:
    <?= ($customerDOB) ? $customerDOB : '………………………………………' ?></span></p>
						</td>
						<td width=163 valign=top style='width:122.45pt;padding:0in 5.4pt 0in 5.4pt;
    height:12.5pt'>
							<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>Ngày sinh</span></p>
						</td>
						<td width=210 valign=top style='width:157.5pt;padding:0in 5.4pt 0in 5.4pt;
    height:12.5pt'>
							<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>: ……………………………………</span></p>
						</td>
					</tr>
					<tr style='height:12.5pt'>
						<td width=161 valign=top style='width:120.9pt;padding:0in 5.4pt 0in 5.4pt;
    height:12.5pt'>
							<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:
    0in;margin-left:-2.4pt;text-indent:-.05in;line-height:normal'><span
									style='font-size:9.0pt;font-family:"Times New Roman",serif'>Số CMND/CCCD/Hộ
    chiếu</span></p>
						</td>
						<td width=209 valign=top style='width:156.55pt;padding:0in 5.4pt 0in 5.4pt;
    height:12.5pt'>
							<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>:
    <?= ($customer_identify) ? $customer_identify : '………………………………………'?></span></p>
						</td>
						<td width=163 valign=top style='width:122.45pt;padding:0in 5.4pt 0in 5.4pt;
    height:12.5pt'>
							<p class=MsoNormal style='margin-bottom:0in;text-indent:-1.2pt;line-height:
    normal'><span style='font-size:9.0pt;font-family:"Times New Roman",serif'>Số
    CMND/CCCD/Hộ chiếu</span></p>
						</td>
						<td width=210 valign=top style='width:157.5pt;padding:0in 5.4pt 0in 5.4pt;
    height:12.5pt'>
							<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>: ……………………………………</span></p>
						</td>
					</tr>
					<tr style='height:16.3pt'>
						<td width=161 valign=top style='width:120.9pt;padding:0in 5.4pt 0in 5.4pt;
    height:16.3pt'>
							<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:
    0in;margin-left:-2.4pt;text-indent:-.05in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>Địa chỉ nơi ở
    hiện tại</span></p>
						</td>
						<td width=209 valign=top style='width:156.55pt;padding:0in 5.4pt 0in 5.4pt;
    height:16.3pt'>
							<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>: <?= ($address) ? $address : '………………………………………' ?></span></p>
						</td>
						<td width=163 valign=top style='width:122.45pt;padding:0in 5.4pt 0in 5.4pt;
    height:16.3pt'>
							<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>Địa chỉ nơi ở
    hiện tại</span></p>
						</td>
						<td width=210 valign=top style='width:157.5pt;padding:0in 5.4pt 0in 5.4pt;
    height:16.3pt'>
							<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>: ……………………………………</span></p>
						</td>
					</tr>
					<tr style='height:12.5pt'>
						<td width=161 valign=top style='width:120.9pt;padding:0in 5.4pt 0in 5.4pt;
    height:12.5pt'>
							<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:
    0in;margin-left:-2.4pt;text-indent:-.05in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>Số tài khoản/Số
    thẻ</span></p>
						</td>
						<td width=209 valign=top style='width:156.55pt;padding:0in 5.4pt 0in 5.4pt;
    height:12.5pt'>
							<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>:
    <?= ($bank_account) ? $bank_account : '………………………………………' ?></span></p>
						</td>
						<td width=163 valign=top style='width:122.45pt;padding:0in 5.4pt 0in 5.4pt;
    height:12.5pt'>
							<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>&nbsp;</span></p>
						</td>
						<td width=210 valign=top style='width:157.5pt;padding:0in 5.4pt 0in 5.4pt;
    height:12.5pt'>
							<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>&nbsp;</span></p>
						</td>
					</tr>
					<tr style='height:16.3pt'>
						<td width=161 valign=top style='width:120.9pt;padding:0in 5.4pt 0in 5.4pt;
    height:16.3pt'>
							<p class=MsoNormal style='margin-top:0in;margin-right:0in;margin-bottom:
    0in;margin-left:-2.4pt;text-indent:-.05in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>Tại Ngân hàng</span></p>
						</td>
						<td width=209 valign=top style='width:156.55pt;padding:0in 5.4pt 0in 5.4pt;
    height:16.3pt'>
							<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>: <?= ($bank_name_nganluong) ? $bank_name_nganluong : '………………………………………………'?></span></p>
						</td>
						<td width=163 valign=top style='width:122.45pt;padding:0in 5.4pt 0in 5.4pt;
    height:16.3pt'>
							<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>Chi nhánh</span></p>
						</td>
						<td width=210 valign=top style='width:157.5pt;padding:0in 5.4pt 0in 5.4pt;
    height:16.3pt'>
							<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><span
									style='font-size:10.0pt;font-family:"Times New Roman",serif'>: <?= ($bank_branch) ? $bank_branch : '…………………………' ?></span></p>
						</td>
					</tr>

				</table>
				<p class=MsoNormal style='margin-bottom:0in;line-height:normal'><i><span
							style='font-size:10.0pt;font-family:"Times New Roman",serif'>Sau đây gọi tắt
  là <b>“Bên Vay”                                                                  
  </b>Sau đây gọi tắt là <b>“Bên Cho Vay”</b></span></i></p>
				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><b><span
							style='font-size:11.0pt;font-family:"Times New Roman",serif'>Bên cung cấp dịch
  vụ: CÔNG TY CỔ PHẦN CÔNG NGHỆ TIỆN NGAY ĐÔNG BẮC</span></b></p>
				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'>Địa chỉ trụ sở
  chính: Tầng 15, Khối B, Tòa nhà Sông Đà, đường Phạm Hùng, Phường Mỹ Đình 1,
  Quận Nam Từ Liêm, thành phố Hà Nội. </span></p>
				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'>Địa điểm giao dịch:
  <?= ($contract->store->address) ? $contract->store->address : '………………………………………………………………………………………………………………..……..' ?></span></p>
				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'>Đại diện bởi: <?= isset($store->representative) ? $store->representative : '…………………………………………….' ?>, Giấy
  ủy quyền số: …….……………………………………………………..</span></p>
				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><i><span
							style='font-size:10.0pt;font-family:"Times New Roman",serif'>Sau đây gọi tắt
  là <b>“Công Ty Đông Bắc”</b></span></i></p>
				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><i><span
							style='font-size:10.0pt;font-family:"Times New Roman",serif'>&nbsp;</span></i></p>
				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><i><span
							style='font-size:10.0pt;font-family:"Times New Roman",serif'>Các bên cùng thỏa
  thuận điều chỉnh, bổ sung Thỏa thuận ba bên về việc hỗ trợ tài chính số <?= empty($code_contract) ? '…………………………………………' : $code_contract ?> </span></i></p>
				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><i><span
							style='font-size:10.0pt;font-family:"Times New Roman",serif'>ký
  ngày <?=  date('d',$created_at); ?>/<?=  date('m',$created_at); ?>/<?=  date('Y',$created_at); ?> (Sau đây gọi là “Thỏa thuận ba bên”) như sau:</span></i></p>
				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><b><span
							style='font-size:11.0pt;font-family:"Times New Roman",serif'>Điều 1. Điều chỉnh
  Thông tin khoản vay tại Khoản 1, Khoản 2, Khoản 7, Khoản 8, Khoản 9, Khoản
  10, Mục I của Thỏa thuận ba bên như sau:</span></b></p>

				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'>“1. Số Tiền Đề
  Nghị Vay: <?= (number_format($amount_money, 0, '.', '.') . ' đ') ? (number_format($amount_money, 0, '.', '.') . ' đ') : '…………………….... …………………..'?></span></p>
				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'>(Bằng chữ:  <b class="qcont"><?= ($amount_money>0) ? convert_number_to_words($amount_money) : '………………………………………………….…' ?></b>).”</span></p>
				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'>“2. Số Tiền Vay:
  …………………………………………………………………………..….………….... …………………………..</span></p>
				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'>(Bằng chữ: ………………………………………………………………………………..……………………………………….……)</span></p>
				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'>(Lưu ý: Số Tiền
  Vay luôn luôn bé hơn hoặc bằng với Số Tiền Đề Nghị Vay)”.</span></p>
				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'>“7. Thời hạn
  vay: </span><span style='font-size:10.0pt;font-family:"Segoe UI Symbol",sans-serif'><?= ($number_day_loan == 1) ? "&#9745;" : "☐" ?></span><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'> 01 tháng      </span><span
						style='font-size:10.0pt;font-family:"Segoe UI Symbol",sans-serif'><?= ($number_day_loan == 3) ? "&#9745;" : "☐" ?></span><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'> 03 tháng      </span><span
						style='font-size:10.0pt;font-family:"Segoe UI Symbol",sans-serif'><?= ($number_day_loan == 6) ? "&#9745;" : "☐" ?></span><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'> 06 tháng      </span><span
						style='font-size:10.0pt;font-family:"Segoe UI Symbol",sans-serif'><?= ($number_day_loan == 9) ? "&#9745;" : "☐" ?></span><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'> 09 tháng      </span><span
						style='font-size:10.0pt;font-family:"Segoe UI Symbol",sans-serif'><?= ($number_day_loan == 12) ? "&#9745;" : "☐" ?></span><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'> 12 tháng    </span><span
						style='font-size:10.0pt;font-family:"Segoe UI Symbol",sans-serif'><?= ($number_day_loan == 18) ? "&#9745;" : "☐" ?></span><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'> 18 tháng      </span><span
						style='font-size:10.0pt;font-family:"Segoe UI Symbol",sans-serif'><?= ($number_day_loan == 24) ? "&#9745;" : "☐" ?></span><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'> 24 tháng”</span></p>
				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'>“8. Kỳ thanh
  toán: <b>Hàng tháng</b>”.</span></p>
				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'>“Phương thức
  thanh toán:………………………………………………………………………………………………………………..</span></p>
				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><span
						style='font-size:10.0pt;font-family:"Segoe UI Symbol",sans-serif'><?= ($type_interest == 2) ? "&#9745; " : "☐ "?></span><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'> 1.Thanh toán gốc
  cuối kỳ, lãi và các khoản phí (nếu có) hàng tháng</span></p>
				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><span
						style='font-size:10.0pt;font-family:"Segoe UI Symbol",sans-serif'><?= ($type_interest == 1) ? "&#9745; " : "☐ "?></span><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'> 2.Thanh toán gốc,
  lãi và các khoản phí (nếu có) hàng tháng theo thông báo cụ thể của Công Ty Đông Bắc”.</span></p>
				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><span
						style='font-size:10.0pt;font-family:"Times New Roman",serif'>“10. Tổng số tiền
  phải trả hàng tháng: …………………. (Bằng chữ:……………………………………………………….……)”.</span></p>
				<p class=MsoNormal style='margin-top:3.0pt;margin-right:0in;margin-bottom:
  0in;margin-left:0in;text-align:justify;line-height:normal'><b><span
							style='font-size:11.0pt;font-family:"Times New Roman",serif'>Điều 2: Các điều
  khoản khác</span></b></p>
				<p class=MsoListParagraphCxSpLast style='margin-top:3.0pt;margin-right:0in;
  margin-bottom:0in;margin-left:16.8pt;text-align:justify;text-indent:-.25in;
  line-height:normal'><span style='font-size:10.0pt;font-family:"Times New Roman",serif'>-<span
							style='font:7.0pt "Times New Roman"'>
 </span><span style='font-size:10.0pt;font-family:"Times New Roman",serif'>&nbsp;Phụ
  lục này là một bộ phận không thể tách rời của Thỏa thuận ba bên về việc hỗ trợ
  tài chính số …………………………………………………… ký ngày……/……/……….</span></p>

				<p class=MsoListParagraphCxSpLast style='margin-top:3.0pt;margin-right:0in;
  margin-bottom:0in;margin-left:16.8pt;text-align:justify;text-indent:-.25in;
  line-height:normal'><span style='font-size:10.0pt;font-family:"Times New Roman",serif'>-<span
							style='font:7.0pt "Times New Roman"'>
 </span><span style='font-size:10.0pt;font-family:"Times New Roman",serif'>&nbsp;&nbsp;Các
  điều khoản không được quy định tại Phụ lục này được tuân thủ theo đúng quy định
  tại Thỏa thuận ba bên số  ………………………………………… ký ngày……/……/……….</span></p>
				<p class=MsoListParagraphCxSpLast style='margin-top:3.0pt;margin-right:0in;
  margin-bottom:0in;margin-left:16.8pt;text-align:justify;text-indent:-.25in;
  line-height:normal'><span style='font-size:10.0pt;font-family:"Times New Roman",serif'>-<span
							style='font:7.0pt "Times New Roman"'>
 </span><span style='font-size:10.0pt;font-family:"Times New Roman",serif'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Phụ
  lục này có hiệu lực kể từ ngày ký. Phụ Lục được lập thành 03 (ba) bản bằng tiếng
  Việt, mỗi bên giữ 01(một) bản, mỗi bản có giá trị pháp lý như nhau.</span></p>
				<table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0 align=left
					   width=745 style='border-collapse:collapse;border:none;margin-left:6.75pt;
   margin-right:6.75pt'>
					<tr style='height:22.0pt'>
						<td width=248 valign=top style='width:186.3pt;padding:0in 5.4pt 0in 5.4pt;
    height:22.0pt'>
							<p class=MsoNormal align=center style='margin-top:3.0pt;margin-right:0in;
    margin-bottom:0in;margin-left:0in;text-align:center;line-height:normal'><b><span
										style='font-size:11.0pt;font-family:"Times New Roman",serif'>BÊN CHO VAY</span></b></p>
						</td>
						<td width=248 valign=top style='width:186.3pt;padding:0in 5.4pt 0in 5.4pt;
    height:22.0pt'>
							<p class=MsoNormal align=center style='margin-top:3.0pt;margin-right:0in;
    margin-bottom:0in;margin-left:0in;text-align:center;line-height:normal'><b><span
										style='font-size:11.0pt;font-family:"Times New Roman",serif'>BÊN VAY</span></b></p>
						</td>
						<td width=248 valign=top style='width:186.35pt;padding:0in 5.4pt 0in 5.4pt;
    height:22.0pt'>
							<p class=MsoNormal align=center style='margin-top:3.0pt;margin-right:0in;
    margin-bottom:0in;margin-left:0in;text-align:center;line-height:normal'><b><span
										style='font-size:11.0pt;font-family:"Times New Roman",serif'>ĐẠI DIỆN CÔNG TY ĐÔNG BẮC</span></b></p>
						</td>
					</tr>
				</table>
				<p class=MsoNormal style='margin-bottom:0in;text-align:justify;line-height:
  115%'></p>
			</td>
		</tr>
	</table>

</div>


</body>

</html>
