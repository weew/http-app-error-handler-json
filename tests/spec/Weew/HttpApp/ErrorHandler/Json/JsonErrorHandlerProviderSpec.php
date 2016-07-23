<?php

namespace tests\spec\Weew\HttpApp\ErrorHandler\Json;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Weew\Container\IContainer;
use Weew\ErrorHandler\IErrorHandler;
use Weew\HttpApp\ErrorHandler\Json\JsonErrorHandler;
use Weew\HttpApp\ErrorHandler\Json\JsonErrorHandlerProvider;
use Weew\HttpApp\IHttpApp;

/**
 * @mixin JsonErrorHandlerProvider
 */
class JsonErrorHandlerProviderSpec extends ObjectBehavior {
    function it_is_initializable() {
        $this->shouldHaveType(JsonErrorHandlerProvider::class);
    }

    function it_initializes(
        IHttpApp $httpApp,
        IErrorHandler $errorHandler,
        IContainer $container
    ) {
        $httpApp->getDebug()->willReturn(true);
        $errorHandler->addErrorHandler(Argument::any())->shouldBeCalled();
        $errorHandler->addExceptionHandler(Argument::any())->shouldBeCalled();
        $container->set(JsonErrorHandler::class, Argument::type(JsonErrorHandler::class))->shouldBeCalled();

        $this->initialize($httpApp, $errorHandler, $container);
    }
}
