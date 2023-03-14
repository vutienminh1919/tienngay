<?php

namespace App\Exceptions;

use Carbon\Carbon;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Throwable $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        $param = json_encode($this->request->all());
        $env = env('APP_ENV');
        $uri = $this->request->getRequestUri();
        $message = [
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'message' => $exception->getMessage(),

        ];
        $message_new = 'Thời gian: ' . Carbon::now() . "\n" .
            'Client: ' . $env . "\n" .
            'Api: ' . '"<b>' . $uri . '</b>"' . "\n" .
            'Phát sinh lỗi: ' . '"<b>' . json_encode($message) . '</b>"' . "\n" .
            'Data: ' . '"<b>' . $param . '</b>"' . "\n" .
            'IP: ' . '"<b>' . $this->request->ip() . '</b>"';
        $chat_id = "-648631798";
        $token = "5574112787:AAGwGtq-BGImh6Qn0clNj2pn4Bz_PvoHtfg";
       $result = Http::get("https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id . "&text=" . $message_new . "&parse_mode=HTML");
       parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        return parent::render($request, $exception);
    }
}
