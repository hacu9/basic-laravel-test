<?php

namespace App\Http\Requests;

class PostRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  ($this->method() == 'POST' || $this->method() == 'GET') || $this->user()->posts()->where('id', $this->route('post')->id)->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        if($this->method() == 'POST'){
            $rules = [
                'title' => 'required|string',
                'slug' => 'required|string',
                'content' => 'required|string|max:255',
                'is_published' => 'nullable|boolean',
            ];
        }

        return $rules;
    }
}
