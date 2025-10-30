<?php

namespace App\Observers;

use App\Models\DonHang;
use App\Models\ThanhToan;

class DonHangObserver
{
    /**
     * Handle the DonHang "created" event.
     */
    public function created(DonHang $donHang): void
    {
        //
    }

    /**
     * Handle the DonHang "updated" event.
     */
    public function updated(DonHang $donHang)
    {
        if ($donHang->isDirty('trangthai') && $donHang->trangthai === 'hoàn thành') {
            $thanhToan = ThanhToan::where('id_donhang', $donHang->id)->first();
            if ($thanhToan && $thanhToan->phuongthucthanhtoan === 'pay_later') {
                $thanhToan->update([
                    'trangthai' => 'đã thanh toán',
                ]);
            }
        }
    }

    /**
     * Handle the DonHang "deleted" event.
     */
    public function deleted(DonHang $donHang): void
    {
        //
    }

    /**
     * Handle the DonHang "restored" event.
     */
    public function restored(DonHang $donHang): void
    {
        //
    }

    /**
     * Handle the DonHang "force deleted" event.
     */
    public function forceDeleted(DonHang $donHang): void
    {
        //
    }
}
