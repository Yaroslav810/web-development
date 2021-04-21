<?php
// В файлах страниц должна быть,
// обработка параметров запроса
// и вызов функции renderTemplate
require_once 'Page.php';

class MainPage extends Page
{

    public function renderPage(): void
    {
        $template = new Template();
        $template->renderTemplate();
    }
}