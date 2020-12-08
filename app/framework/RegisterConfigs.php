<?php

declare(strict_types=1);

namespace Framework;

class RegisterConfigs implements ICommand
{
    /**
     * @var ReceiverRegisterConfigs
     */
    private $receiverRegisterConfigs;

    /**
     * @var array
     */
    private $data = array();

    public function __construct(ReceiverRegisterConfigs $receiverRegisterConfigs)
    {
        $this->receiverRegisterConfigs = $receiverRegisterConfigs;
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        $this->data['containerBuilder'] = $this->receiverRegisterConfigs->registerConfigs();
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        $trace = debug_backtrace();
        trigger_error(
            'Неопределенное свойство в __get(): ' . $name .
            ' в файле ' . $trace[0]['file'] .
            ' на строке ' . $trace[0]['line'],
            E_USER_NOTICE
        );
        return null;
    }
}
