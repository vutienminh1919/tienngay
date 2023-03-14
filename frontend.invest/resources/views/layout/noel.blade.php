<style>
    body {
        background: url({{asset('/images/background.png')}}) no-repeat;
        background-size: cover;
        background-attachment: fixed;
    }
    .container-tight {
        position: relative;
    }
    .caythong {
        position: fixed;
        bottom: 35px;

    }

    .caythongtrai {
        left: 35px;
    }

    .caythongphai {
        right: 35px;
    }

    .ongianoel {
        position: absolute;
        top: -37px;
        right: -49px;
    }

    .deer {
        position: absolute;
        left: -120px;
        z-index: 0;
        bottom: 40%;
    }

    #thelogin .panel-login {
        position: relative;
    }

    .item_gift {
        position: absolute;
        top: 0;
        z-index: 9999;
        cursor: pointer;
        -webkit-transform-origin: 50% 0;
        -moz-transform-origin: 50% 0;
        -o-transform-origin: 50% 0;
        transform-origin: 50% 0;
        -webkit-transition: all .3s ease-in-out;
        -moz-transition: all .3s ease-in-out;
        -o-transition: all .3s ease-in-out;
        transition: all .3s ease-in-out;
        animation: bounce 5s infinite alternate;
    }

    @keyframes bounce {
    0 {
        -webkit-transform:rotate(9deg);
        -moz-transform:rotate(9deg);
        -o-transform:rotate(9deg);
        transform:rotate(9deg);
    }

    50% {
        -webkit-transform:rotate(-18deg);
        -moz-transform:rotate(-18deg);
        -o-transform:rotate(-18deg);
        transform:rotate(-18deg);
    }

    100% {
        -webkit-transform:rotate(18deg);
        -moz-transform:rotate(18deg);
        -o-transform:rotate(18deg);
        transform:rotate(18deg);
    }
    }

    .item_gift1 {
        left: 40px;
    }

    .item_gift2 {
        left: 250px;
    }

    .item_gif3 {
        left: 400px;
        top: -100px;
    }

    .item_gift4 {
        right: 20px;
    }

    .item_gift5 {
        right: 250px;
    }

    .item_gif6 {
        right: 350px;
        top: -100px;
    }
</style>
<script type="text/javascript">
    document.write('<img style="position:fixed;z-index:9999;bottom:20px;left:20px;width: 80px" src="{{asset('images/bottomleft.png')}}"/>');
    var no = 100;
    var hidesnowtime = 0;
    var snowdistance = 'pageheight';
    var ie4up = (document.all) ? 1 : 0;
    var ns6up = (document.getElementById && !document.all) ? 1 : 0;

    function iecompattest() {
        return (document.compatMode && document.compatMode != 'BackCompat') ? document.documentElement : document.body
    }

    var dx, xp, yp;
    var am, stx, sty;
    var i, doc_width = 800,
        doc_height = 600;
    if (ns6up) {
        doc_width = self.innerWidth;
        doc_height = self.innerHeight
    } else if (ie4up) {
        doc_width = iecompattest().clientWidth;
        doc_height = iecompattest().clientHeight
    }
    dx = new Array();
    xp = new Array();
    yp = new Array();
    am = new Array();
    stx = new Array();
    sty = new Array();
    for (i = 0; i < no; ++i) {
        dx[i] = 0;
        xp[i] = Math.random() * (doc_width - 50);
        yp[i] = Math.random() * doc_height;
        am[i] = Math.random() * 20;
        stx[i] = 0.02 + Math.random() / 10;
        sty[i] = 0.7 + Math.random();
        if (ie4up || ns6up) {
            document.write('<div id="dot' + i + '" style="POSITION:absolute;Z-INDEX:' + i + ';VISIBILITY:visible;TOP:15px;LEFT:15px;"><span style="font-size:18px;color:#fff">*</span></div>')
        }
    }

    function snowIE_NS6() {
        doc_width = ns6up ? window.innerWidth - 10 : iecompattest().clientWidth - 10;
        doc_height = (window.innerHeight && snowdistance == 'windowheight') ? window.innerHeight : (ie4up && snowdistance == 'windowheight') ? iecompattest().clientHeight : (ie4up && !window.opera && snowdistance == 'pageheight') ? iecompattest().scrollHeight : iecompattest().offsetHeight;
        for (i = 0; i < no; ++i) {
            yp[i] += sty[i];
            if (yp[i] > doc_height - 50) {
                xp[i] = Math.random() * (doc_width - am[i] - 30);
                yp[i] = 0;
                stx[i] = 0.02 + Math.random() / 10;
                sty[i] = 0.7 + Math.random()
            }
            dx[i] += stx[i];
            document.getElementById('dot' + i).style.top = yp[i] + 'px';
            document.getElementById('dot' + i).style.left = xp[i] + am[i] * Math.sin(dx[i]) + 'px'
        }
        snowtimer = setTimeout('snowIE_NS6()', 10)
    }

    function hidesnow() {
        if (window.snowtimer) {
            clearTimeout(snowtimer)
        }
        for (i = 0; i < no; i++) document.getElementById('dot' + i).style.visibility = 'hidden'
    }

    if (ie4up || ns6up) {
        snowIE_NS6();
        if (hidesnowtime > 0) setTimeout('hidesnow()', hidesnowtime * 1000)
    }
</script>
