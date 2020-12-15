<?php


namespace App\DTOs;


class GithubUserAccount
{
    public string $avatar, $url, $full_name, $email, $username;

    public function __construct(string $avatar, string $url, string $full_name, string $email, string $username)
    {
        $this->avatar = $avatar;
        $this->url = $url;
        $this->full_name = $full_name;
        $this->email = $email;
        $this->username = $username;
    }
}
