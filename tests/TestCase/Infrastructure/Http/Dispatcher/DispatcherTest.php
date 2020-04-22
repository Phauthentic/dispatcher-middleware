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
use Psr\Http\Message\ServerRequestInterface;

/**
 * DispatcherTest
 */
class DispatcherTest extends TestCase
{
    /**
     *
     */
    public function testSomething()
    {
        $request = $this->getMockBuilder(ServerRequestInterface::class)
            ->getMock();

        //$dispatcher = new Dispatcher();
        //$dispatcher->dispatch($request, 'Plugin.Controller@foo');
    }
}
