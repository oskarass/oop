<?php

use App\Drinks\Drink;
use App\Orders\Model;
use App\Views\Form;
use App\Views\Navigation;

require '../bootloader.php';

if ($user = \App\App::$session->getUser()){
    $show_form = true;
}

function form_success_deliver($input, &$form)
{
    $modelOrders = new \App\Orders\Model();
    $input['id'] = (int) $input['id'];

    $order = $modelOrders->getById($input['id']);
    $order->setStatus('Delivered');

    $modelOrders->update($order);
}

function form_fail_deliver(&$form, $input)
{
    $form['message'] = 'Deliver failed!';
}

$form_deliver = [
    'callbacks' => [
        'success' => 'form_success_deliver',
        'fail' => 'form_fail_deliver'
    ],
    'attr' => [
        'method' => 'POST',
        'class' => 'my-form',
    ],
    'fields' => [
        'id' => [
            'type' => 'hidden',
        ]
    ],
    'buttons' => [
        'deliver' => [
            'title' => 'Deliver',
            'extra' => [
                'attr' => [
                    'class' => 'btn btn-danger save-btn',
                ]
            ]
        ]
    ],
];

$views = [];
$views['nav'] = new Navigation();


if (!empty($_POST)) {
    $safe_input = get_form_input($form_deliver);
    $success = validate_form($safe_input, $form_deliver);
}

$modelDrinks = new \App\Drinks\Model();
$drink = new App\Drinks\Drink();

$modelOrders = new App\Orders\Model();
$orders = $modelOrders->get([]);


foreach($orders as $order) {
    $form_deliver['fields']['id']['value'] = $order->getId();

    $orders_catalog[] = [
        'order' => $order,
        'drink' => $modelDrinks->getById($order->getDrinkId()),
        'form_deliver' => new Form($form_deliver)
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
        <div class="d-flex justify-content-center mt-5 col-10 mx-auto">
            <table class="text-center">
                <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Drink ID</th>
                    <th>Drink name</th>
                    <th>Order date</th>
                    <th>Status</th>
                    <th>Deliver</th>
                </tr>
                </thead>
                <tbody>
            <?php foreach($orders_catalog as $item) :?>
                    <tr>
                        <td><?php print $item['order']->getId(); ?></td>
                        <td><?php print $item['order']->getDrinkId(); ?></td>
                        <td><?php print $item['drink']->getName(); ?></td>
                        <td><?php print date('Y/d/m H:i:s', $item['order']->getTimestamp()); ?></td>
                        <td><?php print $item['order']->getStatus(); ?></td>
                        <td>
                            <?php if($item['order']->getStatus() == 'Delivered') : ?>
                                <p>&#10004;</p>
                            <?php else : ?>
                                <?php print $item['form_deliver']->render(); ?>
                            <?php endif; ?>
                        </td>
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