<?php


namespace Framework;

use Symfony\Component\HttpFoundation\Request;

class Process implements ICommand
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var ReceiverProcess
     */
    private $receiverProcess;

    /**
     * @var array
     */
    private $data = array();

    /**
     * Process constructor.
     * @param Request $request
     * @param ReceiverProcess $receiverProcess
     */
    public function __construct(Request $request, ReceiverProcess $receiverProcess)
    {
        $this->request = $request;
        $this->receiverProcess = $receiverProcess;
    }

    public function execute(): void
    {
        $this->data["Response"] = $this->receiverProcess->process($this->request);
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
