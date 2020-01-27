<?php

use App\Drinks\Drink;
use App\Views\Form;
use App\Views\Navigation;
use App\Orders\Order;

require '../bootloader.php';

if ($user = \App\App::$session->getUser()){
    $show_form = true;
} else {
    $show_form = false;
}

function form_success_edit($input, &$form)
{
    $modelDrinks = new \App\Drinks\Model();
    $input['id'] = (int) $input['id'];
    $drink = new App\Drinks\Drink($input);
    $modelDrinks->update($drink);
}

function form_fail_edit(&$form, $input)
{
    $form['message'] = 'Edit failed!';
}


$modelDrinks = new \App\Drinks\Model();
$drink = $modelDrinks->getById($_GET['id']);
$drink_array = $drink->getData();

$form_edit = [
    'callbacks' => [
        'success' => 'form_success_edit',
        'fail' => 'form_fail_edit'
    ],
    'attr' => [
        'method' => 'POST',
        'class' => 'my-form',
        'id' => 'login-form',
    ],
    'fields' => [
        'id' => [
            'type' => 'hidden',
            'value' =>  $_GET['id'],
        ],
        'name' => [
            'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'label' => 'Pavadinimas',
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
            'label' => 'Kiekis',
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
            'label' => 'Abarot',
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
            'label' => 'Image',
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
            'label' => 'Price',
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
            'label' => 'In Stock',
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
        'edit' => [
            'title' => 'Edit',
            'extra' => [
                'attr' => [
                    'class' => 'btn btn-success save-btn',
                ]
            ]
        ]
    ],
];

$form_edit['fields']['name']['value'] = $drink_array['name'];
$form_edit['fields']['amount_ml']['value'] = $drink_array['amount_ml'];
$form_edit['fields']['abarot']['value'] = $drink_array['abarot'];
$form_edit['fields']['image']['value'] = $drink_array['image'];
$form_edit['fields']['price']['value'] = $drink_array['price'];
$form_edit['fields']['in_stock']['value'] = $drink_array['in_stock'];

$views = [];
$views['form'] = new Form($form_edit);
$views['nav'] = new Navigation();

if (!empty($_POST)) {
    $safe_input = get_form_input($form_edit);
    $success = validate_form($safe_input, $form_edit);
} else {
    $success = false;
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
        <div class="form-container border p-3 col-3 d-flex flex-column justify-content-center mx-auto mt-5 text-center">
            <h3>Edit drink</h3>
            <?php print $views['form']->render(); ?>
        </div>
    <?php endif; ?>
    </body>
</html>
