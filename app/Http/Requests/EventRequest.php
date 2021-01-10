<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'nameEvent'       => 'required|max:55',
            'description' => 'max:255',
            'type_event_id' => 'required|integer',
            'date'        => 'required|date',
            'place'       => 'required|max:55',
            'organizer'   => 'max:50',
        ];
    }
}
