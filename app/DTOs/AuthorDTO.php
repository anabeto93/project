<?php


namespace App\DTOs;


class AuthorDTO
{
    public string $name, $date, $email;

    public function __construct(string $name, string $date, string $email)
    {
        $this->name = $name;
        $this->date = $date;
        $this->email = $email;
    }
}
