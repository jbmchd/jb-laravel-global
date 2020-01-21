<?php

namespace JbGlobal\Exceptions;

use Exception;
use JbGlobal\Services\LogService;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    protected $servico_log;

    public function __construct(LogService $servico_log)
    {
        $this->servico_log = $servico_log;
    }

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'senha',
        'senha_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        $result = null;
        $classe = get_class($exception);
        if (array_search($classe, $this->dontReport) !== false) {
            $result = parent::report($exception);
            return $result;
        }

        try {
            $usuario = auth()->user();

            $this->servico_log->criar([
                'tipo' => $classe,
                'mensagem' =>  $exception->getMessage(),
                'arquivo' => $exception->getFile(),
                'linha' => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
                'action' => Request::fullUrl(),
                'usuario_id' => $usuario ? $usuario->id : null,
                'dados' => $this->toJson(Request::all()),
            ]);
        } catch (Exception $e) {
            \Log::error($e);
        }
        return $result;
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if (config('app.env') != 'local') {
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Headers: Origin, Content-type, Accept, Authorization, Local-address');
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        }

        $codigo = 500;
        $resposta = ['erro' => 'Ocorreu um erro no sistema.'];

        if (config('app.debug')) {
            $resposta['exception'] = get_class($exception);
            $resposta['message'] = $exception->getMessage();
            $resposta['trace'] = $exception->getTrace();
            $resposta['line'] = $exception->getLine();
            $resposta['file'] = $exception->getFile();
        }

        return response()->json($resposta, $codigo);
    }

    protected function toJson($model)
    {
        $model = (array) $model;
        foreach ($model as $chave => $objeto) {
            if ($objeto instanceof UploadedFile) {
                $model[$chave] = [
                    'tipo' => 'Arquivo Binário',
                    'mime' => $objeto->getMimeType(),
                    'tamanho' => $objeto->getSize(),
                    'nome' => $objeto->getClientOriginalName(),
                ];
            }
        }

        $json = json_encode(array_filter($model));
        preg_replace('@"senha":".*?"@', '"senha":"***"', $json);
        return $json;
    }
}
