<?php

namespace Weew\HttpApp\ErrorHandler\Json;

use Weew\App\IApp;
use Weew\Container\IContainer;
use Weew\ErrorHandler\IErrorHandler;
use Weew\HttpApp\IHttpApp;

class JsonErrorHandlerProvider {
    /**
     * @param IApp $app
     * @param IErrorHandler $errorHandler
     * @param IContainer $container
     */
    public function initialize(
        IApp $app,
        IErrorHandler $errorHandler,
        IContainer $container
    ) {
        if ($app instanceof IHttpApp && $app->getDebug()) {
            $jsonErrorHandler = new JsonErrorHandler($app, $errorHandler);
            $jsonErrorHandler->enableErrorHandling();
            $jsonErrorHandler->enableExceptionHandling();

            $container->set(JsonErrorHandler::class, $jsonErrorHandler);
        }
    }
}
