<?php
// Тут нужно получать все ответы из файлов и
// рендерить шаблон с этими ответами

class FeedbacksListPage extends Page
{
    const EMPTY_FIELD = 'An empty search query is specified!';

    private $email;

    public function __construct()
    {
        $this->email = Request::getGETParameter('email');
    }

    public function renderPage(): void
    {
        $template = new Template('feedbacks');

        if (is_null($this->email))
        {
            $template->renderTemplate();
            return;
        }

        if ($this->email === '')
        {
            $template->setArgs(['error' => self::EMPTY_FIELD]);
            $template->renderTemplate();
            return;
        }

        $database = new Database();
        $data = $database->getFeedback($this->email);
        if (is_null($data))
        {
            $template->setArgs(['error' => 'User ' . $this->email . ' not in the system']);
            $template->renderTemplate();
            return;
        }

        $template->setArgs($data);
        $template->renderTemplate();
    }
}
