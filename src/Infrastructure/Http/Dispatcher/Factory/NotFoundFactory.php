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

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 *
 */
class NotFoundFactory implements FactoryInterface
{
    protected ResponseFactoryInterface $responseFactory;

    protected string $message = 'Page not found';

    protected bool $handleEverything = false;

    /**
     *
     */
    public function __construct(
        ResponseFactoryInterface $responseFactory
    ) {
        $this->responseFactory = $responseFactory;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }

    public function handleEverything()
    {
        $this->handleEverything = true;

        return $this;
    }

    public function canHandle($result): bool
    {
        if ($this->handleEverything === false) {
            return $result === null;
        }

        return true;
    }

    public function handle($result, ServerRequestInterface $request)
    {
        return $this->responseFactory->createResponse(
            404,
            $this->message
        );
    }
}
