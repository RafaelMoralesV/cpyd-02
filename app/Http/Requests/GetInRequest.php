<?php

namespace App\Http\Requests;

use App\Rules\FollowsDateFormat;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class GetInRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "classroom" => "required",
            "entrance" => ["required", new FollowsDateFormat()],
            "subject" => "required",
        ];
    }

    public function validated($key = null, $default = null)
    {
        if($key){
            return parent::validated($key, $default);
        }

        $validated = parent::validated($key, $default);

        $validated['entrance'] = Carbon::createFromFormat(
            "Y-m-d\TH:i:s.v\Z",
            $validated['entrance']
        )->toDateTimeString();

        $validated['email'] = session('email');

        return $validated;
    }
}
