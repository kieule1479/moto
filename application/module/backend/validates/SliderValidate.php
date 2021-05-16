<?php

class SliderValidate extends Validate
{
    function __construct($params)
    {
        parent::__construct($params['form']);
    }

    public function validate()
    {
       
        $this->addRule('name', 'string', ['min' => 3, 'max' => 255])
            ->addRule('status', 'status', ['deny' => ['default']])
            ->addRule('ordering', 'status', ['deny' => ['default']])
            ->addRule('picture', 'file', ['min' => 1, 'max' => 1000000, 'extension' => ['jpg', 'png']], false);
       
        $this->run();
    }
}
