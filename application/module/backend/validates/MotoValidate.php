<?php
class MotoValidate extends Validate
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
        // echo '<pre>';
        // print_r($this->source);
        // echo '</pre>';

         //$count = count($this->source['picture']['name']);


        //  die('<h3>Pause</h3>');


        $queryUsername = "SELECT `id` FROM " . TBL_USER . " WHERE `username` = '{$this->source['username']}'";
        $queryEmail = "SELECT `id` FROM " . TBL_USER . " WHERE `email` = '{$this->source['email']}'";
        if (isset($this->source['id'])) {
            $queryUsername .= " AND `id` <> '{$this->source['id']}'";
            $queryEmail .= " AND `id` <> '{$this->source['id']}'";
        } else {
            //$this->addRule('password', 'string', ['min' => 8, 'max' => 32]);
        }

        $this->addRule('name', 'string', ['min' => 3, 'max' => 255])
            ->addRule('short_description', 'string', ['min' => 1, 'max' => 1255])
            ->addRule('description', 'string', ['min' => 1, 'max' => 1000000])
            ->addRule('price', 'int', ['min' => 1, 'max' => 255])
            ->addRule('sale_off', 'int', ['min' => 1, 'max' => 255])
            ->addRule('category_id', 'status', ['deny' => ['default']])
            ->addRule('status', 'status', ['deny' => ['default']])
            ->addRule('special', 'status', ['deny' => ['default']])
            ->addRule('picture', 'file', ['min' => 1, 'max' => 10000000000, 'extension' => ['jpg', 'png']], false)
            ->addRule('gallery', 'muti_file', ['min' => 1, 'max' => 10000000000000000, 'extension' => ['jpg', 'png']], false);
            
        $this->run();
    }
}
