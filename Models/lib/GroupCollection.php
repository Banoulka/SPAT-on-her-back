<?php


class GroupCollection
{
    private $user;
    private $teams = [];

    public function __construct(User $user, array $teams)
    {
        $this->user = $user;
        $this->teams = $teams;
    }

    public function list()
    {
        return $this->teams;
    }

    public function addTeam($teamID)
    {
        QueryBuilder::getInstance()
            ->table("team_members")
            ->insert([
                "user_id" => $this->user->id(),
                "team_id" => $teamID
            ]);
    }

    public function removeTeam($teamID)
    {
        QueryBuilder::getInstance()
            ->table("team_members")
            ->remove([
                "user_id" => $this->user->id(),
                "team_id" => $teamID
            ]);
    }
}