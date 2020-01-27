<?php

use App\Drinks\Drink;
use App\Orders\Order;
use App\Views\Form;
use App\Views\Navigation;
use Core\View;

require '../bootloader.php';

if ($user = \App\App::$session->getUser()){
    $show_form = true;
} else {
    $show_form = false;
}

function form_success_create($input, &$form)
{
    $modelDrinks = new \App\Drinks\Model();
    $drink = new App\Drinks\Drink($input);
    $modelDrinks->insert($drink);
}

function form_fail_create(&$form, $input)
{
    $form['message'] = 'Form failed!';
}

function form_success_delete($input, &$form)
{
    $modelDrinks = new \App\Drinks\Model();
    $drink = new App\Drinks\Drink($input);
    $modelDrinks->delete($drink);
}

function form_fail_delete(&$form, $input)
{
    $form['message'] = 'Form failed!';
}

function form_success_order($input, &$form)
{
    $modelOrders = new \App\Orders\Model();
    $order = new App\Orders\Order([
        'drink_id' => $input['id'],
        'timestamp' => time(),
        'status' => 'Pending'
    ]);
    $modelOrders->insert($order);

    $modelDrinks = new \App\Drinks\Model();

    $drink = $modelDrinks->getById($input['id']);

    $new_stock = $drink->getInStock() -1;
    $drink->setInStock($new_stock);

    $modelDrinks->update($drink);
}

function form_fail_order(&$form, $input)
{
    $form['message'] = 'Form failed!';
}

$form_create = [
    'callbacks' => [
        'success' => 'form_success_create',
        'fail' => 'form_fail_create'
    ],
    'attr' => [
        'method' => 'POST',
        'class' => 'my-form',
        'id' => 'login-form',
    ],
    'fields' => [
        'name' => [
            'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'label' => '',
            'type' => 'text',
            'validators' => [
                'validate_not_empty',
            ],
            'option' => [
                'option_one',
                'option_two',
            ],
            'value' => '',
            'extra' => [
                'attr' => [
                    'placeholder' => 'Pavadinimas',
                    'class' => 'form-control',
                ]
            ]
        ],
        'amount_ml' => [
            'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'label' => '',
            'type' => 'text',
            'validators' => [
                'validate_not_empty',
            ],
            'option' => [
                'option_one',
                'option_two',
            ],
            'value' => '',
            'extra' => [
                'attr' => [
                    'placeholder' => 'Kiekis (ml)',
                    'class' => 'form-control',
                ]
            ]
        ],
        'abarot' => [
            'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'label' => '',
            'type' => 'number',
            'validators' => [
                'validate_not_empty',
            ],
            'option' => [
                'option_one',
                'option_two',
            ],
            'value' => '',
            'extra' => [
                'attr' => [
                    'placeholder' => 'Abarotai (%)',
                    'class' => 'form-control',
                ]
            ]
        ],
        'image' => [
            'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'label' => '',
            'type' => 'text',
            'validators' => [
                'validate_not_empty',
            ],
            'option' => [
                'option_one',
                'option_two',
            ],
            'value' => '',
            'extra' => [
                'attr' => [
                    'placeholder' => 'Nuotrauka (url)',
                    'class' => 'form-control',
                ]
            ]
        ],
        'price' => [
            'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'label' => '',
            'type' => 'text',
            'validators' => [
                'validate_not_empty',
            ],
            'option' => [
                'option_one',
                'option_two',
            ],
            'value' => '',
            'extra' => [
                'attr' => [
                    'placeholder' => 'Price (Eur)',
                    'class' => 'form-control',
                ]
            ]
        ],
        'in_stock' => [
            'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'label' => '',
            'type' => 'text',
            'validators' => [
                'validate_not_empty',
            ],
            'option' => [
                'option_one',
                'option_two',
            ],
            'value' => '',
            'extra' => [
                'attr' => [
                    'placeholder' => 'Items in Stock',
                    'class' => 'form-control',
                ]
            ]
        ],
    ],
    'buttons' => [
        'create' => [
            'title' => 'Sukurti',
            'extra' => [
                'attr' => [
                    'class' => 'btn btn-success save-btn',
                ]
            ]
        ]
    ],
];

$form_delete = [
    'callbacks' => [
        'success' => 'form_success_delete',
        'fail' => 'form_fail_delete'
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
        'delete' => [
            'title' => 'Delete',
            'extra' => [
                'attr' => [
                    'class' => 'btn btn-danger save-btn',
                ]
            ]
        ]
    ],
];

$form_edit = [
    'callbacks' => [
        'success' => 'form_success_edit',
        'fail' => 'form_fail_edit'
    ],
    'attr' => [
        'method' => 'GET',
        'class' => 'my-form',
        'action' => 'edit-drink.php'
    ],
    'fields' => [
        'id' => [
            'type' => 'hidden',
        ]
    ],
    'buttons' => [
        'edit' => [
            'title' => 'Edit',
            'extra' => [
                'attr' => [
                    'class' => 'btn btn-danger save-btn',
                ]
            ]
        ]
    ],
];

$form_order = [
    'callbacks' => [
        'success' => 'form_success_order',
        'fail' => 'form_fail_order'
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
        'order' => [
            'title' => 'Order',
            'extra' => [
                'attr' => [
                    'class' => 'btn btn-danger save-btn',
                ]
            ]
        ]
    ],
];

$catalog = [];

if (!empty($_POST)) {
    switch (get_form_action()) {
        case 'delete':
            $safe_input = get_form_input($form_delete);
            $success = validate_form($safe_input, $form_delete);
            break;
        case 'create':
            $safe_input = get_form_input($form_create);
            $success = validate_form($safe_input, $form_create);
            break;
        case 'order':
            $safe_input = get_form_input($form_order);
            $success = validate_form($safe_input, $form_order);
            break;
        case 'edit':
            $safe_input = get_form_input($form_edit);
            $success = validate_form($safe_input, $form_edit);
            break;
    }
} else {
    $success = false;
}

$modelDrinks = new App\Drinks\Model();
$drinks = $modelDrinks->get([]);

foreach ($drinks as $drink) {
    $form_delete['fields']['id']['value'] = $drink->getId();
    $form_order['fields']['id']['value'] = $drink->getId();
    $form_edit['fields']['id']['value'] = $drink->getId();

    $catalog[] = [
        'dataholder' => $drink,
        'form_delete' => new Form($form_delete),
        'form_order' => new Form($form_order),
        'form_edit' => new Form($form_edit)
    ];
}

$views = [];
$views['form'] = new Form($form_create);
$views['nav'] = new Navigation();

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
        <div class="d-flex justify-content-around">
            <div class="m-5 p-3 col-3 text-center border">
                <h3>Profile</h3>
                <img src="https://i.pinimg.com/originals/0a/ee/a9/0aeea9c36b606902cf17f56048cd30c6.jpg" width="200px">
                <h2 class="my-3">eMail: <?php print $user->getEmail(); ?></h2>
                <h2>UserID: <?php print $user->getName() ?></h2>
            </div>
            <div class="form-container border p-3 col-3 d-flex flex-column justify-content-center mt-5 text-center">
                <h3>Add a drink</h3>
                <?php print $views['form']->render(); ?>
            </div>
        </div>
    <?php endif; ?>
        <div class="d-flex justify-content-around mt-5">
            <?php foreach($catalog as $item) :?>
                <div class="card" style="width: 18rem;">
                    <img class="card-img-top" src="<?php print $item['dataholder']->getImage();?>">
                    <div class="card-body text-center">
                        <h1 class="card-title mb-5"><?php print $item['dataholder']->getName(); ?></h1>
                        <h3 class="card-text"><?php print $item['dataholder']->getAbarot(); ?> &#176;</h3>
                        <h3 class="card-text"><?php print $item['dataholder']->getAmountMl(); ?> ml</h3>
                        <h3 class="card-text">$<?php print $item['dataholder']->getPrice(); ?></h3>
                        <h3 class="card-text">Amount in Stock: <?php print $item['dataholder']->getInStock(); ?></h3>
                        <?php if (App\App::$session->userLoggedIn()) : ?>
                            <div class="d-flex justify-content-around mt-4">
                                <?php print $item['form_delete']->render(); ?>
                                <?php print $item['form_edit']->render(); ?>
                            </div>
                            <?php else :?>
                            <div class="mt-4">
                                <?php print $item['form_order']->render(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </body>
</html>
