<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->renderable(function (NotFoundHttpException $e, $request) {
        if ($request->is('api/*')) {
            return response()->json([
                'status'=>false,
                'message' => 'Record not found, Enter correct URL.'
            ], 404);
        }
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
        
            return response()->json([
                'status'=>false,
                'message' => 'Requested method not allowed.'
            ], 405);
        });

        $this->renderable(function (RouteNotFoundException $e, $request) {
        
            return response()->json([
                'status'=>false,
                'message' => 'Unauthorized access, Bearer token required.'
            ], 401);
        });

        $this->renderable(function (QueryException $e, $request) {
        
            return response()->json([
                'status'=>false,
                'message' => 'Query exception error!'
            ], 500);
        });
    }
}
