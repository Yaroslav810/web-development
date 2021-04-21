<?php

    include('./inc/common.inc.php');

    header('Content-Type: text/plane');

    $password = getGETParameter('password');

    $passwordStrength = getPasswordStrength($password);
    if (!is_null($passwordStrength))
    {
        echo $passwordStrength;
    }