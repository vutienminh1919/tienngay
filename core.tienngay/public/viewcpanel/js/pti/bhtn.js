
  const pti_bhtn = function (fieldSelect, fieldOutput, selected) {
  var gois = {
    'GOI1' : "GOI1 - 20.000.000",
    'GOI2' : "GOI2 - 30.000.000",
    'GOI3' : "GOI3 - 50.000.000",
    'GOI4' : "GOI4 - 70.000.000",
    'GOI5' : "GOI5 - 100.000.000"
  };
  var phis = {
    'GOI1' : 220000,
    'GOI2' : 240000,
    'GOI3' : 280000,
    'GOI4' : 320000,
    'GOI5' : 370000
  };

  var price = {
    'GOI1' : 20000000,
    'GOI2' : 30000000,
    'GOI3' : 50000000,
    'GOI4' : 70000000,
    'GOI5' : 100000000,
  };
  var html = '<option value="">-- Chọn bảo hiểm --</option>';
  for (const [key, value] of Object.entries(gois)) {
    if (selected == key) {
        html += '<option value="'+key+'" selected>'+value+'</option>'
      } else {
        html += '<option value="'+key+'">'+value+'</option>'
      }
  }
  fieldSelect.append(html);
  fieldSelect.on('change', pti_get_phi.bind(null, phis, price, fieldSelect, fieldOutput));
  $('#dob').on('change', pti_get_phi.bind(null, phis, price, fieldSelect, fieldOutput));
  fieldSelect.change();
}
const fomatNumber = function ($value) {
    if ($value > 0 || $value < 0) {
        return $value.toLocaleString('en-US');
    }
    return 0;
}
const pti_get_phi = function(phis, price, fieldSelect, fieldOutput) {
  var age = calAge($('#dob').val());
  $("#pti_bhtn_price").remove();
  fieldOutput.val(0);
  var val = fieldSelect.val();
  if (val !== "" && val !== undefined) {
    if ((age > 17 && age < 71) || age === true) {
    fieldOutput.val(fomatNumber(phis[val]));
    fieldOutput.after('<input type="hidden" id="pti_bhtn_price" value="'+price[val]+'"/>');
    } else {
      fieldOutput.val(0);
      fieldSelect.val("");
      alert("PTI - Bảo Hiểm Tai Nạn chỉ áp dụng cho khách hàng từ 18->70 tuổi!")
    }
  }
  
}

/**
* date format yyyy-mm-dd or mm/dd/yyyy
*/
const calAge = function(date) {
  if (date == '' || date == undefined) {
    return true;
  }
  var dob = new Date(date);
  //calculate month difference from current date in time
  var month_diff = Date.now() - dob.getTime();
  //convert the calculated difference in date format
  var age_dt = new Date(month_diff);
  //extract year from date
  var year = age_dt.getUTCFullYear();
  //calculate the age of the user
  var age = Math.abs(year - 1970);
  return age;
}

pti_bhtn($("#goi-bh"), $("#phi-bh"));
  
$( document ).ready(function() {
  function Bhtn() {
    this.elIn = $('#step-input');
    this.elCon = $('#step-confirm');
    this.elPay = $('#step-payment');
    this.elFi = $('#step-finish');
    this.formIn = $('#formIn');
    this.stepIn = 1;
    this.stepCon = 2;
    this.stepPay = 3;
    this.stepFin = 4;
    this.id = null;
    this.currentStep = this.stepIn;
    this.payment = false;
    this.formVal = {
      name : null,
      dob : null,
      identity : null,
      email : null,
      phone : null,
      address : null,
      goi : null,
      phi : null,
      dieuKhoan1 : null,
      dieuKhoan2 : null,
      price : null,
      pgdId: null,
      pgdName: null,
      _token : _token
    };

    this.init = function(order) {
      
      if (Object.keys(order).length !== 0) {
        console.log(order);
        var dob = order.pti_request.ngay_sinh;
        this.id = order._id;
        this.formVal = {
          name : order.pti_request.ten,
          dob : dob.slice(0, 4) + '-' + dob.slice(4, 6) + '-' + dob.slice(6, 8),
          identity : order.pti_request.so_cmt,
          email : order.pti_request.email,
          phone : order.pti_request.phone,
          address : order.pti_request.dchi,
          goi : order.pti_request.goi,
          phi : parseInt(order.pti_request.phi),
          dieuKhoan1 : order.dieukhoan1,
          dieuKhoan2 : order.dieukhoan2,
          pgdId: null,
          pgdName: null,
          price : parseInt(order.pti_request.tien_bh),
          _token : _token
        };
        if (isPgdBN) {
          this.formVal.pgdId = order.store.id;
          this.formVal.pgdName = order.store.name;
        }
        setPayment(bankInfo);
        this.setInputVal(this.formVal);
        this.setConfirmVal();
        if (payment == 'success') {
          this.payment = true;
          this.currentStep = this.stepFin;
        } else  {
          this.currentStep = this.stepPay;
          var _id = this.id;
          const intervalPayment = setInterval(function(){
            checkPayment(paymentSuccess, _token, _id);
          }, 60000); // check payment each 2 minutes
        }
        this.progressbar(this.currentStep);
      }
      $("#progressbar li").on("click", this.clickStep.bind(this));
      $("#input-confirm, #input-order").on("click", this.btnStep.bind(this));
      $("#confirm-1, #confirm-2").on("change", function() {
        var dieuKhoan1 = $("input[name='dieu-khoan1']")[0].checked;
        var dieuKhoan2 = $("input[name='dieu-khoan2']")[0].checked;
        if (dieuKhoan1 && dieuKhoan2) {
          $("#input-confirm").removeAttr("disabled");
        } else {
          $("#input-confirm").attr("disabled", "disabled");
        }
      });
    }

    this.moneyToNumber = function (val) {
      console.log(val);
      if (val !== 0 && val !== "" && typeof val !== "undefined"){
        var number = Number(val.replace(/[^0-9.-]+/g,""));
        return number;
      }
      return 0;
    }

    this.validate = function() {
      $(".invalid-feedback").remove();
      $(".is-invalid").removeClass('is-invalid');
      var isValid = true;
      var name = this.formVal.name;
      var dob = this.formVal.dob;
      var identity = this.formVal.identity;
      var email = this.formVal.email;
      var phone = this.formVal.phone;
      var address = this.formVal.address;
      var goi = this.formVal.goi;
      var phi = this.formVal.phi;
      var pgdId = this.formVal.pgdId;
      if (name.length < 1 || name.length > 51) {
        isValid = false;
        $("input[name='name']").addClass('is-invalid');
        if (name.length < 1) {
          $("input[name='name']").after('<span class="invalid-feedback font-w5">Tên không được để trống</span>');
        } else {
          $("input[name='name']").after('<span class="invalid-feedback font-w5">Tên không được quá 50 ký tự</span>');
        }
        
      }
      var regNumber = /^\d+$/;
      if (identity.length < 1) {
        isValid = false;
        $("input[name='identity']").after('<span class="invalid-feedback font-w5">Số cmnd/cccd không được để trống</span>');
        $("input[name='identity']").addClass('is-invalid');
      } else if ((identity.length !== 9 && identity.length !== 12) || !regNumber.test(identity)) {
        isValid = false;
        $("input[name='identity']").after('<span class="invalid-feedback font-w5">Số cmnd/cccd không đúng định dạng</span>');
        $("input[name='identity']").addClass('is-invalid');
      }
      var regDate = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
      if (dob.length < 1) {
        isValid = false;
        $("input[name='dob']").after('<span class="invalid-feedback font-w5">Ngày sinh không được để trống</span>');
        $("input[name='dob']").addClass('is-invalid');
      }else if (!regDate.test(dob)) {
        isValid = false;
        $("input[name='dob']").after('<span class="invalid-feedback font-w5">Ngày sinh không đúng định dạng yyyy-mm-dd</span>');
        $("input[name='dob']").addClass('is-invalid');
      }

      var regEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
      if (email.length < 1) {
        isValid = false;
        $("input[name='email']").after('<span class="invalid-feedback font-w5">Email không được để trống</span>');
        $("input[name='email']").addClass('is-invalid');
      }else if (!regEmail.test(email)) {
        isValid = false;
        $("input[name='email']").after('<span class="invalid-feedback font-w5">Định dạng email không hợp lệ</span>');
        $("input[name='email']").addClass('is-invalid');
      }
      var regPhone = /^0[1-9][0-9]{8}$/;
      if (phone.length < 1) {
        isValid = false;
        $("input[name='phone']").after('<span class="invalid-feedback font-w5">Số điện thoại không được để trống</span>');
        $("input[name='phone']").addClass('is-invalid');
      } else if (!regPhone.test(phone)) {
        isValid = false;
        $("input[name='phone']").after('<span class="invalid-feedback font-w5">Số điện thoại không hợp lệ</span>');
        $("input[name='phone']").addClass('is-invalid');
      }

      if (address.length < 1) {
        isValid = false;
        $("input[name='address']").after('<span class="invalid-feedback font-w5">Địa chỉ không được để trống</span>');
        $("input[name='address']").addClass('is-invalid');
      }

      if (goi == undefined || goi.length < 1) {
        isValid = false;
        $("select[name='goi']").after('<span class="invalid-feedback font-w5">Gói bảo hiểm không được để trống</span>');
        $("select[name='goi']").addClass('is-invalid');
      }
      if (isPgdBN) {
        if (pgdId == undefined || pgdId == null || pgdId == '') {
          isValid = false;
          $("select[name='pgd']").after('<span class="invalid-feedback font-w5">PGD chưa được chọn</span>');
          $("select[name='pgd']").addClass('is-invalid');
        }
      }
      
      console.log("isValid "  + isValid);
      return isValid;
    }

    this.setFormVal = function() {
      this.formVal.name = $("input[name='name']").val().toUpperCase();
      this.formVal.dob = $("input[name='dob']").val();
      this.formVal.identity = $("input[name='identity']").val();
      this.formVal.email = $("input[name='email']").val();
      this.formVal.phone = $("input[name='phone']").val();
      this.formVal.address = $("input[name='address']").val();
      this.formVal.goi = $("select[name='goi']").val();
      this.formVal.phi = this.moneyToNumber($("input[name='phi']").val());
      this.formVal.price = this.moneyToNumber($("#pti_bhtn_price").val());
      var dieuKhoan1 = $("input[name='dieu-khoan1']")[0].checked;
      var dieuKhoan2 = $("input[name='dieu-khoan2']")[0].checked;
      if (isPgdBN) {
        this.formVal.pgdId = $("select[name='pgd']").val();
        this.formVal.pgdName = $("select[name='pgd'] option:selected").text();
      }
      console.log(this.formVal);
      if (dieuKhoan1) {
        this.formVal.dieuKhoan1 = $("input[name='dieu-khoan1']").val();
      } else {
        this.formVal.dieuKhoan1 = null;
      }
      if (dieuKhoan2) {
        this.formVal.dieuKhoan2 = $("input[name='dieu-khoan2']").val();
      } else {
        this.formVal.dieuKhoan2 = null;
      }
    }

    this.setInputVal = function(data) {
      $("input[name='name']").val(data.name);
      $("input[name='dob']").val(data.dob);
      $("input[name='identity']").val(data.identity);
      $("input[name='email']").val(data.email);
      $("input[name='phone']").val(data.phone);
      $("input[name='address']").val(data.address);
      $("select[name='goi']").val(data.goi);
      $("select[name='goi']").change();
      $("input[name='dieu-khoan1']").attr("checked", "checked");
      $("input[name='dieu-khoan2']").attr("checked", "checked");
      $("input").prop('disabled', true);
      $("select").prop('disabled', true);
      $("#input-confirm").removeAttr("disabled");
      if (isPgdBN) {
        $("select[name='pgd']").val(data.pgdId);
      }
    }

    this.fomatNumber = function ($value) {
        $value = parseInt($value);
        if ($value > 0 || $value < 0) {
            return $value.toLocaleString('en-US');
        }
        return 0;
    }

    this.setConfirmVal = function() {
      $(".name-val").text(this.formVal.name);
      $(".dob-val").text(this.formVal.dob);
      $(".identity-val").text(this.formVal.identity);
      $(".email-val").text(this.formVal.email);
      $(".phone-val").text(this.formVal.phone);
      $(".address-val").text(this.formVal.address);
      $(".goi-val").text(this.formVal.goi + ' - ' + this.fomatNumber(this.formVal.price));
      $(".phi-val").text(this.fomatNumber(this.formVal.phi));
      if (isPgdBN) {
        $(".pgd-val").text(this.formVal.pgdName);
      }
    }

    this.btnStep = function(event) {
      var selectedId = $(event.currentTarget).attr('id');
      switch(selectedId) {
        case 'input-confirm':
          this.setFormVal();
          if (!this.validate()) {
            return;
          }
          if (this.currentStep < this.stepCon) {
            this.currentStep = this.stepCon;
          }
          this.setConfirmVal();
          this.progressbar(this.stepCon);
          break;
        case 'input-order':
          this.progressbar(this.stepPay);
          if (this.currentStep < this.stepPay) {
            this.currentStep = this.stepPay;
          }
          if (this.id === null) {
            this.createOrder();
          }
          break;
        default:
          this.progressbar(this.stepIn);
          break;
      }
    }

    this.createOrder = function () {
      $("#input-order").attr("disabled", "disabled");
      $("#loading").show();
      var loadingHeight = window.screen.height;
      $("#loading, .right-col iframe").css('height', loadingHeight);
      $.ajax({
        type: "POST",
        url: orderUrl,
        data: this.formVal,
        success: function(data) {
            console.log(data);
            if (data['status'] == 200) {
              setPayment(data['data']['bankInfo']);
              window.location.replace(data['data']['targetUrl']);
            } else {
                $("#errorModal").find(".msg_error").text(data['message']);
                $("#errorModal").show();
            }
            $("#input-order").removeAttr("disabled");
            $("#loading").hide();
        },
        error: function (jqXHR, exception) {
            var msg = '';
            if (jqXHR.status === 0) {
                msg = 'Not connect.\n Verify Network.';
            } else if (jqXHR.status == 404) {
                msg = 'Requested page not found. [404]';
            } else if (jqXHR.status == 500) {
                msg = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msg = 'Requested JSON parse failed.';
            } else if (exception === 'timeout') {
                msg = 'Time out error.';
            } else if (exception === 'abort') {
                msg = 'Ajax request aborted.';
            } else {
                msg = 'Uncaught Error.\n' + jqXHR.responseText;
            }
            $("#errorModal").find(".msg_error").text(msg);
            $("#errorModal").show();
            $("#input-order").removeAttr("disabled");
            $("#loading").hide();
        },
     });
    }

    paymentSuccess = function (response) {
      console.log(response);
      if (response['status'] == 200 && response['payment'] == 'success') {
        location.reload();
      }
    }

    checkPayment = function (onSuccess, token, id) {
      $.ajax({
        type: "POST",
        url: checkPaymentUrl,
        data: {_token: token, id: id},
        success: onSuccess,
     });
    }

    setPayment = function (paymentInfo) {
      $("#step-payment .bank-name").text(paymentInfo['BANK_NAME']);
      $("#step-payment .bank-account").text(paymentInfo['MASTER_ACCOUNT']);
      $("#step-payment .bank-account-name").text(paymentInfo['ACCOUNT_NAME']);
      $("#step-payment .bank-amount").text(paymentInfo['AMOUNT']);
      $("#step-payment .bank-description").text(paymentInfo['DESCRIPTION']);
      $("#step-payment #qr-final").attr("src", paymentInfo['QRCODE']);
    }

    this.clickStep = function(event) {
      var selectedId = $(event.currentTarget).attr('id');
      var progress = this.stepIn;
      switch(selectedId) {
        case 'input':
          progress = this.stepIn;
          break;
        case 'confirm':
          progress = this.stepCon;
          break;
        case 'payment':
          progress = this.stepPay;
          break;
        case 'finish':
          progress = this.stepFin;
          break;
        default:
          progress = this.stepIn;
          break;
      }
      if (progress > this.currentStep) {
        progress = this.currentStep;
      }
      this.progressbar(progress);
    }
    this.progressbar = function(selectedId) {
      console.log("currentStep " + this.currentStep);
      switch(selectedId) {
        case this.stepIn:
          this.elIn.removeClass( "hidden" );
          this.elCon.addClass( "hidden" );
          this.elPay.addClass( "hidden" );
          this.elFi.addClass( "hidden" );
          $('#input').addClass('active');
          $('#confirm').removeClass('active');
          $('#payment').removeClass('active');
          $('#finish').removeClass('active');
          break;
        case this.stepCon:
          this.elIn.addClass( "hidden" );
          this.elCon.removeClass( "hidden" );
          this.elPay.addClass( "hidden" );
          this.elFi.addClass( "hidden" );
          $('#input').addClass('active');
          $('#confirm').addClass('active');
          $('#payment').removeClass('active');
          $('#finish').removeClass('active');
          break;
        case this.stepPay:
          this.elIn.addClass( "hidden" );
          this.elCon.addClass( "hidden" );
          this.elPay.removeClass( "hidden" );
          this.elFi.addClass( "hidden" );
          $('#input').addClass('active');
          $('#confirm').addClass('active');
          $('#payment').addClass('active');
          $('#finish').removeClass('active');
          break;
        case this.stepFin:
          this.elIn.addClass( "hidden" );
          this.elCon.addClass( "hidden" );
          this.elPay.addClass( "hidden" );
          this.elFi.removeClass( "hidden" );
          $('#input').addClass('active');
          $('#confirm').addClass('active');
          $('#payment').addClass('active');
          $('#finish').addClass('active');
          break;
        default:
          this.elIn.removeClass( "hidden" );
          this.elCon.addClass( "hidden" );
          this.elPay.addClass( "hidden" );
          this.elFi.addClass( "hidden" );
          $('#input').addClass('active');
          $('#confirm').removeClass('active');
          $('#payment').removeClass('active');
          $('#finish').removeClass('active');
          break;
      }
    }

  }
  const bhtn = new Bhtn();
  bhtn.init(order);
});