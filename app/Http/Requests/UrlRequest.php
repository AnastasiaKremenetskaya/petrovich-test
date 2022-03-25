<?php

namespace App\Http\Requests;

use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class UrlRequest
{
    /**
     * @param array $data
     * @return Validation
     */
    public function validate(array $data): Validation
    {
        $validator = new Validator();
        $validation = $validator->make($data, $this->getRules());
        $validation->setMessages([
                                     'url:regex' => 'Invalid url'
                                 ]);
        $validation->validate();

        return $validation;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return string[]
     */
    private function getRules(): array
    {
        $urlRegex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        return [
            'url' => 'required|max:255|regex:' . $urlRegex,
        ];
    }
}
