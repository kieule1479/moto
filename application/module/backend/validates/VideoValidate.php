<?php
class VideoValidate extends Validate
{
    //===== __CONSTRUCT ======
    public function __construct($params)
    {        
        $dataForm = $params['form'] ?? [];
        parent::__construct($dataForm);
    }

    //===== VALIDATE ======
    public function validate($model)
    {      
        
        $queryName = "SELECT `id` FROM " . TBL_CATEGORY . " WHERE `name` = '{$this->source['name']}'";
        if (isset($this->source['id'])) {
            $queryName .= " AND `id` <> '{$this->source['id']}'";
        }
        $this->addRule('name', 'string', ['min'=>3, 'max'=>20000])      
        ->addRule('status', 'status', ['deny' => ['default']])
        ->addRule('picture', 'file', ['min' => 1, 'max' => 1000000, 'extension' => ['jpg', 'jpeg', 'png']], false);
        $this->run();
    }
}
