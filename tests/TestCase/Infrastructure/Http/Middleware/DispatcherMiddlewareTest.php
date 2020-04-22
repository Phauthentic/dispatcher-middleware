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

namespace Phauthentic\Test\TestCase\Infrastructure\Http\Dispatcher;

use Phauthentic\Infrastructure\Http\Dispatcher\DispatcherInterface;
use Phauthentic\Infrastructure\Http\Dispatcher\HandlerExtractorInterface;
use Phauthentic\Infrastructure\Http\Middleware\DispatcherMiddleware;
use PHPUnit\Framework\TestCase;

/**
 * DispatcherMiddleware Test
 */
class DispatcherMiddlewareTest extends TestCase
{
    /**
     * @return void
     */
    public function testHandle(): void
    {
        $extractor = $this->getMockBuilder(HandlerExtractorInterface::class)
            ->getMock();

        $dispatcher = $this->getMockBuilder(DispatcherInterface::class)
            ->getMock();

        $middleware = new DispatcherMiddleware(
            $extractor,
            $dispatcher
        );

        //$middleware->process($request, $requestHandlerInterface);
    }
}
