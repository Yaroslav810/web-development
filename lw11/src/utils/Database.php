<?php


class Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO(DSN, USER, PASSWORD);
    }

    public function trySaveFeedback(array $user): bool {

        $name = $this->pdo->quote($user['name']);
        $email = $this->pdo->quote($user['email']);
        $subject = $this->pdo->quote($user['subject']);
        $message = $this->pdo->quote($user['message']);

        $sqlQuery = "INSERT INTO `feedback`(`name`, `email`, `subject`, `message`)
                     VALUES({$name}, {$email}, {$subject}, {$message})
                     WHERE `email` = {$email}";

        $stmt = $this->pdo->query($sqlQuery);
        if (!$stmt->fetch()) {
            return false;
        }

        return true;
    }

    public function getFeedback(string $email): ?array {
        $email = $this->pdo->quote($email);
        $sqlQuery = "SELECT `name`, `email`, `subject`, `message` 
                     FROM `feedback` 
                     WHERE `email` = {$email}";

        $stmt = $this->pdo->query($sqlQuery);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) return null;

        return $data;
    }
}
