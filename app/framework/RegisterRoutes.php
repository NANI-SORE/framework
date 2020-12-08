<?php


namespace Framework;

class RegisterRoutes implements ICommand
{
    /**
     * @var ReceiverRegisterRoutes
     */
    private $receiverRegisterRoutes;

    /**
     * @var array
     */
    private $data = array();

    /**
     * RegisterRoutes constructor.
     * @param ReceiverRegisterRoutes $receiverRegisterRoutes
     */
    public function __construct(ReceiverRegisterRoutes $receiverRegisterRoutes)
    {
        $this->receiverRegisterRoutes = $receiverRegisterRoutes;
    }

    public function execute(): void
    {
        $this->data['routeCollection'] = $this->receiverRegisterRoutes->registerRoutes();
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
