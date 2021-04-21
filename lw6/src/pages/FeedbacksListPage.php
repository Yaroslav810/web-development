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

        $file = new File;
        $data = $file->getDataByEmail($this->email);
        if (is_null($data))
        {
            $template->setArgs(['error' => $file->getError()]);
            $template->renderTemplate();
            return;
        }

        $template->setArgs($data);
        $template->renderTemplate();
    }
}