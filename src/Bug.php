<?php

declare(strict_types=1);

namespace Nahid\ErrorBag;

use Exception;

/**
 * Class Bug
 * @package Nahid\ErrorBag
 */
class Bug implements \ArrayAccess
{
    /**
     * @var ?Exception
     */
    protected ?Exception $exception = null;

    /**
     * @var ?string
     */
    protected ?string $name = null;

    /**
     * Bug constructor.
     * @param Exception $exception
     */
    public function __construct(Exception $exception)
    {
        $this->setException($exception);
        $this->setName(get_class($exception));

    }

    /**
     * set the error name
     *
     * @param ?string $name
     * @return $this
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * set the exception
     *
     * @param ?Exception $exception
     * @return $this
     */
    public function setException(?Exception $exception): self
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * get the exception
     *
     * @return Exception
     */
    public function getException(): Exception
    {
        return $this->exception;
    }

    /**
     * get the name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        if ($offset !== 'name' && $offset !== 'exception') return false;

        return true;
    }

    public function offsetGet($offset)
    {

        if ($offset === 'name') {
            return $this->getName();
        }

        if ($offset === 'exception') {
            return $this->getException();
        }

        return null;
    }

    public function offsetSet($offset, $value)
    {
        throw new \Exception($offset . ' are immutable, you can not change it!');
    }

    public function offsetUnset($offset)
    {
        throw new \Exception($offset . ' are immutable, you can not change it!');
    }
}