<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class FollowsDateFormat implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return Carbon::canBeCreatedFromFormat($value, "Y-m-d\TH:i:s.v\Z");
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $now = Carbon::now()->format("Y-m-d\TH:i:s.v\Z");
        return 'El valor de \':attribute\' debe seguir este formato: yyyy-mm-dd\'T\'hh:mm:ss.mss\'Z\'. E.J: ' . $now;
    }
}
