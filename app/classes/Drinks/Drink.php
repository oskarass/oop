<?php

namespace App\Drinks;

class Drink
{
    private $data;

    private $properties = [
        'id', 'name', 'amount_ml', 'abarot', 'image', 'price', 'in_stock'
    ];

    public function __construct(array $data = null)
    {
        if($data) {
            $this->setData($data);
        }
    }

    public function setName(string $name) {
        $this->data['name'] = $name;
    }

    public function getName() {
        return $this->data['name'] ?? null;
    }

    public function setAmountMl(int $amount_ml) {
        $this->data['amount_ml'] = $amount_ml;

    }

    public function getAmountMl() {
        return $this->data['amount_ml'];
    }

    public function setAbarot(float $abarot) {
        $this->data['abarot'] = $abarot;
    }

    public function getAbarot() {
        return $this->data['abarot'];
    }

    public function setImage(string $url) {
        $this->data['image'] = $url;
    }

    public function getImage() {
        return $this->data['image'];
    }

    public function setPrice(float $price) {
        $this->data['price'] = $price;
    }

    public function getPrice() {
        return $this->data['price'];
    }

    public function setInStock(int $in_stock) {
        $this->data['in_stock'] = $in_stock;
    }

    public function getInStock() {
        return $this->data['in_stock'];
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