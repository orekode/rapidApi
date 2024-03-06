<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Category;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = parent::toArray($request);

        $response['images'] = $this->images;

        $categories = explode(' ', $this->categories);
        $categories = Category::whereIn('id', $categories)->get();

        $response['categories'] = $categories;

        foreach ($response['images'] as &$image) {
            $image['image'] = env('UPLOAD_URL') . $image['image'];
        }

        $response['image'] = $response['images'][0]['image'] ?? env('UPLOAD_URL') . 'products/product.jpg';

        return $response;
    }
}
