<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function slugify($text) {
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // transliterate
    $text = vn_to_str($text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // trim
    $text = trim($text, '-');
    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    // lowercase
    $text = strtolower($text);
    if (empty($text)) {
      return 'n-a';
    }
    return $text;
}
function vn_to_str ($str){
    $unicode = array(
    'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
    'd'=>'đ',
    'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
    'i'=>'í|ì|ỉ|ĩ|ị',
    'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
    'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
    'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
    'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
    'D'=>'Đ',
    'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
    'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
    'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
    'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
    'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
    );
    foreach($unicode as $nonUnicode=>$uni){
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }
    $str = str_replace(' ','_',$str);
    return $str;
}

function showCategoriesModal($menu, $parent_id = "", $char = "", $parentSelected = "") {
    foreach ($menu as $item) {
        $selected = "";
        if($parentSelected == getId($item->_id)) $selected = "selected";
        if ($item->parent_id == $parent_id) {
            echo '<option '.$selected.' value="'.getId($item->_id).'">';
                echo $char . $item->name;
            echo '</option>';
            // Tiếp tục đệ quy để tìm con của item đang lặp
            showCategoriesModal($menu, getId($item->_id), $char.' - ', $parentSelected);
        }
    }
}

function getId($data) {
    $id = (array)$data;
    $id = $id['$oid'];
    return $id;
}

function checkChild($ctgLists, $id) {
    $haveChild = false;
    foreach($ctgLists as $key=>$value) {
        if($key == $id) {
            $haveChild = true;
            break;
        }
    }
    return $haveChild;
}

//Check thằng hiện tại không có cha
function checkParentMenu($ctgLists, $id) {
    $haveParent = false;
    foreach($ctgLists as $key=>$value) {
        foreach($value as $item) {
            if($item == $id) {
                $haveParent = true;
                break;
            }
        }
        
    }
    return $haveParent;
}

function formatNumber($val) {
    if(is_numeric($val) && $val != 0) {
        return number_format($val, 2, ',', '.');
//        return number_format($val, 2, '.', ',');
    } else {
        return $val;
    }
}

function getAmonutByTypePay($type_interest, $amountCalculate, $calLaivayphaitraNDT) {
    //Dư giảm dần
    if($type_interest == 1) {
        $amount = $calLaivayphaitraNDT;
    } 
    //Lãi hàng tháng gốc cuối kỳ
    else {
        $amount = $amountCalculate;
    }
    return $amount;
}

function getLaiVayPhaiTraNDT_expire($type_interest, $amountCalculate, $feeInvestor, $calLaivayphaitraNDT) {
    $amount = 0;
    //Dư giảm dần
    if($type_interest == 1) {
        $amount = $calLaivayphaitraNDT * $feeInvestor / 100;
    } 
    //Lãi hàng tháng gốc cuối kỳ
    else {
        $amount = $amountCalculate * $feeInvestor / 100;
    }
    return $amount;
}

function getLaiVayPhaiTraNDT_end_month($type_interest, $amountCalculate, $feeInvestor, $calLaivayphaitraNDT, $count_date_interest) {
    $amount = 0;
    $cal = 0;
    //Dư giảm dần
    if($type_interest == 1) {
        $cal = $calLaivayphaitraNDT;
    } 
    //Lãi hàng tháng gốc cuối kỳ
    else {
       $cal = $amountCalculate;
    }
    //Tinh toan
    if($feeInvestor > 0) {
        $amount = $feeInvestor > 0 ? $feeInvestor * $cal / 100 : 0;
        $amount = $amount / 30 * $count_date_interest;
    }
    return $amount;
}

function vn_to_str_space ($str){
	$unicode = array(
		'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
		'd'=>'đ',
		'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
		'i'=>'í|ì|ỉ|ĩ|ị',
		'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
		'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
		'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
		'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
		'D'=>'Đ',
		'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
		'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
		'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
		'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
		'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
	);
	foreach($unicode as $nonUnicode=>$uni){
		$str = preg_replace("/($uni)/i", $nonUnicode, $str);
	}
	$str = str_replace(' ',' ',$str);
	return $str;
}

?>
