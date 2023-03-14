<div id="theCall" class="d-none">
  <!-- Dial -->
  <div class="dialpad compact">
    <input type="text" class="dialnumber" placeholder="Số điện thoại">
    <button class="btn btn-link">
      <i class="fa text-dark fa-long-arrow-left dialclear"></i>
    </button>
    <div class="dials">
      <ol>
        <li class="digits">
          <p><strong>1</strong></p>
        </li>
        <li class="digits">
          <p><strong>2</strong></p>
        </li>
        <li class="digits">
          <p><strong>3</strong></p>
        </li>
        <li class="digits">
          <p><strong>4</strong></p>
        </li>
        <li class="digits">
          <p><strong>5</strong></p>
        </li>
        <li class="digits">
          <p><strong>6</strong></p>
        </li>
        <li class="digits">
          <p><strong>7</strong></p>
        </li>
        <li class="digits">
          <p><strong>8</strong></p>
        </li>
        <li class="digits">
          <p><strong>9</strong></p>
        </li>
        <li class="digits">
          <p><strong>*</strong></p>
        </li>
        <li class="digits">
          <p><strong>0</strong></p>
        </li>
        <li class="digits">
          <p><strong>#</strong></p>
        </li>
        <li class="digits">
          <!-- <p><sup><i class="fa text-dark fa-times dialclear"></i></sup></p> -->
        </li>
        <li class="digits">
          <!-- <p> <sup><i class="fa text-dark fa-times dialclear"></i></sup></p> -->
        </li>
        <li class="digits pad-action ">
          <div class="btn btn-primary w-100">
            <i class="fa fa-lg fa-phone"></i> Gọi điện
          </div>

        </li>
      </ol>
    </div>

  </div>

  <!-- Incommming call -->
  <div class="tile-stats inoutcalling m-0">

    <div class="alert alert-success" style="padding:5px;background-color:rgba(80, 175, 0, 0.75)">
      Cuộc gọi đến
    </div>
    <div class="icon ">
      <i class="fa fa-phone"></i>
    </div>
    <div class="name">Nguyễn Thị Thu</div>
    <h5>034 89 123 89</h5>
    <p>Đang kết nối...</p>
    <p>Giới tính: Nam
      <a href="#" class="text-info" style="float:right">Chi tiết</a>
    </p>
    <br>
    <div class="row">
      <div class="col-xs-12">
        <button class="btn btn-danger w-100">Cúp máy</button>
      </div>
    </div>
  </div>

  <!-- Outgoing Call -->
  <div class="tile-stats inoutcalling m-0">

    <div class="alert alert-danger" style="padding:5px;background-color:rgba(80, 175, 0, 0.75)">
      Cuộc gọi đi
    </div>
    <div class="icon red">
      <i class="fa fa-phone"></i>
    </div>
    <div class="name">Nguyễn Thị Thu</div>
    <h5>034 89 123 89</h5>
    <p>Đang kết nối...</p>
    <p>Giới tính: Nam
      <a href="#" class="text-info" style="float:right">Chi tiết</a>
    </p>
    <br>
    <div class="row">
      <div class="col-xs-6">
        <button class="btn btn-danger w-100">Từ chối</button>
      </div>
      <div class="col-xs-6">
        <button class="btn btn-info w-100">Trả lời</button>
      </div>
    </div>

  </div>
  <hr>
  <div class="text-right">
    <button class="btn">Ẩn đi</button>
  </div>
</div>

<script>
$("#CallModal").on('shown.bs.modal', function(){
  $('.dialnumber').focus();
});

$(".dialclear").click(function(event) {
  $(".dialnumber").val(
    function(index, value){
      return value.substr(0, value.length - 1);
    });
});

$(function(){
  function addNumber(theinput) {
    var value = $('.dialnumber').val();
    $('.dialnumber').val(value + '' + theinput );
    $('.dialnumber').focus();
  }

  var dials = $(".dials ol li");
  var index;
  var number = $(".dialnumber");
  var total;

  dials.click(function(){

    index = dials.index(this);

    if(index == 9){

      addNumber("*");

    }else if(index == 10){

      addNumber("0");

    }else if(index == 11){

      addNumber("#");

    }else if(index == 12){

      number.val("");

    }else if(index == 13){
      number.val(
        function(index, value){
          return value.substr(0, value.length - 1);
        });


      }else if(index == 14){

        //add any call action here

      }else{ addNumber(index+1); }
    });


  });
</script>
