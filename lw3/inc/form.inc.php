<?php
    const CHARACTER_WEIGHT = 4;
    const DIGIT_WEIGHT = 4;
    const UPPERCASE_WEIGHT = 2;
    const LOWERCASE_WEIGHT = 2;

    const DIR = "./data/";

    function getPasswordStrength(?string $password): ?int
    {
        if (is_null($password))
        {
            echo 'Нет идентификатора password!';
            return null;
        }

        if (mb_strlen($password) === 0)
        {
            echo 'Пустой идентификатор "password"!';
            return null;
        }

        $strength = 0;
        $strength = $strength + mb_strlen($password) * CHARACTER_WEIGHT;

        $strength = $strength + (preg_match_all("/\d/", $password)) * DIGIT_WEIGHT;

        $uppercase = preg_match_all("/[A-ZА-Я]/u", $password);
        if ($uppercase !== 0)
        {
            $strength = $strength + (mb_strlen($password) - $uppercase) * UPPERCASE_WEIGHT;
        }

        $lowercase = preg_match_all("/[a-zа-я]/u", $password);
        if ($lowercase !== 0)
        {
            $strength = $strength + (mb_strlen($password) - $lowercase) * LOWERCASE_WEIGHT;
        }

        $strength = ctype_alpha($password) ? ($strength - mb_strlen($password)) : $strength;

        $strength = ctype_digit($password) ? ($strength - mb_strlen($password)) : $strength;

        foreach (count_chars($password, 1) as $val)
        {
            if ($val >= 2)
            {
                $strength = $strength - $val;
            }
        }

        return $strength;
    }

    function saveDataByEmail(array $user, string &$error = ''): bool
    {
        if (!empty($user['email']))
        {
            if (!is_dir(DIR))
            {
                mkdir(DIR);
            }

            $filePath = DIR . $user['email'] . '.txt';
            if (is_readable($filePath))
            {
                $currentData = [];
                if (!getDataFromFile($filePath, $currentData))
                {
                    $error = 'Error! Internal server error!';
                    return false;
                }

                $newData = [];
                foreach ($user as $key => $value)
                {
                    $newData[$key] = $value ?? $currentData[$key];
                }

                if (!setDataToFile($filePath, $newData))
                {
                    $error = 'Error! Internal server error!';
                    return false;
                }
            }
            else
            {
                if (!setDataToFile($filePath, $user))
                {
                    $error = 'Error! Internal server error!';
                    return false;
                }
            }
        }
        else
        {
            $error = 'Error! Email required field!';
            return false;
        }

        return true;
    }

    function getDataFromFile(string $filePath, array &$data = []): bool
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
            $value = trim($splitData[1]);
            $data[$key] = $value;
        }

        return true;
    }

    function setDataToFile(string $filePath, array $data): bool
    {
        $fileDescriptor = fopen($filePath, 'w');
        if (!$fileDescriptor)
        {
            return false;
        }

        foreach ($data as $key => $userInfo)
        {
            fwrite($fileDescriptor, $key . ': ' . $userInfo . PHP_EOL);
        }
        fclose($fileDescriptor);

        return true;
    }

    function printDataFromFileByEmail(?string $email, string &$error): bool
    {
        if ($email)
        {
            $filePath = DIR . $email . '.txt';
            if (is_readable($filePath))
            {
                $data = [];
                if (!getDataFromFile($filePath, $data))
                {
                    $error = 'Error! Internal server error!';
                    return false;
                }

                printData($data);
            }
            else
            {
                $error = 'Error! Couldn\'t find a profile with this email address!';
                return false;
            }
        }
        else
        {
            $error = 'Error! Email required field!';
            return false;
        }

        return true;
    }

    function printData(array $data): void
    {
        echo 'First Name: ' . ($data['firstName'] ?? ' ') . PHP_EOL;
        echo 'Last Name: ' . ($data['lastName'] ?? ' ') . PHP_EOL;
        echo 'Email: ' . ($data['email'] ?? ' ') . PHP_EOL;
        echo 'Age: ' . ($data['age'] ?? ' ') . PHP_EOL;
    }
