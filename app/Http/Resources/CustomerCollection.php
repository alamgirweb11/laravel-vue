<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
             'data' => $this->collection->transform(function($customer){
                   return [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'mobile' => $customer->mobile,
                    'image' => $customer->image,
                    'total' => $customer->total,
                    'status' => $customer->status,
                    'created_at' => $customer->created_at,
                    'updated_at' => $customer->updated_at,
                   ];
             })
        ];
    }
}
