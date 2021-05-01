<?php

namespace App\Http\Requests;

class CommentRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  $this->method() == 'POST' || $this->user()->comments()->where('id', $this->route('comment')->id)->exists();
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
                'content' => 'required|string|max:255',
                'is_published' => 'nullable|boolean',
                'post_id' => 'required|exists:posts,id'
            ];
        }

        return $rules;
    }
}
