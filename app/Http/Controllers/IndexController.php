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
        try
        {
            $xmlstring = file_get_contents('https://steamcommunity.com/groups/KingsgamingRP/memberslistxml?xml=1');
            $xml = simplexml_load_string($xmlstring);
            $xmljson = json_encode($xml);
            $result = json_decode($xmljson,TRUE);
            $memberCount = $result['memberCount'];
            $serverid = "254806057321365504";
            $discord_url = "https://discordapp.com/api/servers/".$serverid."/widget.json";
            $json = file_get_contents($discord_url);
            $json_table = json_decode($json, true);
            $channeltables = $json_table;
            $discord_svname = $json_table['name'];
            $discord_channels = $json_table['channels'];
            $discord_users = count($json_table['members']);;
            $ip = '198.27.80.155';
            $port = 27752;
            $timeout =1;
            $engine = SourceQuery::SOURCE;
            $Query->Connect($ip, $port, $timeout, $engine);
            $Info    = $Query->GetInfo();
            $Players = $Query->GetPlayers();
            $Rules   = $Query->GetRules();
            $calc = $Info['Players']/$Info['MaxPlayers']*100;
            //dd($discord_users);
            return view('front.main')->with([
                'Query' => $Query,
                'Info' => $Info,
                'Players' => $Players,
                'Rules' => $Rules,
                'channeltables' => $channeltables,
                'discord_svname' => $discord_svname,
                'discord_channels' => $discord_channels,
                'discord_users' => $discord_users,
                'memberCount' => $memberCount,
                'Calc' => $calc
            ]);
        }
        catch( Exception $e )
        {
            echo $e->getMessage();
        } catch (InvalidArgumentException $e) {
        } catch (TimeoutException $e) {
        }
        $Query->Disconnect();

    }
}
