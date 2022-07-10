<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiRequest extends FormRequest
{
    /**
     * Convert request body before sending it to validator.
     *
     * @return array
     */
    public function validationData()
    {
        return (array) json_decode($this->content);
    }
}
