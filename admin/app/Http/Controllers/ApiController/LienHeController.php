<?php

namespace App\Http\Controllers\ApiController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LienHeController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'LienHe form endpoint']);
    }

    public function send(Request $request)
    {
        $request->validate([
            'ten' => 'required',
            'email' => 'required|email',
            'tieude' => 'required',
            'noidung' => 'required'
        ]);

        $data = [
            'name'         => $request->input('ten'),
            'email'        => $request->input('email'),
            'subject'      => $request->input('tieude'),
            'user_message' => $request->input('noidung'),
        ];

        Mail::send('email.contact', $data, function ($message) use ($data) {
            $message->to('tokhoi1312@gmail.com')
                ->subject($data['subject']);
        });

        return response()->json(['success' => true, 'message' => 'Tin nhắn của bạn đã được gửi thành công!']);
    }
}
