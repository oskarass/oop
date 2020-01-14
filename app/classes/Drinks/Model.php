<?php

namespace App\Drinks;

use Core\FileDB;

Class Model

{
    private $table_name = 'drinks';
    private $db;

    public function __construct()
    {
        $this->db = new FileDB(DB_FILE);
        $this->db->createTable($this->table_name);
    }

    public function insert(Drink $drink)
    {
        return $this->db->insertRow($this->table_name, $drink->getData());
    }

    public function get($conditions)
    {
        $drinks_objects = [];
        $drinks_array = $this->db->getRowsWhere($this->table_name, $conditions);

        foreach($drinks_array as $drink_id => $drink_array) {
            $drink = new Drink($drink_array);
            $drink->setId($drink_id);
            
            $drinks_objects[] = new $drink;
        }

        return $drinks_objects;
    }

}