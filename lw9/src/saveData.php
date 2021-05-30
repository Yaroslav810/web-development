<?php
    require_once __DIR__ . './utils/File.php';

    const EMPTY_NAME_ERROR = 'Error! Please enter a name!';
    const EMPTY_EMAIL_ERROR = 'Error! Please enter email!';
    const EMPTY_SUBJECT_ERROR = 'Error! Please enter the subject!';
    const EMPTY_MESSAGE_ERROR = 'Error! Please enter a message!';
    const INVALID_NAME_ERROR = 'Error! Invalid name!';
    const INVALID_EMAIL_ERROR = 'Error! Invalid email address!';

    function getRequest(): array
    {
        $data = file_get_contents('php://input');
        return json_decode($data, true);
    }

    function SendResponse($data)
    {
        echo json_encode($data);
    }

    function getError(array $data): array
    {
        $error = [];

        if (empty($data['name'])) $error['name_error_msg'] = EMPTY_NAME_ERROR;
        if (empty($data['email'])) $error['email_error_msg'] = EMPTY_EMAIL_ERROR;
        if (empty($data['subject'])) $error['subject_error_msg'] = EMPTY_SUBJECT_ERROR;
        if (empty($data['message'])) $error['message_error_msg'] = EMPTY_MESSAGE_ERROR;

        if (!empty($data['name']) && !preg_match_all('/^[-A-Za-zА-ЯЁа-яё]+$/u', $data['name'])) {
            $error['name_error_msg'] = INVALID_NAME_ERROR;
        }

        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $error['email_error_msg'] = INVALID_EMAIL_ERROR;
        }

        return $error;
    }


    $data = getRequest();

    $error = getError($data);
    if ($error) {
        SendResponse(array_merge($data, $error));
        return;
    }

    $file = new File();
    if (!$file->trySaveUserByEmail($data)) {
        SendResponse(array_merge($data, ['is_save' => false]));
        return;
    }

    SendResponse(array_merge($data, ['is_save' => true]));
