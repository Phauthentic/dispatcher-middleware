<?php

/**
 * Copyright (c) Florian Krämer (https://florian-kraemer.net)
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Florian Krämer (https://florian-kraemer.net)
 * @author    Florian Krämer
 * @link      https://github.com/Phauthentic
 * @license   https://opensource.org/licenses/MIT MIT License
 */

declare(strict_types=1);

namespace Phauthentic\Infrastructure\Http\Middleware;

use Phauthentic\Infrastructure\Http\Dispatcher\DispatcherInterface;
use Phauthentic\Infrastructure\Http\Dispatcher\HandlerExtractorInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * A simple controller dispatcher middleware
 *
 * It will check if there is handler information is in the request. If there is
 * a it will take the resolved handler, this can be anything, a route object,
 * a string, a callable and pass it to the dispatcher.
 */
class DispatcherMiddleware implements MiddlewareInterface
{
    /**
     * @var \Phauthentic\Infrastructure\Http\Dispatcher\HandlerExtractorInterface
     */
    protected $handlerExtractor;

    /**
     * @var \Phauthentic\Infrastructure\Http\Dispatcher\DispatcherInterface
     */
    protected $dispatcher;

    /**
     * @param \Phauthentic\Infrastructure\Http\Dispatcher\HandlerExtractorInterface $handlerExtractor Handler Extractor
     * @param \Phauthentic\Infrastructure\Http\Dispatcher\DispatcherInterface $dispatcher Dispatcher
     */
    public function __construct(
        HandlerExtractorInterface $handlerExtractor,
        DispatcherInterface $dispatcher
    ) {
        $this->handlerExtractor = $handlerExtractor;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Process an incoming server request.
     *
     * Processes an incoming server request in order to produce a response.
     * If unable to produce the response itself, it may delegate to the provided
     * request handler to do so.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request Server Request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler Server Request Handler
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $resolvedHandler = $this->handlerExtractor->extractHandler($request);

        if ($resolvedHandler === null) {
            $handler->handle($request);
        }

        $result = $this->dispatcher->dispatch($request, $resolvedHandler);

        if ($result instanceof ResponseInterface) {
            return $result;
        }

        return $handler->handle($request);
    }
}
