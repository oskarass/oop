<?php

namespace App\Views;

use App\App;

class Navigation extends \Core\View
{

    public function __construct()
    {
        $this->data = [
            'left' => [
                [
                    'title' => 'Home',
                    'url' => '/'
                ]
            ],
            'right' => [
                'orders' => [
                    'title' => 'Orders',
                    'url' => '/orders.php'
                ],
                'login' => [
                    'title' => 'Login',
                    'url' => '/login.php'
                ],
                'register' => [
                    'title' => 'Register',
                    'url' => '/register.php'
                ],
                'logout' => [
                    'title' => 'Logout',
                    'url' => 'logout.php'
                ]
            ]
        ];

        if(App::$session->userLoggedIn()) {
            unset($this->data['right']['login']);
            unset($this->data['right']['register']);
        } else {
            unset($this->data['right']['logout']);
            unset($this->data['right']['orders']);
        }

    }

    public function render($template_path = ROOT . '\App\templates\navigation.tpl.php')
    {
        return parent::render($template_path);
    }
}
