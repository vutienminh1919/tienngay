<?php

namespace App\Exceptions;

use App\Service\TelegramBot;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    public function __construct(TelegramBot $telegramBot,
                                Request $request)
    {
        $this->telegrambot = $telegramBot;
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
//        $param = json_encode($this->request->all());
//        $env = env('APP_ENV');
//        $uri = $this->request->getRequestUri();
//        $message = [
//            'file' => $exception->getFile(),
//            'line' => $exception->getLine(),
//            'message' => $exception->getMessage(),
//
//        ];
//        $this->telegrambot->sendError($env, $uri, json_encode($message), $param);
//        parent::report($exception);
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
