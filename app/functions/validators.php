<?php

function validate_login($filtered_input, &$form) {
    $success = App\App::$session->login($filtered_input['email'], $filtered_input['password']);

    if (!$success) {
        $form['fields']['email']['error'] = 'Neteisingai įvesti duomenys!';
        $form['fields']['password']['error'] = 'Neteisingai įvesti duomenys!';
        return false;
    }

    return true;
}

function validate_mail($field_value, &$field) {
    $modelUser = new \App\Users\Model();
    $users = $modelUser->get(['email' => $field_value]);
    if ($users) {
        $field['error'] = 'Vartotojas tokiu el.paštu jau registruotas!';
        return false;
    }
    
    return true;
}