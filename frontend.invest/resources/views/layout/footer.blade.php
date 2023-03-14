<footer>
    <div class="text-right">
        Hotline : 19006907
    </div>
    <div class="clearfix"></div>
</footer>
<div id="theCall" class="d-none">
    <!-- Dial -->
    <div class="dialpad compact " id="dials">
        <input type="text" class="dialnumber" id="number_header" placeholder="Số điện thoại">
        <button class="btn btn-link dialclear">
            <!-- Download SVG icon from http://tabler-icons.io/i/arrow-narrow-left -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                 stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
                <line x1="5" y1="12" x2="9" y2="16"/>
                <line x1="5" y1="12" x2="9" y2="8"/>
            </svg>
        </button>
        <div class="dials">
            <br>
            @if(isset(session()->get('phonenet')->email_user))
                <select class="form-control" id="choose_number_call">
                    <option value="">Nhánh mặc định
                        - {{ session()->get('phonenet')->extension_number ? session()->get('phonenet')->extension_number : '' }}</option>
                    @if(!empty(session()->get('phonenet')->number_call) )
                        @foreach(session()->get('phonenet')->number_call as $key => $value)
                            # code...
                            <option value="{{$value}}">{{$value}}</option>
                        @endforeach
                    @endif
                </select>
            @endif
            <ol>
                <li class="digits">
                    <p><strong>1</strong>
                    </p>
                </li>
                <li class="digits">
                    <p><strong>2</strong>
                    </p>
                </li>
                <li class="digits">
                    <p><strong>3</strong>
                    </p>
                </li>
                <li class="digits">
                    <p><strong>4</strong>
                    </p>
                </li>
                <li class="digits">
                    <p><strong>5</strong>
                    </p>
                </li>
                <li class="digits">
                    <p><strong>6</strong>
                    </p>
                </li>
                <li class="digits">
                    <p><strong>7</strong>
                    </p>
                </li>
                <li class="digits">
                    <p><strong>8</strong>
                    </p>
                </li>
                <li class="digits">
                    <p><strong>9</strong>
                    </p>
                </li>
                <li class="digits">
                    <p><strong>*</strong>
                    </p>
                </li>
                <li class="digits">
                    <p><strong>0</strong>
                    </p>
                </li>
                <li class="digits">
                    <p><strong>#</strong>
                    </p>
                </li>
                <li class="digits pad-action ">
                    <div class="btn btn-primary w-100" id="call_header">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#modal-report"
                           style="color: #fff;text-decoration: none;width: 100%;">
                            Gọi điện &nbsp <i class="fa fa-lg fa-phone"></i>
                        </a>
                    </div>
                </li>
            </ol>
        </div>
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

        <br> <br>
        <div class="row">
            <div class="col-xs-12">
                <button class="btn btn-danger w-100" id="end_header">Cúp máy</button>
            </div>
        </div>
    </div>

    <!-- Outgoing Call -->
    <div class="tile-stats inoutcalling m-0 d-none" id="incalling">

        <div class="alert alert-danger" style="padding:5px;background-color:rgba(80, 175, 0, 0.75)">
            Cuộc gọi đến
        </div>
        <div class="icon red">
            <i class="fa fa-phone"></i>
        </div>
        <div class="name"></div>
        <h5 id="num_in"></h5>
        <p id="status_in"></p>

        <br>
        <div class="row">
            <div class="col-xs-12">
                <button class="btn btn-danger w-100" id="cancel_in">Từ chối</button>
                <button class="btn btn-info w-100" id="answer_in">Trả lời</button>
            </div>
        </div>

    </div>
    <hr>
    <p id="status" class="text-right"></p>
    <div class="text-right">
        <button class="btn" onclick="$('#theCall').toggleClass('d-none')">Ẩn đi</button>
    </div>
</div>

<style>
    #cancel_in, #answer_in {
        width: 100px !important;
        display: block;
    }

    #cancel_in {
        float: left;
    }

    @media (max-width: 768px) {
        #cancel_in, #answer_in {
            width: 49% !important;
        }
    }

    #answer_in {
        float: right;
    }

    .list-style {
        list-style: none;
        padding-left: 0px;
        padding-right: 0px;
        width: 300px;
    }

    .dropdown-item {
        min-width: 11rem;
        display: block;
        align-items: center;
        margin: 0;
        line-height: 1.4285714;
    }

    #theCall {
        display: block;
        position: absolute;
        top: 50px;
        right: 10px;
        background-color: #fff;
        width: 300px;
        padding: 15px;
        z-index: 99;
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
    }

    .inoutcalling {
        border: 0px solid transparent
    }

    .inoutcalling .icon {
        background-color: rgba(80, 175, 0, 0.75);
        padding: 5px;
        top: 55px;
        right: 15px;
        width: initial;
        height: initial;
        display: block;
    }

    .inoutcalling .icon {
        border-radius: 50%;
        box-shadow: 0 0 0 rgba(38, 185, 154, .4);
        animation: pulse 2s infinite;
    }

    .inoutcalling p {
        margin-right: 0;
        margin-left: 0;
    }

    #outcalling {
        display: block;
        align-items: center;
    }

    #outcalling .icon, #incalling .icon {
        width: 55px !important;
        color: #fff;
        right: 0 !important;
        float: right;
    }

    #num_out, #num_in {
        margin-top: 30px;
        font-size: 18px;
    }

    #theCall hr {
        margin: 15px 0;
    }

    .alert-success, #incalling .alert-danger {
        color: #fff;
    }

    #cancel_in {
        margin-bottom: 0px;
    }

    @-webkit-keyframes pulse {
        0% {
            -webkit-box-shadow: 0 0 0 0 rgba(38, 185, 154, .4);
        }
        70% {
            -webkit-box-shadow: 0 0 0 10px rgba(204, 169, 44, 0);
        }
        100% {
            -webkit-box-shadow: 0 0 0 0 rgba(204, 169, 44, 0);
        }
    }

    @keyframes pulse {
        0% {
            -moz-box-shadow: 0 0 0 0 rgba(38, 185, 154, .4);
            box-shadow: 0 0 0 0 rgba(38, 185, 154, .4);
        }
        70% {
            -moz-box-shadow: 0 0 0 10px rgba(204, 169, 44, 0);
            box-shadow: 0 0 0 10px rgba(204, 169, 44, 0);
        }
        100% {
            -moz-box-shadow: 0 0 0 0 rgba(204, 169, 44, 0);
            box-shadow: 0 0 0 0 rgba(204, 169, 44, 0);
        }
    }


    .inoutcalling.tile-stats .icon i {
        font-size: 32px;
        color: #fff !important;
        line-height: 1;
        width: 45px;
        line-height: 45px;
        text-align: center;
    }

    .inoutcalling.tile-stats .icon.red {
        background-color: red;
    }

    .inoutcalling.tile-stats .name {
        font-size: 24px;
        margin-left: 0;
        max-width: calc(100% - 50px)
    }

    .inoutcalling.tile-stats h5 {
        position: relative;
        margin: 0 0 0 0;
        z-index: 5;
        padding: 0;
    }

    .dialpad .dials ol {
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    .dialpad .dialnumber {
        position: relative;
        z-index: 2;
        padding: 10px 15px;
        color: #4d4d4d;
        font-weight: 300;
        font-size: 24px;
        background: #fff;
        width: 100%;
        border: 0px solid transparent;
        display: inline-block;
        width: calc(100% - 62px)
    }

    .dialpad .dials {
        margin: -1px 0 0 -1px;
        /* background: #1d1918; */
        cursor: pointer;
        display: block;
    }

    .dialpad .dials:before,
    .dialpad .dials:after {
        content: "\0020";
        display: block;
        height: 0;
        overflow: hidden
    }

    .dialpad .dials:after {
        clear: both
    }

    .dialpad .dials .digits {
        float: left;
        width: 33.33%
    }

    .dialpad .dials .digits p {
        font-weight: 600;
        padding: 15px 25px;

    }

    .dialpad .dials .digits p strong {
        color: #0e9549;
        font-weight: 400;
        font-size: 50px;
        margin-right: 0;
    }

    .btn-link {
        color: #0e9549;
    }

    .dialpad .dials .digits:active {
        background: #00caf2;
        border-top-color: #b2f2ff
    }

    .compact .dials .digits p {
        padding: 15px;
        margin: 0;
    }

    .compact .dials .digits p strong {
        font-size: 30px;
        display: block;
        margin: 0;

        text-align: center;
    }

    .compact .dials .digits p sup {
        text-transform: uppercase;
        color: #c1c1c1;
        display: block;
        margin: 0;
        text-align: center;
        top: 0;
        line-height: 1;
    }

    .compact .dials .pad-action {
        /* background: #093; */
        width: 100%;
    }

    .compact .dials .pad-action p sup {

        color: #fff !important
    }

    .compact .dials .pad-action p {
        padding: 5px;
    }

    .compact .dials .pad-action:active {
        background: #0c3
    }

    .size_col_mkt {
        max-width: 225px;
        display: block;
        word-break: break-all;
    }

    a.nav-link.px-0 {
        display: inline-block;
        margin-top: 10px;
    }

    label.title {
        font-style: normal;
        font-weight: 600;
        font-size: 16px;
        line-height: 22px;
        color: #0E9549;
    }

    label.form-label {
        font-style: normal;
        font-weight: normal;
        font-size: 14px;
        line-height: 19px;
        color: #154001;
    }

    #modal-report .modal-header {
        padding-right: 15px;
    }

    .btn_end {
        opacity: 1;
        border: none;
        background: unset;
    }

    .btn_end_img {
        margin-left: 20px;
    }

    span.time_call {
        font-weight: 600;
        font-size: 16px;
        line-height: 22px;
        color: #154001;
        display: inline-block;
        margin-left: 15px;
    }
</style>
<script type="text/javascript">
    $('.phone').click(function () {
        $('#theCall').toggleClass('d-none');
    })
</script>
<script>
    $("#CallModal").on('shown.bs.modal', function () {
        $('.dialnumber').focus();
    });

    $(".dialclear").click(function (event) {
        $(".dialnumber").val(
            function (index, value) {
                return value.substr(0, value.length - 1);
            });
    });

    $(function () {
        function addNumber(theinput) {
            var value = $('.dialnumber').val();
            $('.dialnumber').val(value + '' + theinput);
            $('.dialnumber').focus();
        }

        var dials = $(".dials ol li");
        var index;
        var number = $(".dialnumber");
        var total;

        dials.click(function () {

            index = dials.index(this);

            if (index == 9) {

                addNumber("*");

            } else if (index == 10) {

                addNumber("0");

            } else if (index == 11) {

                addNumber("#");

            } else if (index == 12) {

                number.val("");

            } else if (index == 13) {
                number.val(
                    function (index, value) {
                        return value.substr(0, value.length - 1);
                    });


            } else if (index == 14) {

                //add any call action here

            } else {
                addNumber(index + 1);
            }
        });


    });
</script>
<script>
    @if(isset(session()->get('phonenet')->email_user) && session()->get('phonenet')->extension_number > 0)

    var host = 'tienngay.phonenet.io';
    var ext = {{session()->get('phonenet')->extension_number}};
    var password = 'matkhau';
    // let ext = '99999';
    // let password = '12345678';
    var contact_uri = 'sip:' + ext + '@' + Math.random().toString(36).substring(2, 15) + '.invalid;transport=ws';
    var phone = null;
    var call = null;
    if ($('#choose_number_call').val() == "") {
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
    } else {
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

            extraHeaders: [
                'X-CallerNumber:' + $('#choose_number_call').val()
            ]
        };
    }
    console.log('khoi_tao' + $('#choose_number_call').val());
    $(document).ready(() => {
        //Kiểm tra có được sử dụng mic không
        navigator.mediaDevices.getUserMedia({audio: true}).then(() => {
            console.log('start');
            //Kết nối webrtc tới phonenet
            phone = new JsSIP.UA({
                sockets: [new JsSIP.WebSocketInterface('wss://' + host + ':7443')],
                uri: 'sip:' + ext + '@' + host,
                realm: host,
                ha1: $.md5(ext + ':' + host + ':' + password),
                contact_uri: contact_uri,
                session_timers: false,
            });
            console.log('----');
            phone.on('registered', (e) => {
                //Kết nối thành công
                $('#icon_call').css("color", "#0E9549");
                $('#span_call').addClass('badge bg-green');
                $('#a_call').attr('title', 'Điện thoại sẵn sàng');
                $('#status').text('Điện thoại sẵn sàng');


                //Thực hiện gọi
                $('#call').click(() => {
                    if ($('#choose_number_call').val() == "") {
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
                    } else {
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
                            extraHeaders: [
                                'X-CallerNumber:' + $('#choose_number_call').val()
                            ]
                        };
                    }
                    console.log('call' + $('#choose_number_call').val());

                    if ($('#number').val() != '') {
                        console.log($('#number').val())
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
                        } catch (err) {
                            console.log("call " + err.message);
                        }
                    } else {
                        alert('Mời nhập số');
                    }
                });


                $("#number_header").keyup(function (e) {
                    if (e.which == 13) {

                        if ($('#choose_number_call').val() == "") {
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
                        } else {
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

                                extraHeaders: [
                                    'X-CallerNumber:' + $('#choose_number_call').val()
                                ]
                            };
                        }
                        console.log('call_13' + $('#choose_number_call').val());
                        // Enter key pressed
                        $('#outcalling').removeClass('d-none');
                        $('#incalling').addClass('d-none');
                        $('#dials').addClass('d-none');
                        if ($('#number_header').val() != '') {
                            try {
                                phone.call($('#number_header').val(), callOptions);
                                call.connection.onaddstream = function (e) {
                                    const remoteAudio = document.createElement('audio');
                                    remoteAudio.srcObject = e.stream;
                                    remoteAudio.play();
                                };
                            } catch (err) {
                                console.log("enter " + err.message);
                            }
                            $('#end_header').click(() => {
                                call.terminate();
                                $('#number_header').val("");
                            });

                            $('#num_out').text($('#number_header').val());
                            $('#status').text('Đang gọi...');
                            $('#a_call').attr('title', 'Đang gọi...');
                            $('#status_out').text('Đang gọi đi...');
                        } else {
                            alert('Mời nhập số');
                            $('#outcalling').addClass('d-none');
                            $('#incalling').addClass('d-none');
                            $('#dials').removeClass('d-none');
                        }
                    }
                });


                $('#call_header').click(() => {
                    if ($('#choose_number_call').val() == "") {
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
                    } else {
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

                            extraHeaders: [
                                'X-CallerNumber:' + $('#choose_number_call').val()
                            ]
                        };
                    }
                    console.log('call_click' + $('#choose_number_call').val());

                    $('#outcalling').removeClass('d-none');
                    $('#incalling').addClass('d-none');
                    $('#dials').addClass('d-none');
                    if ($('#number_header').val() != '') {
                        try {
                            phone.call($('#number_header').val(), callOptions);
                            call.connection.onaddstream = function (e) {
                                const remoteAudio = document.createElement('audio');
                                remoteAudio.srcObject = e.stream;
                                remoteAudio.play();
                            };
                        } catch (err) {
                            console.log("enter " + err.message);
                        }
                        $('#end_header').click(() => {
                            call.terminate();
                            $('#number_header').val("");
                        });

                        $('#num_out').text($('#number_header').val());
                        $('#status').text('Đang gọi...');
                        $('#a_call').attr('title', 'Đang gọi...');
                        $('#status_out').text('Đang gọi đi...');
                    } else {
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
                if (call) {
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
                            if ($('#choose_number_call').val() == "") {
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
                            } else {
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

                                    extraHeaders: [
                                        'X-CallerNumber:' + $('#choose_number_call').val()
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
                        } catch (err) {
                            console.log("answer_in " + err.message);
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
                    setTimeout(function () {
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
                    setTimeout(function () {
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
    @endif
</script>
<script>
    $('#choose_number_call').on('change', function () {
        if (typeof (Storage) !== 'undefined') {

            localStorage.setItem('so_chon_call', $('#choose_number_call').val());
            console.log(localStorage.getItem('so_chon_call'));
        } else {
            alert('Trình duyệt của bạn không hỗ trợ localStorage. Hãy nâng cấp trình duyệt để sử dụng!');
        }
    });
    if (typeof (Storage) !== 'undefined') {
        let so_chon = (localStorage.getItem('so_chon_call') == null) ? '' : localStorage.getItem('so_chon_call');
        $('#choose_number_call  option[value="' + so_chon + '"]').prop("selected", true);
        console.log(localStorage.getItem('so_chon_call'));

    } else {
        alert('Trình duyệt của bạn không hỗ trợ localStorage. Hãy nâng cấp trình duyệt để sử dụng!');
    }
</script>
