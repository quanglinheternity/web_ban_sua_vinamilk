<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
        // return [
        //     'id' => $this->id,
        //     'ma_don_hang' => $this->order_code,
        //     // 'customer_name' => $this->customer_name ?? null,
        //     // 'total' => $this->total,
        //     // 'status' => [
        //     //     'id' => $this->trang_thai,
        //     //     'name' => optional($this->orderStatus)->name,
        //     // ],
        //     // 'payment_status' => $this->trang_thai_thanh_toan,
        //     // 'payment_method' => optional($this->paymentMethod)->name,
        //     // 'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        //     // 'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        // ];
    }
}
