<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
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
        return [
            'id_bienthe' => $this->id,
            'slug'       => $this->slug,
            'name'       => $this->sanpham ? $this->sanpham->tensp : 'Sản phẩm',
            'category'   => $this->sanpham && $this->sanpham->danhmuc ? $this->sanpham->danhmuc->tendanhmuc : null,
            'price'      => $this->gia,
            'sale_price' => $this->giakm,
            'weight'     => $this->khoiluong ? $this->khoiluong->khoiluong : null,
            'filling'    => $this->nhanbanh ? $this->nhanbanh->tenNhanBanh : null,
            'image'      => $this->hinh,
            'full_name'  => $this->full_name,
            'quantity'   => 1,
            'created_at' => $this->created_at,
        ];
    }
}
