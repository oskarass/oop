<?php

namespace App\Orders;

use App\App;
use App\Orders\Order;
use Core\FileDB;

class Model
{
    private $table_name = 'orders';

    public function __construct()
    {
        App::$db->createTable($this->table_name);
    }

    public function insert (Order $order)
    {
        return App::$db->insertRow($this->table_name, $order->getData());
    }

    public function get($conditions)
    {
        $orders_objects = [];
        $orders_array = App::$db->getRowsWhere($this->table_name, $conditions);

        foreach($orders_array as $order_id => $order_array) {
            $order = new Order($order_array);
            $order->setId($order_id);

            $orders_objects[] = $order;
        }

        return $orders_objects;
    }

    public function getById($row_id) {
        $order_array = App::$db->getRow($this->table_name, $row_id);
        var_dump("get by id", $order_array, $row_id);


        $order = new Order($order_array);
        $order->setId($row_id);

        return $order;
    }

    public function update(Order $order)
    {
        return App::$db->updateRow($this->table_name, $order->getId(), $order->getData());
    }

    public function delete(Order $order)
    {
        return App::$db->deleteRow($this->table_name, $order->getId());
    }
}
