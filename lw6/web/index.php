<?php

    require_once './../src/common.inc.php';

    $method = Request::getRequestMethod();
    if ($method == 'POST') {
        $page = new SaveFeedbackPage();
    }
    else
    {
        $page = new MainPage();
    }

    $page->renderPage();