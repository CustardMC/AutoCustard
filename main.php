<?php

include __DIR__.'/vendor/autoload.php';

use Discord\DiscordCommandClient;
use Discord\WebSockets\Intents;
use Discord\WebSockets\Event;
use Discord\Parts\User\Activity;
use Dotenv\Dotenv;

DotEnv::createImmutable(__DIR__)->safeLoad();

$discord = new DiscordCommandClient([
    "token" => $_ENV["DISCORD_TOKEN"],
    "prefix" => "\/",
    "description" => "An awesome bot in PHP to meet the high standards of CustardMC.",
    "discordOptions" => [
        "intents" => Intents::getDefaultIntents() | Intents::MESSAGE_CONTENT
    ]
]);

$discord->on("ready", function ($discord) {
    $discord->updatePresence(new Activity(
        $discord,
        [
            "type" => Activity::TYPE_LISTENING,
            "name" => "\/help"
        ]));
});

$discord->registerCommand("when", function ($message, $params) {
    switch (rand(0, 5)) {
        case 0:
            return "in " . rand(1, 6) . " days";
        case 1:
            return "in " . rand(1, 4) . " weeks";
        case 2:
            return "in " . rand(1, 12) . " months";
        case 3:
            return "in " . rand(1, 5) . " years";
        case 4:
            return "never";
        case 5:
            return "soon™";
    }
}, [
    "description" => "See into the future with CustardVesion™",
]);

$discord->registerCommand("prune", function ($message, $params) {
    if (count($params) != 1)
        return "No";

    return "Yes!";
}, [
    "description" => "Purge messages with a bunch of http requests™"
]);

$discord->run();