<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class AdminSettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        
        // Ensure standard keys exist for the UI to prevent undefined errors
        $defaults = [
            'site_name' => 'Hung Thinh Food',
            'contact_email' => '',
            'contact_phone' => '',
            'address' => '',
            'bank_name' => '',
            'bank_account_number' => '',
            'bank_account_name' => '',
            'bank_qr_code' => '',
            'facebook_url' => '',
            'youtube_url' => '',
            'tiktok_url' => '',
            'zalo_url' => '',
        ];

        $settings = array_merge($defaults, $settings);

        if (!empty($settings['bank_qr_code'])) {
            $settings['bank_qr_code_url'] = Storage::url($settings['bank_qr_code']);
        }

        return Inertia::render('Settings/Index', [
            'settings' => $settings
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        
        foreach ($data as $key => $value) {
            if ($request->hasFile($key)) {
                $path = $request->file($key)->store('uploads/settings', 'public');
                Setting::updateOrCreate(['key' => $key], ['value' => $path]);
            } else if (!is_array($value)) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
        }

        return redirect()->route('settings.index')->with('success', 'Cấu hình đã được cập nhật thành công!');
    }
}
