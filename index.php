<?php

use Discord\Parts\Channel\Channel;

include __DIR__.'/vendor/autoload.php';
    require_once "helpers.php";

    $discord = discordApp();

    $discord->on('ready', function ($discord) {

        // Listen for messages.
        $discord->on('message', function ($message, $discord) {
            if (strpos($message->content, '_') === 0) {
                try {
                    $messageContent = trim($message->content);

                    $command = explode('_', $messageContent)[1];

                    $command = explode(" ", $command)[0];

                    switch ($command)
                    {
                        case "randomize":
                            file_put_contents('lastRandomizer.txt', $message->content);
                            return createTeams($message);
                        case "again":
                            return createTeams($message, true);
                        case "wz":
                            return randomizeLZ($message);
                        default:
                            return null;
                    }
                } catch (Throwable $exception) {
                    echo $exception->getMessage();
                }
            }
        });
    });

    function createTeams($message, $repeat = false)
    {
        if ($repeat) {
            $message->content = file_get_contents('lastRandomizer.txt');
        }

        if (false === strpos($message->content, ', ')) {
            $message->content.= ", 2";
        }

        $numberOfTeams = explode(",", $message->content);
        $numberOfTeams = end($numberOfTeams);

        $message->content = trim($message->content, $numberOfTeams);

        if (!is_numeric($numberOfTeams)) {
            $numberOfTeams = 2;
        }

        $players = explode(' ', $message->content);
        unset($players[0]);

        if (count($players) < 3 || $numberOfTeams > count($players)) {
            return false;
        }

        $teams = [];

        while(count($players) > 0)
        {
            for($i = 0; $i < $numberOfTeams; $i++)
            {
                if (count($players) > 0) {
                    $randomPlayer = array_rand($players);
                    $teams[$i][] = trim($players[$randomPlayer], ',');
                    unset($players[$randomPlayer]);
                    reset($players);
                }
            }
        }

        $messageResponse = "\n";

        $key = 1;
        foreach ($teams as $team)
        {
            $teamMembers = implode("  ", $team);
            $messageResponse .= "Team $key: " . $teamMembers;
            $messageResponse .= " | ";
            $key++;
        }

        return $message->channel->sendMessage($messageResponse);

    }

    function randomizeLZ($message)
    {
        $poi = ['Summit', 'Military Base', 'Salt Mine', 'Lumber', 'Farmland', 'Hospital', 'Downtown', 'Prison', 'Port', 'Park', 'Hills', 'Promenade East', 'Promenade West', 'Boneyard', 'Train Station', 'Factory', 'Superstore', 'Airport', 'Storage town', 'Stadium', 'Array', 'TV Station'];

        return $message->channel->sendMessage($poi[array_rand($poi)]);
    }

$discord->run();