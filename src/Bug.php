<?php

declare(strict_types=1);

namespace Nahid\ErrorBag;

use Exception;

class Bug
{
    protected Exception $exception;
    protected string $name;

    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
        $this->name = get_class($exception);

    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getException(): Exception
    {
        return $this->exception;
    }

    public function getName(): string
    {
        return $this->name;
    }

}