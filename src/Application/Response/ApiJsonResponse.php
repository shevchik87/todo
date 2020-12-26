<?php

declare(strict_types=1);

namespace App\Application\Response;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiJsonResponse extends JsonResponse
{
    private $result;

    /**
     * @var ErrorDto[]
     */
    private $errors;

    public function createSuccessResponse($data, int $status = 200): ApiJsonResponse
    {
        $response = new static(null, $status);
        $response->result = $data;
        $response->formatResponse();
        return $response;
    }

    public function createFromException(\Throwable $exception, int $httpCode)
    {
        $err = new ErrorDto(
            $exception->getMessage(),
            '',
            $httpCode
        );

        $response = new static(null, $httpCode);
        $response->errors[] = $err;
        $response->formatResponse();
        return $response;
    }

    private function formatResponse()
    {
        $this->setData([
            'result' => $this->result,
            'errors' => $this->getErrors(),
        ]);
    }

    private function getErrors()
    {
        if (is_null($this->errors)) {
            return [];
        }

        $errorsData = [];
        foreach ($this->errors as $error) {
            $errorsData[] = $error;
        }

        return $errorsData;
    }
}
