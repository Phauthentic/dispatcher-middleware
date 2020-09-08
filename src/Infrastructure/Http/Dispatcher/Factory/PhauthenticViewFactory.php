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

use Phauthentic\Presentation\Service\RenderServiceInterface;
use Phauthentic\Presentation\View\ViewInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 *
 */
class PhauthenticViewFactory implements FactoryInterface
{
    protected RenderServiceInterface $renderService;

    public function __construct(RenderServiceInterface $renderService)
    {
        $this->renderService = $renderService;
    }

    public function canHandle($result): bool
    {
        return $result instanceof ViewInterface;
    }

    public function handle($result, ServerRequestInterface $request)
    {
        return $this->renderService
            ->setOutputMimeTypeByRequest($request)
            ->renderToResponse($result);
    }
}
