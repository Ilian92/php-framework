<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;

class ContactController extends AbstractController
{
    private $email;
    private $subject;
    private $message;

    public function __construct($email = '', $subject = '', $message = '')
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->message = $message;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getContactInfo(): array
    {
        return [
            'email' => $this->getEmail(),
            'subject' => $this->getSubject(),
            'message' => $this->getMessage(),
        ];
    }

    public function process(Request $request): Response
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['email'], $data['subject'], $data['message'])) {
            $this->setEmail($data['email']);
            $this->setSubject($data['subject']);
            $this->setMessage($data['message']);
        } else {
            return new Response(json_encode(['error' => 'Invalid request body']), 400, ['Content-Type' => 'application/json']);
        }

        $contactInfo = $this->getContactInfo();
        $timestamp = time();
        $filename = sprintf(__DIR__ . '/../../var/contacts/%s_%s.json', $timestamp, $this->getEmail());

        if (!is_dir(__DIR__ . '/../../var/contacts')) {
            mkdir(__DIR__ . '/../../var/contacts', 0777, true);
        }

        file_put_contents($filename, json_encode($contactInfo));

        return new Response(json_encode($contactInfo), 200, ['Content-Type' => 'application/json']);
    }
}
