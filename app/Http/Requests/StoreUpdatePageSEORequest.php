<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreUpdatePageSEORequest extends FormRequest
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
        $slug = Str::slug($this->title);
        return [
            // 'slug' => "required|unique:pages,slug,{$slug},slug",
            'title' => 'required|min:3|max:255|unique:pages,slug,{$slug},slug',
            'meta_title' => 'min:3|max:255',
            'path' => 'required|max:255',
            'image' => ['nullable', 'image'],
            'description' => 'min:3',
        ];
    }
}
