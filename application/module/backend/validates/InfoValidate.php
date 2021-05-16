<?php

class InfoValidate extends Validate
{
    function __construct($params)
    {
        parent::__construct($params['form']);
    }

    public function validate()
    {
        $this->addRule('name', 'string', ['min' => 3, 'max' => 255])
             ->addRule('telephone', 'string', ['min' => 10, 'max' => 13])
            ->addRule('status', 'status', ['deny' => ['default']]);
        $this->run();
    }
}
