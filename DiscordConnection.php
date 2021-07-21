<?php


use Discord\Discord;
use Discord\WebSockets\Intents;

class DiscordConnection
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (null == self::$instance)
        {
            self::$instance = new Discord([
                'token' => env('DISCORD_BOT_SECRET'),
//                'loadAllMembers' => true,
//                'intents' => 12345
            ]);
        }

        return self::$instance;
    }
}