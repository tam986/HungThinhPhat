<?php

namespace App\Http\Controllers\ApiController;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function getSettings()
    {
        $keys = [
            'contact_phone',
            'contact_email',
            'zalo_url',
            'facebook_url',
            'youtube_url',
            'tiktok_url',
            'address'
        ];

        $settings = Setting::whereIn('key', $keys)->get()->pluck('value', 'key');
        
        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    }

    public function getBankSettings()
    {
        // Fetch all bank-related settings and return as a key-value object
        $keys = [
            'bank_name',
            'bank_account_number',
            'bank_account_name',
            'bank_qr_code'
        ];

        $settings = Setting::whereIn('key', $keys)->get()->pluck('value', 'key');
        
        return response()->json([
            'success' => true,
            'data' => $settings
        ]);
    }
}
