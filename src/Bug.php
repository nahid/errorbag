<?php

declare(strict_types=1);

namespace Nahid\ErrorBag;

use Exception;

class Bug
{
    /**
     * @var Exception
     */
    protected Exception $exception;

    /**
     * @var false|string
     */
    protected string $name;

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
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * set the exception
     *
     * @param Exception $exception
     * @return $this
     */
    public function setException(Exception $exception): self
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

}