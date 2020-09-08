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

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * A simple controller dispatcher middleware
 */
class StringToClassResolverFactory implements FactoryInterface
{
    /**
     * @var string
     */
    protected string $defaultNamespace = '';

    /**
     * @var string
     */
    protected string $methodSeparator = '@';

    /**
     * @var string
     */
    protected string $namespaceSeparator = '.';

    /**
     * @var string
     */
    protected string $classTemplate = '{namespace}{className}';

    /**
     * @var array
     */
    protected array $classParts = [];

    /**
     * @var \Psr\Container\ContainerInterface;
     */
    protected ContainerInterface $container;

    /**
     * @param \Psr\Container\ContainerInterface $container PSR Container
     */
    public function __construct(
        ContainerInterface $container
    ) {
        $this->container = $container;
    }

    /**
     * @param string $namespace Namespace
     * @return $this
     */
    public function setDefaultNamespace(string $namespace): DispatcherInterface
    {
        $this->defaultNamespace = $namespace;

        return $this;
    }

    /**
     * @param array $classParts Class Template Vars
     * @return $this
     */
    public function setClassParts(array $classParts): DispatcherInterface
    {
        $this->classParts = $classParts;

        return $this;
    }

    /**
     * @param string $template Template String
     * @return $this
     */
    public function setClassTemplate(string $template): DispatcherInterface
    {
        $this->classTemplate = $template;

        return $this;
    }

    /**
     * @param string $separator Separator
     * @return $this
     */
    public function setMethodSeparator(string $separator): DispatcherInterface
    {
        $this->methodSeparator = $separator;

        return $this;
    }

    /**
     * @param string $separator Separator
     * @return $this
     */
    public function setNamespaceSeparator(string $separator): DispatcherInterface
    {
        $this->namespaceSeparator = $separator;

        return $this;
    }

    public function canHandle($result): bool {
        $this->parsedResult = $this->parseString($result);

        if ($this->container->has($this->parsedResult['className']) === false) {
            return false;
        }

        $this->parsedResult['object'] = $this->container->get($this->parsedResult['className']);

        return true;
    }

    /**
     * @param mixed $handler Handler
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return mixed
     */
    public function handle(
        $handler,
        ServerRequestInterface $request
    ): ResponseInterface {
        if ($this->parsedResult['method'] === null) {
            return $this->parsedResult['object']($request);
        }

        return $this->parsedResult['object']->{$this->parsedResult['method']}($request);
    }

    /**
     * @param string $handler Handler String
     * @return array
     */
    protected function parseString(string $handler): array
    {
        $namespace = $this->defaultNamespace;
        $method = null;

        // Determine the namespace
        $position = strpos($handler, $this->namespaceSeparator);
        if ($position) {
            $namespace = strstr($handler, '.', true);
            $handler = substr($handler, $position + 1);
        }

        // Determine if there is an action besides a class
        $position = strpos($handler, $this->methodSeparator);
        if ($position) {
            $method = substr($handler, $position + 1);
            $handler = substr($handler, 0, $position);
        }

        $fqcn = $this->classTemplate;
        $this->classParts['className'] = $handler;
        $this->classParts['namespace'] = $namespace;

        foreach ($this->classParts as $placeholder => $var) {
            $fqcn = str_replace(
                '{' . (string)$placeholder . '}',
                (string)$var,
                $fqcn
            );
        }

        return [
            'className' => $fqcn,
            'method' => $method,
            'object' => null
        ];
    }
}
