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

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 *
 */
interface FactoryInterface
{
    /**
     * Check if this handler can do something with the result
     *
     * @param mixed $result Result
     * @return boolean
     */
    public function canHandle($result): bool;

    /**
     * @param mixed $result Result
     * @param \Psr\Http\Message\ServerRequestInterface $request Request
     * @return mixed
     */
    public function handle($result, ServerRequestInterface $request);
}
