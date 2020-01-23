<?php

use App\Users\User;
Use App\Views\Form;
use App\Views\Navigation;
use Core\View;

require '../bootloader.php';

function form_success($input, &$form)
{
    $modelUsers = new \App\Users\Model();
    $user = new App\Users\User($input);
    $modelUsers->insert($user);
    $form['message'] = 'Registration successful!';
}

function form_fail(&$form, $input)
{
    $form['message'] = 'Register failed!';
}

$form = [
    'callbacks' => [
        'success' => 'form_success',
        'fail' => 'form_fail'
    ],
    'attr' => [
        'method' => 'POST',
        'class' => 'my-form',
        'id' => 'login-form',
    ],
    'fields' => [
        'name' => [
            'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'label' => 'name',
            'type' => 'text',
            'option' => [
                'option_one',
                'option_two',
            ],
            'value' => '',
            'extra' => [
                'validators' => [
                    'validate_not_empty',
                ],
                'attr' => [
                    'placeholder' => 'name',
                    'class' => 'form-control',
                ]
            ]
        ],
        'email' => [
            'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'label' => 'eMail',
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
                'validators' => [
                    'validate_not_empty',
                ],
                'attr' => [
                    'placeholder' => 'eMail',
                    'class' => 'form-control',
                ]
            ]
        ],
        'password' => [
            'filter' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'label' => 'Password',
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
                'validators' => [
                    'validate_not_empty',
                ],
                'attr' => [
                    'placeholder' => 'Password',
                    'class' => 'form-control',
                ]
            ]
        ],
    ],
    'buttons' => [
        'save' => [
            'title' => 'Register',
            'extra' => [
                'attr' => [
                    'class' => 'btn btn-success save-btn',
                ]
            ]
        ]
    ],
];

if (!empty($_POST)) {
    $safe_input = get_form_input($form);
    $success = validate_form($safe_input, $form);
} else {
    $success = false;
}

$modelUsers = new App\Users\Model();
$users = $modelUsers->get([]);

$views = [];
$views['form'] = new Form($form);
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
        <div class="form-container d-flex justify-content-center mt-5 text-center">
            <?php print $views['form']->render(); ?>
        </div>
    </body>
</html>