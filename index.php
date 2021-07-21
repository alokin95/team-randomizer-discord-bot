<?php

    $players = file_get_contents('players.txt');

    $players = explode(" ", $players);

    $numberOfTeams = $argv[1] ?? 2;

    $teams = [];

    while(count($players) > 0)
    {
        for($i = 0; $i < $numberOfTeams; $i++)
        {
            $randomPlayer = array_rand($players);
            $teams[$i][] = $players[$randomPlayer];
            unset($players[$randomPlayer]);
            reset($players);
        }
    }

    $key = 1;
    foreach ($teams as $team)
    {
        $teamMembers = implode("  ", $team);
        echo "Team $key: \n" . $teamMembers;
        echo "\n";
        $key++;
    }

    die;
