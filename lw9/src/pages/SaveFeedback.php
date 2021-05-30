<?php

require_once __DIR__ . '/Page.php';
require_once __DIR__ . './../utils/File.php';
require_once __DIR__ . './../utils/User.php';

class SaveFeedback
{
    const EMPTY_NAME_ERROR = 'Error! Please enter a name!';
    const EMPTY_EMAIL_ERROR = 'Error! Please enter email!';
    const EMPTY_SUBJECT_ERROR = 'Error! Please enter the subject!';
    const EMPTY_MESSAGE_ERROR = 'Error! Please enter a message!';
    const INVALID_NAME_ERROR = 'Error! Invalid name!';
    const INVALID_EMAIL_ERROR = 'Error! Invalid email address!';

    private $user;

    public function __construct($data)
    {
        $name = trim($data['name']);
        $email = trim($data['email']);
        $subject = trim($data['subject']);
        $message = trim($data['message']);
        //$this->user = new User($name, $email, $subject, $message);
    }

    public function trySaveData(): bool
    {
//        $error = self::checkCurrentUser();
//        if ($error)
//        {
//            return false;
//        }
        return false;
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

        $file = new File();
        if (!$file->trySaveUserByEmail($this->user))
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
