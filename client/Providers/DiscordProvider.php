<?php

class DiscordProvider
{
    public static string $clientId = '997806172377731182';
    private static string $clientSecret = 'ySrBTlXaN_mAMb5uyeW-jm8Y5UTrFKPG';


    public static function callback()
    {
        $token = DiscordProvider::getToken("https://discordapp.com/api/oauth2/token", DiscordProvider::$clientId, DiscordProvider::$clientSecret);

        $user = DiscordProvider::getUser($token);
        var_dump($user);
        $unifiedUser = (fn () => [
            "id" => $user["id"],
            "name" => $user["name"],
            "email" => $user["email"],
            "firstName" => $user['first_name'],
            "lastName" => $user['last_name'],
        ])();
        echo "Vous êtes bien connecté";
        echo "<pre>";
        var_dump($unifiedUser);
        echo "</pre>";
    }

    private static function getToken($baseUrl, $clientId, $clientSecret)
    {
        ["code" => $code, "state" => $state] = $_GET;
        $specifParams = [
            'code' => $code,
            'grant_type' => 'authorization_code',
        ];
        $queryParams = http_build_query(array_merge([
        'client_id' => DiscordProvider::$clientId ,
        'client_secret' => DiscordProvider::$clientSecret ,
        'redirect_uri' => 'http://localhost/ds_oauth_success',
        'response_type' => 'code',
        'scope' => 'identify',
        "state" => bin2hex(random_bytes(16))

        ], $specifParams));
        $context = stream_context_create([
        'http' => [
            'method' => "POST",
            'header' => "Content-type: application/x-www-form-urlencoded\r\n"
            . "Content-Length: " . strlen($queryParams) . "\r\n",
            'content' => $queryParams
            ]
        ]
        );

        $response = file_get_contents("https://discordapp.com/api/oauth2/token", false, $context);
        $token = json_decode($response, true);
        $context = stream_context_create([
        'http' => [
            'method' => "GET",
            'header' => "Authorization: Bearer {$token['access_token']}"
            ]
        ]);

    }

    private static function getUser($token)
    {


        $context = stream_context_create([
            "http"=>[
                "header"=>"Authorization: Bearer {$token}"
            ]
        ]);
        $response = file_get_contents("https://discordapp.com/api/oauth2/authorize", false, $context);

        /*$context = stream_context_create([
            "http"=>[
                "header"=>"Authorization: Bearer {$token}"
            ]
        ]);
        $response = file_get_contents("https://discord.com/api/oauth2/@me", false, $context);*/
        $user = json_decode($response, true);
        
       // return json_decode($response, true);
    }

}