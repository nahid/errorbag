<?php

declare(strict_types=1);

namespace Nahid\ErrorBag;


class Error
{
    /**
     * @var array[Bug]
     */
    protected array $bag = [];

    protected bool $occurred = false;

    public function push(\Exception $exception): void
    {
        $this->setBag(new Bug($exception));

        if (!$this->occurred) {
            $this->occurred = true;
        }
    }

    public function pushAs(string $name, \Exception $exception): void
    {
        $this->setBag((new Bug($exception))->setName($name));

        if (!$this->occurred) {
            $this->occurred = true;
        }
    }

    protected function setBag(Bug $bug): void
    {
        array_push($this->bag, $bug);
    }

    public function has(): bool
    {
        return $this->occurred;
    }

    public function first(): ?Bug
    {
        if ($this->has()) {
            return reset($this->bag);
        }

        return null;
    }

    public function last(): ?Bug
    {
        if ($this->has()) {
            return end($this->bag);
        }

        return null;
    }

    public function all(): array
    {
        return $this->bag;
    }

    public function toArray(): array
    {
        $errors = [];

        /**
         * @var Bug $error
         */
        foreach ($this->bag as $error) {
            $errors[] = [
                'name' => $error->getName(),
                'exception' => $error->getException()
            ];
        }

        return $errors;
    }

    public function get(string $name): ?array
    {
        $errors = array_filter($this->bag, function ($error) use($name) {
            return $name == $error->getName();
        });

        return count($errors) ? $errors : null;
    }

    public function hasName(string $name)
    {
        $return = false;

        foreach ($this->bag as $error) {
            if ($error->getName() == $name) {
                $return = true;
                break;
            }
        }

        return $return;
    }
}