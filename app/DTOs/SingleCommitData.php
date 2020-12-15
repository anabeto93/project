<?php


namespace App\DTOs;


class SingleCommitData
{
    public string $sha, $message;
    public AuthorDTO $author;

    public function __construct($sha, $message, $name, $email, $date)
    {
        $this->sha = $sha;
        $this->message = $message;
        $this->author = new AuthorDTO($name, $date, $email);
    }

}
