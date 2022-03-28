<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FindLinks implements Rule
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
        $reg_exUrl = "/((\w+:\/\/\S+)|(\w+[\.:]\w+\S+))[^\s,\.]/i";
        //$reg_exUrl = "/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))/";
        preg_match($reg_exUrl, $value, $matches);
        return (count($matches)) ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Не может содержать ссылки';
    }
}
