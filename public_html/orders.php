<?php

use App\Drinks\Drink;
use App\Orders\Model;
use App\Views\Form;
use App\Views\Navigation;

require '../bootloader.php';

if ($user = \App\App::$session->getUser()){
    $show_form = true;
}

$views = [];
$views['nav'] = new Navigation();

$modelOrders = new App\Orders\Model();
$orders = $modelOrders->get([]);

$modelDrinks = new \App\Drinks\Model();
$drink = new App\Drinks\Drink();

foreach($orders as $order) {
    $orders_catalog[] = [
        'order' => $order,
        'drink' => $modelDrinks->getById($order->getDrinkId()),
    ];
}

?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="media/css/normalize.css">
        <link rel="stylesheet" href="media/css/milligram.min.css">
        <link rel="stylesheet" href="media/css/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <title>OOP</title>
    </head>
    <body>
    <?php print $views['nav']->render(); ?>
    <?php if($show_form) :?>
        <div class="d-flex justify-content-center mt-5 col-6 mx-auto">
            <table class="text-center">
                <thead>
                <tr>
                    <td>Order ID</td>
                    <td>Drink ID</td>
                    <td>Item name</td>
                    <td>Order date</td>
                </tr>
                </thead>
                <tbody>
            <?php foreach($orders_catalog as $item) :?>
                    <tr>
                        <td><?php print $item['order']->getId(); ?></td>
                        <td><?php print $item['order']->getDrinkId(); ?></td>
                        <td><?php print $item['drink']->getName(); ?></td>
                        <td><?php print date('Y/d/m H:i:s', $item['order']->getTimestamp()); ?></td>
                    </tr>
            <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <?php header('location:login.php'); ?>
    <?php endif; ?>
    </body>
</html>