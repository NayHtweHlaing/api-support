<?php

namespace Hexcores\Api;

use JsonSerializable;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Arrayable;

class Response
{

	public function ok($data, array $headers = [])
	{
        return $this->jsonResponse($data, 200, $headers);
	}

	public function missing($message = null, array $headers = [])
	{
		$message = is_null($message) ? 'Resource not found!' : $message;

		$data = $this->getErrorData($message);

		return $this->jsonResponse($data, 404, $headers);
	}

	public function error($message, $status = 500, array $headers = [])
	{
		$data = $this->getErrorData($message);

		return $this->jsonResponse($data, $status, $headers);
	}

	public function unauthorized($message = null, array $headers = [])
	{
		$message = is_null($message) ? 'Unauthorized' : $message;
		
		$data = $this->getErrorData($message);

		return $this->jsonResponse($data, 401, $headers);
	}

	public function jsonResponse($data, $status, array $headers = [], $options = 0)
	{
		if ($data instanceof Arrayable && !$data instanceof JsonSerializable) {
            $data = $data->toArray();
        }

        return new JsonResponse($data, $status, $headers, $options);
	}

	protected function getErrorData($message)
	{
		return ['error' => [
			'message'	=> $message
		]];
	}
}