<?php
require_once 'google-api-php-client/src/Google/autoload.php'; //this may change based on where your google api client files are located
require_once 'google-api-php-client/src/Google/Service/ShoppingContent.php'; //this may change based on where your google api client files are located
require_once 'vendor/autoload.php'; //this is what composer uses.  If you are not using composer and manually including the files this needs to be removed
class ezjwt {
    /**
     * require for composer.json found at -> https://developers.google.com/api-client-library/php/start/installation
     * composer require firebase/php-jwt
     * 
     * 
     * [generateToken will allow you to generate JWTs with a refresh token by just filling the parameters.]
     * @param  string $issuer The issuer of the JWT 
     * @param  string $audience defaults to 'https://www.googleapis.com/oauth2/v3/token' and is the audience that will use the JWT
     * @param string $scope The scope that the JWT will be able to access
     * @param string $key This is the file that the Private Key will be accessed from.  Currently this only supports RS256
     * @param string $algorithm The algorithm that will be used to create the JWT, only RS256 is currently supported
     * @param string $grant This is usually provided from whichever API that you will be querying at least in the case of Google API's it will
     * @param string $APIurl The URL that will be accessed for API calls
     * @param array $headers Any custom headers that will need to be passed over.  The default is 'array('Content-Type' => 'application/x-www-form-urlencoded')'
     * @return json Oauth token is returned
     */
    function generateToken($issuer, $audience = "https://www.googleapis.com/oauth2/v3/token", $scope, $key, $algorithm, $grant, $APIurl, $headers = array('Content-Type' => 'application/x-www-form-urlencoded')) {
    
        //private key issued via Google API/Developer Console
        $header = '{
            "alg": "RS256", 
            "typ": "JWT"
        }';
        $claims = array(
            "iss" => $issuer,//client email 
            "aud" => $audience, //url to request token from 
            "scope" => $scope, //product shopping API URL
            "iat" => time(), //get current time to ensure the JWT is always refreshed 
            "exp" => time() + 3600, // expires the JWT after 1 hour
        );
      
        JWT::$leeway = 60; // $leeway in seconds
        JWT::$supported_algs = array(
          'RS256' => array('openssl', 'SHA256'), //only allow the algorithms supported by Google API
          );
        $key = file_get_contents($key);
        $jwt = JWT::encode($claims, $key, $algorithm); //build JWT and sign using the JWT library
        $data = array(
          'grant_type' => $grant, // required params from Google API to get OAuth Token
          'assertion' => $jwt
        );


        $data = http_build_query($data); //format for URL 
        $response = Requests::post($APIurl, $headers, $data); // send the requests to Google Servers for the Token
        $oauth2Token = $response->body; // save the response body to a variable as an object for use
        
        return $oauth2Token; // return it
    }
}
