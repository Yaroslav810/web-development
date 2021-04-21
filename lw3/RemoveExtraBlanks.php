<?php
    include('./inc/common.inc.php');

    header("Content-Type: text/plain");

    $text = getGETParameter('text');
    if ($text)
    {
        $text = trim($text);
        $text = preg_replace('/\s+/', ' ', $text);
        echo $text;
    }
    else
    {
        echo 'Parameter "text" missing';
    }