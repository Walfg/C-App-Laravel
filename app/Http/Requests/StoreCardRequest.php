<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCardRequest extends FormRequest
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
            "name" => "required",
            "phone_number" => "required|digits:9",
            "email" => [
                "required",
                "email",
                //applies the rule BUT allowing other users to register the same mail as contact,
                //once pero user.
                Rule::unique("contacts", "email")->where("user_id", auth()->user())
                ->ignore(request()->route("card"))
            ],
            "age" => "required|numeric|min:3|max:255",
            "profile_pricture" => "image|nullable"
        ];
    }

public function messages(){
    return [
        "email.unique" => "This mail is already registered."
    ];
}

}
