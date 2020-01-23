<?php

namespace Core;

use App\Users\Model;
use App\Users\User;

class Session
{
    /** @var \App\Users\Model */
    private $model;

    /** @var \App\Users\User */
    private $user;

    public function __construct()
    {
        $this->model = new \App\Users\Model();

        $this->loginFromCookie();
    }

    public function loginFromCookie()
    {
        if($_SESSION) {
            $this->login($_SESSION['email'], $_SESSION['password']);
        }
    }

    public function login($email, $password)
    {
        $users = $this->model->get(
          [
              'email' => $email,
              'password' => $password
          ]
        );

        if(!empty($users)) {
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;
            $this->user = $users[0];

            return true;
        }

        return false;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function userLoggedIn()
    {
        if (!empty($_SESSION)) {
            $users = $this->model->get([
                'email' => $_SESSION['email'],
                'password' => $_SESSION['password'],
            ]);

            if (!empty($users)) {
                return true;
            }
        } else {
            return false;
        }
    }

    public function logout()
    {
        $_SESSION = [];
        session_destroy();
        setcookie(session_name(), null, -1);
        header("location: login.php");
    }

}