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

*Note: Add `API_APP_KEY` and `API_APP_SECRET` at `.env` file*

If you want to add multiple key, use comma for key string from `.env` file.

Example :

```
API_APP_KEY=first_key,second_key,third_key
API_APP_SECRET=first_secret,second_secret,third_secret
```