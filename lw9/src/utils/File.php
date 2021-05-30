<?php


class File
{
    const DIR = './data/';

    private $error = '';

    public function getDataByEmail(string $email): ?array
    {
        $filePath = self::DIR . mb_strtolower($email) . '.txt';
        if (is_readable($filePath))
        {
            $fileDescriptor = fopen($filePath, 'r');
            if (!$fileDescriptor)
            {
                $this->error = 'Error! Couldn\'t read the file!';
                return null;
            }

            $data = [];
            while (($fileLine = fgets($fileDescriptor)) !== false)
            {
                $splitData = explode(':', $fileLine, 2);
                $key = trim($splitData[0]);
                $value = str_replace(['\r\n', '\n'], '<br />', htmlspecialchars(trim($splitData[1])));
                $data[$key] = $value;
            }
        }
        else
        {
            $this->error = 'Error! A user with this email address ' . $email . ' not in the system!';
            return null;
        }

        return $data;
    }

    public function trySaveUserByEmail(array $data): bool
    {
        if (!is_dir(self::DIR)) mkdir(self::DIR);

        $filePath = self::DIR . mb_strtolower($data['email']) . '.txt';
        if (!self::trySetDataToFile($filePath, $data)) return false;

        return true;
    }

    private function trySetDataToFile(string $filePath, array $data): bool
    {
        $fileDescriptor = fopen($filePath, 'w');
        if (!$fileDescriptor) return false;

        foreach ($data as $key => $userInfo)
        {
            $userInfo = str_replace(["\r\n", "\r", "\n"], '\n', $userInfo);
            fwrite($fileDescriptor, $key . ': ' . $userInfo . PHP_EOL);
        }
        fclose($fileDescriptor);

        return true;
    }
}
