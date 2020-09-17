<?php

use Nahid\ErrorBag\Error;
use PHPUnit\Framework\TestCase;

class ErrorBagTest extends TestCase
{
    protected Error $errorBag;

    protected function setUp(): void
    {
        $this->errorBag = new Error();
    }

    public function testErrorPush()
    {
        $this->errorBag->push(new \Exception("What Happened"));
        $this->assertCount(1, $this->errorBag->all());
        return $this->errorBag;
    }

    /**
     * @depends testErrorPush
     * @param Error $error
     */
    public function testErrorPushAsFirstName(Error $error)
    {
        $this->errorBag = $error;
        $this->errorBag->pushAs('first_name', new \Exception("Hashemi"));
        $this->assertCount(2, $this->errorBag->all());
        return $this->errorBag;
    }

    /**
     * @depends testErrorPushAsFirstName
     * @param Error $error
     */
    public function testErrorPushAsLastName(Error $error)
    {
        $this->errorBag = $error;
        $this->errorBag->pushAs('last_name', new \Exception("Rafsan"));
        $this->assertCount(3, $this->errorBag->all());
        return $this->errorBag;
    }

    /**
     * @depends testErrorPushAsFirstName
     * @param Error $error
     */
    public function testGetErrorByName(Error $error)
    {
        $this->errorBag = $error;
        $this->assertCount(1, $this->errorBag->get('first_name'));
    }

    /**
     * @depends testErrorPushAsLastName
     * @param Error $error
     */
    public function testHasErrorByName(Error $error)
    {
        $this->errorBag = $error;
        $this->assertTrue($this->errorBag->hasName('last_name'));
    }

    /**
     * @depends testErrorPushAsLastName
     * @param Error $error
     */
    public function testFirstBugName(Error $error)
    {
        $this->errorBag = $error;
        $this->assertSame('Exception', $this->errorBag->first()->getName());
    }

    /**
     * @depends testErrorPushAsLastName
     * @param Error $error
     */
    public function testLastBugName(Error $error)
    {
        $this->errorBag = $error;
        $this->assertSame('last_name', $this->errorBag->last()->getName());
    }
}