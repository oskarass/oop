<?php

namespace Core;

class FileDB
{

    private $file_name;
    private $data;

    public function __construct($file_name)
    {
        $this->file_name = $file_name;
    }

    public function setData($data_array)
    {
        $this->data = $data_array;
    }

    public function save()
    {
        $encoded_array = json_encode(($this->data));
        $bits_written = file_put_contents($this->file_name, $encoded_array);
        if ($bits_written !== false) {
            return true;
        }

        return false;
    }

    public function load()
    {
        if(file_exists($this->file_name)) {
            $content = file_get_contents($this->file_name);
            $this->data = json_decode($content, true);
        } else {
            $this->data = [];
        }
    }

    public function getData()
    {
        return $this->data;
    }

    public function createTable($table_name)
    {
        if($this->tableExists($table_name)) {
            $this->data[$table_name] = [];
            return true;
        }

        return false;
    }

    public function tableExists($table_name)
    {
        if(!isset($this->data[$table_name])) {
            return true;
        }

        return false;
    }

    public function dropTable($table_name)
    {
        if(isset($this->data[$table_name])) {
            unset($this->data[$table_name]);
        }
    }

    public function truncateTable($table_name)
    {
        $this->data[$table_name] = [];
    }

    public function insertRow($table_name, $row, $row_id = null)
    {
        if ($row_id) {
            if(!($this->rowExists($table_name, $row_id))) {
            $this->data[$table_name][$row_id] = $row;
            return $row_id;
            } else {
                return false;
            }
        } else {
            $this->data[$table_name][] = $row;
            return array_key_last($this->data[$table_name]);
        }
    }

    public function rowExists($table_name, $row_id)
    {
        if(isset($table_name[$row_id])) {
            return true;
        }

        return false;
    }

    public function updateRow($table_name, $row_id, $row)
    {
        if($this->rowExists($table_name, $row_id)) {
            $this->data[$table_name] = $row;
            return true;
        }
        return false;

    }

    public function deleteRow($table_name, $row_id)
    {
        if($this->rowExists($table_name, $row_id)) {
            unset($this->data[$table_name][$row_id]);
            return true;
        } else {
            return false;
        }
    }

    public function getRow($table_name, $row_id)
    {
        if($this->rowExists($table_name, $row_id)) {
            return $this->data[$table_name][$row_id];
        }

        return false;
    }

    public function getRowsWhere($table_name, array $conditions)
    {
        $results = [];
        foreach($this->data[$table_name] as $row_id => $row) {
            $found = true;
            foreach($conditions as $cond_key => $cond_value) {
                $row_value = $row[$cond_key];
                if($cond_value != $row_value) {
                    $found = false;
                    break;
                }
            }
            if($found) {
                $results[$row_id] = $row;
            }
        }
        return $results;
    }

    public function __destruct()
    {
        $this->save();
    }
}
