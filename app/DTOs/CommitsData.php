<?php


namespace App\DTOs;


class CommitsData
{
    public array $commits;

    public function __construct(array $commits)
    {
        $all = [];

        foreach($commits as $commit) {
            if ($commit instanceof SingleCommitData) {
                array_push($all, $commit);
            }
        }

        $this->commits = $all;
    }

    public function toArray()
    {
        $all = [];

        foreach($this->commits as $i => $commit) {
            $all[$i] = (array) $commit;
        }

        return $all;
    }
}
