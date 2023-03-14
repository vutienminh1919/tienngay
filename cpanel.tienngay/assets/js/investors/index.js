$(document).ready(function(){


$('#bank').selectize({
    create: false,
    valueField: 'bank_id',
    labelField: 'name',
    searchField: 'name',
    maxItems: 1,
    sortField: {
        field: 'name',
        direction: 'asc'
    }
});
$('#number_investment').keyup(function(event) {
    // skip for arrow keys
    if(event.which >= 37 && event.which <= 40) return;

    // format number
    $(this).val(function(index, value) {
        return value
        .replace(/\D/g, "")
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        ;
    });
});
$('#number_investment').keyup(function(event) {

    $('.number').keypress(function(event) {

        if ((event.which != 46 || $(this).val().indexOf(',') != -1) && (event.which < 48 || event.which > 57)) {

            event.preventDefault();
        }
    });
});
$("#update_en_btn").click(function(event) {

    $("input").prop('disabled', false);
    $("#bank").prop('disabled', false);
    $("select").prop('disabled', false);
    $("input[name='code']").prop('disabled', true);
    $(".update_investors").prop('disabled', false);
});
$(".delete_investors").click(function(event) {
    event.preventDefault();
    var id = $(this).attr('data-id');
    var formData = {
        id: id
    };
    $.ajax({
        url :  _url.base_url + '/investors/deleteinvestors',
        type: "POST",
        data : formData,
        dataType : 'json',
        beforeSend: function(){$("#loading").show();},
        success: function(data) {
            if (data.res) {
                $(".investors_" + id).remove();
                $('#successModal').modal('show');
                $('.msg_success').text(data.message);
            } else {
                $('#errorModal').modal('show');
                $('.msg_error').text(data.message);
            }
        },
        error: function(data) {
            console.log(data);
            $("#loading").hide();
        }
    });
 
});
$(".create_investors").click(function(event) {
    event.preventDefault();
        var type_investors = $("select[name='type_investors']").val();
        var merchant_id = $("input[name='merchant_id']").val();
        var merchant_password = $("input[name='merchant_password']").val();
        var receiver_email = $("input[name='receiver_email']").val();
        var code = $("input[name='code']").val();
        var name = $("input[name='name']").val();
        var dentity_card = $("input[name='dentity_card']").val();
        var balance = $("input[name='balance']").val();
        var tax_code = $("input[name='tax_code']").val();
        var percent_interest_investor = $("input[name='percent_interest_investor']").val();
        var date_of_birth = $("input[name='date_of_birth']").val();
        var email = $("input[name='email']").val();
        var account_number = $("input[name='account_number']").val();
        var bank = $("select[name='bank']").val();
        var bank_branch = $("input[name='bank_branch']").val();
        var phone = $("input[name='phone']").val();
        var address = $("input[name='address']").val();
        var form_of_receipt = $("select[name='form_of_receipt']").val();
        var status = $("input[name='status']:checked").val();
        var formData = new FormData();
        formData.append('type_investors', type_investors);
        formData.append('merchant_id', merchant_id);
        formData.append('merchant_password', merchant_password);
        formData.append('receiver_email', receiver_email);
        formData.append('code', code);
        formData.append('name', name);
        formData.append('dentity_card', dentity_card);
        formData.append('balance', balance);
        formData.append('tax_code', tax_code);
        formData.append('percent_interest_investor', percent_interest_investor);
        formData.append('date_of_birth', date_of_birth);
        formData.append('email', email);
        formData.append('account_number', account_number);
        formData.append('bank', bank);
        formData.append('bank_branch', bank_branch);
        formData.append('phone', phone);
        formData.append('address', address);
        formData.append('form_of_receipt', form_of_receipt); 
        formData.append('status', status); 

    $.ajax({
        url :  _url.base_url + 'investors/doAddInvestors',
        type: "POST",
        data : formData,
        dataType : 'json',
        processData: false,
        contentType: false,
        beforeSend: function(){$(".theloading").show();},
        success: function(data) {
            $(".theloading").hide();
              //console.log(data);
            if (data.res) {
                  console.log(data);
                $('#successModal').modal('show');
                $('.msg_success').text(data.message);
                setTimeout(function(){ 
                    window.location.href = _url.base_url + 'investors/listinvestors';
                }, 3000);
            } else {
                  console.log(data);
                $("#div_error").css("display", "block");
                $(".div_error").text(data.message);
                window.scrollTo(0, 0);
                setTimeout(function(){ 
                $("#div_error").css("display", "none");
                }, 3000);
            }
        },
        error: function(data) {
            //console.log(data);
            $(".theloading").hide();
         
                
        }
    });
 
});

$(".update_investors").click(function(event) {
    event.preventDefault();
        var type_investors = $("select[name='type_investors']").val();
        var merchant_id = $("input[name='merchant_id']").val();
        var merchant_password = $("input[name='merchant_password']").val();
        var receiver_email = $("input[name='receiver_email']").val();

        var id = $("input[name='id_investors']").val();
        var code = $("input[name='code']").val();
        var name = $("input[name='name']").val();
        var dentity_card = $("input[name='dentity_card']").val();
        var balance = $("input[name='balance']").val();
        var tax_code = $("input[name='tax_code']").val();
        var percent_interest_investor = $("input[name='percent_interest_investor']").val();
        var date_of_birth = $("input[name='date_of_birth']").val();
        var email = $("input[name='email']").val();
        var account_number = $("input[name='account_number']").val();
        var bank = $("select[name='bank']").val();
        var bank_branch = $("input[name='bank_branch']").val();
        var phone = $("input[name='phone']").val();
        var address = $("input[name='address']").val();
        var form_of_receipt = $("select[name='form_of_receipt']").val();
        var status = $("input[name='status']:checked").val();
        var formData = new FormData();
        formData.append('type_investors', type_investors);
        formData.append('merchant_id', merchant_id);
        formData.append('merchant_password', merchant_password);
        formData.append('receiver_email', receiver_email);
        formData.append('code', code);
        formData.append('name', name);
        formData.append('dentity_card', dentity_card);
        formData.append('balance', balance);
        formData.append('tax_code', tax_code);
        formData.append('percent_interest_investor', percent_interest_investor);
        formData.append('date_of_birth', date_of_birth);
        formData.append('email', email);
        formData.append('account_number', account_number);
        formData.append('bank', bank);
        formData.append('bank_branch', bank_branch);
        formData.append('phone', phone);
        formData.append('address', address);
        formData.append('form_of_receipt', form_of_receipt); 
        formData.append('status', status); 
        formData.append('id', id);
    $.ajax({
        url :  _url.base_url + '/investors/doUpdateInvestors',
        type: "POST",
        data : formData,
        dataType : 'json',
        processData: false,
        contentType: false,
        beforeSend: function(){$(".theloading").show();},
        success: function(data) {
             $(".theloading").hide();
            if (data.res) {
                $('#successModal').modal('show');
                $('.msg_success').text(data.message);
                setTimeout(function(){ 
                    window.location.href = _url.base_url + '/investors/listinvestors';
                }, 3000);
            } else {
                $("#div_error").css("display", "block");
                $(".div_error").text(data.message);
                window.scrollTo(0, 0);
                setTimeout(function(){ 
                $("#div_error").css("display", "none");
                }, 3000);
            }
        },
        error: function(data) {
            console.log(data);
            $(".theloading").hide();
        }
    });
 
});

$(".update_detail_payment").click(function(event) {
    event.preventDefault();
        var id_contract = $("input[name='id_contract']").val();
        var ngay_tra = $("input[name='ngay_tra']").val();
        var so_tien_lai_da_tra = $("input[name='so_tien_lai_da_tra']").val();
        var so_tien_goc_da_tra = $("input[name='so_tien_goc_da_tra']").val();
         var so_tien_lai_phai_tra = $("input[name='so_tien_lai_den_han']").val();
        var so_tien_goc_phai_tra = $("input[name='so_tien_goc_den_han']").val();
        var hinh_thuc_tra = $("input[name='payment_method']:checked").val();
        var ma_giao_dich_ngan_hang = $("input[name='ma_giao_dich_ngan_hang']").val();
        var ghi_chu = $("textarea[name='ghi_chu']").val();
        var formData = new FormData();
        formData.append('ma_giao_dich_ngan_hang', ma_giao_dich_ngan_hang);
        formData.append('ghi_chu', ghi_chu);
        formData.append('ngay_tra', ngay_tra);
        formData.append('so_tien_lai_da_tra', so_tien_lai_da_tra);
        formData.append('so_tien_goc_da_tra', so_tien_goc_da_tra);
         formData.append('so_tien_goc_phai_tra', so_tien_goc_phai_tra);
        formData.append('so_tien_lai_phai_tra', so_tien_lai_phai_tra);
        formData.append('hinh_thuc_tra', hinh_thuc_tra);
        formData.append('id_contract', id_contract);

    $.ajax({
        url :  _url.base_url + '/investors/doUpdateTemporary_plan_contract',
        type: "POST",
        data : formData,
        dataType : 'json',
        processData: false,
        contentType: false,
        beforeSend: function(){$(".theloading").show();},
        success: function(data) {
            $("#loading").hide();
            if(data.status == 200){
                $("#successModal").modal("show");
                $(".msg_success").text(data.msg);
                setTimeout(function(){
                    window.location.href = _url.base_url +data.url;
                }, 3000);

            }else{
                $('#errorModal').modal('show');
                $('.msg_error').text(data.msg);
            }
        },
        error: function(data) {
            console.log(data);
            $(".theloading").hide();
        }
    });
});


$('.toggleTheDetail').click(function(event) {
  event.preventDefault();
  var code_contract= $(this).data('code_contract');
  var stt= $(this).data('stt');
  var phan_tram_lai_vay= $(this).data('laivay');
  var hinhthuctralai= $(this).data('hinhthuctralai');
  var sotienvay= $(this).data('sotienvay');

  var tong_so_goc_da_tra=0,tong_so_lai_da_tra=0,tong_so_goc_phai_tra=0,tong_so_lai_phai_tra=0,tong_so_con_lai_phai_tra_DH=0;
  var html_fist,html_last='',html_history='';
  var  html_history='',html_history_fist='',html_history_last='';
  var formData = {
          code_contract: code_contract,
          // code: code
      };

    $.ajax({
    url :  _url.base_url + 'investors/doGetTemporary_plan_contract',
    type: "POST",
    data : formData,
    dataType : 'json',
    beforeSend: function(){$("#loading").show();},
    success: function(data) {
     
        if (data.res) {
          $('#thedetail'+stt).empty();

        for (var key in data.data) {
            var obj = data.data[key];
            var ma_giao_dich_ngan_hang= (obj.hasOwnProperty('lich_su_tra_ndt_thu')) ? obj.lich_su_tra_ndt_thu.ma_giao_dich_ngan_hang : '';
            var ghi_chu= (obj.hasOwnProperty('lich_su_tra_ndt_thu')) ? obj.lich_su_tra_ndt_thu.ghi_chu : '';
            var hinh_thuc_tra= (obj.hasOwnProperty('lich_su_tra_ndt_thu')) ? obj.lich_su_tra_ndt_thu.hinh_thuc_tra : '';
            var so_tien_goc_da_tra= (obj.hasOwnProperty('lich_su_tra_ndt_thu')) ? obj.lich_su_tra_ndt_thu.so_tien_goc_da_tra : '';
            var so_tien_lai_da_tra= (obj.hasOwnProperty('lich_su_tra_ndt_thu')) ? obj.lich_su_tra_ndt_thu.so_tien_lai_da_tra : '';

            if(hinhthuctralai==2)
            var lai_ky=Number(sotienvay)*Number(phan_tram_lai_vay/100);
            if(hinhthuctralai==1)
            var lai_ky=Number(obj.tien_goc_con)*Number(phan_tram_lai_vay/100);

            var ngay_tra= (obj.hasOwnProperty('lich_su_tra_ndt_thu')) ? obj.lich_su_tra_ndt_thu.ngay_tra : '';
            var so_con_lai_phai_tra_DH= (obj.hasOwnProperty('lich_su_tra_ndt_thu')) ? (Number(obj.tien_goc_1ky)+Number(lai_ky)-Number(so_tien_goc_da_tra)-Number(so_tien_lai_da_tra)) : '';
            var so_con_lai_phai_tra= (obj.hasOwnProperty('lich_su_tra_ndt_thu')) ? (Number(obj.tien_goc_1ky)+Number(lai_ky)-Number(so_tien_goc_da_tra)-Number(so_tien_lai_da_tra)) : '';
            tong_so_goc_da_tra+=Number(so_tien_goc_da_tra);
            tong_so_lai_da_tra+=Number(so_tien_lai_da_tra);
            tong_so_goc_phai_tra+=Number(obj.tien_goc_1ky);
            tong_so_lai_phai_tra+=Number(lai_ky);
           // tong_so_lai_phai_tra+=(Number(obj.tien_goc_con)*Number(phan_tram_lai_vay));

                html_last+=' <tr> <td>'+(Number(key)+1)+'</td> <td>'+obj.ky_tra+'</td>  <td>'+formatDate(obj.ngay_ky_tra)+'</td> <td> Tiền gốc: '+ formatMoney(obj.tien_goc_1ky)+'<br> Tiền lãi: '+ formatMoney(lai_ky)+'<br> Tổng: '+ formatMoney(Number(obj.tien_goc_1ky)+Number(lai_ky))+' </td> <td> Tiền gốc: '+formatMoney(so_tien_goc_da_tra)+'<br> Tiền lãi: '+formatMoney(so_tien_lai_da_tra)+'<br> Tổng: '+formatMoney(Number(so_tien_lai_da_tra)+Number(so_tien_goc_da_tra))+' </td> <td> Tiền gốc: '+formatMoney(Number(obj.tien_goc_1ky)-so_tien_goc_da_tra)+'<br> Tiền lãi: '+formatMoney(Number(lai_ky)-so_tien_lai_da_tra)+'<br> Tổng: '+formatMoney((Number(obj.tien_goc_1ky)-so_tien_goc_da_tra)+Number(lai_ky)-so_tien_lai_da_tra)+'</td>  </tr>  ';
                  if(obj.hasOwnProperty('lich_su_tra_ndt_thu')) 
                html_history_last+=' <tr> <td>'+(Number(key)+1)+'</td> <td>'+obj.ky_tra+'</td> <td>'+formatDate(obj.lich_su_tra_ndt_thu.ngay_tra)+' </td><td>'+ma_giao_dich_ngan_hang+'</td> <td>'+formatDate(obj.ngay_ky_tra)+'</td> <td>'+hinh_thuc_tra+'</td> <td> Tiền gốc: '+ formatMoney(obj.tien_goc_1ky)+'<br> Tiền lãi: '+ formatMoney(lai_ky)+'<br> Tổng: '+ formatMoney(Number(obj.tien_goc_1ky)+Number(lai_ky))+' </td> <td> Tiền gốc: '+formatMoney(so_tien_goc_da_tra)+'<br> Tiền lãi: '+formatMoney(so_tien_lai_da_tra)+'<br> Tổng: '+formatMoney(Number(so_tien_lai_da_tra)+Number(so_tien_goc_da_tra))+'</td> <td>Tiền gốc: '+formatMoney(Number(obj.tien_goc_1ky)-so_tien_goc_da_tra)+'<br> Tiền lãi: '+formatMoney(Number(lai_ky)-so_tien_lai_da_tra)+'<br> Tổng: '+formatMoney(so_con_lai_phai_tra)+'</td><td>'+ghi_chu+'</td>   </tr> ';
            }
            tong_so_con_lai_phai_tra_DH=Number((Number(tong_so_goc_phai_tra)+Number(tong_so_lai_phai_tra)))-Number((Number(tong_so_goc_da_tra)+Number(tong_so_lai_da_tra)));
            console.log(html_history_last);
            if(html_history_last=='')
            html_history_last+=  ' <tr> <td colspan="10"><center><b>Chưa có lịch sử trả lãi</b></center></td></tr>';  
            html_history_fist='<td class="p-0" colspan="2"><h5> Lịch sử trả lãi</h5> <table class="table table-striped"><thead><tr><th>#</th><th>Kỳ</th><th>Thời gian thanh toán</th><th>Mã giao dịch</th><th>Kỳ hạn</th><th>Hình thức trả</th><th>Số tiền phải trả mỗi kỳ</th><th>Số tiền đã trả</th><th>Số còn lại phải trả NĐT</th><th>Ghi chú</th></tr></thead><tbody>';
            html_history_last+="</tbody></table></td>";
            html_history=html_history_fist+html_history_last;
            html_last+="</tbody> </table> </td> </tr><tr id=\"history"+stt+"\"> "+html_history+"</tr> </tbody> </table></td> <script>   $('a.modal_cttt_ndt').click(function(event) { var code_contract = $(this).data('codecontract'); var title= 'Cập nhật thanh toán lãi và gốc'; var id = $(this).data('id'); $(\"input[name='so_tien_goc_da_tra']\").val('');$(\"input[name='so_tien_lai_da_tra']\").val(''); $(\"input[name='ngay_tra']\").val(''); $(\"input[name='hinh_thuc_tra']\").val(''); $(\"input[name='ma_giao_dich_ngan_hang']\").val(''); $(\"textarea[name='ghi_chu']\").val('');    $('#exampleModalLabel').text(title); $(\"input[name='id']\").val(id); $(\"input[name='laivay']\").val("+phan_tram_lai_vay+"); $(\"input[name='sotienvay']\").val("+sotienvay+"); $(\"input[name='hinhthuctralai']\").val("+hinhthuctralai+"); $(\"input[name='code_contract']\").val(code_contract); $(\"input[name='stt']\").val("+stt+") ; });</script>";
            html_fist='<td colspan="10"> <table class="table"> <tbody> <tr> <td> Gốc phải trả NĐT:<strong> '+formatMoney(tong_so_goc_phai_tra)+'</strong> </td><td> Gốc đã trả:<strong> '+formatMoney(tong_so_goc_da_tra)+'</strong> </td> </tr>  <tr> <td> Số lãi phải trả NĐT: <strong>'+formatMoney(tong_so_lai_phai_tra)+'</strong> </td>  <td>  Số lãi đã trả: <strong>'+formatMoney(tong_so_lai_da_tra)+'</strong> </td> </tr> <tr>  <td colspan="2">  Số còn lại phải trả NĐT đến thời điểm đáo hạn: <strong>'+formatMoney(tong_so_con_lai_phai_tra_DH)+'</strong> </td> </tr> <tr> <td class="p-0" colspan="2">  <div class="page-title"><div class="title_left"><h5> Chi tiết thanh toán cho NĐT</h5></div><div class="title_right text-right"></div> </div> <table class="table table-striped"> <thead> <tr> <th>#</th> <th>Kỳ</th>  <th>Kỳ hạn</th> <th>Số tiền phải trả mỗi kỳ</th> <th>Số tiền đã trả</th><th>Số còn lại phải trả NĐT</th>  </tr> </thead> <tbody class="data_cttt" >';
         
          $('#thedetail'+stt).append(html_fist+html_last);
           // console.log('xxxxx');
        } 
    },
    error: function(data) {
       
    }
  });

$('#thedetail'+stt).toggleClass('d-none');
});

 

  $('a.modal_cttt_ndt').click(function(event) {
   var id = $(this).data('id'); 
   var title= 'Cập nhật thanh toán lãi và gốc'; 
 $("input[name='so_tien_goc_da_tra']").val('');
 $("input[name='so_tien_lai_da_tra']").val(''); 
  $("input[name='so_tien_goc_den_han']").val(formatMoney(Number($(this).data('gocdenhan'))));
 $("input[name='so_tien_lai_den_han']").val(formatMoney(Number($(this).data('laidenhan')))); 
  $("input[name='ma_giao_dich_ngan_hang']").val(''); 
 $("input[name='ngay_tra']").val(''); 
  $("input[name='id_contract']").val(id); 
 $("textarea[name='ghi_chu']").val('');   
  $('#exampleModalLabel').text(title); 
});


function formatDate(timestamp)
{
    try {
      var offset = new Date().getTimezoneOffset();
      date = new Date(timestamp * 1000 + 7*60*60*1000);
      return  date.getDate()+'/'+ (Number(date.getMonth())+1) +'/'+date.getFullYear();
       } catch (e) {
          console.log(e)
        }
}

function formatMoney(amount, decimalCount = 0, decimal = ".", thousands = ",") {
  try {
    decimalCount = Math.abs(decimalCount);
    decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

    const negativeSign = amount < 0 ? "-" : "";

    let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
    let j = (i.length > 3) ? i.length % 3 : 0;

    return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
  } catch (e) {
    console.log(e)
  }
};
});
function isEmpty(obj) {
    if(!obj || Object.keys(obj).length === 0)
    return "";
}

$('.so_tien_goc_da_tra').on('input', function(e){        
    $(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress',function(e){
    if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function(e){    
    var cb = e.originalEvent.clipboardData || window.clipboardData;      
    if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
});
$('.so_tien_lai_da_tra').on('input', function(e){        
    $(this).val(formatCurrency(this.value.replace(/[,VNĐ]/g,'')));
}).on('keypress',function(e){
    if(!$.isNumeric(String.fromCharCode(e.which))) e.preventDefault();
}).on('paste', function(e){    
    var cb = e.originalEvent.clipboardData || window.clipboardData;      
    if(!$.isNumeric(cb.getData('text'))) e.preventDefault();
});
function formatCurrency(number){
    var n = number.split('').reverse().join("");
    var n2 = n.replace(/\d\d\d(?!$)/g, "$&,");    
    return  n2.split('').reverse().join('');
}