<?php


class User
{
    private $name;
    private $email;
    private $subject;
    private $message;

    public function __construct(?string $name, ?string $email, ?string $subject, ?string $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUser(): array
    {
        $name = $this->name;
        $email = $this->email;
        $subject = $this->subject;
        $message = $this->message;

        $user = [
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
        ];

        return $user;
    }
}