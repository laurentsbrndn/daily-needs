<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            $guard = data_get($exception->guards(), 0);
        
            switch ($guard) {
                case 'admin':
                    return redirect()->route('admin.login');
                case 'customer':
                    return redirect()->route('login');
                case 'courier' :
                    return redirect()->route('courier.login');
                default:
                    return redirect('/');
            }
        }
    
        return parent::render($request, $exception);
    }

}
