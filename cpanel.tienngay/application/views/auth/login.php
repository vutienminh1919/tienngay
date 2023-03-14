<?php
$y = date("Y");
$t = date("d-m-Y");
if (strtotime('20-12-'.$y) < strtotime($t) && strtotime('25-12-'.$y) >= strtotime($t)) {
	$this->load->view('auth/noel');
}
// elseif(strtotime('26-12-'.$y) <= strtotime($t) && strtotime('03-01-'.$y) > strtotime($t))
// {
// 	$this->load->view('auth/tet');
// }
elseif(strtotime('26-12-2022') <= strtotime($t) && strtotime('29-01-2023') > strtotime($t))
{
	$this->load->view('auth/tet');
}
//tet am
// elseif(strtotime('15-01-'.$y) <= strtotime($t) && strtotime('03-02-'.$y) > strtotime($t))
// {
// 	$this->load->view('auth/tet');
// }
elseif(strtotime('09-02-'.$y) <= strtotime($t) && strtotime('15-02-'.$y) > strtotime($t))
{
	$this->load->view('auth/valentine');
}
elseif(strtotime('01-03-'.$y) <= strtotime($t) && strtotime('09-03-'.$y) > strtotime($t))
{
	$this->load->view('auth/womenday');
}
elseif(strtotime('26-08-'.$y) <= strtotime($t) && strtotime('03-09-'.$y) > strtotime($t))
{
	$this->load->view('auth/quockhanh');
}
elseif(strtotime('06-09-'.$y) <= strtotime($t) && strtotime('14-09'.$y) > strtotime($t))
{
	$this->load->view('auth/trungthu');
}
//sinh nhat cong ty
elseif(strtotime('15-09-'.$y) <= strtotime($t) && strtotime('22-09-'.$y) > strtotime($t))
{
	$this->load->view('auth/sinhnhat');
}
elseif(strtotime('24-10-'.$y) <= strtotime($t) && strtotime('03-11-'.$y) > strtotime($t))
{
	$this->load->view('auth/halloween');
}
// elseif(strtotime('29-11-'.$y) <= strtotime($t) && strtotime('06-12-'.$y) > strtotime($t))
// {
// 	$this->load->view('auth/image');
// }
else{
	$this->load->view('auth/normal');
}
?>


