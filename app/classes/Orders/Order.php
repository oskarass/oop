<?php

namespace App\Orders;

class Order

{
    private $data;

    private $properties = [
        'id', 'drink_id', 'timestamp'
    ];

    public function __construct(array $data = null)
    {
        if($data) {
            $this->setData($data);
        }
    }

    public function setDrinkId(int $drink_id) {
        $this->data['drink_id'] = $drink_id;
    }

    public function getDrinkId() {
        return $this->data['drink_id'] ?? null;
    }

    public function setTimestamp(int $timestamp) {
        $this->data['timestamp'] = $timestamp;
    }

    public function getTimestamp() {
        return $this->data['timestamp'] ?? null;
    }

    public function setData(array $data) {

        foreach($this->properties as $property) {

            if(isset($data[$property])) {
                $value = $data[$property];
                $setter = str_replace('_', '', 'set' . $property);

                $this->{$setter}($value);
            }
        }
    }

    public function getData() {
        $data = [];

        foreach($this->properties as $property) {
            $getter = str_replace('_', '', 'get' . $property);

            $data[$property] = $this->{$getter}();
        }

        return $data;

    }

    public function setId(int $id) {
        $this->data['id'] = $id;
    }

    public function getId() {
        return $this->data['id'] ?? null;
    }
}