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

use ArrayIterator;

/**
 * ResultHandlerCollection
 */
class FactoryCollection implements FactoryCollectionInterface
{
    /**
     * @var array
     */
    protected array $handlers = [];

    public function __construct(array $handlers = [])
    {
        foreach ($handlers as $handler)
        {
            $this->add($handler);
        }
    }

    /**
     * @param \Phauthentic\Infrastructure\Http\Dispatcher\Factory\FactoryInterface $handler Handler
     */
    public function add(FactoryInterface $handler)
    {
        $this->handlers[] = $handler;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new ArrayIterator($this->handlers);
    }
}
