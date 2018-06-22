<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use xPaw\SourceQuery\Exception\InvalidArgumentException;
use xPaw\SourceQuery\Exception\InvalidPacketException;
use xPaw\SourceQuery\Exception\TimeoutException;
use xPaw\SourceQuery\SourceQuery;

class IndexController extends Controller
{


    public function index()
    {
        $Query = new SourceQuery();
        $ip = '198.27.80.155';
        $port = 27752;
        $timeout = 1;
        $engine = SourceQuery::SOURCE;

        $serverid = "254806057321365504";

        $steamRawInfo = file_get_contents('https://steamcommunity.com/groups/KingsgamingRP/memberslistxml?xml=1');
        $steamLoadedInfo = simplexml_load_string($steamRawInfo);
        $steamJson = json_encode($steamLoadedInfo);
        $steamGroup = json_decode($steamJson, TRUE);

        $memberCount = $steamGroup['memberCount'];
        $discord_url = "https://discordapp.com/api/servers/" . $serverid . "/widget.json";
        $getDiscord = file_get_contents($discord_url);
        $decodeDiscord = json_decode($getDiscord, true);
        $discordServerName = $decodeDiscord['name'];
        $discordChannels = $decodeDiscord['channels'];
        $discordUsers = count($decodeDiscord['members']);;
        try {
            $Query->Connect($ip, $port, $timeout, $engine);

            $serverInfo = $Query->GetInfo();
            $serverPlayers = $Query->GetPlayers();
            $calc = $serverInfo['Players'] / $serverInfo['MaxPlayers'] * 100;
            return view('front.main')->with([
                'Query' => $Query,
                'serverInfo' => $serverInfo,
                'serverPlayers' => $serverPlayers,
                'discordServerName' => $discordServerName,
                'discordChannels' => $discordChannels,
                'discordUsers' => $discordUsers,
                'memberCount' => $memberCount,
                'calc' => $calc
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
            $Query->Disconnect();
        }
}

