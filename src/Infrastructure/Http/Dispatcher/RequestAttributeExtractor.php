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
 * Simple Request Attribute Extractor
 */
class RequestAttributeExtractor implements HandlerExtractorInterface
{
    /**
     * @var string
     */
    protected $attributeName;

    /**
     * @param string $attributeName Attribute name to check for the handler
     */
    public function __construct(string $attributeName = 'handler')
    {
        $this->attributeName = $attributeName;
    }

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request Server Request
     * @return mixed
     */
    public function extractHandler(ServerRequestInterface $request)
    {
        return $request->getAttribute($this->attributeName, null);
    }
}
