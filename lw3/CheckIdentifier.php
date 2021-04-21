<?php
    include('./inc/common.inc.php');

    header("Content-Type: text/plain");

    $identifier = getGETParameter('identifier');
    try {
        if (isIdentifier($identifier))
        {
            echo 'Yes';
        }
    }
    catch (Exception $e) {
        echo "No" . PHP_EOL . $e->getMessage();
    }
