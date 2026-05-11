<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

/**
 * 异常处理器
 */
class Handler extends ExceptionHandler
{
    /**
     * 不报告的异常类型
     */
    protected $dontReport = [
        //
    ];

    /**
     * 验证异常时不闪存的输入字段
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * 注册异常处理回调
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
