<?php

declare(strict_types=1);

namespace Nahid\ErrorBag;


use Exception;

class Error implements \Iterator
{
    /**
     * @var array[Bug]
     */
    protected array $bag = [];

    /**
     * @var bool
     */
    protected bool $occurred = false;

    /**
     * push an error in error bag
     *
     * @param Exception $exception
     */
    public function push(Exception $exception): void
    {
        $this->setBag(new Bug($exception));

        if (!$this->occurred) {
            $this->occurred = true;
        }
    }

    /**
     * push an error with name in error bag
     *
     * @param string $name
     * @param Exception $exception
     */
    public function pushAs(string $name, Exception $exception): void
    {
        $this->setBag((new Bug($exception))->setName($name));

        if (!$this->occurred) {
            $this->occurred = true;
        }
    }

    /**
     * set bug to the bag
     *
     * @param Bug $bug
     */
    protected function setBag(Bug $bug): void
    {
        array_push($this->bag, $bug);
    }

    /**
     * check has already error occurred
     *
     * @return bool
     */
    public function has(): bool
    {
        return $this->occurred;
    }

    /**
     * get the first occurred error
     *
     * @return Bug|null
     */
    public function first(): ?Bug
    {
        if ($this->has()) {
            return reset($this->bag);
        }

        return null;
    }

    /**
     * get the last occurred error
     *
     * @return Bug|null
     */
    public function last(): ?Bug
    {
        if ($this->has()) {
            return end($this->bag);
        }

        return null;
    }

    /**
     * get all errors
     *
     * @return array
     */
    public function all(): array
    {
        return $this->bag;
    }

    /**
     * get errors as array
     *
     * @return array
     */
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

    /**
     * get errors by name
     *
     * @param string $name
     * @return array|null
     */
    public function get(string $name): ?array
    {
        $errors = array_filter($this->bag, function ($error) use($name) {
            return $name == $error->getName();
        });

        return count($errors) ? $errors : null;
    }

    /**
     * check has errors by name
     *
     * @param string $name
     * @return bool
     */
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

    public function current()
    {
        return current($this->bag);
    }

    public function next()
    {
        return next($this->bag);
    }

    public function key()
    {
        return key($this->bag);
    }

    public function valid()
    {
        return key($this->bag) !== null;
    }

    public function rewind()
    {
        return reset($this->bag);
    }
}