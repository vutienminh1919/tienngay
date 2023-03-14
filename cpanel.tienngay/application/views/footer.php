<footer>
    <div class="pull-right">
<!--		<div class="animte_hotline">-->
<!--			Hotline : <span>0981323456</span>-->
<!--		</div>-->
    </div>
    <div class="clearfix"></div>
</footer>
 <script src="<?php echo base_url();?>assets/js/lead/lib/jssip.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/lead/lib/jquery.md5.js"></script>
<div id="theCall" class="d-none">
  <!-- Dial -->
  <div class="dialpad compact "  id="dials">
    <input type="text" class="dialnumber" id="number_header" placeholder="Số điện thoại">
    <button class="btn btn-link">
      <i class="fa text-dark fa-long-arrow-left dialclear"></i>
    </button>
    <div class="dials">
      <br>
       <?php if(isset($this->session->upnetInfor->email_user) ){   ?>
        <select class="form-control" id="choose_number_call">
          <option value="" >Nhánh mặc định - <?= $this->session->upnetInfor->extension_number ? $this->session->upnetInfor->extension_number : '' ?></option>
           <?php if(!empty($this->session->upnetInfor->number_call) ){   ?>
             <?php foreach ($this->session->upnetInfor->number_call as $key => $value) {
               # code...
              ?>
            <option value="<?=$value?>" ><?=$value?></option>
            <?php }} ?>
          </select>
       <?php } ?>
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
          <div class="btn btn-primary w-100" id="call_header">
            <i class="fa fa-lg fa-phone"></i> Gọi điện
          </div>

        </li>
      </ol>
    </div>
<!--    <a href="--><?php //echo base_url()?><!--lead_custom/historyCall" class="btn btn-link w-100">-->
<!--      Lịch sử cuộc gọi-->
<!--    </a>-->
    <?php date_default_timezone_set('Asia/Ho_Chi_Minh'); if(date('H') < 8 || date("H") > 16){ ?>
          <div class="alert alert-danger">
                  <strong>Cảnh báo: Bây giờ là <?= date('H:i:s')?></strong> Cuộc gọi quảng cáo sẽ không được thực hiện trước 8h và sau 17h, vi phạm sẽ bị phạt tới 100 triệu, bạn có chắc chắn đây không phải cuộc gọi quảng cáo ?
               </div>
        <?php }?>
  </div>

  <!-- Incommming call -->
  <div class="tile-stats inoutcalling m-0 d-none" id="outcalling">

    <div class="alert alert-success" style="padding:5px;background-color:rgba(80, 175, 0, 0.75)">
      Cuộc gọi đi
    </div>
    <div class="icon ">
      <i class="fa fa-phone"></i>
    </div>
    <div class="name"></div>
    <h5 id="num_out"></h5>
    <p id="status_out"></p>
    
    <br>   <br>   
    <div class="row">
      <div class="col-xs-12">
        <button class="btn btn-danger w-100" id="end_header">Cúp máy</button>
      </div>
    </div>
  </div>

  <!-- Outgoing Call -->
  <div class="tile-stats inoutcalling m-0 d-none"  id="incalling">

    <div class="alert alert-danger" style="padding:5px;background-color:rgba(80, 175, 0, 0.75)">
      Cuộc gọi đến
    </div>
    <div class="icon red">
      <i class="fa fa-phone"></i>
    </div>
    <div class="name"></div>
    <h5 id="num_in"></h5>
    <p id="status_in"></p>
  
    <br> <br> <br>
    <div class="row">
      <div class="col-xs-6">
        <button class="btn btn-danger w-100" id="cancel_in">Từ chối</button>
      </div>
      <div class="col-xs-6">
        <button class="btn btn-info w-100" id="answer_in">Trả lời</button>
      </div>
    </div>

  </div>
  <hr>
  <p id="status" style="margin-left: 125px;"></p>
  <div class="text-right">
    <button class="btn" onclick="$('#theCall').toggleClass('d-none')">Ẩn đi</button>
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
<script>
    <?php if(isset($this->session->upnetInfor->email_user) && isset($this->session->upnetInfor->extension_number) && $this->session->upnetInfor->extension_number>0 ){   ?>
    
    let host = 'tienngay.phonenet.io';
     let ext = <?= $this->session->upnetInfor->extension_number ? $this->session->upnetInfor->extension_number : '' ?>;
   let password = 'matkhau';
    // let ext = '99999';
    // let password = '12345678';
    let contact_uri = 'sip:'+ext+'@'+Math.random().toString(36).substring(2, 15)+'.invalid;transport=ws';
    let phone = null;
    let call = null;
 if($('#choose_number_call').val()=="")
 {
    let callOptions = {
        mediaConstraints: {
            audio: true,
            video: false
        },
        pcConfig: {
            iceServers: [
                {
                    urls: [
                        'stun:stun-vn-01.phonenet.io',
                        'stun:stun.l.google.com:19302'
                    ]
                },
            ],
        },

      
    };
  }else{
      let callOptions = {
        mediaConstraints: {
            audio: true,
            video: false
        },
        pcConfig: {
            iceServers: [
                {
                    urls: [
                        'stun:stun-vn-01.phonenet.io',
                        'stun:stun.l.google.com:19302'
                    ]
                },
            ],
        },

        extraHeaders:[
        'X-CallerNumber:'+$('#choose_number_call').val()
        ]
    };
}
 console.log('khoi_tao'+$('#choose_number_call').val());
    $(document).ready(() => {
        //Kiểm tra có được sử dụng mic không
        navigator.mediaDevices.getUserMedia({audio: true}).then(() => {
         console.log('start');
            //Kết nối webrtc tới phonenet
            phone = new JsSIP.UA({
                sockets: [new JsSIP.WebSocketInterface('wss://' + host + ':7443')],
                uri: 'sip:' + ext + '@' + host,
                realm: host,
                ha1: $.md5(ext+':'+host+':'+password),
                contact_uri: contact_uri,
                session_timers: false,
            });
              console.log('----');
            phone.on('registered', (e) => {
                //Kết nối thành công
            
                 $('#icon_call').css("color","blue");
                  $('#span_call').addClass('badge bg-blue');
                  $('#a_call').attr('title', 'Điện thoại sẵn sàng');
                $('#status').text('Điện thoại sẵn sàng');
             
              
                //Thực hiện gọi
                $('#call').click(() => {
                    if($('#choose_number_call').val()=="")
 {
     callOptions = {
        mediaConstraints: {
            audio: true,
            video: false
        },
        pcConfig: {
            iceServers: [
                {
                    urls: [
                        'stun:stun-vn-01.phonenet.io',
                        'stun:stun.l.google.com:19302'
                    ]
                },
            ],
        },

      
    };
  }else{
       callOptions = {
        mediaConstraints: {
            audio: true,
            video: false
        },
        pcConfig: {
            iceServers: [
                {
                    urls: [
                        'stun:stun-vn-01.phonenet.io',
                        'stun:stun.l.google.com:19302'
                    ]
                },
            ],
        },

        extraHeaders:[
        'X-CallerNumber:'+$('#choose_number_call').val()
        ]
    };
}

                     console.log('call'+$('#choose_number_call').val());
                    
                          if($('#number').val() != '') {
                         try {
                        phone.call(window.atob($('#number').val()), callOptions);
       
                        call.connection.onaddstream = function (e) {
                            const remoteAudio = document.createElement('audio');
                            remoteAudio.srcObject = e.stream;
                            remoteAudio.play();
                        };
                        $('#end').click(() => {
                            call.terminate();
                        });
                        $('#status').text('Đang gọi...');
                      }catch(err) {
                      console.log("call "+err.message);
                      }
                    }else{
                        alert('Mời nhập số');
                    }
                });
              
                
                $("#number_header").keyup(function (e) {
                        if (e.which == 13) {
                           
                         if($('#choose_number_call').val()=="")
                           {
                               callOptions = {
                                  mediaConstraints: {
                                      audio: true,
                                      video: false
                                  },
                                  pcConfig: {
                                      iceServers: [
                                          {
                                              urls: [
                                                  'stun:stun-vn-01.phonenet.io',
                                                  'stun:stun.l.google.com:19302'
                                              ]
                                          },
                                      ],
                                  },

                                
                              };
                            }else{
                                 callOptions = {
                                  mediaConstraints: {
                                      audio: true,
                                      video: false
                                  },
                                  pcConfig: {
                                      iceServers: [
                                          {
                                              urls: [
                                                  'stun:stun-vn-01.phonenet.io',
                                                  'stun:stun.l.google.com:19302'
                                              ]
                                          },
                                      ],
                                  },

                                  extraHeaders:[
                                  'X-CallerNumber:'+$('#choose_number_call').val()
                                  ]
                              };
                          }
 console.log('call_13'+$('#choose_number_call').val());
                            // Enter key pressed
                              $('#outcalling').removeClass('d-none');
                         $('#incalling').addClass('d-none');
                         $('#dials').addClass('d-none');
                       if($('#number_header').val() != '') {
                         try {
                        phone.call($('#number_header').val(), callOptions);
                         call.connection.onaddstream = function (e) {
                            const remoteAudio = document.createElement('audio');
                            remoteAudio.srcObject = e.stream;
                            remoteAudio.play();
                        };
                        }catch(err) {
                      console.log("enter "+err.message);
                        }
                        $('#end_header').click(() => {
                            call.terminate();
                             $('#number_header').val("");
                        });

                          $('#num_out').text($('#number_header').val());
                        $('#status').text('Đang gọi...');
                         $('#a_call').attr('title', 'Đang gọi...');
                          $('#status_out').text('Đang gọi đi...');
                    }else{
                        alert('Mời nhập số');
                        $('#outcalling').addClass('d-none');
                       $('#incalling').addClass('d-none');
                       $('#dials').removeClass('d-none');
                    }
                        }
                     });
                
                 
                  $('#call_header').click(() => {
                      if($('#choose_number_call').val()=="")
                           {
                               callOptions = {
                                  mediaConstraints: {
                                      audio: true,
                                      video: false
                                  },
                                  pcConfig: {
                                      iceServers: [
                                          {
                                              urls: [
                                                  'stun:stun-vn-01.phonenet.io',
                                                  'stun:stun.l.google.com:19302'
                                              ]
                                          },
                                      ],
                                  },

                                
                              };
                            }else{
                                 callOptions = {
                                  mediaConstraints: {
                                      audio: true,
                                      video: false
                                  },
                                  pcConfig: {
                                      iceServers: [
                                          {
                                              urls: [
                                                  'stun:stun-vn-01.phonenet.io',
                                                  'stun:stun.l.google.com:19302'
                                              ]
                                          },
                                      ],
                                  },

                                  extraHeaders:[
                                  'X-CallerNumber:'+$('#choose_number_call').val()
                                  ]
                              };
                          }
 console.log('call_click'+$('#choose_number_call').val());
                   
                     $('#outcalling').removeClass('d-none');
                         $('#incalling').addClass('d-none');
                         $('#dials').addClass('d-none');
                    if($('#number_header').val() != '') {
                         try {
                        phone.call($('#number_header').val(), callOptions);
                         call.connection.onaddstream = function (e) {
                            const remoteAudio = document.createElement('audio');
                            remoteAudio.srcObject = e.stream;
                            remoteAudio.play();
                        };
                         }catch(err) {
                      console.log("enter "+err.message);
                      }
                        $('#end_header').click(() => {
                            call.terminate();
                             $('#number_header').val("");
                        });

                          $('#num_out').text($('#number_header').val());
                        $('#status').text('Đang gọi...');
                         $('#a_call').attr('title', 'Đang gọi...');
                          $('#status_out').text('Đang gọi đi...');
                    }else{
                        alert('Mời nhập số');
                        $('#outcalling').addClass('d-none');
                       $('#incalling').addClass('d-none');
                       $('#dials').removeClass('d-none');
                    }
                });
                 
            });
            phone.on('disconnected', () => {
               $('#outcalling').addClass('d-none');
               $('#incalling').addClass('d-none');
               $('#dials').removeClass('d-none');
                //Mất kết nối, thông thường nó sẽ tự kết nối lại
                $('#status').text('Mất kết nối');
                console.log('Phone disconnected');
            });
            phone.start();
            phone.on("newRTCSession", (data) => {
                 if(call){
                    data.session.terminate();
                    return;
                }
                //Có cuộc gọi mới
                call = data.session;
                if (call.direction === "incoming") {
            
                   $('#num_in').text(call.remote_identity._display_name);
                  $('#outcalling').addClass('d-none');
                   $('#incalling').removeClass('d-none');
                   $('#dials').addClass('d-none');
                   $('#theCall').removeClass('d-none');
                    $('#status').text('Có cuộc gọi đến, bấm trả lời để nhận');
                     $('#a_call').attr('title', 'Có cuộc gọi đến, bấm trả lời để nhận');
                     $('#status_in').text('Có cuộc gọi đến, bấm trả lời để nhận');
                   
                         
                     $('#answer_in').click(() => {
                        try {
                                              if($('#choose_number_call').val()=="")
 {
     callOptions = {
        mediaConstraints: {
            audio: true,
            video: false
        },
        pcConfig: {
            iceServers: [
                {
                    urls: [
                        'stun:stun-vn-01.phonenet.io',
                        'stun:stun.l.google.com:19302'
                    ]
                },
            ],
        },

      
    };
  }else{
       callOptions = {
        mediaConstraints: {
            audio: true,
            video: false
        },
        pcConfig: {
            iceServers: [
                {
                    urls: [
                        'stun:stun-vn-01.phonenet.io',
                        'stun:stun.l.google.com:19302'
                    ]
                },
            ],
        },

        extraHeaders:[
        'X-CallerNumber:'+$('#choose_number_call').val()
        ]
    };
}
                        $('#answer_in').addClass('d-none');
                        call.answer(callOptions);
                    
                          call.connection.onaddstream = function (e) {
                            const remoteAudio = document.createElement('audio');
                            remoteAudio.srcObject = e.stream;
                            remoteAudio.play();
                        };
                         }catch(err) {
                      console.log("answer_in "+err.message);
                      }
                    });
                     
              
                    $('#cancel_in').click(() => {
                            call.terminate();
                             $('#number_header').val("");
                        });
                    }
                call.on("icecandidate", (e) => {
                    setTimeout(() => {
                        e.ready();
                    }, 10000);
                });
                call.on("progress", function () {
                    //Đổ chuông
                    $('#status').text('Đang đổ chuông');
                     $('#a_call').attr('title', 'Đang đổ chuông');
                      $('#status_out').text('Đang đổ chuông');
                    console.log('progress');
                });
                call.on("accepted", function () {
                    //Đầu khách trả lời
                    $('#status').text('Đang đàm thoại');
                     $('#a_call').attr('title', 'Đang đàm thoại');
                     $('#status_out').text('Đang đàm thoại');
                    console.log('accepted');
                });
                call.on("confirmed", function () {
                    //Kết nối ok
                    $('#status').text('Đang đàm thoại');
                    $('#a_call').attr('title', 'Đang đàm thoại');
                    $('#status_in').text('Đang đàm thoại');
                    console.log('confirmed');
                });
                call.on("ended", function () {
                  $('#outcalling').addClass('d-none');
                     $('#incalling').addClass('d-none');
                     $('#dials').removeClass('d-none');
                      $('#answer_in').removeClass('d-none');
                    //Cuộc gọi dừng
                  $('#status').text('Đã kết thúc cuộc gọi');
                  $('#a_call').attr('title', 'Đã kết thúc cuộc gọi');
                 setTimeout(function(){ 
                 $('#status').text('Điện thoại sẵn sàng');
                 $('#a_call').attr('title', 'Điện thoại sẵn sàng');
                }, 3000);
                    console.log('ended');
                       call = null;
                });
                call.on("failed", function (e) {

                   $('#outcalling').addClass('d-none');
                   $('#incalling').addClass('d-none');
                   $('#dials').removeClass('d-none');
                     $('#answer_in').removeClass('d-none');
                    //Thất bại
                    $('#status').text('Cuộc gọi thất bại');
                     $('#a_call').attr('title', 'Cuộc gọi thất bại');
                     setTimeout(function(){ 
                 $('#status').text('Điện thoại sẵn sàng');
                  $('#a_call').attr('title', 'Điện thoại sẵn sàng');
                }, 3000);
                    console.log('failed');
                    console.log(e);
                       call = null;
                });
                console.log(this.call);
                // call.connection.onaddstream = function (e) {
                //     const remoteAudio = document.createElement('audio');
                //     remoteAudio.srcObject = e.stream;
                //     remoteAudio.play();
                // };
            });
        }).catch(() => {
            //K có mic
           
        });
    });
<?php } ?>
</script>
<script>
  $('#choose_number_call').on('change', function() {
   if (typeof(Storage) !== 'undefined') {
    
            localStorage.setItem('so_chon_call',  $('#choose_number_call').val());
            console.log(localStorage.getItem('so_chon_call'));
        } else {
            alert('Trình duyệt của bạn không hỗ trợ localStorage. Hãy nâng cấp trình duyệt để sử dụng!');
        }
});
  if (typeof(Storage) !== 'undefined') {
                 let so_chon=   (localStorage.getItem('so_chon_call')==null) ? '' : localStorage.getItem('so_chon_call');
              $('#choose_number_call  option[value="'+so_chon+'"]').prop("selected", true); 
              console.log(localStorage.getItem('so_chon_call'));
          
        } else {
            alert('Trình duyệt của bạn không hỗ trợ localStorage. Hãy nâng cấp trình duyệt để sử dụng!');
        }
  </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


<style>
	.suntory-alo-phone {
		background-color: transparent;
		cursor: pointer;
		height: 120px;
		position: fixed;
		transition: visibility 0.5s ease 0s;
		width: 94px;
		z-index: 200000 !important;
	}

	.suntory-alo-ph-circle {
		animation: 1.2s ease-in-out 0s normal none infinite running suntory-alo-circle-anim;
		background-color: transparent;
		border: 2px solid rgba(30, 30, 30, 0.4);
		border-radius: 100%;
		height: 100px;
		left: 0px;
		opacity: 0.1;
		position: absolute;
		top: 0px;
		transform-origin: 50% 50% 0;
		transition: all 0.5s ease 0s;
		width: 100px;
	}
	.suntory-alo-ph-circle-fill {
		animation: 2.3s ease-in-out 0s normal none infinite running suntory-alo-circle-fill-anim;
		border: 2px solid transparent;
		border-radius: 100%;
		height: 70px;
		left: 15px;
		position: absolute;
		top: 15px;
		transform-origin: 50% 50% 0;
		transition: all 0.5s ease 0s;
		width: 70px;
	}
	.suntory-alo-ph-img-circle {
		/* animation: 1s ease-in-out 0s normal none infinite running suntory-alo-circle-img-anim; */
		border: 2px solid transparent;
		border-radius: 100%;
		height: 50px;
		left: 25px;
		opacity: 0.7;
		position: absolute;
		top: 25px;
		transform-origin: 50% 50% 0;
		width: 50px;
	}
	.suntory-alo-phone.suntory-alo-hover, .suntory-alo-phone:hover {
		opacity: 1;
	}
	.suntory-alo-phone.suntory-alo-active .suntory-alo-ph-circle {
		animation: 1.1s ease-in-out 0s normal none infinite running suntory-alo-circle-anim !important;
	}
	.suntory-alo-phone.suntory-alo-static .suntory-alo-ph-circle {
		animation: 2.2s ease-in-out 0s normal none infinite running suntory-alo-circle-anim !important;
	}
	.suntory-alo-phone.suntory-alo-hover .suntory-alo-ph-circle, .suntory-alo-phone:hover .suntory-alo-ph-circle {
		border-color: #00aff2;
		opacity: 0.5;
	}
	.suntory-alo-phone.suntory-alo-green.suntory-alo-hover .suntory-alo-ph-circle, .suntory-alo-phone.suntory-alo-green:hover .suntory-alo-ph-circle {
		border-color: #bd0505;
		opacity: 1;
	}
	.suntory-alo-phone.suntory-alo-green .suntory-alo-ph-circle {
		border-color: #008fe5;
		opacity: 1;
	}
	.suntory-alo-phone.suntory-alo-hover .suntory-alo-ph-circle-fill, .suntory-alo-phone:hover .suntory-alo-ph-circle-fill {
		background-color: rgba(0, 175, 242, 0.9);
	}
	.suntory-alo-phone.suntory-alo-green.suntory-alo-hover .suntory-alo-ph-circle-fill, .suntory-alo-phone.suntory-alo-green:hover .suntory-alo-ph-circle-fill {
		background-color: #bd0505;
	}
	.suntory-alo-phone.suntory-alo-green .suntory-alo-ph-circle-fill {
		background-color: #008fe5;
	}

	.suntory-alo-phone.suntory-alo-hover .suntory-alo-ph-img-circle, .suntory-alo-phone:hover .suntory-alo-ph-img-circle {
		background-color: #00aff2;
	}
	.suntory-alo-phone.suntory-alo-green.suntory-alo-hover .suntory-alo-ph-img-circle, .suntory-alo-phone.suntory-alo-green:hover .suntory-alo-ph-img-circle {
		background-color: #bd0505;
	}
	.suntory-alo-phone.suntory-alo-green .suntory-alo-ph-img-circle {
		background-color: #008fe5;
	}
	@keyframes suntory-alo-circle-anim {
		0% {
			opacity: 0.1;
			transform: rotate(0deg) scale(0.5) skew(1deg);
		}
		30% {
			opacity: 0.5;
			transform: rotate(0deg) scale(0.7) skew(1deg);
		}
		100% {
			opacity: 0.6;
			transform: rotate(0deg) scale(1) skew(1deg);
		}
	}

	@keyframes suntory-alo-circle-img-anim {
		0% {
			transform: rotate(0deg) scale(1) skew(1deg);
		}
		10% {
			transform: rotate(-25deg) scale(1) skew(1deg);
		}
		20% {
			transform: rotate(25deg) scale(1) skew(1deg);
		}
		30% {
			transform: rotate(-25deg) scale(1) skew(1deg);
		}
		40% {
			transform: rotate(25deg) scale(1) skew(1deg);
		}
		50% {
			transform: rotate(0deg) scale(1) skew(1deg);
		}
		100% {
			transform: rotate(0deg) scale(1) skew(1deg);
		}
	}
	@keyframes suntory-alo-circle-fill-anim {
		0% {
			opacity: 0.2;
			transform: rotate(0deg) scale(0.7) skew(1deg);
		}
		50% {
			opacity: 0.2;
			transform: rotate(0deg) scale(1) skew(1deg);
		}
		100% {
			opacity: 0.2;
			transform: rotate(0deg) scale(0.7) skew(1deg);
		}
	}
	.suntory-alo-ph-img-circle i {
		animation: 1s ease-in-out 0s normal none infinite running suntory-alo-circle-img-anim;
		font-size: 30px;
		line-height: 50px;
		padding-left: 10px;
		color: #fff;
	}

	/*=================== End phone ring ===============*/
	@keyframes suntory-alo-ring-ring {
		0% {
			transform: rotate(0deg) scale(1) skew(1deg);
		}
		10% {
			transform: rotate(-25deg) scale(1) skew(1deg);
		}
		20% {
			transform: rotate(25deg) scale(1) skew(1deg);
		}
		30% {
			transform: rotate(-25deg) scale(1) skew(1deg);
		}
		40% {
			transform: rotate(25deg) scale(1) skew(1deg);
		}
		50% {
			transform: rotate(0deg) scale(1) skew(1deg);
		}
		100% {
			transform: rotate(0deg) scale(1) skew(1deg);
		}
	}
	/*@media (min-width: 992px) {*/
	/*	.hidden-sm, .hidden-md*/
	/*	{*/
	/*		display: none;*/
	/*	}*/
	/*}*/
	@media(max-width: 768px){
		.suntory-alo-phone{
			display: block;
			top: unset !important;
		}
		#section5 .timeline-entry .timeline-entry-container:before {
			background: #ff6c3a;
			right: -56px;display:none;
		}
	}

	.button-zalo {
		position: fixed;
		left: 19px;
		bottom: 14px;
		cursor: pointer;
	}

	#button-zalo-m {
	}

	.button-zalo-main {
	}

	.button-zalo:before, .button-zalo:before {
		left: 36px !important;
	}

	.button-zalo:before {
		background-color: #ff5d5d;
	}

	.button-zalo:before {
		position: absolute;
		top: 2px;
		left: 12px;
		z-index: 4;
		content: "";
		width: 8px;
		height: 8px;
		border: 1px solid #fff;
		-webkit-border-radius: 100%;
		-moz-border-radius: 100%;
		border-radius: 100%;
	}

	.button-zalo-main {
		display: block;
		position: relative;
		z-index: 3;
		background: url(img/stick_zalo.png) 0 0 no-repeat;
		background-size: cover;
		width: 58px;
		height: 58px;
	}

	.button-zalo em {
		position: absolute;
		top: 7px;
		left: 17px;
	}


	.button-zalo em:before {
		-webkit-box-shadow: 0 0 8px 4px #ff5d5d;
		box-shadow: 0 0 8px 4px #ff5d5d;
	}

	.button-zalo em:after {
		-webkit-box-shadow: inset 0 0 6px 2px #ff5d5d;
		box-shadow: inset 0 0 6px 2px #ff5d5d;
	}

	.button-zalo em:after, .button-zalo em:before {
		position: absolute;
		left: -4px;
		top: 2px;
		content: "";
		width: 32px;
		height: 32px;
		-webkit-border-radius: 100%;
		-moz-border-radius: 100%;
		border-radius: 100%;
		-webkit-animation-name: Grow;
		-moz-animation-name: Grow;
		animation-name: Grow;
		-webkit-animation-duration: 1.5s;
		-moz-animation-duration: 1.5s;
		animation-duration: 1.5s;
		-webkit-animation-iteration-count: infinite;
		-moz-animation-iteration-count: infinite;
		animation-iteration-count: infinite;
		-webkit-animation-timing-function: linear;
		-moz-animation-timing-function: linear;
		animation-timing-function: linear;
	}

</style>
