<?php

namespace Weew\HttpApp\ErrorHandler\Json;

use Exception;
use Weew\ErrorHandler\Errors\IError;
use Weew\ErrorHandler\IErrorHandler;
use Weew\Http\HttpStatusCode;
use Weew\Http\Responses\JsonResponse;
use Weew\HttpApp\IHttpApp;

class JsonErrorHandler {
    /**
     * @var IHttpApp
     */
    protected $httpApp;

    /**
     * @var IErrorHandler
     */
    protected $errorHandler;

    /**
     * JsonErrorHandler constructor.
     *
     * @param IHttpApp $httpApp
     * @param IErrorHandler $errorHandler
     */
    public function __construct(IHttpApp $httpApp, IErrorHandler $errorHandler) {
        $this->httpApp = $httpApp;
        $this->errorHandler = $errorHandler;
    }

    /**
     * @return IHttpApp
     */
    public function getHttpApp() {
        return $this->httpApp;
    }

    /**
     * @param IHttpApp $httpApp
     */
    public function setHttpApp(IHttpApp $httpApp) {
        $this->httpApp = $httpApp;
    }

    /**
     * @return IErrorHandler
     */
    public function getErrorHandler() {
        return $this->errorHandler;
    }

    /**
     * @param IErrorHandler $errorHandler
     */
    public function setErrorHandler(IErrorHandler $errorHandler) {
        $this->errorHandler = $errorHandler;
    }

    /**
     * Enable error handling.
     */
    public function enableErrorHandling() {
        $this->errorHandler->addErrorHandler([$this, 'handleError']);
    }

    /**
     * Enable exception handling.
     */
    public function enableExceptionHandling() {
        $this->errorHandler->addExceptionHandler([$this, 'handleException']);
    }

    /**
     * @param IError $error
     */
    public function handleError(IError $error) {
        $response = new JsonResponse(HttpStatusCode::INTERNAL_SERVER_ERROR);
        $response->getData()->set('error.message', $error->getMessage());
        $response->getData()->set('error.code', $error->getCode());
        $response->getData()->set('error.file', $error->getFile());
        $response->getData()->set('error.line', $error->getLine());

        $this->httpApp->shutdownWithResponse($response);
    }

    /**
     * @param Exception $ex
     */
    public function handleException(Exception $ex) {
        $trace = $ex->getTrace();

        foreach ($trace as &$item) {
            foreach (array_keys($item) as $key) {
                if ( ! array_contains(['file', 'line', 'function', 'class'], $key)) {
                    array_remove($item, $key);
                }
            }
        }

        $response = new JsonResponse(HttpStatusCode::INTERNAL_SERVER_ERROR);
        $response->getData()->set('error.message', $ex->getMessage());
        $response->getData()->set('error.code', $ex->getCode());
        $response->getData()->set('error.file', $ex->getFile());
        $response->getData()->set('error.line', $ex->getLine());
        $response->getData()->set('error.trace', $trace);

        $this->httpApp->shutdownWithResponse($response);
    }
}
