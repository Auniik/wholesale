<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class PurchaseProductCode implements Rule
{
    private $code, $quantity;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($code, $quantity)
    {
        $this->code = $code;
        $this->quantity = $quantity;
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
        if($this->quantity > 0){
            return 'required';
        }
        return 'nullable';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
