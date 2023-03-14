<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
if (!function_exists('contract_status')) {
	function contract_status($status = null)
	{
		$result = '';
		$leadstatus = [
			1 => "Mới",
			2 => "Chờ trưởng PGD duyệt",
			3 => "Đã hủy",
			4 => "Trưởng PGD không duyệt",
			5 => "Chờ hội sở duyệt",
			6 => "Đã duyệt",
			7 => "Kế toán không duyệt",
			8 => "Hội sở không duyệt",
			9 => "Chờ ngân lượng xử lý",
			10 => "Giải ngân ngân lượng thất bại",
			11 => "Chờ TP quản lý hợp đồng vay duyệt gia hạn",
			12 => "Chờ TP quản lý hợp đồng vay duyệt cơ cấu",
			13 => "TP quản lý hợp đồng vay không duyệt gia hạn",
			14 => "TP quản lý hợp đồng vay không duyệt cơ cấu",
			15 => "Chờ giải ngân",
			16 => "Đã tạo lệnh giải ngân thành công",
			17 => "Đang vay",
			18 => "Giải ngân thất bại",
			19 => "Đã tất toán",
			20 => "Đã quá hạn",
			21 => "Chờ trưởng PGD duyệt gia hạn",
			22 => "Trưởng PGD không duyệt gia hạn",
			23 => "Chờ trưởng PGD duyệt cơ cấu",
			24 => "Trưởng PGD không duyệt cơ cấu",
			25 => "Chờ hội sở duyệt gia hạn",
			26 => "Hội sở không duyệt gia hạn",
			27 => "Chờ hội sở duyệt cơ cấu",
			28 => "Hội sở không duyệt cơ cấu",
			29 => "Chờ tạo phiếu thu gia hạn",
			30 => "Chờ ASM duyệt gia hạn",
			31 => "Chờ tạo phiếu thu cơ cấu",
			32 => "Chờ ASM duyệt cơ cấu",
			33 => "Đã gia hạn",
			34 => "Đã cơ cấu",
			35 => "Chờ ASM duyệt",
			36 => "ASM không duyệt",
			37 => "Chờ thanh lý",
			38 => "Chờ CEO duyệt thanh lý",
			39 => "Chờ TP quản lý hợp đồng vay thanh lý tài sản",
			40 => "Chờ tạo phiếu thu thanh lý tài sản",
			41 => "ASM không duyệt gia hạn",
			42 => "ASM không duyệt cơ cấu",
			43 => "CEO không duyệt thanh lý xe",
			44 => "Chờ định giá tài sản thanh lý",
			45 => "BPĐG trả về yêu cầu định giá tài sản",
			46 => "Chờ TP quản lý hợp đồng vay cập nhật giá tham khảo",
			47 => "Chờ TP quản lý hợp đồng vay duyệt thay CEO",
			48 => "Chờ bán tài sản thanh lý",
			49 => "Chờ BPĐG định giá lại",
		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('loan_products')) {
	function loan_products($status = null)
	{
		$result = '';
		$leadstatus = [
			1 => "Vay nhanh xe máy",
			2 => "Vay theo đăng ký - cà vẹt xe máy",
			3 => "Vay theo đăng ký - cà vẹt xe máy không chính chủ",
			4 => "Cầm cố xe máy",
			5 => "Cầm cố ô tô",
			6 => "Vay nhanh ô tô",
			7 => "Vay theo đăng ký - cà vẹt ô tô",
			8 => "Vay tín chấp CBNV VFC",
			9 => "Vay tín chấp CBNV tập đoàn",
			10 => "Vay theo xe CBNV VFC",
			11 => "Vay theo xe CBNV tập đoàn",
			12 => "Vay theo xe CBNV Phúc Bình",
			13 => "Quyền sử dụng đất",
			14 => "Bổ sung vốn kinh doanh Online",
			15 => "Vay tín chấp CBNV Phúc Bình",
			16 => "Sổ đỏ",
			17 => "Sổ hồng, hợp đồng mua bán căn hộ",
			18 => "Ứng tiền siêu tốc cho tài xế công nghệ",
			19 => "Sản phẩm vay nhanh gán định vị"
		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('bh_products')) {
	function bh_products($status = null)
	{
		$result = '';
		$leadstatus = [
			1 => "GIC - EASY",
			2 => "GIC - Phúc Lộc Thọ",
			3 => "PTI - Vững Tâm An",
			4 => "VBI - Ung Thư Vú",
			5 => "VBI - Sốt Xuất Huyết",
			6 => "MIC TNDS",
			7 => "TNDS Ô Tô VBI",

		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('loai_khach')) {
	function loai_khach($status = null)
	{
		$result = '';
		$leadstatus = [
			'BN' => "Bán ngoài",
			'NB' => "Nội bộ",


		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('checkBH')) {
	function checkBH($money = "", $money_bh = "", $type = "", $number_day_loan = 0, $disbursement_date = 0)
	{
		$code_GIC_easy = "";
		$month_loan = $number_day_loan / 30;
		$money_bh_ck = 0;
		if (!empty($money_bh)) {
			if ($disbursement_date > 1596240000) {
				if ($type == "GIC_KV" || $type == "MIC_KV") {
					if ($month_loan > 12) {
						$money_bh_ck = round($money * 0.06);
						if ($money_bh != $money_bh_ck) {
							return false;
						}
					} else {
						$money_bh_ck = round($money * 0.05);
						if ($money_bh != $money_bh_ck) {
							return false;
						}
					}
				}
			} else {
				$money_bh_ck = round($money * 0.03);
				if ($money_bh != $money_bh_ck) {
					return false;
				}
			}
			if ($type == "GIC_EASY") {
				if ($code_GIC_easy == "GIC_EASY_20") {
					$money_bh_ck = "348000";
					if ($money_bh != $money_bh_ck) {
						return false;
					}
				}
				if ($code_GIC_easy == "GIC_EASY_40") {
					$money_bh_ck = "398000";
					if ($money_bh != $money_bh_ck) {
						return false;
					}
				}
				if ($code_GIC_easy == "GIC_EASY_70") {
					$money_bh_ck = "598000";
					if ($money_bh != $money_bh_ck) {
						return false;
					}
				}
			}
		} else {
			return true;
		}
		return true;
	}
}

if (!function_exists('status_job')) {
	function status_job($status = null)
	{
		$leadstatus = [
			1 => 'Nhân viên văn phòng',
			2 => 'Nhân viên kinh doanh',
			3 => 'Bán hàng',
			4 => 'Kế toán-Kiểm toán',
			5 => 'Tư vấn',
			6 => 'Kỹ thuật',
			7 => 'Quản trị kinh doanh',
			8 => 'Xây dựng',
			9 => 'Marketing-PR',
			10 => 'Điện-Điện tử-Điện lạnh',
			11 => 'Cơ khí-Chế tạo',
			12 => 'Khách sạn-Nhà hàng',
			13 => 'Kiến trúc-TK nội thất',
			14 => 'Nhân sự',
			15 => 'Kho vận-Vật tư',
			16 => 'Thực phẩm-Đồ uống',
			17 => 'Dịch vụ',
			18 => 'Thư ký-Trợ lý',
			19 => 'Ngân hàng',
			20 => 'Thiết kế-Mỹ thuật',
			21 => 'Tài chính-Đầu tư',
			22 => 'Biên-Phiên dịch',
			23 => 'Vận tải',
			24 => 'Tiếp thị-Quảng cáo',
			25 => 'Ngoại thương-Xuất nhập khẩu',
			26 => 'IT phần mềm',
			27 => 'Ô tô - Xe máy',
			28 => 'KD bất động sản',
			29 => 'IT phần cứng/mạng',
			30 => 'Y tế-Dược',
			31 => 'Kỹ thuật ứng dụng',
			32 => 'Thiết kế đồ hoạ web',
			33 => 'Dệt may - Da giày',
			34 => 'Giáo dục-Đào tạo',
			35 => 'Điện tử viễn thông',
			36 => 'Thương mại điện tử',
			37 => 'Spa-Mỹ phẩm-Trang sức',
			38 => 'Công nghiệp',
			39 => 'Thời trang',
			40 => 'Báo chí-Truyền hình',
			41 => 'Hoá học-Sinh học',
			42 => 'Ngành nghề khác',
			43 => 'In ấn-Xuất bản',
			44 => 'Du lịch',
			45 => 'Pháp lý-Luật',
			46 => 'Hoạch định-Dự án',
			47 => 'Quan hệ đối ngoại',
			48 => 'Nông-Lâm-Ngư nghiệp',
			49 => 'An ninh-Bảo vệ',
			50 => 'Bảo hiểm',
			51 => 'Tổ chức sự kiện-Quà tặng',
			52 => 'Bưu chính',
			53 => 'Dầu khí-Hóa chất',
			54 => 'Nghệ thuật - Điện ảnh',
			55 => 'Công nghệ cao',
			56 => 'Hàng gia dụng',
			57 => 'Hàng hải',
			58 => 'Chứng khoán- Vàng',
			59 => 'Hàng không',
			60 => 'Thủ công mỹ nghệ',
			61 => 'Gammer',
			62 => 'Tài xế tự do',
			63 => 'Kinh doanh tự do',
			64 => 'Tài xế công nghệ',
			65 => 'Tài xế Grap',
			66 => 'Tài xế Be',
			67 => 'Tài xế Goviet',
			68 => 'Tài xế HeyU',
			69 => 'Tài xế FastGo',
			70 => 'Tài xế MyGo',
			71 => 'Shipper tự do',
			72 => 'Shipper công nghệ'
		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('note_renewal')) {
	function note_renewal($status = null)
	{
		$leadstatus = [
			1 => 'C_CAB - KH chưa nghe máy, gọi lại sau',
			2 => 'C_HUP - Đang nói chuyện cúp máy ngang',
			3 => 'C_NAB - Số không liên lạc được, số không tồn tại, số không đúng',
			4 => 'C_NCP - Không phải số KH/ Số người thân',
			5 => 'C_NKP - Không nhấc máy/máy bận/gọi vào hộp thư thoại',
			6 => 'C_PA - Đã thanh toán',
			7 => 'C_PTP - Hứa thanh toán',
			8 => 'C_RTP - Từ chối thanh toán',
			9 => 'C_WFP - Khách hàng đã thanh toán đang chờ Phòng Kế toán kiểm tra',
			10 => 'C_DIF - KH khó khăn kinh tế',
			11 => 'C_HPR - Gia đình bận rộn (đám cưới, đám tang, về quê, công tác, nghỉ mát)',
			12 => 'C_IGN1 - Khách hàng chưa nhận khoản vay',
			13 => 'C_IGN2 - Khách hàng báo đã hủy hợp đồng',
			14 => 'C_IGN3 - Đang chờ điều chỉnh hóa đơn',
			15 => 'C_IGN4 - Đang chờ gửi ảnh nộp tiền xác nhận khoản treo',
			16 => 'C_IGN5 - Đang chờ giảm phí phạt, đóng hợp đồng',
			17 => 'C_IGN6 - Khách hàng đã thanh toán trước khi nhân viên được phân hợp đồng',
			18 => 'C_LEM - Để lại lời nhắn cho người thân',
			19 => 'C_LEM_O - Để lại lời nhắn cho người khác',
			20 => 'C_CGI - KH đi tù/nghĩa vụ/cai nghiện/tâm thần',
			21 => 'C_LST - Mất việc làm, phá sản, làm ăn thua lỗ',
			22 => 'C_WAS - Chờ thu nhập, trợ cấp của người thân',
			23 => 'C_MCW - KH bị bệnh, tai nạn',
			24 => 'C_CTI - Thiên tai, mất mùa, bão lũ…',
			25 => 'C_RMA - Người thân ốm đau, tai nạn',
			26 => 'C_CNZ - KH không sử dụng zalo',
			27 => 'C_CNF - KH không sử dụng facebook',
			28 => 'C_SZC - Đã gửi thông báo qua zalo cho KH',
			29 => 'C_SFC - Đã gửi thông báo qua facebook cho KH',
			30 => 'C_CBPZF - Khách hàng đã chặn điện thoại, zalo, facebook',
			31 => 'C_BED - Khách hàng bị người môi giới lừa đứng tên vay',
			32 => 'C_BRP - Xe đã được thu hồi',
			33 => 'C_CSO - Khách hàng đứng tên vay cho người khác',
			34 => 'C_DIE - Khách hàng chết, gia đình gặp khó khăn kinh tế',
			35 => 'C_GSF - Nghi ngờ gian lận: Sai địa chỉ, CMND giả, KH ko biết về khoản vay…',
			36 => 'C_TER - KH thanh lý hợp đồng',
			37 => 'C_CFF - Call không còn khả năng tác động và đủ điều kiện chuyển qua Thực địa',
			38 => 'F_BED - Khách hàng bị người môi giới lừa đứng tên vay',
			39 => 'F_BRP - Xe đã được thu hồi',
			40 => 'F_CSO - Khách hàng đứng tên vay cho người khác',
			41 => 'F_DIE - Khách hàng chết, gia đình gặp khó khăn kinh tế',
			42 => 'F_DIF - KH khó khăn kinh tế',
			43 => 'F_HOS - Nhà đã bán',
			44 => 'F_NAH1 - Không gặp được Khách hàng, đã để lại thư báo;',
			45 => 'F_NAH2 - Khách hàng bỏ nhà đi, thỉnh thoảng mới về, đã để lại thư báo',
			46 => 'F_NFH - Không tìm thấy nhà; Nhà đã bị giải tỏa.',
			47 => 'F_NIW - Công ty không hợp tác, không xác định được rõ Khách hàng còn làm hay không',
			48 => 'F_OBT - Đã thu được tiền',
			49 => 'F_RENT - KH thuê nhà trọ nhưng đã dọn đi (có thể gặp gia đình)',
			50 => 'F_SOB - Xe đã bán',
			51 => 'F_WAU - Khách hàng bỏ trốn, gia đình còn ở tại địa phương',
			52 => 'F_WET - Khách hàng bỏ trốn, không gặp được gia đình',
			53 => 'F_GSF - Nghi ngờ gian lận: Sai địa chỉ, CMND giả, KH ko biết về khoản vay…',
			54 => 'F_HPR - Gia đình bận rộn (đám cưới, đám tang, về quê, công tác, nghỉ mát)',
			55 => 'F_IGN1 - Khách hàng chưa nhận khoản vay',
			56 => 'F_IGN2 - Khách hàng báo đã hủy hợp đồng',
			57 => 'F_IGN3 - Đang chờ điều chỉnh hóa đơn',
			58 => 'F_IGN4 - Đang chờ gửi ảnh nộp tiền xác nhận khoản treo',
			59 => 'F_IGN5 - Đang chờ giảm phí phạt, đóng hợp đồng',
			60 => 'F_IGN6 - Khách hàng đã thanh toán trước khi nhân viên được phân hợp đồng',
			61 => 'F_LEM - Để lại lời nhắn cho người thân',
			62 => 'F_LEM_O - Để lại lời nhắn cho người khác',
			63 => 'F_PA - Đã thanh toán',
			64 => 'F_PTP - Hứa thanh toán',
			65 => 'F_RTP - Từ chối thanh toán',
			66 => 'F_WFP - Khách hàng đã thanh toán đang chờ Phòng Kế toán kiểm tra',
			67 => 'F_NLA - KH chưa từng ở địa chỉ được cung cấp',
			68 => 'F_CGI - KH đi tù/nghĩa vụ/cai nghiện/tâm thần',
			69 => 'F_LST - Mất việc làm, phá sản, làm ăn thua lỗ',
			70 => 'F_WAS - Chờ thu nhập, trợ cấp của người thân',
			71 => 'F_MCW - KH bị bệnh, tai nạn',
			72 => 'F_CTI - Thiên tai, mất mùa, bão lũ…',
			73 => 'F_RMA - Người thân ốm đau, tai nạn',
			74 => 'F_TER - KH thanh lý hợp đồng',
			75 => 'F_FFA - Thực địa không còn khả năng tác động và đủ điều kiện chuyển cho Pháp lý',
		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('bucket')) {
	function bucket($status = null)
	{
		$leadstatus = [
			'B0' => 'B0',
			'B1' => 'B1',
			'B2' => 'B2',
			'B3' => 'B3',
			'B4' => 'B4',
			'B5' => 'B5',
			'B6' => 'B6',
			'B7' => 'B7',
			'B8' => 'B8',

		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('get_bucket')) {
	function get_bucket($time = 0)
	{
		if ($time < 0) {
			$bucket = 'B0';
		} else if ($time == 0) {
			$bucket = 'B0';
		} else if ($time >= 1 && $time <= 9) {
			$bucket = 'B1';
		} else if ($time >= 10 && $time <= 30) {
			$bucket = 'B1';
		} else if ($time >= 31 && $time <= 60) {
			$bucket = 'B2';
		} else if ($time >= 61 && $time <= 90) {
			$bucket = 'B3';
		} else if ($time >= 91 && $time <= 120) {
			$bucket = 'B4';
		} else if ($time >= 121 && $time <= 150) {
			$bucket = 'B5';
		} else if ($time >= 151 && $time <= 180) {
			$bucket = 'B6';
		} else if ($time >= 181 && $time <= 360) {
			$bucket = 'B7';
		} else {
			$bucket = 'B8';
		}
		return $bucket;
	}
}
if (!function_exists('get_bucket_text')) {
	function get_bucket_text($time = 0)
	{
		if ($time < 0) {
			$bucket = '<span class="label label-success">Chưa đến kỳ </span>';
		} else if ($time == 0) {
			$bucket = '<span class="label label-info">Đến kỳ thanh toán</span>';
		} else if ($time >= 1 && $time <= 9) {
			$bucket = '<span class="label label-warning"> nhóm 1</span><br>( đủ tiêu chuẩn)';
		} else if ($time >= 10 && $time <= 30) {
			$bucket = '<span class="label label-warning"> nhóm 2</span><br>( cần chú ý)';
		} else if ($time >= 31 && $time <= 60) {
			$bucket = '<span class="label label-danger"> nhóm 3</span><br>( dưới tiêu chuẩn)';
		} else if ($time >= 61 && $time <= 90) {
			$bucket = '<span class="label label-danger"> nhóm 3</span><br>( dưới tiêu chuẩn)';
		} else if ($time >= 91 && $time <= 120) {
			$bucket = '<span class="label label-danger"> xấu nhóm 4</span><br>(  nghi ngờ bị mất vốn)';
		} else if ($time >= 121 && $time <= 150) {
			$bucket = '<span class="label label-danger"> xấu nhóm 4</span><br>(  nghi ngờ bị mất vốn)';
		} else if ($time >= 151 && $time <= 180) {
			$bucket = '<span class="label label-danger"> xấu nhóm 4</span><br>(  nghi ngờ bị mất vốn)';
		} else if ($time >= 181 && $time <= 360) {
			$bucket = '<span class="label label-danger"> xấu nhóm 5</span><br>( có khả năng mất vốn)';
		} else {
			$bucket = '<span class="label label-danger"> xấu nhóm 5</span><br>( có khả năng mất vốn)';
		}
		return $bucket;
	}
}
function get_code_plt($id)
{
	switch ($id) {
		case 'COPPER':
			return "COPPER-PHÚC";
			break;
		case 'SILVER':
			return "SILVER-LỘC";
			break;
		case 'GOLD':
			return "GOLD-THỌ";
		default:
			return "";
	}
}

if (!function_exists('contract_error_code')) {
	function contract_error_code($status = null)
	{
		$leadstatus = [
			'K1' => 'Không thực hiện đúng theo hướng dẫn kịch bản tư vấn gọi điện cho khách hàng từ nguồn hội sở',
			'K2' => 'Không thực hiện chương trình MKT của công ty',
			'K3' => 'Hình ảnh chụp giấy tờ/ảnh thực địa không đúng quy định',
			'K4' => 'Không thực hiện các bước kiểm tra tính thật giả của giấy tờ',
			'K5' => 'Không thực hiện kiểm tra quan hệ tín dụng của KH',
			'K6' => 'Không ghi chú rõ các trường hợp ngoại lệ',
			'K7' => 'Quỹ tiền mặt tại PGD vượt quy định nhưng TPGD không chuyển về công ty',
			'K8' => 'Không thực hiện luân chuyển hồ sơ về công ty đúng thời gian quy định',
			'K9' => 'Không đạt yêu cầu về tỷ lệ hồ sơ trả về theo quy định',
			'K10' => 'Không đạt yêu cầu về tỷ lệ hồ sơ huỷ theo quy định',
			'T-S1' => 'Cập nhập thiếu, sai tên KH/ngày sinh của KH trên hợp đồng/hệ thống',
			'T-S2' => 'Cập nhập thiếu, sai số CMND/CCCD của KH trên hợp đồng/hệ thống',
			'T-S3' => 'Cập nhập thiếu, sai tên TSĐB/model/biển số xe/số máy/số khung TSĐB trên hợp đồng/hệ thống',
			'T-S4' => 'Cập nhập thiếu, sai địa chỉ nơi ở và công việc của KH trên hợp đồng/hệ thống',
			'T-S5' => 'Câp nhập thiếu, sai số tiền vay/thời hạn vay/hình thức vay/hình thức trả trên hợp đồng/hệ thống',
			'T-S6' => 'Cập nhập thiếu, sai thông tin thẩm định thực địa và thẩm định qua điện thoại',
			'T-S7' => 'Cập nhập thiếu, sai số hợp đồng/ Mã HĐ',
			'T-S8' => 'Cập nhập thiếu ngày ký hợp đồng/ngày giải ngân trên hợp đồng/ sai ngày ký hợp đồng trên các giấy tờ khác.',
			'T-S9' => 'Cập nhật thiếu/ sai tên tài khoản khách hàng trên hệ thống/ hợp đồng',
			'T-S10' => 'Cập nhập thiếu các thông tin khác trên hợp đồng/hệ thống',
			'T-S11' => 'Upload thiếu chứng từ mà không ghi chú',

		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
//'4' => 'Chưa gửi duyệt' phiếu thu hợp đồng
//'10' => 'Chưa gửi duyệt' phiếu thu khác
if (!function_exists('status_transaction')) {
	function status_transaction($status = null)
	{
		$leadstatus = [
			'new' => 'Mới',
			'1' => 'Thành công',
			'2' => 'Chờ xác nhận',
			'3' => 'Đã hủy',
			'4' => 'Chưa gửi duyệt PT hợp đồng',
			'10' => 'Chưa gửi duyệt',
			'11' => 'Kế toán trả về',
			"5" => 'Chờ nạp tiền về công ty'
		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {

			if ($key == $status) {
				$result = $item;
			}

		}
		$result = (empty($result)) ? $status : $result;
		return $result;
	}
}
if (!function_exists('status_bao_hiem')) {
	function status_bao_hiem($status = null)
	{
		$leadstatus = [
			1 => 'Kế toán đã duyệt',
			2 => 'Chờ kế toán xác nhận',
			3 => 'Kế toán hủy',
			10 => 'PGD đã thu tiền',
			11 => 'Kế toán trả về'

		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {

			if ($key == $status) {
				$result = $item;
			}

		}
		$result = (empty($result)) ? $status : $result;
		return $result;
	}
}
if (!function_exists('type_bao_hiem')) {
	function type_bao_hiem($status = null)
	{
		$leadstatus = [
			'KVG' => 'Bảo hiểm khoản vay GIC',
			'KVM' => 'Bảo hiểm khoản vay MIC',
			'EASY' => 'Bảo hiểm xe máy(easy)',
			'VBI' => 'Bảo hiểm VBI',
			'PLT' => 'Bảo hiểm phúc lộc thọ',

		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {

			if ($key == $status) {
				$result = $item;
			}

		}
		$result = (empty($result)) ? $status : $result;
		return $result;
	}
}
if (!function_exists('type_transaction')) {
	function type_transaction($status = null)
	{
		$leadstatus = [
			'1' => 'Thanh toán tiện ích',
			'2' => 'Phí phạt hợp đồng',
			'3' => 'Tất toán',
			'4' => 'Thanh toán',
			'6' => 'Thanh toán nhà đầu tư',
			'7' => 'Thanh toán HeyU',
			'8' => 'Bảo hiểm Xe máy - MIC_TNDS',
			'9' => 'Chưa thu hồi',
			'10' => 'Bảo hiểm Ô tô - VBI_TNDS',
			'11' => 'Bảo hiểm VBI_Ung thư vú',
			'12' => 'Bảo hiểm VBI_Sốt xuất huyết',
			'13' => 'Bảo hiểm GIC EASY',
			'14' => 'Bảo hiểm GIC Phúc Lộc Thọ',
			'15' => 'Bảo hiểm PTI Vững Tâm An',
			'16' => 'PTI - Bảo Hiểm Tai Nạn Con Người',
			'17' => 'Thanh toán hoa hồng CTV'

		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {

			if ($key == $status) {
				$result = $item;
			}

		}
		$result = (empty($result)) ? $status : $result;
		return $result;
	}
}
if (!function_exists('type_payment')) {
	function type_payment($status = null)
	{
		$leadstatus = [
			'1' => 'Thanh toán lãi kỳ',
			'2' => 'Gia hạn',
			'3' => 'Cơ cấu',
			'4' => 'Thanh toán hợp đồng đã thanh lý tài sản',

		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {

			if ($key == $status) {
				$result = $item;
			}

		}
		$result = (empty($result)) ? $status : $result;
		return $result;
	}
}
if (!function_exists('group_debt')) {
	function group_debt($status = null)
	{
		$leadstatus = [
			'1' => 'Đủ tiêu chuẩn',
			'2' => 'Cần chú ý',
			'3' => 'Dưới tiêu chuẩn',
			'4' => 'Có nghi ngờ',
			'5' => 'Người gọi dừng',
			'6' => 'Có khả năng mất vốn'
		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {

			if ($key == $status) {
				$result = $item;
			}

		}
		$result = (empty($result)) ? $status : $result;
		return $result;
	}
}
if (!function_exists('recoding_status')) {
	function recoding_status($status = null)
	{
		$leadstatus = [
			'NO_USER_RESPONSE' => 'Không nghe máy',
			'USER_BUSY' => 'User bận',
			'NORMAL_CLEARING' => 'Thành công',
			'CALL_REJECTED' => 'Từ chối',
			'ORIGINATOR_CANCEL' => 'Người gọi dừng',
			'NO_ANSWER' => 'Cuộc gọi nhỡ'
		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {

			if ($key == $status) {
				$result = $item;
			}

		}
		$result = (empty($result)) ? $status : $result;
		return $result;
	}
}
if (!function_exists('gic_easy')) {
	function gic_easy($status = null)
	{
		$leadstatus = [
			'348000' => 'GIC_EASY_20',
			'398000' => 'GIC_EASY_40',
			'598000' => 'GIC_EASY_70'
		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {

			if ($key == $status) {
				$result = $item;
			}

		}
		$result = (empty($result)) ? $status : $result;
		return $result;
	}
}
if (!function_exists('gic_plt')) {
	function gic_plt($status = null)
	{
		$leadstatus = [
			'199000' => 'COPPER-PHÚC',
			'299000' => 'SILVER-LỘC',
			'499000' => 'GOLD-THỌ'
		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {

			if ($key == $status) {
				$result = $item;
			}

		}
		$result = (empty($result)) ? $status : $result;
		return $result;
	}
}
if (!function_exists('loan_insurances')) {
	function loan_insurance($status = null)
	{
		$leadstatus = [
			'1' => 'GIC',
			'2' => 'MIC',
		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {

			if ($key == $status) {
				$result = $item;
			}

		}
		$result = (empty($result)) ? $status : $result;
		return $result;
	}
}
if (!function_exists('reason')) {
	function reason($status = null, $hide = true)
	{
		$leadstatus = [
			1 => 'Xe đang trả góp',
			2 => 'Nhu cầu vay nhiều hơn',
			3 => 'Xe không chính chủ',
			4 => 'Không có HK hoặc không làm việc tại nội thành HN',
			5 => 'Không có đăng ký xe bản gốc',
			6 => 'Không thuộc sản phẩm hỗ trợ',
			7 => 'Không có xe máy/ô tô',
			8 => 'Không muốn giữ đăng ký xe',
			9 => 'Không có nhu cầu vay nữa',
			10 => 'Nhầm máy',
			11 => 'Chê lãi cao',
			12 => 'Không thuộc khu vực hỗ trợ',
			13 => 'Thuê bao',
			14 => 'Không chứng minh được thu nhập',
			15 => 'Không nghe máy nhiều lần',
			16 => 'Đời xe không hỗ trợ',
			17 => 'Đã vay bên tổ chức khác',
			18 => 'Hẹn đến PGD',
			19 => 'Khách hẹn qua nhà hỗ trợ trực tiếp',
			20 => 'Thiếu giấy tờ',
			21 => 'Đã liên hệ lại và thay đổi trạng thái',
			22 => 'Gọi lại lần 1',
			23 => 'Gọi lại lần 2',
			24 => 'Gọi lại lần 3',
			25 => 'Gọi lại lần 4',
			26 => 'Gọi lại lần 5',
			27 => 'Gọi lại lần 6',
			28 => 'Không muốn thẩm định nhà/ công ty',
			29 => 'Xe KCC- không nhận lương CK',
			30 => 'Xe KCC-không có KT1',
			31 => 'Gốc còn lại cao',
			32 => 'Đã ra PGD',
			33 => 'Đeo bám quá lâu mà vẫn đang suy nghĩ khoản vay',
			34 => 'Sai số (Số ĐT báo không đúng) ',
			35 => 'Trùng hồ sơ',
			36 => 'Tham khảo, chưa muốn vay ',
			37 => 'Không khai báo thông tin',
			38 => 'Nhu cầu vay ít hơn',
			39 => 'Không đồng ý thời hạn vay',
			40 => 'Không đồng ý giữ xe',
			41 => 'Không đủ tuổi quy định',
			42 => 'Không có bản gốc CMT/ CCCD/Hộ chiếu',
			43 => 'Không có SHK/ giấy tờ chứng minh nơi ở',
			44 => 'Không có giấy tờ chứng minh sở hữu xe',
			45 => 'Không có đăng kiểm xe',
			46 => 'Lý do khác',
			47 => 'Xe KCC- HCM',
			48 => 'Xe KCC - Mekong',
			49 => 'Sim không chính chủ',
			50 => 'Xe KCC- HN',
			51 => 'Không liên hệ được KH'


		];
		if ($hide) {
			$remove = [1, 4, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 31, 32, 33];
			foreach ($remove as $k => $v) {
				unset($leadstatus[$v]);
			}
		}
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('lead_priority')) {
	function lead_priority($status = null, $hide = true)
	{
		$leadstatus = [
			1 => 'Cao',
			2 => 'Trung bình',
			3 => 'Thấp'
		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('lead_status')) {
	function lead_status($status = null, $hide = true)
	{
		$leadstatus = [
			1 => 'Mới',
			2 => 'Đồng ý vay',
			3 => 'Chưa liên lạc được',
			4 => 'Không đủ điều kiện vay',
			5 => 'Đang suy nghĩ',
			6 => 'Đang chờ duyệt hồ sơ',
			7 => 'Chưa tư vấn được',
			8 => 'Đã ký HĐ',
			9 => 'Đã ra PGD',
			10 => 'Chờ gọi lại lần 1',
			11 => 'Chờ gọi lại lần 2',
			12 => 'Chờ gọi lại lần 3',
			13 => 'Chờ gọi lại lần 4',
			14 => 'Chờ gọi lại lần 5',
			15 => 'Chờ gọi lại lần 6',
			16 => 'Chờ gọi lại lần 7',
			17 => 'Chờ gọi lại lần 8',
			18 => 'Chờ gọi lại lần 9',
			19 => 'Hủy',
			20 => 'Chờ Bot gọi lại',
			30 => 'Phòng giao dịch tạo'


		];
		if ($hide) {
			$remove = [3, 4, 7];
			foreach ($remove as $k => $v) {
				unset($leadstatus[$v]);
			}
		}
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('lead_source')) {
	function lead_source($status = null)
	{
		$leadstatus = [
			1 => 'Facebook',
			2 => 'Google',
			3 => 'Zalo',
			4 => 'Tiktok',
			5 => 'Cốc côc',
			6 => 'Website'
		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('lead_nguon')) {

	function lead_nguon($status = null, $hide = true)
	{
		$leadstatus = [
			1 => 'Digital',
			2 => 'TLS Tự kiếm',
			3 => 'Tổng đài',
			4 => 'Giới thiệu',
			5 => 'Đối tác',
			6 => 'Fanpage',
			7 => 'Nguồn khác',
			12 => 'Nguồn App Mobile',
			8 => 'KH vãng lai',
			9 => 'KH tự kiếm',
			10 => 'Cộng tác viên',
			11 => 'KH giới thiệu KH',
			'VM' => 'VM',
			'trandata' => 'trandata',
			'TS' => 'TS',
			'VPS' => 'VPS',
			'MB' => 'MB',
			14 => "Tool FB",
			15 => "Tiktok",
			16 => 'Remarketing',
			'Homedy' => 'Homedy',
			17 => 'Sms Ads',
			18 => 'Zalo Ads',
			19 => 'Viettel Ads',
			20 => 'Search Mkt',
			'phan_nguyen' => 'phan_nguyen',
			21 => 'Google',
			22 => 'Zalo',
			23 => 'Topup',
			24 => 'Tái vay',

		];
		if ($hide) {
			$remove = [8, 9, 10];
			foreach ($remove as $k => $v) {
				unset($leadstatus[$v]);
			}
		}
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('lead_nguon_pgd')) {
	function lead_nguon_pgd($status = null)
	{
		$leadstatus = [
			8 => 'KH vãng lai',
			9 => 'KH tự kiếm',
			10 => 'Cộng tác viên',
			11 => 'KH giới thiệu KH',
			"VPS" => 'VPS',
			'MB' => 'MB',
			'CTV' => 'Website_CTV',
			'Homedy' => 'Homedy',
			'Merchant' => 'Merchant',
			17 => 'Nguồn ngoài'
		];

		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('lead_nguon_check')) {
	function lead_nguon_check($status = null)
	{
		$leadstatus = [
			1 => 'Digital',
			2 => 'TLS Tự kiếm',
			3 => 'Tổng đài',
			4 => 'Giới thiệu',
			5 => 'Đối tác',
			6 => 'Fanpage',
			7 => 'Nguồn khác',
			12 => 'Nguồn App Mobile',
			8 => 'KH vãng lai',
			9 => 'KH tự kiếm',
			10 => 'Cộng tác viên',
			11 => 'KH giới thiệu KH',
			'VM' => 'VM',
			'trandata' => 'trandata',
			'TS' => 'TS',
			'VPS' => 'VPS',
			'MB' => 'MB',
			14 => "Tool FB",
			15 => "Tiktok",
			16 => 'Remarketing',
			'Homedy' => 'Homedy',
			'CTV' => 'Website_CTV',
			'Merchant' => 'Merchant',
			17 => 'Nguồn ngoài',
			'phan_nguyen' => 'phan_nguyen'
		];

		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('status_pgd')) {
	function status_pgd($status = null, $hide = true)
	{
		$result = '';
		$leadstatus = [
			1 => 'Mới',
			2 => 'Ko thuộc khu vực hỗ trợ',
			3 => 'Ko thuộc sản phẩm hỗ trợ',
			4 => 'Ko cung cấp được SHK/KT3',
			5 => 'Ko cung cấp được thông tin thu nhập',
			6 => 'Ko cung cấp được ĐKX/HĐMB',
			7 => 'Ko đồng ý giữ ĐKX/HĐMB',
			8 => 'Trả về CSKH',
			9 => 'Thuê bao/Không nghe máy',
			10 => 'Khách hết nhu cầu',
			11 => 'Khách chê lãi cao',
			12 => 'Khách từ chối vì duyệt thấp',
			13 => 'Xe ko chính chủ',
			14 => 'Tài sản giá trị thấp',
			15 => 'Đeo bám',
			16 => 'Hủy',
			17 => 'Đang xử lý',
			18 => 'Đã giải ngân',
			19 => 'Chờ gọi lại lần 1',
			20 => 'Chờ gọi lại lần 2',
			21 => 'Chờ gọi lại lần 3',
			22 => 'Chờ gọi lại lần 4',
			23 => 'Chờ gọi lại lần 5',
			24 => 'Chờ gọi lại lần 6',
			25 => 'Chờ gọi lại lần 7',
			26 => 'Chờ gọi lại lần 8',
			27 => 'Chờ gọi lại lần 9',
			28 => 'Đang suy nghĩ',
			29 => 'Trùng PGD tự kiếm',
			30 => 'Chờ KH bổ sung hồ sơ',
			31 => 'KH hẹn ra PGD',
			32 => 'KH thuộc khu vực cách ly/phong toả',
			33 => 'Chưa liên hệ được',
			34 => 'Chưa đặt lịch hẹn',
			35 => 'KH chưa đến PGD',
			36 => 'Hỗ trợ tận nhà',
			37 => 'Hẹn gọi lại',
			38 => 'Chờ thẩm định',
			39 => 'Chờ phê duyệt',
			40 => 'Chờ giải ngân'
		];
		if ($hide) {
			$remove = [1, 2, 3, 4, 5, 6, 7 ,8, 9, 10, 11, 12, 13, 14, 15, 17, 19, 20, 21, 22, 23, 24, 25, 26, 27, 29, 32];
			foreach ($remove as $k => $v) {
				unset($leadstatus[$v]);
			}
		}
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
function divide_amount_money($amount_money)
{
	$money = $amount_money;
	$max = 300000000;
	$part = 0;
	$arr_money = array();
	if ($amount_money > $max) {
		$part = ceil($amount_money / $max);
		$arr_money['total_part'] = $part;
		for ($i = 1; $i <= $part; $i++) {
			if ($money >= $max) {
				$arr_money['part_' . $i] = array('money' => $max, "status" => 1);
				$money = $money - $max;
			} else if ($money < $max && $money > 0) {
				$arr_money['part_' . $i] = array('money' => $money, "status" => 1);
				$money = 0;
			}
		}
		return $arr_money;
	} else {
		return $amount_money;
	}
}

if (!function_exists('type_fee')) {
	function type_fee($status = null)
	{
		$leadstatus = [
			'CC' => 'Cầm cố',
			'DKXM' => 'Đăng ký xe máy',
			'DKXOTO' => 'Đăng ký xe ô tô',
			'TC' => 'Tín chấp',
			'KDOL' => "Kinh doanh online - TSDB",
			'KDOL_TC' => "Bổ sung vốn KDOL - Tín chấp"

		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('reason_return')) {
	function reason_return($status = null)
	{
		$reason_return = [
			//code 8 => Tra lai CSKH
			101 => 'Khách hết nhu cầu',
			102 => 'Không đồng ý giữ ĐKX/ Cà vẹt xe',
			103 => 'Sai số điện thoại',
			104 => 'KH hẹn nhiều lần nhưng không đến PGD',
			105 => 'Chuyển PGD khác hỗ trợ'
		];
		if ($status === null) return $reason_return;
		foreach ($reason_return as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('reason_process')) {
	function reason_process($status = null)
	{
		// code 17 => Dang xu ly
		$reason_process = [
			201 => 'KH hẹn ra PGD',
			202 => 'Chờ KH bổ sung hồ sơ',
			203 => 'Đã gọi nhưng khách chưa nghe máy',
			204 => 'Đã tư vấn, khách đang suy nghĩ',
		];
		if ($status === null) return $reason_process;
		foreach ($reason_process as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}


function change_type_loan($name)
{
	switch ($name) {
		case 'Cho vay':
			return "Đăng ký xe";
			break;
		case 'Cầm cố':
			return "Cầm cố xe";
			break;
	}
}

if (!function_exists('lead_area')) {
	function lead_area($status = null)
	{
		$leadstatus = [
			1 => 'Hà Nội',
			2 => 'HCMC'

		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('lead_status_PGD')) {
	function lead_status_PGD($status = null)
	{
		$leadStatusPGD = [
			1 => 'Đang xử lý',
			2 => 'Hủy',
			3 => 'Trả lại CSKH'

		];
		if ($status === null) return $leadStatusPGD;
		foreach ($leadStatusPGD as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('lead_VBI')) {
	function lead_VBI($status = null)
	{
		$lead_VBI = [
			1 => 'Sốt xuất huyết cá nhân gói đồng',
			2 => 'Sốt xuất huyết cá nhân gói bạc',
			3 => 'Sốt xuất huyết cá nhân gói vàng',
			4 => 'Sốt xuất huyết gia đình 6 người gói đồng',
			5 => 'Sốt xuất huyết gia đình 6 người gói bạc',
			6 => 'Sốt xuất huyết gia đình 6 người gói vàng',
			7 => 'Ung thư vú - nữ giới 18-40 tuổi Lemon',
			8 => 'Ung thư vú - nữ giới 18-40 tuổi Orange',
			9 => 'Ung thư vú - nữ giới 18-40 tuổi Pomelo',
			10 => 'Ung thư vú - nữ giới 41-55 tuổi Lemon',
			11 => 'Ung thư vú - nữ giới 41-55 tuổi Orange',
			12 => 'Ung thư vú - nữ giới 41-55 tuổi Pomelo',

		];
		if ($status === null) return $lead_VBI;
		foreach ($lead_VBI as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('lead_cancel_C1')) {
	function lead_cancel_C1($status = null)
	{
		$lead_cancel_C1 = [
			"C1.1" => 'C1.1: Khách hàng thuộc danh sách đen (Blacklist)',
			"C1.2" => 'C1.2: Khách hàng đang có tiền án tiền sự',
			"C1.3" => 'C1.3: Khách hàng không biết chữ',
			"C1.4" => 'C1.4: CMND/CCCD/HC có số bị in đè - CMND/CCCD có dấu hiệu nghi ngờ bóc tách, thay ảnh - CMND/CCCD mờ số hoặc mờ ảnh hoàn toàn không nhận diện được',
		];
		if ($status === null) return $lead_cancel_C1;
		foreach ($lead_cancel_C1 as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('lead_cancel_C2')) {
	function lead_cancel_C2($status = null)
	{
		$lead_cancel_C2 = [
			"C2.1" => 'C2.1: KH không sống tại địa chỉ kê khai',
			"C2.2" => 'C2.2: KH cố tình cung cấp sai địa chỉ, thông tin nơi ở, tạm trú',
		];
		if ($status === null) return $lead_cancel_C2;
		foreach ($lead_cancel_C2 as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('lead_cancel_C3')) {
	function lead_cancel_C3($status = null)
	{
		$lead_cancel_C3 = [
			"C3.1" => 'C3.1: KH không sống tại địa chỉ kê khai',
			"C3.2" => 'C3.2: KH cố tình cung cấp sai địa chỉ, thông tin nơi ở, tạm trú',
		];
		if ($status === null) return $lead_cancel_C3;
		foreach ($lead_cancel_C3 as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('lead_cancel_C4')) {
	function lead_cancel_C4($status = null)
	{
		$lead_cancel_C4 = [
			"C4.1" => 'C4.1: Tài sản quá cũ so với thời gian trên giấy tờ',
			"C4.2" => 'C4.2: Giá trị tài sản quá thấp',
		];
		if ($status === null) return $lead_cancel_C4;
		foreach ($lead_cancel_C4 as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('lead_cancel_C5')) {
	function lead_cancel_C5($status = null)
	{
		$lead_cancel_C5 = [
			"C5.1" => 'C5.1: Giả mạo người thân của KH để cung cấp thông tin',
			"C5.2" => 'C5.2: Thông tin thu thập không đúng như KH kê khai',
			"C5.3" => 'C5.3: Người tham chiếu cung cấp sai thông tin / không thể cung cấp được thông tin',
		];
		if ($status === null) return $lead_cancel_C5;
		foreach ($lead_cancel_C5 as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('lead_cancel_C6')) {
	function lead_cancel_C6($status = null)
	{
		$lead_cancel_C6 = [
			"C6.1" => 'C6.1: KH có lịch sử trả tiền xấu tại VFC',
			"C6.2" => 'C6.2: KH có số lượng khoản vay app online vượt quá quy định, PGD không có ngoại lệ hoặc không đủ điều kiện ngoại lệ',
		];
		if ($status === null) return $lead_cancel_C6;
		foreach ($lead_cancel_C6 as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('lead_cancel_C7')) {
	function lead_cancel_C7($status = null)
	{
		$lead_cancel_C7 = [
			"C7.1" => 'C7.1: Nghi ngờ giấy tờ/thông tin KH giả mạo',
			"C7.2" => 'C7.2: Sai khác thông tin trên hồ sơ và chứng từ',
			"C7.3" => 'C7.3: KH không bổ sung được hồ sơ theo yêu cầu của TĐV',
			"C7.4" => 'C7.4: KH không còn nhu cầu vay',
		];
		if ($status === null) return $lead_cancel_C7;
		foreach ($lead_cancel_C7 as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('gh_cc_exception')) {
	function gh_cc_exception($status = null)
	{
		$lead_exception = [
			1 => 'Khoản thanh toán nhiều',
			2 => 'Khách hàng có nhu cầu',
		];
		if ($status === null) return $lead_exception;
		foreach ($lead_exception as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}


if (!function_exists('lead_exception_E1')) {
	function lead_exception_E1($status = null)
	{
		$lead_exception_E1 = [
			1 => 'E1.1: Ngoại lệ về tuổi vay',
			2 => 'E1.2: Ngoại lệ về giấy tờ định danh: CMND/CCCD mờ ảnh / mờ số không đủ điều kiện',
		];
		if ($status === null) return $lead_exception_E1;
		foreach ($lead_exception_E1 as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('lead_exception_E2')) {
	function lead_exception_E2($status = null)
	{
		$lead_exception_E2 = [
			3 => 'E2.1: Khách hàng KT3 tạm trú dưới 6 tháng',
			4 => 'E2.2: Khách hàng KT3 không có hợp đồng thuê nhà, sổ tạm trú, xác minh qua chủ nhà trọ',
		];
		if ($status === null) return $lead_exception_E2;
		foreach ($lead_exception_E2 as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('lead_exception_E3')) {
	function lead_exception_E3($status = null)
	{
		$lead_exception_E3 = [
			5 => 'E3.1: Khách hàng thiếu một trong những chứng từ chứng minh thu nhập',
		];
		if ($status === null) return $lead_exception_E3;
		foreach ($lead_exception_E3 as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('lead_exception_E4')) {
	function lead_exception_E4($status = null)
	{
		$lead_exception_E4 = [
			6 => 'E4.1: Ngoại lệ về TSĐB khác TSĐB trong quy định về SP hiện hành của công ty (đất, giấy tờ khác...)',
			7 => 'E4.2: Ngoại lệ về lãi suất sản phẩm',
		];
		if ($status === null) return $lead_exception_E4;
		foreach ($lead_exception_E4 as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('lead_exception_E5')) {
	function lead_exception_E5($status = null)
	{
		$lead_exception_E5 = [
			8 => 'E5.1: Ngoại lệ về điều kiện đối với người tham chiếu',
			9 => 'E5.2: Ngoại lệ PGD gọi điện cho tham chiếu không sử dụng hệ thống phonet',
		];
		if ($status === null) return $lead_exception_E5;
		foreach ($lead_exception_E5 as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('lead_exception_E6')) {
	function lead_exception_E6($status = null)
	{
		$lead_exception_E6 = [
			10 => 'E6.1: KH có nhiều hơn 3 KV ở các app hay tổ chức tín dụng, ngân hàng khác',
		];
		if ($status === null) return $lead_exception_E6;
		foreach ($lead_exception_E6 as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('lead_exception_E7')) {
	function lead_exception_E7($status = null)
	{
		$lead_exception_E7 = [
			11 => 'E7.1: Khách hàng vay lại có lịch sử trả tiền tốt',
			12 => 'E7.2: Thu nhập cao, gốc còn lại tại thời điểm hiện tại thấp',
			13 => 'E7.3: KH làm việc tại các công ty là đối tác chiến lược',
			14 => 'E7.4: Giá trị định giá tài sản cao',
		];
		if ($status === null) return $lead_exception_E7;
		foreach ($lead_exception_E7 as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('lead_return')) {
	function lead_return($status = null)
	{
		$lead_return = [
			"B1" => 'Nhập thiếu/sai thông tin trên hệ thống',
			"B2" => 'Bổ sung giấy tờ/thông tin (khác) theo quy định sản phẩm',
			"B3" => 'SĐT KH, NTC chưa liên hệ được / chưa đúng / từ chối cc thông tin hoặc chưa đủ',
			"B4" => 'Bổ sung thông tin thiết bị định vị tài sản',
			"B5" => 'Trả về theo yêu cầu PGD',
		];
		if ($status === null) return $lead_return;
		foreach ($lead_return as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}


if (!function_exists('lead_type_finance')) {
	function lead_type_finance($status = null)
	{
		$lead_type_finance = [
			1 => "Cầm cố ô tô",
			2 => "Cầm cố xe máy",
			3 => "Đăng kí ô tô",
			4 => "Đăng kí xe máy",
			5 => "Đăng kí bảo hiểm",
			6 => "Kinh doanh Online",
			7 => "Ứng tiền cho tài xế công nghệ",
			8 => "Sổ đỏ",
			9 => "Sổ hồng, hợp đồng mua bán căn hộ",
			10 => "Bảo hiểm Vững Tâm An",
			11 => "Bảo hiểm Phúc Lộc Thọ",
			12 => "Bảo hiểm Ung thư vú",
			13 => "Bảo hiểm Sốt xuất huyết",
			14 => "Bảo hiểm TNDS xe máy/ô tô",
			15 => "Bảo hiểm Khoản vay",
			16 => "Sản phẩm vay nhanh gán định vị",
			17 => "Bảo hiểm tai nạn con người",
			18 => "Topup",
			19 => "Tái vay",
		];
		if ($status === null) return $lead_type_finance;
		foreach ($lead_type_finance as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
function get_info_pheduyet($email)
{
	switch ($email) {
		case 'lanltk@tienngay.vn':
			return "Phê duyệt 1";
			break;
		case 'khanhpb@tienngay.vn':
			return "Phê duyệt 2";
			break;
		default:
			return $email;
			break;
	}

}

function encrypt($data, $password = "df15bfa89439693e")
{
	$en_text = base64_encode($data);
	return $en_text;
}


if (!function_exists('lead_obj')) {
	function lead_obj($status = null)
	{
		$lead_obj = [
			1 => "Cá nhân",
			2 => "Doanh nghiệp",
			3 => "Chủ hộ kinh doanh"
		];
		if ($status === null) return $lead_obj;
		foreach ($lead_obj as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $lead_obj;
	}
}
if (!function_exists('region')) {
	function region($status = null)
	{
		$leadstatus = [
			'VHN' => 'Vùng Hà Nội',
			'VDB' => 'Vùng Đông Bắc',
			'VTB' => 'Vùng Tây Bắc',
			'VMT1' => 'Miền trung 1: Thanh Hoá - Hà Tĩnh',
			'VMT2' => 'Miền trung 2: Quảng Bình- Phú Yên',
			'VMT3' => 'Miền trung 3: Tây Nguyên',
			'VHCM' => 'Vùng HCM',
			'VMD' => 'Vùng Miền Đông',
			'VMC' => 'Vùng MeKong',
		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {

			if ($key == $status) {
				$result = $item;
			}

		}
		$result = (empty($result)) ? $status : $result;
		return $result;
	}
}
if (!function_exists('domain')) {
	function domain($status = null)
	{
		$leadstatus = [
			'MB' => 'Miền Bắc',
			'MT' => 'Miền Trung',
			'MN' => 'Miền Nam',

		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {

			if ($key == $status) {
				$result = $item;
			}

		}
		$result = (empty($result)) ? $status : $result;
		return $result;
	}
}
function stars($phone)
{
	$times = strlen(trim(substr($phone, 4, 4)));
	$star = '';
	for ($i = 0; $i < $times; $i++) {
		$star .= '*';
	}
	return $star;
}

function hide_phone($phone, $role = "")
{
	$result = str_replace(substr($phone, 4, 4), stars($phone), $phone);
	if ($role != "") {
		return $phone;
	} else {
		return $result;
	}

}

if (!function_exists('loan_time')) {
	function loan_time($status = null)
	{
		$loan_time = [
			1 => "1 Tháng",
			3 => "3 Tháng",
			6 => "6 Tháng",
			9 => "9 Tháng",
			12 => "12 Tháng",
			18 => "18 Tháng",
			24 => "24 Tháng",

		];
		if ($status === null) return $loan_time;
		foreach ($loan_time as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}

		return $result;
	}
}
if (!function_exists('type_repay')) {
	function type_repay($status = null)
	{
		$type_repay = [
			1 => "Lãi hàng tháng, gốc hàng tháng",
			2 => "Lãi hàng tháng,gốc cuối kì"
		];
		if ($status === null) return $type_repay;
		foreach ($type_repay as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('convert_zero_phone')) {
	function convert_zero_phone($number)
	{
		if (!empty($number) && strlen($number) > 10) {
			if ($number[0] . $number[1] == '84')
				$number = substr($number, 2, strlen($number) - 1);
		}
		if (!empty($number) && strlen($number) > 10) {
			if ($number[0] . $number[1] . $number[2] == '+84')
				$number = substr($number, 3, strlen($number) - 1);
		}
		if (!empty($number)) {
			if ($number[0] == 'o' || $number[0] == 'O')
				$number = substr($number, 1, strlen($number) - 1);
		}
		if (!empty($number)) {
			if ($number[0] != 0)
				$number = '0' . $number;
		}
		return $number;
	}
}

function convert_number_to_words($so)
{

	$ChuSo = [" không ", " một ", " hai ", " ba ", " bốn ", " năm ", " sáu ", " bảy ", " tám ", " chín "];
	$Tien = ["", " nghìn", " triệu", " tỷ", " nghìn tỷ", " triệu tỷ"];
	$mangso = ['không', 'một', 'hai', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín'];
	if ($so == 0) return ' ' + $mangso[0];
	$chuoi = "";
	$hauto = "";
	do {
		$ty = $so % 1000000000;
		$so = floor($so / 1000000000);
		if ($so > 0) {
			$chuoi = dochangtrieu($ty, true) . $hauto . $chuoi . " đồng";
		} else {
			$chuoi = dochangtrieu($ty, false) . $hauto . $chuoi . " đồng";
		}
		$hauto = " tỷ";
	} while ($so > 0);
	return str_replace('đồng đồng', 'đồng', ucfirst(trim($chuoi)));
}

function dochangtrieu($so, $daydu)
{
	$chuoi = "";
	$trieu = floor($so / 1000000);
	$so = $so % 1000000;
	if ($trieu > 0) {
		$chuoi = docblock($trieu, $daydu) . " triệu";
		$daydu = true;
	}
	$nghin = floor($so / 1000);
	$so = $so % 1000;
	if ($nghin > 0) {
		$chuoi .= docblock($nghin, $daydu) . " nghìn";
		$daydu = true;
	}
	if ($so > 0) {
		$chuoi .= docblock($so, $daydu);
	}
	return $chuoi;
}

function docblock($so, $daydu)
{
	$ChuSo = [" không ", " một ", " hai ", " ba ", " bốn ", " năm ", " sáu ", " bảy ", " tám ", " chín "];
	$Tien = ["", " nghìn", " triệu", " tỷ", " nghìn tỷ", " triệu tỷ"];
	$mangso = ['không', 'một', 'hai', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín'];
	$chuoi = "";
	$tram = floor($so / 100);
	$so = $so % 100;
	if ($daydu || $tram > 0) {
		$chuoi = " " . $mangso[$tram] . " trăm";
		$chuoi .= dochangchuc($so, true);
	} else {
		$chuoi = dochangchuc($so, false);
	}
	return $chuoi;
}

function dochangchuc($so, $daydu)
{
	$ChuSo = [" không ", " một ", " hai ", " ba ", " bốn ", " năm ", " sáu ", " bảy ", " tám ", " chín "];
	$Tien = ["", " nghìn", " triệu", " tỷ", " nghìn tỷ", " triệu tỷ"];
	$mangso = ['không', 'một', 'hai', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín'];
	$chuoi = "";
	$chuc = floor($so / 10);
	$donvi = $so % 10;
	if ($chuc > 1) {
		$chuoi = " " . $mangso[$chuc] . " mươi";
		if ($donvi == 1) {
			$chuoi .= " mốt";
		}
	} else if ($chuc == 1) {
		$chuoi = " mười";
		if ($donvi == 1) {
			$chuoi .= " một";
		}
	} else if ($daydu && $donvi > 0) {
		$chuoi = " lẻ";
	}
	if ($donvi == 5 && $chuc >= 1) {
		$chuoi .= " lăm";
	} else if ($donvi > 1 || ($donvi == 1 && $chuc == 0)) {
		$chuoi .= " " . $mangso[$donvi];
	}
	return $chuoi;
}

function count_values($array, $colum1 = "", $value1 = "", $colum2 = "", $value2 = "", $colum3 = "", $value3 = "")
{
	$count = 0;
	foreach ($array as $v) {
		if ($colum1 == '') {
			$count++;
		} else if ($colum2 == '') {
			if ($v[$colum1] == $value1)
				$count++;
		} else if ($colum3 == '') {
			if ($v[$colum1] == $value1 && $v[$colum2] == $value2)
				$count++;
		} else {
			if ($v[$colum1] == $value1 && $v[$colum2] == $value2 && $v[$colum3] == $value3)
				$count++;
		}
	}
	return $count;
}

function sum_values($array, $colum1 = "", $value1 = "", $colum2 = "", $value2 = "", $colum3 = "", $value3 = "", $col_sum = "")
{
	$sum = 0;
	foreach ($array as $v) {
		if ($colum1 === '') {
			$sum++;
		} else if ($colum2 === '') {
			if ($v[$colum1] === $value1)
				$sum += (int)$v[$col_sum];
		} else if ($colum3 === '') {
			if ($v[$colum1] === $value1 && $v[$colum2] === $value2)
				$sum += $v[$col_sum];
		} else {
			if ($v[$colum1] === $value1 && $v[$colum2] === $value2 && $v[$colum3] === $value3)
				$sum += $v[$col_sum];
		}
	}
	return $sum;
}

function unique_multidim_array($array, $key)
{
	$temp_array = array();
	$i = 0;
	$key_array = array();

	foreach ($array as $val) {
		if (!in_array($val[$key], $key_array) && $val != '') {
			$key_array[$i] = $val[$key];
			$temp_array[$i] = $val;
		}
		$i++;
	}
	return $temp_array;
}

function get_value_Url($url, $parameter_name)
{
	$parts = parse_url($url);
	if (isset($parts['query'])) {
		parse_str($parts['query'], $query);
		if (isset($query[$parameter_name])) {
			return $query[$parameter_name];
		} else {
			return "";
		}
	} else {
		return "";
	}
}

function get_values($array, $colum1 = "", $value1 = "", $colum2 = "", $value2 = "", $colum3 = "", $value3 = "", $find = "", $all = true, $sum = false)
{
	$count = ($sum) ? 0 : '';
	foreach ($array as $v) {
		if (!$sum) {
			if ($all) {
				if ($colum3 != "") {
					if ($v[$colum1] === $value1 && $v[$colum2] === $value2 && $v[$colum3] === $value3)
						$count .= implode(", ", $v[$find]);
				} else
					if ($colum2 != "") {
						if ($v[$colum1] === $value1 && $v[$colum2] === $value2)
							$count .= implode(", ", $v[$find]);
					} else {
						if ($v[$colum1] === $value1)
							$count .= implode(", ", $v[$find]);
					}
			} else {
				if ($colum3 != "") {
					if ($v[$colum1] === $value1 && $v[$colum2] === $value2 && $v[$colum3] === $value3)
						$count = $v[$find];
				} else
					if ($colum2 != "") {
						if ($v[$colum1] === $value1 && $v[$colum2] === $value2)
							$count = $v[$find];
					} else {
						if ($v[$colum1] === $value1)
							$count = $v[$find];
					}
			}
		} else {
			if ($colum3 != "") {
				if ($v[$colum1] === $value1 && $v[$colum2] === $value2 && $v[$colum3] === $value3)
					$count += $v[$find];
			} else
				if ($colum2 != "") {
					if ($v[$colum1] === $value1 && $v[$colum2] === $value2)
						$count += $v[$find];
				} else {
					if ($v[$colum1] === $value1)
						$count += $v[$find];
				}

		}

	}
	return $count;
}

function gen_html_QC($arr_return_QC_SOU, $arr_return_QC_CAM)
{
	$n = 1;
	$o = 1;
	$y = 1;
	$html = '';
	foreach ($arr_return_QC_SOU as $key => $value) {

		$html .= '<tr data-id="' . $n++ . '" data-parent="0">';
		$html .= '<td data-column="name"></td><td>';
		$html .= ($value['utm_source'] == "") ? "Khác" : $value['utm_source'] . '</td>';
		$html .= '<td></td>';
		$html .= '<td></td>';
		$html .= '<td class="table-active" align="center">' . $value['tongsocohoi'] . '</td>';
		$html .= '<td align="center">' . $value['tongsodonhang'] . '</td><td align="center">';
		$html .= ($value['tongsocohoi'] == 0) ? 0 : (int)(($value['tongsodonhang'] / $value['tongsocohoi']) * 100) . '%</td>';
		$html .= '<td class="table-warning" align="center">' . $value['dangxuly'] . '</td><td class="table-warning" align="center">';
		$html .= ($value['tongsocohoi'] == 0) ? 0 : (int)(($value['dangxuly'] / (int)$value['tongsocohoi']) * 100) . '%</td>';
		$html .= '<td class="table-primary" align="center">' . $value['donmoi'] . '</td><td class="table-primary" align="center">';
		$html .= ($value['tongsocohoi'] == 0) ? 0 : (int)(($value['donmoi'] / $value['tongsocohoi']) * 100) . '%</td>';
		$html .= '<td style="background-color: #ffe0b3;" align="center">' . $value['redon'] . '</td><td style="background-color: #ffe0b3;" align="center">';
		$html .= ($value['tongsocohoi'] == 0) ? 0 : (int)(($value['redon'] / $value['tongsocohoi']) * 100) . '%</td>';
		$html .= '<td class="table-danger" align="center">' . $value['thatbai'] . '</td><td class="table-danger" align="center">';
		$html .= ($value['tongsocohoi'] == 0) ? 0 : (int)(($value['thatbai'] / $value['tongsocohoi']) * 100) . '%</td>';
		$html .= '<td class="table-info" align="right" >' . number_format($value['doanhsoban']) . '</td>';
		$html .= '<td class="table-success" align="right">' . number_format($value['loinhuan']) . '</td>';
		$html .= '</tr>';
		$o = $n;
		$y = $n;
		foreach ($arr_return_QC_CAM as $key1 => $value1) {

			if ($value1['utm_source'] == $value['utm_source']) {
				$html .= '<tr data-id="' . (int)$n++ . '"  data-parent="' . (int)($y - 1) . '">';
				$html .= '<td data-column="name"> </td>';
				$html .= '<td></td><td>';
				$html .= ($value1['utm_campaigns'] == "") ? "Khác" : $value1['utm_campaigns'] . '</td>';
				$html .= '<td></td>';
				$html .= '<td class="table-active" align="center">' . $value1['tongsocohoi'] . '</td>';
				$html .= '<td align="center">' . $value1['tongsodonhang'] . '</td><td align="center">';
				$html .= ($value1['tongsocohoi'] == 0) ? 0 : (int)(($value1['tongsodonhang'] / $value1['tongsocohoi']) * 100) . '%</td>';
				$html .= '<td class="table-warning" align="center">' . $value1['dangxuly'] . '</td><td class="table-warning" align="center">';
				$html .= ($value1['tongsocohoi'] == 0) ? 0 : (int)(($value1['dangxuly'] / $value1['tongsocohoi']) * 100) . '%</td>';
				$html .= '<td class="table-primary" align="center">' . $value1['donmoi'] . '</td><td class="table-primary" align="center">';
				$html .= ($value1['tongsocohoi'] == 0) ? 0 : (int)(($value1['donmoi'] / $value1['tongsocohoi']) * 100) . '%</td>';
				$html .= '<td style="background-color: #ffe0b3;" align="center">' . $value1['redon'] . '</td><td style="background-color: #ffe0b3;" align="center">';
				$html .= ($value1['tongsocohoi'] == 0) ? 0 : (int)(($value1['redon'] / $value1['tongsocohoi']) * 100) . '%</td>';
				$html .= '<td class="table-danger" align="center">' . $value1['thatbai'] . '</td><td class="table-danger" align="center">';
				$html .= ($value1['tongsocohoi'] == 0) ? 0 : (int)(($value1['thatbai'] / $value1['tongsocohoi']) * 100) . '%</td>';
				$html .= '<td class="table-info" align="right" >' . number_format($value1['doanhsoban']) . '</td>';
				$html .= '<td class="table-success" align="right">' . number_format($value1['loinhuan']) . '</td>';
				$html .= '</tr>';
				if (count($value1['list_term']) > 0) {
					foreach ($value1['list_term'] as $key2 => $value2) {
						$html .= '<tr  data-id="' . $n++ . '" data-parent="' . $o . '" >';
						$html .= '<td >' . date('d-m-Y', strtotime($value2['date'])) . ' <br/> ' . $value2['source_text'] . ' </td>';
						$html .= '<td></td>';
						$html .= '<td></td>';
						$html .= '<td>' . $value2['utm_terms'] . '</td>';
						$html .= '<td class="table-active" align="center">' . $value2['tongsocohoi'] . '</td>';
						$html .= '<td align="center">' . $value2['tongsodonhang'] . '</td><td align="center">';
						$html .= ($value2['tongsocohoi'] == 0) ? 0 : (int)(($value2['tongsodonhang'] / $value2['tongsocohoi']) * 100) . '%</td>';
						$html .= '<td class="table-warning" align="center">' . $value2['dangxuly'] . '</td><td class="table-warning" align="center">';
						$html .= ($value2['tongsocohoi'] == 0) ? 0 : (int)(($value2['dangxuly'] / $value2['tongsocohoi']) * 100) . '%</td>';
						$html .= '<td class="table-primary" align="center">' . $value2['donmoi'] . '</td><td class="table-primary" align="center">';
						$html .= ($value2['tongsocohoi'] == 0) ? 0 : (int)(($value2['donmoi'] / $value2['tongsocohoi']) * 100) . '%</td>';
						$html .= '<td style="background-color: #ffe0b3;" align="center">' . $value2['redon'] . '</td><td style="background-color: #ffe0b3;" align="center">';
						$html .= ($value2['tongsocohoi'] == 0) ? 0 : (int)(($value2['redon'] / $value2['tongsocohoi']) * 100) . '%</td>';
						$html .= '<td class="table-danger" align="center">' . $value2['thatbai'] . '</td><td class="table-danger" align="center">';
						$html .= ($value2['tongsocohoi'] == 0) ? 0 : (int)(($value2['thatbai'] / $value2['tongsocohoi']) * 100) . '%</td>';
						$html .= '<td class="table-info" align="right" >' . number_format($value2['doanhsoban']) . '</td>';
						$html .= '<td class="table-success" align="right">' . number_format($value2['loinhuan']) . '</td>';
						$html .= '</tr>';

					}
				}
			}
		}
	}
	//dd($html);
	return $html;
}


if (!function_exists('status_debt_recovery')) {
	function status_debt_recovery($status = null)
	{
		$debt_recovery = array(
			1 => "Đã thu tiền",
			2 => "Hứa thanh toán",
			3 => "Chưa viếng thăm",
			4 => "Đã thu hồi xe",
			5 => "Tiếp tục tác động",
			6 => "Mất khả năng thanh toán"
		);
		if ($status === null) return $debt_recovery;
		foreach ($debt_recovery as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('get_area_by_province')) {
	function get_area_by_province($code = null)
	{
		$result = '';
		$province = [
			"An Giang" => "AG",
			"Kon Tum" => "KT",
			"Đắk Nông" => "ĐNO",
			"Sóc Trăng" => "ST",
			"Bình Phước" => "BP",
			"Hưng Yên" => "HY",
			"Thanh Hóa" => "TH",
			"Quảng Trị" => "QT",
			"Tuyên Quang" => "TQ",
			"Quảng Ngãi" => "QNG",
			"Hà Nội" => "HN",
			"Lào Cai" => "LC",
			"Vĩnh Long" => "VL",
			"Lâm Đồng" => "LĐ",
			"Bình Định" => "BĐ",
			"Nghệ An" => "NA",
			"Kiên Giang" => "KG",
			"Hà Giang" => "HAG",
			"Phú Yên" => "PY",
			"Lạng Sơn" => "LS",
			"Đà Nẵng" => "ĐN",
			"Sơn La" => "SL",
			"Tây Ninh" => "TN",
			"Nam Định" => "NĐ",
			"Lai Châu" => "LCH",
			"Bến Tre" => "BT",
			"Khánh Hòa" => "KH",
			"Bình Thuận" => "BTH",
			"Cao Bằng" => "CB",
			"Hải Phòng" => "HP",
			"Ninh Bình" => "NB",
			"Yên Bái" => "YB",
			"Gia Lai" => "GL",
			"Hoà Bình" => "HB",
			"Bà Rịa - Vũng Tàu" => "BRVT",
			"Cà Mau" => "CM",
			"Bình Dương" => "BD",
			"Cần Thơ" => "CT",
			"Thừa Thiên Huế" => "TTH",
			"Đồng Nai" => "ĐNA",
			"Tiền Giang" => "TG",
			"Điện Biên" => "ĐB",
			"Vĩnh Phúc" => "VP",
			"Quảng Nam" => "QN",
			"Đắk Lắk" => "ĐL",
			"Thái Nguyên" => "TNG",
			"Hải Dương" => "HD",
			"Bạc Liêu" => "BL",
			"Trà Vinh" => "TV",
			"Thái Bình" => "TB",
			"Hà Tĩnh" => "HT",
			"Ninh Thuận" => "NT",
			"Đồng Tháp" => "ĐT",
			"Long An" => "LA",
			"Hậu Giang" => "HG",
			"Quảng Ninh" => "QNI",
			"Phú Thọ" => "PT",
			"Quảng Bình" => "QB",
			"Hồ Chí Minh" => "HCM",
			"Hà Nam" => "HNA",
			"Bắc Ninh" => "BN",
			"Bắc Giang" => "BG",
			"Bắc Kạn" => "BK",
		];
		if ($code === null) return $province;
		foreach ($province as $key => $item) {
			if ($key == $code) {
				$result = $item;
			}
		}
		return $result;
	}
}


if (!function_exists('meet_relatives')) {
	function meet_relatives($status = null)
	{
		$debt_recovery = array(
			1 => 'Khách Hàng',
			2 => 'Vợ Khách Hàng',
			3 => 'Chồng Khách Hàng',
			4 => 'Con Khách Hàng',
			5 => 'Bố Khách Hàng',
			6 => 'Mẹ Khách Hàng',
			7 => 'Anh/Em trai Khách Hàng',
			8 => 'Chị/Em gái Khách Hàng',
			9 => 'Bác/Cậu/Chú/Cô/Dì Khách Hàng',
			10 => 'Người khác',
			11 => 'Không gặp ai'
		);
		if ($status === null) return $debt_recovery;
		foreach ($debt_recovery as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}


if (!function_exists('type_property')) {
	function type_property($status = null)
	{
		$type_property = array(
			1 => 'Xe ga',
			2 => 'Xe số',
			3 => 'Xe côn',
			4 => 'Lithium',
			5 => 'Ắc quy'
		);
		if ($status === null) return $type_property;
		foreach ($type_property as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('status_property')) {
	function status_property($status = null)
	{
		$type_property = array(
			1 => 'Chờ duyệt',
			2 => 'Đã duyệt',
			3 => 'Hủy'
		);
		if ($status === null) return $type_property;
		foreach ($type_property as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists("billing_content")) {
	function billing_content($status = null)
	{
		$result = '';
		$billing_content = array(
			1 => " Thanh toán kỳ hợp đồng",
			2 => " Thanh toán đủ kỳ",
			3 => " Thanh toán đủ kỳ 1",
			4 => " Thanh toán đủ kỳ 2",
			5 => " Thanh toán đủ kỳ 3",
			6 => " Thanh toán đủ kỳ 4",
			7 => " Thanh toán đủ kỳ 5",
			8 => " Thanh toán đủ kỳ 6",
			9 => " Thanh toán đủ kỳ 7",
			10 => " Thanh toán đủ kỳ 8",
			11 => " Thanh toán đủ kỳ 9",
			12 => " Thanh toán đủ kỳ 10",
			13 => " Thanh toán đủ kỳ 11",
			14 => " Thanh toán đủ kỳ 12",
			15 => " Thanh toán đủ kỳ 13",
			16 => " Thanh toán đủ kỳ 14",
			17 => " Thanh toán đủ kỳ 15",
			18 => " Thanh toán đủ kỳ 16",
			19 => " Thanh toán đủ kỳ 17",
			20 => " Thanh toán đủ kỳ 18",
			21 => " Thanh toán đủ kỳ 19",
			22 => " Thanh toán đủ kỳ 20",
			23 => " Thanh toán đủ kỳ 21",
			24 => " Thanh toán đủ kỳ 22",
			25 => " Thanh toán đủ kỳ 23",
			26 => " Thanh toán đủ kỳ 24",
			27 => " Thanh toán một phần kỳ",
			28 => " Thanh toán một phần kỳ 1",
			29 => " Thanh toán một phần kỳ 2",
			30 => " Thanh toán một phần kỳ 3",
			31 => " Thanh toán một phần kỳ 4",
			32 => " Thanh toán một phần kỳ 5",
			33 => " Thanh toán một phần kỳ 6",
			34 => " Thanh toán một phần kỳ 7",
			35 => " Thanh toán một phần kỳ 8",
			36 => " Thanh toán một phần kỳ 9",
			37 => " Thanh toán một phần kỳ 10",
			38 => " Thanh toán một phần kỳ 11",
			39 => " Thanh toán một phần kỳ 12",
			40 => " Thanh toán một phần kỳ 13",
			41 => " Thanh toán một phần kỳ 14",
			42 => " Thanh toán một phần kỳ 15",
			43 => " Thanh toán một phần kỳ 16",
			44 => " Thanh toán một phần kỳ 17",
			45 => " Thanh toán một phần kỳ 18",
			46 => " Thanh toán một phần kỳ 19",
			47 => " Thanh toán một phần kỳ 20",
			48 => " Thanh toán một phần kỳ 21",
			49 => " Thanh toán một phần kỳ 22",
			50 => " Thanh toán một phần kỳ 23",
			51 => " Thanh toán một phần kỳ 24",
			52 => " Phí phạt chậm trả",
			53 => " Chậm trả kỳ 1",
			54 => " Chậm trả kỳ 2",
			55 => " Chậm trả kỳ 3",
			56 => " Chậm trả kỳ 4",
			57 => " Chậm trả kỳ 5",
			58 => " Chậm trả kỳ 6",
			59 => " Chậm trả kỳ 7",
			60 => " Chậm trả kỳ 8",
			61 => " Chậm trả kỳ 9",
			62 => " Chậm trả kỳ 10",
			63 => " Chậm trả kỳ 11",
			64 => " Chậm trả kỳ 12",
			65 => " Chậm trả kỳ 13",
			66 => " Chậm trả kỳ 14",
			67 => " Chậm trả kỳ 15",
			68 => " Chậm trả kỳ 16",
			69 => " Chậm trả kỳ 17",
			70 => " Chậm trả kỳ 18",
			71 => " Chậm trả kỳ 19",
			72 => " Chậm trả kỳ 20",
			73 => " Chậm trả kỳ 21",
			74 => " Chậm trả kỳ 22",
			75 => " Chậm trả kỳ 23",
			76 => " Chậm trả kỳ 24",
			77 => " Phí gia hạn",
			78 => " Tất toán hợp đồng",
			79 => " Phí cơ cấu",


		);
		if ($status === null) return $billing_content;
		foreach ($billing_content as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('file_manager_status')) {
	function file_manager_status($status = null)
	{
		$result = '';
		$leadstatus = [
			1 => "Mới",
			2 => "Hủy yêu cầu",
			3 => "YC gửi HS giải ngân",
			4 => "QLHS YC bổ sung",
			5 => "Đã XN YC gửi HS",
			6 => "Hoàn tất lưu kho",
			7 => "QLHS chưa nhận HS",
			8 => "YC trả HS sau tất toán",
			9 => "QLHS đã xác nhận YC trả HS",
			10 => "YC bổ sung HS",
			11 => "Đã trả HS sau tất toán",
			13 => "Trả về yêu cầu",
		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('file_manager_status_tattoan')) {
	function file_manager_status_tattoan($status = null)
	{
		$result = '';
		$leadstatus = [
			6 => "Hoàn tất lưu kho",
			7 => "QLHS chưa nhận HS",
			8 => "YC trả HS sau tất toán",
			9 => "QLHS đã xác nhận YC trả HS",
			10 => "YC bổ sung HS",
			11 => "Đã trả HS sau tất toán",
			13 => "Trả về yêu cầu",
		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('file_manager_borrowed_status')) {
	function file_manager_borrowed_status($status = null)
	{
		$result = '';
		$leadstatus = [
			1 => "Mới",
			2 => "Hủy yêu cầu",
			3 => "PGD YC mượn HS giải ngân",
			4 => "Yêu cầu mượn HS",
			5 => "QLHS trả về yêu cầu mượn",
			6 => "Chờ nhận hồ sơ",
			7 => "Đang mượn hồ sơ",
			8 => "Chưa nhận đủ HS mượn",
			9 => "Trả HS mượn về HO",
			10 => "Lưu kho",
			11 => "Chưa trả đủ HS đã mượn",
			12 => "Quá hạn mượn HS",
			13 => "Trả hồ sơ cho KH tất toán",
			14 => "QLHS xác nhận KH đã tất toán",
			15 => "Yêu cầu gia hạn mượn hồ sơ",
			16 => "Chờ TP QLKV duyệt YC mượn hồ sơ",
			17 => "Chờ TP QLKV duyệt YC gia hạn mượn hồ sơ",
		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}


function array_sort($array, $on, $order = SORT_ASC)
{
	$new_array = array();
	$sortable_array = array();

	if (count($array) > 0) {
		foreach ($array as $k => $v) {
			if (is_array($v)) {
				foreach ($v as $k2 => $v2) {
					if ($k2 == $on) {
						$sortable_array[$k] = $v2;
					}
				}
			} else {
				$sortable_array[$k] = $v;
			}
		}

		switch ($order) {
			case SORT_ASC:
				asort($sortable_array);
				break;
			case SORT_DESC:
				arsort($sortable_array);
				break;
		}

		foreach ($sortable_array as $k => $v) {
			$new_array[$k] = $array[$k];
		}
	}

	return $new_array;
}

function days_in_month($month, $year)
{
// calculate number of days in a month
	return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
}

if (!function_exists('exemptions_status')) {
	function exemptions_status($status = null)
	{
		$result = '';
		$exemptions = [
			1 => "Chờ Lead QLHDV xử lý đơn miễn giảm",
			2 => "Đã hủy đơn miễn giảm",
			3 => "Lead QLHDV yêu cầu bổ sung đơn miễn giảm",
			4 => "Chờ TP QLHDV xử lý đơn miễn giảm",
			5 => "TP QLHDV đã duyệt đơn miễn giảm",
			6 => "Chờ quản lý cấp cao xử lý đơn miễn giảm",
			7 => "Quản lý cấp cao đã duyệt đơn miễn giảm",
			8 => "TP QLHDV yêu cầu bổ sung đơn miễn giảm",
			9 => "QLCC yêu cầu bổ sung đơn miễn giảm",
		];
		if ($status === null) return $exemptions;
		foreach ($exemptions as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('prevent_insurance')) {
	function prevent_insurance($status = null)
	{
		$result = '';
		$prevent = [
			1 => "Chặn",
			2 => "Không chặn"
		];
		if ($status === null) return $prevent;
		foreach ($prevent as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('status_contract_debt_to_field')) {
	function status_contract_debt_to_field($status = null)
	{
		$contract_debt = [
			1 => "Mới",
			2 => "Đã duyệt",
			3 => "Đà từ chối",
			4 => "Đã xóa",
			5 => "Đã xóa", //data old
			36 => "Đã gọi khách hàng",
			37 => "Đã chuyển yêu cầu sang Field",
			279 => "Chờ TP QLHDV duyệt Field",
		];
		if ($status === null) return $contract_debt;
		foreach ($contract_debt as $key => $item) {


			if ($key == $status) {
				$result = $item;
			}

		}
		$result = (empty($result)) ? $status : $result;
		return $result;
	}
}

if (!function_exists('status_contract_field')) {
	function status_contract_field($status = null)
	{
		$contract_debt = [
			1 => "Mới",
			2 => "Đã duyệt",
			3 => "Đã từ chối",
			4 => "Đã xóa",
			279 => "Đã import cho Call",

		];
		if ($status === null) return $contract_debt;
		foreach ($contract_debt as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		$result = (empty($result)) ? $status : $result;
		return $result;
	}
}

if (!function_exists('payment_method')) {
	function payment_method($status = null)
	{
		$transaction_payment = [
			1 => "Tiền mặt",
			2 => "Chuyển khoản",
			"app_vfc_nl" => "app_vfc_nl",
			"momo_app" => "momo_app",
			"VPBank" => "VPBank"
		];
		if ($status === null) return $transaction_payment;
		foreach ($transaction_payment as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('lead_nguon_full')) {

	function lead_nguon_full($status = null)
	{
		$leadstatus = [
			1 => 'Digital',
			2 => 'TLS Tự kiếm',
			3 => 'Tổng đài',
			4 => 'Giới thiệu',
			5 => 'Đối tác',
			6 => 'Fanpage',
			7 => 'Nguồn khác',
			12 => 'Nguồn App Mobile',
			8 => 'KH vãng lai',
			9 => 'KH tự kiếm',
			10 => 'Cộng tác viên',
			11 => 'KH giới thiệu KH',
			'VM' => 'VM',
			'trandata' => 'trandata',
			'TS' => 'TS',
			'VPS' => 'VPS',
			'MB' => 'MB',
			14 => "Tool FB",
			15 => "Tiktok",
			16 => 'Remarketing',
			'Homedy' => 'Homedy',
			'phan_nguyen' => 'phan_nguyen',
			21 => 'Google',
			22 => 'Zalo',
			23 => 'Topup',
			24 => 'Tái vay',


		];

		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('status_contract_megadoc')) {
	function status_contract_megadoc($status = null)
	{
		$status_megadoc = [
			0 => "Hợp đồng tạo mới",
			1 => "Đã gửi",
			2 => "Hợp đồng có một chữ ký",
			3 => "Hợp đồng hoàn thành",
			7 => "Hợp đồng đã hủy",
			99 => "Kết nối Megadoc thất bại!"
		];

		if ($status === null) return $status_megadoc;
		foreach ($status_megadoc as $key => $item) {
			if ($status == $key) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('lead_exception')) {
	function lead_exception($status = null)
	{
		$lead_exception = [
			'1' => 'E1.1: Ngoại lệ về tuổi vay',
			'2' => 'E1.2: Ngoại lệ về giấy tờ định danh: CMND/CCCD mờ ảnh / mờ số không đủ điều kiện',
			'3' => 'E2.1: Khách hàng KT3 tạm trú dưới 6 tháng',
			'4' => 'E2.2: Khách hàng KT3 không có hợp đồng thuê nhà, sổ tạm trú, xác minh qua chủ nhà trọ',
			'5' => 'E3.1: Khách hàng thiếu một trong những chứng từ chứng minh thu nhập',
			'6' => 'E4.1: Ngoại lệ về TSĐB khác TSĐB trong quy định về SP hiện hành của công ty (đất, giấy tờ khác...)',
			'7' => 'E4.2: Ngoại lệ về lãi suất sản phẩm',
			'8' => 'E5.1: Ngoại lệ về điều kiện đối với người tham chiếu',
			'9' => 'E5.2: Ngoại lệ PGD gọi điện cho tham chiếu không sử dụng hệ thống phonet',
			'10' => 'E6.1: KH có nhiều hơn 3 KV ở các app hay tổ chức tín dụng, ngân hàng khác',
			'11' => 'E7.1: Khách hàng vay lại có lịch sử trả tiền tốt',
			'12' => 'E7.2: Thu nhập cao, gốc còn lại tại thời điểm hiện tại thấp',
			'13' => 'E7.3: KH làm việc tại các công ty là đối tác chiến lược',
			'14' => 'E7.4: Giá trị định giá tài sản cao',
		];
		if ($status === null) return $lead_exception;
		foreach ($lead_exception as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('status_history_property')) {
	function status_history_property($status = null)
	{
		$status_megadoc = [
			'approved' => "Đã duyệt",
			'create' => "Đã tạo",
			'note' => "Trả về",
			'valuation' => "Định giá",
			'cancel' => "Hủy duyệt",
			'delete' => "Đã xóa"
		];
		if ($status === null) return $status_megadoc;
		foreach ($status_megadoc as $key => $item) {
			if ($status == $key) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('status_valuation_property')) {
	function status_valuation_property($status = null)
	{
		$type_property = array(
			'3' => 'Đã duyệt',//3 approved
			'6' => 'Hủy duyệt',//6 cancel_approve
			'2' => 'Đang chờ duyệt',//2 pending_approve
			'1' => 'Đang chờ định giá', //1 pending
			'5' => 'Hủy định giá',//5 cancel
			'4' => "Trả về", //4 note
		);
		if ($status === null) return $type_property;
		foreach ($type_property as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('type_sms_megadoc')) {
	function type_sms_megadoc($status = null)
	{
		$type_sms = [
			'ky_so' => "Ký số",
			'mxt' => "Mã xác thực"
		];
		if ($status === null) return $type_sms;
		foreach ($type_sms as $key => $item) {
			if ($status == $key) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('status_sms_megadoc')) {
	function status_sms_megadoc($status = null)
	{
		$status_sms_megadoc = [
			'new' => "Tạo mới",
			'success' => "Thành công",
			'fail' => "Thất bại",
		];
		if ($status === null) return $status_sms_megadoc;
		foreach ($status_sms_megadoc as $key => $item) {
			if ($status == $key) {
				$result = $item;
			}
		}
		return $result;
	}
}
if (!function_exists('type_document_sms')) {
	function type_document_sms($status = null)
	{
		$type_document_sms = [
			'ttbb' => "Thỏa thuận ba bên",
			'bbbgt' => "Biên bản bàn giao khi vay",
			'tb' => "Thông báo",
			'bbbgs' => "Biên bản bàn giao khi thanh lý",
		];
		if ($status === null) return $type_document_sms;
		foreach ($type_document_sms as $key => $item) {
			if ($status == $key) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('status_blacklist_property')) {
	function status_blacklist_property($status = null)
	{
		$type_document_sms = [
			'1' => "Chờ kiểm tra",
			'2' => "Yêu cầu cập nhật",
			'3' => "Trả về",
			'4' => "Xác nhận tài sản thật",
			'active' => 'Đã xác nhận giấy tờ giả',
			'200' => "Hủy"
		];
		if ($status === null) return $type_document_sms;
		foreach ($type_document_sms as $key => $item) {
			if ($status == $key) {
				$result = $item;
			}
		}
		return $result;
	}
}


if (!function_exists('return_kt')) {
	function return_kt($status = null)
	{
		$return_kt = [
			"GIOI_TINH" => 'Sai giới tính khách hàng',
			"STK" => 'Sai số tài khoản nhận của khách hàng',
			"HOSO" => 'Upload thiếu hồ sơ giải ngân, chứng từ giải ngân bị mờ chữ',
			"CMT/CCCD" => 'Sai thông tin trên CMT/CCCD, CMT/CCCD không chụp đầy đủ 4 góc',
			"SOTIEN" => 'Điền sai kỳ thanh toán, số tiền phải trả hàng tháng bằng số và chữ',
			"ANH" => 'Chụp ảnh không rõ mặt khách hàng',
			"TEN" => 'Chưa viết đầy đủ họ tên khách hàng',
			"CAVET" => 'Sai thông tin cavet xe',
			"KHAC" => 'Khác',
		];
		if ($status === null) return $return_kt;
		foreach ($return_kt as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}

}

if (!function_exists('log_action')) {
	function log_action($status = null)
	{
		$type = [
			'created' => "Tạo mới",
			'updated' => "Cập nhật",
			'noted' => "Trả về",
			'cancelled' => "Hủy bỏ",
			'cancel_approved' => "Hủy duyệt tài sản",
			'approved' => "Duyệt tài sản",
			'valuation' => "Định giá tài sản",
			'comment' => "Phản hồi",
		];
		if ($status === null) return $type;
		foreach ($type as $key => $item) {
			if ($status == $key) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('lead_fb_mkt')) {
	function lead_fb_mkt($status = null, $hide = true)
	{
		$leadstatus = [
			1 => 'Cao',
			2 => 'Trung bình',
			3 => 'Thấp'
		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('history_blacklist_property')) {
	function history_blacklist_property($status = null)
	{
		$return_kt = [
			"create" => 'Thêm mới',
			"cancel" => 'Hủy',
			"note" => 'Trả về',
			"check_fake_property" => 'Xác nhận tài sản giả',
			"check_real_property" => 'Xác nhận tài sản thật',
			"update_request_blacklist" => 'Cập nhật thông tin vào blacklist',
			"update_feedback" => 'Cập nhật sau trả về',
			"request_update" => 'Yêu cầu cập nhật',
			"comment" => 'Bình luận',
		];
		if ($status === null) return $return_kt;
		foreach ($return_kt as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('status_verified_ctv')) {
	function status_verified_ctv($status = null)
	{
		$return_kt = [
			"1" => 'Chưa xác thực',
			"2" => 'Đang chờ xác thực',
			"3" => 'Đã xác thực',
			"4" => 'Xác thực lại',
		];
		if ($status === null) return $return_kt;
		foreach ($return_kt as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('name_code_data_cp')) {
	function name_code_data_cp($status = null)
	{
		$name_code_data_cp = [
			"HC.01" => 'Thuê văn phòng HO',
			"NS.01" => 'Thanh toán lương hàng tháng',
			"MKT.01" => 'Tạm ứng CP chạy quảng cáo L1',
			"HC.02" => 'Chi phí hành chính',
			"HC.03" => 'Đổ mực',
			"HC.04" => 'Cước điện thoại cố định 1900',
			"HC.05" => 'Nước thanh toán',
			"HC.06" => 'Mua sắm thiết bị CNTT',
			"HC.07" => 'Vệ sinh',
			"HC.08" => 'Định vị',
			"HC.09" => 'Nạp cước điện thoại hotline',
			"HC.10" => 'Cước Internet các PGD và HO',
			"HC.11" => 'Camera Phúc Bình',
			"XDCB.01" => 'Xây mới PGD, sửa chữa PGD cũ',
			"PD.01" => 'Giao dịch đảm bảo',
			"MKT.02" => 'CP MKT Affirate: Rio, Accesstrade..',
			"MKT.03" => 'Thanh toán CP CTV MKT',
			"NS.02" => 'Thanh lý lương đợt 1',
			"NS.03" => 'Thanh toán CP tuyển dụng đợt 1',
			"KT.01" => 'Bảo hiểm GIC, MIC, PTI, VBI',
			"KT.02" => 'Thu hộ HeyU',
			"HC.12" => 'Vé máy bay và phòng khách sạn',
			"PTMB.01" => 'Thanh toán mặt bằng',
			"HC.13" => 'Nước uống',
			"HC.14" => 'Giấy vệ sinh',
			"HC.15" => 'Gửi xe',
			"HC.16" => 'Bảo vệ',
			"HC.17" => 'VPP',
			"HC.18" => 'CPN',
			"HC.19" => 'Điện sinh hoạt',
			"NS.04" => 'Thanh lý lương đợt 2',
			"NS.05" => 'Thanh toán CP tuyển dụng đợt 2',
			"NS.06" => 'Thanh toán BHXH',
			"MKT.04" => 'Tạm ứng CP chạy quảng cáo L2',
			"MKT.05" => 'Ấn phẩm trade MKT',
			"XDCB.02" => 'Xây mới PGD, sửa chữa PGD cũ',

		];
		if ($status === null) return $name_code_data_cp;
		foreach ($name_code_data_cp as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('name_ratio')) {
	function name_ratio($status = null)
	{
		$name_ratio = [
			'ndt_hop_tac' => 'NĐT hợp tác',
			'ndt_app_vi_nl' => 'NĐT App ví NL',
			'ndt_app_vi_vimo' => 'NĐT App ví Vimo',
			'ndt_app_vi_vay_muon' => 'NĐT App ví Vimo Vay Mượn',
			'vndt' => '	VNDT',
		];
		if ($status === null) return $name_ratio;
		foreach ($name_ratio as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('status_exemption_profile')) {
	function status_exemption_profile($status = null)
	{
		$status_exemption = [
			1 => "Mới",
			2 => "Chờ gửi",
			3 => "Đã gửi",
			4 => "Hoàn tất lưu hồ sơ",
			5 => "Trả về",
			6 => "Đã trả",
			7 => "Thiếu hồ sơ",
			8 => "Lưu kho trả",
			9 => "Chờ trả",
			10 => "Kết thúc",
		];

		if ($status === null) return $status_exemption;
		foreach ($status_exemption as $key => $item) {
			if ($status == $key) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('is_yes_or_no')) {
	function is_yes_or_no($status = null)
	{
		$is_email_confirm = [
			1 => "Có",
			2 => "Không có",
		];
		if ($status === null) return $is_email_confirm;
		foreach ($is_email_confirm as $key => $item) {
			if ($status == $key) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('type_send')) {
	function type_send($status = null)
	{
		$type_exemption = [
			1 => "GỬI",
			2 => "TRẢ",
			3 => "THIẾU",
		];
		if ($status === null) return $type_exemption;
		foreach ($type_exemption as $key => $item) {
			if ($status == $key) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('type_exception')) {
	function type_exception($status = null)
	{
		$type_exemption = [
			1 => "Ngoại lệ",
			2 => "Thanh lý tài sản",
			3 => "Thường",
		];
		if ($status === null) return $type_exemption;
		foreach ($type_exemption as $key => $item) {
			if ($status == $key) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('type_xuat_nhap_ton')) {
	function type_xuat_nhap_ton($status = null)
	{
		$type_exemption = [
			1 => "Nhập kho mới",
			2 => "Xuất bàn giao mới",
			3 => "Xuất bàn giao cũ",
			4 => "Điều chuyển kho xuất",
			5 => "Điều chuyển kho nhập",
			6 => "Thu hồi về kho",
			7 => "Nhập kho cũ",
		];
		if ($status === null) return $type_exemption;
		foreach ($type_exemption as $key => $item) {
			if ($status == $key) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('color_type_xuat_nhap_ton')) {
	function color_type_xuat_nhap_ton($status = null)
	{
		$result = '';
		$leadstatus = [
			1 => "label-primary",
			2 => "label-success",
			3 => "label-warning",
			4 => "label-info",
			5 => "label-info",
			6 => "label-danger",
			7 => "label-default",
		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('status_trans_ctv')) {
	function status_trans_ctv($status = null)
	{
		$leadstatus = [
			'1' => 'Đã thanh toán',
			'2' => 'Chờ ngân lượng xử lý',
			'3' => 'Thanh toán tự động thất bại',
			'4' => 'Giao dịch đã hoàn trả',
		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {

			if ($key == $status) {
				$result = $item;
			}

		}
		$result = (empty($result)) ? $status : $result;
		return $result;
	}
}


/**
 *  Trạng thái lý do trả về phiếu thu
 * */
if (!function_exists('reasons_return_transaction')) {
	function reasons_return_transaction($status = null)
	{
		$reasons = [
			1 => "Thiếu chứng từ",
			2 => "Sai thông tin miễn giảm",
			3 => "Sai thông tin liên quan tới gia hạn",
			4 => "Sai thông tin liên quan tới cơ cấu",
			5 => "Sai thông tin phiếu thu HeyU",
			6 => "Bổ sung xác nhận huỷ PT tiền mặt của quản lý"
		];
		if ($status === null) return $reasons;
		foreach ($reasons as $key => $item) {
			if ($key == $status) {
				$result = $item;
				break;
			}
		}
		$result = (empty($result)) ? $status : $result;
		return $result;
	}
}

/**
 *  Trạng thái lý do hủy phiếu thu
 * */
if (!function_exists('reasons_cancel_transaction')) {
	function reasons_cancel_transaction($status = null)
	{
		$reasons = [
			1 => "Trùng lệnh",
			2 => "Sai số tiền",
			3 => "Sai phương thức thanh toán",
			4 => "Sai loại thanh toán",
			5 => "Sai thông tin miễn giảm",
			6 => "Lỗi GD duyệt định danh",
			7 => "Lỗi gộp GD ngân hàng",
			8 => "Sai ngày thanh toán",
			9 => "Sai thông tin phiếu thu HeyU",
		];
		if ($status === null) return $reasons;
		foreach ($reasons as $key => $item) {
			if ($key == $status) {
				$result = $item;
				break;
			}
		}
		$result = (empty($result)) ? $status : $result;
		return $result;
	}
}

if (!function_exists('loan_product')) {
	function loan_product($status = null)
	{
		$lead_type_finance = [
			1 => "Vay nhanh xe máy",
			2 => "Vay theo đăng ký - cà vẹt xe máy chính chủ",
			3 => "Vay theo đăng ký - cà vẹt xe máy không chính chủ",
			4 => "Cầm cố xe máy",
			5 => "Cầm cố ô tô",
			6 => "Vay nhanh ô tô",
			7 => "Vay theo đăng ký - cà vẹt ô tô",
			9 => "Vay tín chấp CBNV tập đoàn",
			10 => "Vay theo xe CBNV VFC",
			11 => "Vay theo xe CBNV tập đoàn",
			12 => "Vay theo xe CBNV Phúc Bình",
			13 => "Quyền sử dụng đất",
			14 => "Bổ sung vốn kinh doanh Online",
			15 => "Vay tín chấp CBNV Phúc Bình",
			16 => "Sổ đỏ",
			17 => "Sổ hồng, hợp đồng mua bán căn hộ",
			18 => "Ứng tiền siêu tốc cho tài xế công nghệ",
			19 => "Sản phẩm vay nhanh gán định vị",
		];
		if ($status === null) return $lead_type_finance;
		foreach ($lead_type_finance as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}
/**
 *  Loại đơn miễn giảm
 * */
if (!function_exists('type_payment_exem')) {
	function type_payment_exem($type = null)
	{
		$type_exemption = [
			'1' => 'Thanh toán',
			'2' => 'Tất toán',
		];
		if ($type === null) return $type_exemption;
		foreach ($type_exemption as $key => $item) {

			if ($key == $type) {
				$result = $item;
			}

		}
		$result = (empty($result)) ? $type : $result;
		return $result;
	}
}


if (!function_exists('name_area')) {
	function name_area($status = null)
	{
		$name = [
			"KV_HN1" => "Khu vực Hà Nội",
			"KV_QN" => "Khu vực Đông Bắc",
			"KV_BD" => "Khu vực Bình Dương",
			"KV_HCM2" => "Khu vực Hồ Chí Minh ",
			"KV_HCM1" => "Khu vực Hồ Chí Minh ",
			"KV_MK" => "Khu vực MeKong",
			"KV_BTB" => "Khu vực Bắc Trung Bộ",
		];
		if ($status === null) return $name;
		foreach ($name as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}

if (!function_exists('status_dkx')) {
	function status_dkx($status = null)
	{
		$status_dkx = [
			'1' => 'Lưu kho',
			'2' => 'Đã trả',
			'3' => 'Lưu hợp đồng khác',
			'4' => 'Chưa cập nhật',
		];
		if ($status === null) return $status_dkx;
		foreach ($status_dkx as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		$result = (empty($result)) ? $status : $result;
		return $result;
	}
}

if (!function_exists('loan_security')) {
	function loan_security($status = null)
	{
		$array_loan_security = [
			'1' => 'Công khai',
			'2' => 'Bảo mật'
		];
		if ($status === null) return $array_loan_security;
		foreach ($array_loan_security as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		$result = (empty($result)) ? $status : $result;
		return $result;
	}
}

if (!function_exists('status_device')) {
	function status_device($status = null)
	{
		$type_exemption = [
			1 => "Mới",
			2 => "Cũ",
			3 => "Đang hoạt động",
		];
		if ($status === null) return $type_exemption;
		foreach ($type_exemption as $key => $item) {
			if ($status == $key) {
				$result = $item;
				return $result;
			}
		}
		return "Khác";
	}
}

if (!function_exists('status_hand_over')) {
	function status_hand_over($status = null)
	{
		$type_exemption = [
			1 => "Gửi yêu cầu",
			2 => "Xác nhận về kho",
		];
		if ($status === null) return $type_exemption;
		foreach ($type_exemption as $key => $item) {
			if ($status == $key) {
				$result = $item;
				return $result;
			}
		}
		return;
	}
}

if (!function_exists('status_pgd_old')) {
	function status_pgd_old($status = null)
	{
		$result = '';
		$leadstatus = [
			1 => 'Mới',
			2 => 'Ko thuộc khu vực hỗ trợ',
			3 => 'Ko thuộc sản phẩm hỗ trợ',
			4 => 'Ko cung cấp được SHK/KT3',
			5 => 'Ko cung cấp được thông tin thu nhập',
			6 => 'Ko cung cấp được ĐKX/HĐMB',
			7 => 'Ko đồng ý giữ ĐKX/HĐMB',
			8 => 'Trả về CSKH',
			9 => 'Thuê bao/Không nghe máy',
			10 => 'Khách hết nhu cầu',
			11 => 'Khách chê lãi cao',
			12 => 'Khách từ chối vì duyệt thấp',
			13 => 'Xe ko chính chủ',
			14 => 'Tài sản giá trị thấp',
			15 => 'Đeo bám',
			16 => 'Hủy',
			17 => 'Đang xử lý',
			18 => 'Đã giải ngân',
			19 => 'Chờ gọi lại lần 1',
			20 => 'Chờ gọi lại lần 2',
			21 => 'Chờ gọi lại lần 3',
			22 => 'Chờ gọi lại lần 4',
			23 => 'Chờ gọi lại lần 5',
			24 => 'Chờ gọi lại lần 6',
			25 => 'Chờ gọi lại lần 7',
			26 => 'Chờ gọi lại lần 8',
			27 => 'Chờ gọi lại lần 9',
			28 => 'Đang suy nghĩ',
			29 => 'Trùng PGD tự kiếm',
			30 => 'Chờ KH bổ sung hồ sơ',
			31 => 'KH hẹn ra PGD',
			32 => 'KH thuộc khu vực cách ly/phong toả',
			33 => 'Chưa liên hệ được',
			34 => 'Chưa đặt lịch hẹn',
			35 => 'KH chưa đến PGD',
			36 => 'Hỗ trợ tận nhà',
			37 => 'Hẹn gọi lại',
			38 => 'Chờ thẩm định',
			39 => 'Chờ phê duyệt',
			40 => 'Chờ giải ngân'
		];
		if ($status === null) return $leadstatus;
		foreach ($leadstatus as $key => $item) {
			if ($key == $status) {
				$result = $item;
			}
		}
		return $result;
	}
}




