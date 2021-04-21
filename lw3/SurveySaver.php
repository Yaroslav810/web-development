<?php
    include('./inc/common.inc.php');

    header('Content-Type: text/plane');


    $user = [
        'firstName' => getGETParameter('first_name'),
        'lastName' => getGETParameter('last_name'),
        'email' => getGETParameter('email'),
        'age' => getGETParameter('age'),
    ];
    $error = '';

    if (!saveDataByEmail($user, $error))
    {
        echo $error;
    }