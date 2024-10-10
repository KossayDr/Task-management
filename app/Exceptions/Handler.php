<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        // Handling Spatie UnauthorizedException
        if ($exception instanceof UnauthorizedException) {
            return response()->json([
                'message' => 'User does not have the right roles'
            ], 403);
        }
    
        // Handling Laravel AuthorizationException
        if ($exception instanceof AuthorizationException) {
            return response()->json([
                'message' => 'Authorized for admin',
            ], 403);
        }
    
        // Handling ModelNotFoundException
        if ($exception instanceof ModelNotFoundException) {
            // نحصل على اسم النموذج الذي تسبب في الاستثناء
            $modelName = class_basename($exception->getModel());
    
            // تخصيص رسالة الخطأ بناءً على اسم النموذج
            $message = match ($modelName) {
                'User' => 'User not found',
                'Role' => 'Role not found',
                default => 'Resource not found',
            };
    
            return response()->json([
                'message' => $message,
            ], 404);
        }
    
        return parent::render($request, $exception); // هنا القوس الناقص أغلقته
    }
    
}
