<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PartnershipInquiry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PartnershipInquiryController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'business' => ['required', 'string', 'max:180'],
            'phone' => ['required', 'string', 'max:40'],
            'city' => ['required', 'string', 'max:120'],
            'type' => ['required', 'string', 'max:120'],
            'need' => ['required', 'string', 'max:160'],
            'message' => ['nullable', 'string', 'max:2000'],
            'source_url' => ['nullable', 'string', 'max:2048'],
        ]);

        $inquiry = PartnershipInquiry::create([
            'name' => $data['name'],
            'business_name' => $data['business'],
            'phone' => $data['phone'],
            'city' => $data['city'],
            'partner_type' => $data['type'],
            'estimated_need' => $data['need'],
            'message' => $data['message'] ?? null,
            'source_url' => $data['source_url'] ?? $request->headers->get('referer'),
            'ip_address' => $request->ip(),
            'user_agent' => Str::limit((string) $request->userAgent(), 1000, ''),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data mitra berhasil tersimpan.',
            'id' => $inquiry->id,
        ]);
    }
}
