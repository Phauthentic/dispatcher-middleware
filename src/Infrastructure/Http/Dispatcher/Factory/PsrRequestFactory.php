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

namespace Phauthentic\Infrastructure\Http\Dispatcher\Factory;

use Psr\Http\Message\ServerRequestInterface;

/**
 * PsrRequestHandler
 */
class PsrRequestFactory implements FactoryInterface
{
    public function canHandle($result): bool
    {
        return $result instanceof RequestHandlerInterface;
    }

    public function handle($result, ServerRequestInterface $request)
    {
        /**
         * @var \Psr\Http\Server\RequestHandlerInterface $result
         */
        return $result->handle($request);
    }
}
