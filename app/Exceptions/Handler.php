<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
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
   * @param \Exception $exception
   * @return void
   *
   * @throws \Exception
   */
  public function report(Exception $exception)
  {
    parent::report($exception);
  }

  /**
   * Render an exception into an HTTP response.
   *
   * @param \Illuminate\Http\Request $request
   * @param \Exception $e
   * @return \Symfony\Component\HttpFoundation\Response
   *
   * @throws \Exception
   */
  public function render($request, Exception $e)
  {
    if ($e instanceof NoConnectionException ||
      $e instanceof NotFoundHttpException
    ) {
      \Log::info('EXCEPTION HAPPENED: ' . $e->getStatusCode() . ' | ' . $e->getMessage());
      return response()->json(['status' => $e->getStatusCode(), 'error' => get_class($e), 'message' => $e->getMessage()], $e->getStatusCode());
    }

    return parent::render($request, $e);
  }
}
