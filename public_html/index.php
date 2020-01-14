<?php

require '../bootloader.php';

$DB = new \Core\FileDB(DB_FILE);

$modelDrinks = new \App\Drinks\Model();

$drink = new App\Drinks\Drink([
        'name' => 'Svaboda',
        'abarot' => 55,
        'amount_ml' => 700,
        'image' => '/media/images/svoboda.png'
]);

$drinks = $modelDrinks->get([
        'abarot' => 55,
]);

foreach ($drinks as $drink) {
    var_dump($drink->getName());
}

$DB->load();
$DB->createTable('drinks');

?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="media/css/normalize.css">
        <link rel="stylesheet" href="media/css/milligram.min.css">
        <link rel="stylesheet" href="media/css/style.css">		
        <title>OOP</title>
    </head>
    <body>
    </body>
</html>
