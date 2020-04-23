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

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * A simple controller dispatcher middleware
 *
 * It will check if there is route in the request attributes. If there is a
 * route it will take the handler and check if it is a string and tries to
 * resolve it against the DI container.
 */
class Dispatcher implements DispatcherInterface
{
    /**
     * @var string
     */
    protected $defaultNamespace = '';

    /**
     * @var string
     */
    protected $methodSeparator = '@';

    /**
     * @var string
     */
    protected $namespaceSeparator = '.';

    /**
     * @var string
     */
    protected $classTemplate = '{namespace}{className}';

    /**
     * @var array
     */
    protected $classParts = [];

    /**
     * @var \Psr\Container\ContainerInterface;
     */
    protected $container;

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

    /**
     * @inheritDoc
     */
    public function dispatch(
        ServerRequestInterface $request,
        $handler
    ): ?ResponseInterface {
        if (is_string($handler)) {
            $handler = $this->stringHandler($handler, $request);
        }

        if ($handler instanceof RequestHandlerInterface) {
            return $handler->handle($request);
        }

        if (is_callable($handler)) {
            return $handler($request);
        }

        return null;
    }

    /**
     * @param string $handler Handler String
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return mixed
     */
    protected function stringHandler(
        string $handler,
        ServerRequestInterface $request
    ) {
        $result = $this->parseString($handler);

        if (!$this->container->has($result['className'])) {
            return null;
        }

        $handler = $this->container->get($result['className']);

        if ($result['method'] === null) {
            return $handler;
        }

        return $handler->{$result['method']}($request);
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
            'method' => $method
        ];
    }
}
