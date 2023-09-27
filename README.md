
#####  If you work in a macro service structure or if you need a very light library to send and receive reposts in a simple service or application, this library will greatly help you.

Currently, it is only implemented to receive tokens from https://www.keycloak.org/, but you can complete it
‍‍‍‍
The best usage example is shown in this chart so that you can do the "Request To Service With Token" step with this library.

![enter image description here](https://s6.uupload.ir/files/chart_sm7v.jpg)


## setp #1
```bash
composer require pickmap/service-request
```
## setp #2
Define the following variables in your .env file
```php
KEYCLOAK_CLIENT_ID=client-id
KEYCLOAK_CLIENT_SECRET=keycloak-secret-key
KEYCLOAK_USERNAME=usernameOrEmail
KEYCLOAK_PASSWORD=password
KEYCLOAK_LOGIN_URL='https://...openid-connect/token?grant_type=password'
```

## setp #2
In any class you want to be equipped to send a request like a model or controller, do the following
```php
class  sample {
use  ServiceRequest;

public  function  aMethod()
	{
		self::requestPost('https:://service.com/list');
	}
}
```
You can access these methods separately
```php
//If $refreshToken is equal to true, the token will be refreshed regardless of the cache
self::getToken($refreshToken);

self::requestToKeyCloak();

/*
Authorization is set in all tokens, but with this method, it is overwritten by the third parameter of post and get methods.
*/
self::HeadersProcess($newHeader);

self::requestPost(string  $url,array  $data  = [],$headers  = []);

self::requestGet(string  $url,array  $data  = [],$headers  = []);
```
