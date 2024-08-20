<?php

class FormController {
    /**
     * @var FormHandler
     */
    private FormHandler $formHandler;

    /**
     * @param FormHandler $formHandler
     */
    public function __construct(FormHandler $formHandler) {
        $this->formHandler = $formHandler;
    }

    /**
     * @return void
     */
    public function handleRequest(): void
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->formHandler->handleRequest($_POST);
        }
    }
}
