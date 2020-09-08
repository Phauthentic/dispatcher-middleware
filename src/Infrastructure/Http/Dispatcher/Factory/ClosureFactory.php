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

use Closure;
use Psr\Http\Message\ServerRequestInterface;

/**
 *
 */
class ClosureFactory implements FactoryInterface
{
    public function canHandle($result): bool
    {
        return $result instanceof Closure;
    }

    public function handle($result, ServerRequestInterface $request)
    {
        return $result($request);
    }
}
