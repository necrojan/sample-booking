<?php

namespace App\Helpers;

use Illuminate\Support\Collection;

class Result
{
    /**
     * @var bool
     */
    protected $success = false;

    /**
     * @var string
     */
    protected $message = '';

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var null|mixed
     */
    protected $data;

    public function set($success = false, $message = '', $data = null, $statusCode = 200)
    {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
        $this->statusCode = $statusCode;

        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function isSuccessful()
    {
        return $this->success;
    }

    public function getData()
    {
        return $this->data;
    }
}
