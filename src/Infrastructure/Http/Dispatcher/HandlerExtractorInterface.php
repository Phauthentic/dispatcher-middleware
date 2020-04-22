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

namespace Phauthentic\Infrastructure\Http\Dispatcher;

use Psr\Http\Message\ServerRequestInterface;

/**
 * A simple controller dispatcher middleware
 *
 * It will check if there is route in the request attributes. If there is a
 * route it will take the handler and check if it is a string and tries to
 * resolve it against the DI container.
 */
interface HandlerExtractorInterface
{
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request Server Request
     * @return mixed
     */
    public function extractHandler(ServerRequestInterface $request);
}
