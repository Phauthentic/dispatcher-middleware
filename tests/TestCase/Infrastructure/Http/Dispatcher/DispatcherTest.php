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

use Phauthentic\Infrastructure\Http\Dispatcher\Dispatcher;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * DispatcherTest
 */
class DispatcherTest extends TestCase
{
    /**
     * @return void
     */
    public function testDispatchingCallableHandler(): void
    {
        $container = $this->getMockBuilder(ContainerInterface::class)
            ->getMock();
        $request = $this->getMockBuilder(ServerRequestInterface::class)
            ->getMock();
        $response = $this->getMockBuilder(ResponseInterface::class)
            ->getMock();

        $callable = function() use ($response) {
            return $response;
        };

        $dispatcher = new Dispatcher($container);
        $result = $dispatcher->dispatch($request, $callable);
        $this->assertInstanceOf(ResponseInterface::class, $result);

        new class {
            public function log($msg)
            {
                echo $msg;
            }
        };
    }

    /**
     * @return void
     */
    public function testDispatchingClassString(): void
    {
        $container = $this->getMockBuilder(ContainerInterface::class)
            ->getMock();
        $request = $this->getMockBuilder(ServerRequestInterface::class)
            ->getMock();
        $response = $this->getMockBuilder(ResponseInterface::class)
            ->getMock();

        $class = new class($response) {
            protected $response;
            public function __construct(ResponseInterface $response)
            {
                $this->response = $response;
            }

            public function login(ServerRequestInterface $request)
            {
                return $this->response;
            }
        };

        $container->expects($this->any())
            ->method('has')
            ->with('Users')
            ->willReturn(true);

        $container->expects($this->any())
            ->method('get')
            ->with('Users')
            ->willReturn($class);

        $dispatcher = new Dispatcher($container);
        $result = $dispatcher->dispatch($request, 'Users@login');
        $this->assertInstanceOf(ResponseInterface::class, $result);
    }
}
