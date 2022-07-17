<?php

class GithubProvider
{
    public static string $clientId = 'a10c300a59aa4e7d143a';
    private static string $clientSecret = '34dd606fd568e43e6283f470b58a65d15b9c7e74';

    public static function callback()
    {
        $token = GithubProvider::getToken("https://github.com/login/oauth/access_token", GithubProvider::$clientId, GithubProvider::$clientSecret);
        $user = GithubProvider::getUser($token);
        $unifiedUser = (fn () => [
            "id" => $user["id"],
            "login" => $user["login"],
            "name" => $user["name"],
        ])();
        echo "<pre>";
        var_dump($unifiedUser);
        echo "</pre>";
    }

    private static function getToken($baseUrl, $clientId, $clientSecret)
    {
        $context = stream_context_create([
            "http"=>[
                "header"=>"Accept: application/json"
            ]
        ]);

        ["code"=> $code, "state" => $state] = $_GET;
        $queryParams = http_build_query([
            "client_id"=> $clientId,
            "client_secret"=> $clientSecret,
            "redirect_uri"=>"https://localhost/gh_oauth_success",
            "code"=> $code,
        ]);

        $url = $baseUrl . "?{$queryParams}";
        $response = file_get_contents($url, false, $context);
        if (!$response) {
            echo $http_response_header;
            return;
        }
        ["access_token" => $token] = json_decode($response, true);

        return $token;
    }

    private static function getUser($token)
    {
        $context = stream_context_create([
            "http"=>[
                "header"=>"Authorization: token {$token}\r\n" .
                          "User-Agent: SDK Application"
            ]
        ]);

        $response = file_get_contents("https://api.github.com/user", false, $context);

        if (!$response) {
            echo $http_response_header;
            return;
        }
        return json_decode($response, true);
    }
}