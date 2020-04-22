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

use Phauthentic\Infrastructure\Http\Dispatcher\RequestAttributeExtractor;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

/**
 * RequestAttributeExtractorTest
 */
class RequestAttributeExtractorTest extends TestCase
{
    /**
     * @return void
     */
    public function testExtract(): void
    {
        $extractor = new RequestAttributeExtractor();
        $request = $this->getMockBuilder(ServerRequestInterface::class)
            ->getMock();

        $request->expects($this->at(0))
            ->method('getAttribute')
            ->with('handler', null)
            ->willReturn(null);

        $result = $extractor->extractHandler($request);
        $this->assertNull($result);

        $request->expects($this->at(0))
            ->method('getAttribute')
            ->with('handler', null)
            ->willReturn('Users@login');

        $result = $extractor->extractHandler($request);
        $this->assertEquals('Users@login', $result);
    }
}
