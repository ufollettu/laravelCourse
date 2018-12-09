<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'album_thumb' => 'required|image',
            // 'user_id' => 'required',
        ];
    }

    // per sovrascrivere i messaggi d'errore basta dichiarare un metodo messages()
    public function messages()
    {
        return [
            'name.required' => 'il nome dell\'album è obbligatorio',
            'album_thumb.required' => 'il thumb dell\'album è obbligatorio',
            'description.required' => 'la descrizione dell\'album è obbligatorio',
        ];
    }
}
