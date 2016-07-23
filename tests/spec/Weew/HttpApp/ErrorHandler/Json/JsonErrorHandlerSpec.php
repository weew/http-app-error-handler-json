<?php

namespace tests\spec\Weew\HttpApp\ErrorHandler\Json;

use Exception;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Weew\ErrorHandler\ErrorHandler;
use Weew\ErrorHandler\Errors\IError;
use Weew\ErrorHandler\IErrorHandler;
use Weew\Http\HttpStatusCode;
use Weew\Http\Responses\JsonResponse;
use Weew\HttpApp\ErrorHandler\Json\JsonErrorHandler;
use Weew\HttpApp\HttpApp;
use Weew\HttpApp\IHttpApp;

/**
 * @mixin JsonErrorHandler
 */
class JsonErrorHandlerSpec extends ObjectBehavior {
    function let(IHttpApp $httpApp, IErrorHandler $errorHandler) {
        $this->beConstructedWith($httpApp, $errorHandler);
    }

    function it_is_initializable() {
        $this->shouldHaveType(JsonErrorHandler::class);
    }

    function it_takes_and_returns_http_app() {
        $httpApp = new HttpApp();
        $this->getHttpApp()->shouldHaveType(IHttpApp::class);
        $this->setHttpApp($httpApp);
        $this->getHttpApp()->shouldBe($httpApp);
    }

    function it_takes_and_returns_error_handler() {
        $errorHandler = new ErrorHandler();
        $this->getErrorHandler()->shouldHaveType(IErrorHandler::class);
        $this->setErrorHandler($errorHandler);
        $this->getErrorHandler()->shouldBe($errorHandler);
    }
    
    function it_enables_error_handling(IErrorHandler $errorHandler) {
        $errorHandler->addErrorHandler([$this, 'handleError'])->shouldBeCalled();
        $this->enableErrorHandling();
    }

    function it_enables_exception_handling(IErrorHandler $errorHandler) {
        $errorHandler->addExceptionHandler([$this, 'handleException'])->shouldBeCalled();
        $this->enableExceptionHandling();
    }

    function it_handles_error(IHttpApp $httpApp, IError $error) {
        $error->getMessage()->willReturn('message');
        $error->getCode()->willReturn('code');
        $error->getFile()->willReturn('file');
        $error->getLine()->willReturn('line');

        $response = new JsonResponse(HttpStatusCode::INTERNAL_SERVER_ERROR);
        $response->getData()->set('error.message', 'message');
        $response->getData()->set('error.code', 'code');
        $response->getData()->set('error.file', 'file');
        $response->getData()->set('error.line', 'line');

        $httpApp->shutdownWithResponse($response)->shouldBeCalled();

        $this->handleError($error);
    }

    function it_handles_exception(IHttpApp $httpApp, Exception $ex) {
        $httpApp->shutdownWithResponse(Argument::type(JsonResponse::class))->shouldBeCalled();

        $this->handleException($ex);
    }
}
