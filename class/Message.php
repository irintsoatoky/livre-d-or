<?php
namespace Grafikart\GuestBook;

use \DateTime; 
use \DateTimeZone;

class Message
{

    const LIMIT_USERNAME = 5;
    const LIMIT_MESSAGE = 10;

    private $username;
    private $message;
    private $date;

    public function __construct(string $username, string $message, ?DateTime $date = null)
    {
        $this->username = $username;
        $this->message = $message;
        $this->date = $date ?: new DateTime();
    }

    public function getErrors(): array
    {
        $errors = [];
        if (strlen($this->username) < self::LIMIT_USERNAME) {
            $errors['username'] = 'Votre pseudo est trop court';
        }
        if (strlen($this->username) < self::LIMIT_MESSAGE) {
            $errors['message'] = 'Votre message est trop court';
        }
        return $errors;
    }

    public function isValid(): bool
    {
        return empty($this->getErrors());
    }

    public function toJSON(): string
    {
        return json_encode([
            'username' => $this->username,
            'message' => $this->message,
            'date' => $this->date->getTimestamp()
        ]);
    }

    public function toHTML(): string
    {
        $username = htmlentities($this->username);
        $date = $this->date->format('d/m/Y à H:i');
        $message = nl2br(htmlentities($this->message));
        return <<<HTML
        <p>
            <strong>{$this->username}</strong> <em>le {$date}</em><br>
            {$message}
        </p>
        HTML;
    }

    public static function fromJSON(string $json): Message
    {
        $data = json_decode($json, true);
        return $messages[] = new self($data['username'], $data['message'], new DateTime("@" . $data['date']));
    }
    
}