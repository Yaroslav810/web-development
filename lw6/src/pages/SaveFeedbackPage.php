<?php
// Тут должна должна проводиться валидация полей из формы,
// которые должны быть получены из post, в случае неправильных
// данных должен рендериться шаблон main с информацией об ошибках,
// в случае правильных данных, данные должны сохраняться
// и должен рендериться шаблон main с информацией о том
// что данные сохранены
require_once __DIR__ . '/Page.php';
require_once __DIR__ . './../utils/File.php';
require_once __DIR__ . './../utils/User.php';

class SaveFeedbackPage extends Page
{
    const EMPTY_NAME_ERROR = 'Error! Please enter a name!';
    const EMPTY_EMAIL_ERROR = 'Error! Please enter email!';
    const EMPTY_SUBJECT_ERROR = 'Error! Please enter the subject!';
    const EMPTY_MESSAGE_ERROR = 'Error! Please enter a message!';
    const INVALID_NAME_ERROR = 'Error! Invalid name!';
    const INVALID_EMAIL_ERROR = 'Error! Invalid email address!';
    const SAVE_DIR = "./data/";

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

        $error = self::checkUser();
        if ($error)
        {
            $user = $this->user->getUser();
            if (is_null($user))
            {
                $template->renderTemplate();
            }

            $template->setArgs(array_merge($this->user->getUser(), $error));
            $template->renderTemplate();
            return;
        }

        $file = new File();
        //file->saveDateBuEmail должна что-то возвращать? Например если неуспешное завершение, то set вернёт null
        if (!self::saveDataByEmail())
        {
            $template->setArgs(array_merge($this->user, ['is_save' => false]));
            $template->renderTemplate();
            return;
        }

        $template->setArgs(['is_save' => true]);
        $template->renderTemplate();
    }

    private function checkUser(): array
    {
        $error = [];

        if (empty($this->user['name']))
        {
            $error['name_error_msg'] = self::EMPTY_NAME_ERROR;
        }

        if (empty($this->user['email']))
        {
            $error['email_error_msg'] = self::EMPTY_EMAIL_ERROR;
        }

        if (empty($this->user['subject']))
        {
            $error['subject_error_msg'] = self::EMPTY_SUBJECT_ERROR;
        }

        if (empty($this->user['message']))
        {
            $error['message_error_msg'] = self::EMPTY_MESSAGE_ERROR;
        }

        if (!empty($this->user['name']) && !preg_match_all('/^[-A-Za-zА-ЯЁа-яё]+$/u', $this->user['name']))
        {
            $error['name_error_msg'] = self::INVALID_NAME_ERROR;
        }

        if (!empty($this->user['email']) && !filter_var($this->user['email'], FILTER_VALIDATE_EMAIL))
        {
            $error['email_error_msg'] = self::INVALID_EMAIL_ERROR;
        }

        return $error;
    }

    private function saveDataByEmail(): bool
    {
        if (empty($this->user['email']))
        {
            return false;
        }

        if (!is_dir(self::SAVE_DIR))
        {
            mkdir(self::SAVE_DIR);
        }

        $filePath = self::SAVE_DIR . mb_strtolower($this->user['email']) . '.txt';
        if (!self::setDataToFile($filePath))
        {
            return false;
        }

        return true;
    }

    private function getDataFromFile(string $filePath, array &$data = []): bool
    {
        $fileDescriptor = fopen($filePath, 'r');
        if (!$fileDescriptor)
        {
            return false;
        }

        while (($fileLine = fgets($fileDescriptor)) !== false)
        {
            $splitData = explode(':', $fileLine, 2);
            $key = trim($splitData[0]);
            $value = str_replace(['\r\n', '\n'], '<br />', htmlspecialchars(trim($splitData[1])));
            $data[$key] = $value;
        }

        return true;
    }

    private function setDataToFile(string $filePath): bool
    {
        $fileDescriptor = fopen($filePath, 'w');
        if (!$fileDescriptor)
        {
            return false;
        }

        foreach ($this->user as $key => $userInfo)
        {
            $userInfo = str_replace("\r\n", '\n', $userInfo);
            fwrite($fileDescriptor, $key . ': ' . $userInfo . PHP_EOL);
        }
        fclose($fileDescriptor);

        return true;
    }

    //Как вариант сначал подготовить данные, а затем отдельным методом save в File сохранить их
}