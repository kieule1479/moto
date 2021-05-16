<?php
class NewsValidate extends Validate
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
        $this->addRule('title', 'string-notExistRecord', ['database' => $model, 'query' => $queryName, 'min' => 3, 'max' => 1000])
        ->addRule('short_description', 'string', ['min'=>3, 'max'=>1000])
        ->addRule('description', 'string', ['min'=>3, 'max'=>20000])
        ->addRule('link', 'url')
        ->addRule('status', 'status', ['deny' => ['default']])
        ->addRule('picture', 'file', ['min' => 1, 'max' => 1000000, 'extension' => ['jpg', 'jpeg', 'png']], false);
        $this->run();
    }
}
