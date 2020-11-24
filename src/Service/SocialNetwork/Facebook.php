<?php

declare(strict_types=1);

namespace Service\SocialNetwork;

class Facebook
{
    public function testSend(string $message): string
    {
        return strtoupper($message);
    }
}

class FacebookAdapter implements ISocialNetwork
{
    private $adaptee;

    public function __construct(Facebook $adaptee)
    {
        $this->adaptee = $adaptee;
    }

    /**
     * @inheritdoc
     */
    public function send(string $message): void
    {
        $test = $this->adaptee->testSend($message);
    }
}
