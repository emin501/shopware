<?php

namespace Shopware\Api;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ResponseEnvelope implements \JsonSerializable
{
    /**
     * @var int
     */
    private $total = 0;

    /**
     * @var mixed
     */
    private $data;

    /**
     * @var \Exception[]
     */
    private $errors = [];

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * @var HttpException
     */
    private $exception;

    /**
     * @param mixed $data
     */
    public function __construct($data = null)
    {
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->total;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return \Exception[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getException(): ?HttpException
    {
        return $this->exception;
    }

    public function jsonSerialize()
    {
        return [
            'parameters' => $this->getParameters(),
            'exception' => $this->transformExceptionToArray($this->getException()),
            'errors' => $this->getErrors(),
            'total' => $this->getTotal(),
            'data' => $this->getData(),
        ];
    }

    private function transformExceptionToArray(?HttpException $exception): ?array
    {
        if (!$exception) {
            return null;
        }

        return [
            'type' => get_class($exception),
            'message' => $exception->getMessage(),
            'statusCode' => $exception->getStatusCode(),
        ];
    }

    /**
     * @param int $total
     */
    public function setTotal(int $total)
    {
        $this->total = $total;
    }

    /**
     * @param \Exception[] $errors
     */
    public function setErrors(array $errors)
    {
        $this->errors = $errors;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function setException(HttpException $exception)
    {
        $this->exception = $exception;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}