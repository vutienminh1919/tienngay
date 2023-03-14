<?php

namespace Modules\Mailer\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Response;
use App;

class CheckServerAlive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mailer:checkServerAlive {user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "send alert when server request time out";

    public static $curlErrors = [
        1 => 'curle unsupported protocol',
        2 => 'curle failed init',
        3 => 'curle url malformat',
        4 => 'curle url malformat user',
        5 => 'curle couldnt resolve proxy',
        6 => 'curle couldnt resolve host',
        7 => 'curle couldnt connect',
        8 => 'curle ftp weird server reply',
        9 => 'curle remote access denied',
        11 => 'curle ftp weird pass reply',
        13 => 'curle ftp weird pasv reply',
        14 =>'curle ftp weird 227 format',
        15 => 'curle ftp cant get host',
        17 => 'curle ftp couldnt set type',
        18 => 'curle partial file',
        19 => 'curle ftp couldnt retr file',
        21 => 'curle quote error',
        22 => 'curle http returned error',
        23 => 'curle write error',
        25 => 'curle upload failed',
        26 => 'curle read error',
        27 => 'curle out of memory',
        28 => 'curle operation timedout',
        30 => 'curle ftp port failed',
        31 => 'curle ftp couldnt use rest',
        33 => 'curle range error',
        34 => 'curle http post error',
        35 => 'curle ssl connect error',
        36 => 'curle bad download resume',
        37 => 'curle file couldnt read file',
        38 => 'curle ldap cannot bind',
        39 => 'curle ldap search failed',
        41 => 'curle function not found',
        42 => 'curle aborted by callback',
        43 => 'curle bad function argument',
        45 => 'curle interface failed',
        47 => 'curle too many redirects',
        48 => 'curle unknown telnet option',
        49 => 'curle telnet option syntax',
        51 => 'curle peer failed verification',
        52 => 'curle got nothing',
        53 => 'curle ssl engine notfound',
        54 => 'curle ssl engine setfailed',
        55 => 'curle send error',
        56 => 'curle recv error',
        58 => 'curle ssl certproblem',
        59 => 'curle ssl cipher',
        60 => 'curle ssl cacert',
        61 => 'curle bad content encoding',
        62 => 'curle ldap invalid url',
        63 => 'curle filesize exceeded',
        64 => 'curle use ssl failed',
        65 => 'curle send fail rewind',
        66 => 'curle ssl engine initfailed',
        67 => 'curle login denied',
        68 => 'curle tftp notfound',
        69 => 'curle tftp perm',
        70 => 'curle remote disk full',
        71 => 'curle tftp illegal',
        72 => 'curle tftp unknownid',
        73 => 'curle remote file exists',
        74 => 'curle tftp nosuchuser',
        75 => 'curle conv failed',
        76 => 'curle conv reqd',
        77 => 'curle ssl cacert badfile',
        78 => 'curle remote file not found',
        79 => 'curle ssh',
        80 => 'curle ssl shutdown failed',
        81 => 'curle again',
        82 => 'curle ssl crl badfile',
        83 => 'curle ssl issuer error',
        84 => 'curle ftp pret failed',
        84 => 'curle ftp pret failed',
        85 => 'curle rtsp cseq error',
        86 => 'curle rtsp session error',
        87 => 'curle ftp bad file list',
        88 => 'curle chunk failed'
    ];

    public static $httpCodeErrors = [
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',                                     // RFC2295
        507 => 'Insufficient Storage',                                        // RFC4918
        508 => 'Loop Detected',                                               // RFC5842
        510 => 'Not Extended',                                                // RFC2774
        511 => 'Network Authentication Required',                             // RFC6585
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param  \App\DripEmailer  $drip
     * @return mixed
     */
    public function handle()
    {
        $user = $this->argument('user');
        $messages = '';
        $domains = [
            'https://lms.tienngay.vn/',
            'https://api.tienngay.vn/',
            'https://apiv2.tienngay.vn/',
            'https://cpanelv2.tienngay.vn/',
            'https://tienngay.vn/',
            'https://apivp.tienngay.vn/'
        ];
        foreach($domains as $domain) {
            $message = $this->sendRequest($domain);
            if (!empty($message)) {
                $messages .= $message;
            }
        }
        if (!empty($messages)) {
            $messages .= "<p>Trên Server: <strong><span style='color: red'>10.0.28.22</span></strong></p>";
            Log::channel('cronjob-mailer')->info('Begin send email');
            $mailController = App::make(\Modules\Mailer\Http\Controllers\MailController::class);
            $mailController->callAction('sendMailAlertServerDown', [$messages, 'cronjob-mailer', $user]);
        }
    }

    public function sendRequest($service) {
        $message = '';
        $dataRaw = '';
        $curl = curl_init();
        $curl_option = [
            CURLOPT_URL => $service,
            CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_CONNECT_ONLY => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_CONNECTTIMEOUT => 60,          // timeout on connect
            CURLOPT_TIMEOUT        => 180,          // timeout on response
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ];
        Log::channel('cronjob-mailer')->info('checkServerAlive: '. $service);
        curl_setopt_array($curl, $curl_option);
        $result = curl_exec($curl);
        $errorCode = curl_errno($curl);
        Log::channel('cronjob-mailer')->info('checkServerAlive: '. $service . ' curlError: ' . $errorCode);
        if ($errorCode) {
            // Do something on timeout.
            $detail = isset(self::$curlErrors[$errorCode]) ? self::$curlErrors[$errorCode] : "Error Code $errorCode";
            $message = "<p><strong>Domain: $service </strong> <span style='color: red'>curlError $errorCode $detail </span></p>";
        } else {
            //do nothing
        }

        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        Log::channel('cronjob-mailer')->info('checkServerAlive: '. $service . ' status: ' . $httpcode);
        if (isset(self::$httpCodeErrors[$httpcode])) {
            $detail = self::$httpCodeErrors[$httpcode];
            $message = "<p><strong>Domain: $service </strong> <span style='color: red'>status $httpcode $detail</span></p>";
        } else {
            //do nothing
        }
        curl_close($curl);
        var_dump($httpcode);
        return $message;
    }
}