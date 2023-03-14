


    <div class="right_col" role="main">

<input id="number"  />
<button id="call">Gọi</button>
<button id="end">Dừng</button>
<button id="answer">Trả lời</button>
<br/>
<p id="status"></p>
</div>
<script>
    let host = 'tienngay.phonenet.io';
    let ext = '99998';
    let password = 'matkhau';
    let contact_uri = 'sip:'+ext+'@'+Math.random().toString(36).substring(2, 15)+'.invalid;transport=ws';
    let phone = null;
    let call = null;

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
        }
    };

    $(document).ready(() => {
        //Kiểm tra có được sử dụng mic không
        // navigator.mediaDevices.getUserMedia({audio: true}).then(() => {
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
                console.log('Phone registered');
                $('#status').text('Điện thoại sẵn sàng');
                console.log(e);
                //Thực hiện gọi
                $('#call').click(() => {
                     console.log('call');
                    if($('#number').val() != '') {
                        phone.call($('#number').val(), callOptions);
                        $('#end').click(() => {
                            call.terminate();
                        });
                        $('#status').text('Đang gọi');
                    }else{
                        alert('Mời nhập số');
                    }
                });
            });
            phone.on('disconnected', () => {
                //Mất kết nối, thông thường nó sẽ tự kết mối lại
                $('#status').text('Mất kết nối');
                console.log('Phone disconnected');
            });
            phone.start();
            phone.on("newRTCSession", (data) => {

                //Có cuộc gọi mới
                call = data.session;
                if (call.direction === "incoming") {
                     console.log('Phone call');
                    $('#status').text('Có cuộc gọi đến, bấm trả lời để nhận');
                    $('#answer').click(() => {
                        call.answer(callOptions);
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
                    console.log('progress');
                });
                call.on("accepted", function () {
                    //Đầu khách trả lời
                    $('#status').text('Đang đàm thoại');
                    console.log('accepted');
                });
                call.on("confirmed", function () {
                    //Kết nối ok
                    $('#status').text('Đang đàm thoại');
                    console.log('confirmed');
                });
                call.on("ended", function () {
                    //Cuộc gọi dừng
                    $('#status').text('Đã kết thúc cuộc gọi');
                    console.log('ended');
                });
                call.on("failed", function (e) {
                    //Thất bại
                    $('#status').text('Cuộc gọi thất bại');
                    console.log('failed');
                    console.log(e);
                });
                console.log(this.call);
                call.connection.onaddstream = function (e) {
                    const remoteAudio = document.createElement('audio');
                    remoteAudio.srcObject = e.stream;
                    remoteAudio.play();
                };
            });
        // }).catch(() => {
        //     //K có mic
        //     alert('Máy tính không có mic hoặc không được cấp quyền dùng mic!');
        // });
    });
</script>
</body>
</html>