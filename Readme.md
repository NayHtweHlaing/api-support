# Support Library for Laravel API Application

## Installation

```
$ composer require hexcores/api-support
```

## Response

API Support have totally 4 methods for json response.
Avaliable methods are - 

- Response::ok($data, array $headers = [])
- Response::missing($message = null, array $headers = [])
- Response::error($message, $status = 500, array $headers = [])
- Response::unauthorized($message = null, array $headers = [])

Example -

```php
use Hexcores\Api\Facades\Response as ApiResponse;

class UserApiController extends Controller 
{
	public function create()
	{
		if ( ! User::can('create'))
		{
			// User has not permission to create new record,
			// So response unauthorized with status 401
			return ApiResponse::unauthorized();
		}

		if ( $user = User::create(Input::all()))
		{
			return ApiResponse::ok($user);
		}
		
		// User creation has a problem,
		// So response error with status 500
		return ApiResponse::error('User creationo is fail');
	}

	public function show($id)
	{
		$user = User::find($id);

		if ( is_null($user))
		{
			return ApiResponse::missing();
		}

		return ApiResponse::ok($user);
	}
}

```

You can use helper functions for each response.

- response_ok()
- response_missing()
- response_error()
- response_unauthorized()

## Middleware

- `VerifyApiRequestHeader`

#### VerifyApiRequestHeader

VerifyApiRequestHeader middleware is used for api request access checking. 
You need to pass `X-API-KEY` and `X-API-SECRET` headers for reuqest.

*Note: Add `X-API-KEY` and `X-API-SECRET` at `.env` file*

If you want to add multiple key, use comma for key string from `.env` file.

Example :

```
X-API-KEY=first_key,second_key,third_key
X-API-SECRET=first_secret,second_secret,third_secret
```

## Key Generator

You can use artisan command to generate new key.

Command usage - 

Generate new keys and added at .env file

```
php artisan api:key
```

Show current register keys from .env file.

```
php artisan api:key --current
```

Print only the new keys

```
php artisan api:key --print
```

Replace new keys with current register keys from .env file

```
php artisan api:key --replace
```

Add artisan command in `app/console/Kernel.php`

```
protected $commands = [
    \App\Console\Commands\Inspire::class,
    // Other commands.
	Hexcores\Api\Console\ApiKeyGenerate,    
];

```