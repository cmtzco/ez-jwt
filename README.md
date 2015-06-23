# ez-jwt
Simple OAuth Tools 

##Install
`composer require cmtz/ez-jwt`

##How to Use ez-jwt

####Parameters
```
$issuer = your@developer.gserviceaccount.com; //this would be the email issued via Google API console (Credentials)
$audience = "https://www.googleapis.com/oauth2/v3/token"; //for google jwt this is what would default
$scope = "https://www.googleapis.com/auth/content"; //for google jwt this is what would default
$key = file_get_contents(yourkeyfile.priv);
$algorithm = 'RS256'; //as of now only RS256 is supported using ez-jwt
$grant = 'urn:ietf:params:oauth:grant-type:jwt-bearer'; //for google jwt this is what would default
$APIurl = 'https://www.googleapis.com/oauth2/v3/token'; //for google jwt this is what would default
$headers = array('Content-Type' => 'application/x-www-form-urlencoded'); //this does not need to be set as it will default to what is needed but can be set to something else if needed
```

####Calling ezjwt
```
$token = ezjwt::generateToken($issuer, $audience, $scope, $key, $algorithm, $grant, $APIurl, $headers)
``` 


