<?php

session_start();

require "Providers/OauthServerProvider.php";
require "Providers/FacebookProvider.php";
//require "Providers/GithubProvider.php";

define("GIT_CLIENT_ID", '2368e541da87c8b362f5');
define("GIT_CLIENT_SECRET", '1004f016ca09094a02d50c3cbd7c116fc930cd43');


// Create a login page with a link to oauth
function login()
{
    $queryParams = http_build_query([
        "state"=>bin2hex(random_bytes(16)),
        "client_id"=> OauthServerProvider::$clientId,
        "scope"=>"profile",
        "response_type"=>"code",
        "redirect_uri"=>"http://localhost:8081/oauth_success",
    ]);
    echo "
        <form method=\"POST\" action=\"/oauth_success\">
            <input type=\"text\" name=\"username\"/>
            <input type=\"password\" name=\"password\"/>
            <input type=\"submit\" value=\"Login\"/>
        </form>
    ";
    $fbQueryParams = http_build_query([
        "state"=>bin2hex(random_bytes(16)),
        "client_id"=> FacebookProvider::$clientId,
        "scope"=>"public_profile,email",
        "redirect_uri"=>"https://localhost/fb_oauth_success",
    ]);
    $gitQueryParams = http_build_query([
        "state"=>bin2hex(random_bytes(16)),
        "client_id"=> GithubProvider::$clientId,
        "scope"=>"user",
        "redirect_uri"=>"https://localhost/git_oauth_success",
    ]);
    


    echo "<a href=\"http://localhost:8080/auth?{$queryParams}\">Login with Oauth-Server</a><br>";
    echo "<a href=\"https://www.facebook.com/v13.0/dialog/oauth?{$fbQueryParams}\">Login with Facebook</a><br>";
    echo "<a href=\"https://github.com/login/oauth/authorize?{$gitQueryParams}\">Login with Github</a><br>";
}



$route = $_SERVER["REQUEST_URI"];
switch (strtok($route, "?")) {
    case '/login':
        login();
        break;
    case '/oauth_success':
        OauthServerProvider::callback();
        break;
    case '/fb_oauth_success':
        FacebookProvider::callback();
        break;
    case '/git-auth-success':
        GithubProvider::callback();
        break;
    default:
        http_response_code(404);
}