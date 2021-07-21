<?php

include 'DiscordConnection.php';

function env($key)
{
    $file = file('.env');

    foreach ($file as $row) {
        $array = explode('=', $row);

        if ($key == $array[0]) {
            return trim($array[1]);
        }
    }

    return null;
}

function discordApp()
{
    return DiscordConnection::getInstance();
}