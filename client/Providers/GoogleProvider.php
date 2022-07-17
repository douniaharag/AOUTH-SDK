<?php

class GoogleProvider
{
    public static string $clientId = '122194665762-h246aajbs1sqfklna28192mr03red1sk.apps.googleusercontent.com';
    private static string $clientSecret = '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';


    public static function callback()
    {
            $specifParams = [
                    "grant_type" => "authorization_code",
                    "code" => $_GET["code"],
                ];
            $clientId = "122194665762-h246aajbs1sqfklna28192mr03red1sk.apps.googleusercontent.com";
            $clientSecret = "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";
            $redirectUri = "http://localhost:8081/gg_callback";
            $data = http_build_query(array_merge([
                "redirect_uri" => $redirectUri,
                "client_id" => $clientId,
                "client_secret" => $clientSecret
            ], $specifParams));

            $url = "https://oauth2.googleapis.com/token";
            $options = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => 'Content-Type: application/x-www-form-urlencoded',
                    'content' => $data
                )
            );
            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            $result = json_decode($result, true);
            $accessToken = $result['access_token'];
        
            $url = "https://www.googleapis.com/oauth2/v1/userinfo";
            $options = array(
                'http' => array(
                    'method' => 'GET',
                    'header' => 'Authorization: Bearer ' . $accessToken
                )
            );
            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            $result = json_decode($result, true);
            echo "Hello {$result['email']}
            
        }

    

}