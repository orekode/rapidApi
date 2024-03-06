<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'                  => ['unique:products,name,except,' . $this->product->id],
            'price'                 => ['numeric'],
            'quantity'              => ['integer'],
            'categories'            => [function ($attr, $value, $fail) {

                $categoryIds = explode(' ', trim($value));
                $categoryIds = array_filter($categoryIds);
                $categoriesCount = Category::whereIn('id', $categoryIds)->count();
                $check = count($categoryIds) == $categoriesCount;

                if (!$check) {
                    $fail(" A selected category no longer exists ");
                }

                return $check;
            }],
            'images.*' => ['image', 'max:5048']
        ];
    }
}
