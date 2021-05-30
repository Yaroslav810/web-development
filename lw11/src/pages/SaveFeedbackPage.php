<?php
// Тут должна должна проводиться валидация полей из формы,
// которые должны быть получены из post, в случае неправильных
// данных должен рендериться шаблон main с информацией об ошибках,
// в случае правильных данных, данные должны сохраняться
// и должен рендериться шаблон main с информацией о том
// что данные сохранены
require_once __DIR__ . '/Page.php';
require_once __DIR__ . './../utils/Database.php';
require_once __DIR__ . './../utils/User.php';

class SaveFeedbackPage extends Page
{
    const EMPTY_NAME_ERROR = 'Error! Please enter a name!';
    const EMPTY_EMAIL_ERROR = 'Error! Please enter email!';
    const EMPTY_SUBJECT_ERROR = 'Error! Please enter the subject!';
    const EMPTY_MESSAGE_ERROR = 'Error! Please enter a message!';
    const INVALID_NAME_ERROR = 'Error! Invalid name!';
    const INVALID_EMAIL_ERROR = 'Error! Invalid email address!';

    private $user;

    public function __construct()
    {
        $name = trim(Request::getPOSTParameter('name'));
        $email = trim(Request::getPOSTParameter('email'));
        $subject = trim(Request::getPOSTParameter('subject'));
        $message = trim(Request::getPOSTParameter('message'));
        $this->user = new User($name, $email, $subject, $message);
    }

    public function renderPage(): void
    {
        $template = new Template('main');

        $error = self::checkCurrentUser();
        if ($error)
        {
            $template->setArgs(array_merge($this->user->getUser(), $error));
            $template->renderTemplate();
            return;
        }

        $database = new Database();
        if ($database->trySaveFeedback($this->user->getUser()))
        {
            $template->setArgs(array_merge($this->user->getUser(), ['is_save' => false]));
            $template->renderTemplate();
            return;
        }

        $template->setArgs(['is_save' => true]);
        $template->renderTemplate();
    }

    private function checkCurrentUser(): array
    {
        $error = [];
        $user = $this->user->getUser();

        if (empty($user['name']))
        {
            $error['name_error_msg'] = self::EMPTY_NAME_ERROR;
        }

        if (empty($user['email']))
        {
            $error['email_error_msg'] = self::EMPTY_EMAIL_ERROR;
        }

        if (empty($user['subject']))
        {
            $error['subject_error_msg'] = self::EMPTY_SUBJECT_ERROR;
        }

        if (empty($user['message']))
        {
            $error['message_error_msg'] = self::EMPTY_MESSAGE_ERROR;
        }

        if (!empty($user['name']) && !preg_match_all('/^[-A-Za-zА-ЯЁа-яё]+$/u', $user['name']))
        {
            $error['name_error_msg'] = self::INVALID_NAME_ERROR;
        }

        if (!empty($user['email']) && !filter_var($user['email'], FILTER_VALIDATE_EMAIL))
        {
            $error['email_error_msg'] = self::INVALID_EMAIL_ERROR;
        }

        return $error;
    }
}
