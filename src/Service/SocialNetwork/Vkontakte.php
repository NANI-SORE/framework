<?php

declare(strict_types=1);

namespace Service\SocialNetwork;

class Vkontakte
{
    public function testSend(string $message): string
    {
        return strtoupper($message);
    }
}

class VKAdapter implements ISocialNetwork
{
    private $adaptee;

    public function __construct(Vkontakte $adaptee)
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
