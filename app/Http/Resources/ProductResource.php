<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductImagesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id'=> $this->id,
        'title'=> $this->title,
        'slug'=> $this->slug,
        'quantity'=> $this->quantity,
        'description'=> $this->description,
        'published'=> $this->published,
        'inStock'=> $this->inStock,
        'price'=> $this->price,
        'brand_id'=> $this->brand_id,
        'category_id'=> $this->category_id,
        'created_by'=> $this->created_by,
        'updated_by'=> $this->updated_by,
        'deleted_by'=> $this->deleted_by,
        'product_images'=>$this->whenLoaded('product_images',function(){
            return ProductImagesResource::collection($this->product_images);
        }),
        'category'=> new CategoryResource($this->whenLoaded('category')),
        'brand'=> new BrandResource($this->whenLoaded('brand'))
    ];
    }
}
