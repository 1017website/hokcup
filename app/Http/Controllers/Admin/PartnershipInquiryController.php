<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnershipInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartnershipInquiryController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $inquiries = PartnershipInquiry::query()
            ->when($status && array_key_exists($status, PartnershipInquiry::statuses()), fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.partnership-inquiries.index', [
            'inquiries' => $inquiries,
            'status' => $status,
            'statuses' => PartnershipInquiry::statuses(),
            'totalCount' => PartnershipInquiry::count(),
            'newCount' => PartnershipInquiry::where('status', PartnershipInquiry::STATUS_NEW)->count(),
            'contactedCount' => PartnershipInquiry::where('status', PartnershipInquiry::STATUS_CONTACTED)->count(),
        ]);
    }

    public function show(PartnershipInquiry $partnershipInquiry): View
    {
        return view('admin.partnership-inquiries.show', [
            'inquiry' => $partnershipInquiry,
            'statuses' => PartnershipInquiry::statuses(),
        ]);
    }

    public function update(Request $request, PartnershipInquiry $partnershipInquiry): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'in:' . implode(',', array_keys(PartnershipInquiry::statuses()))],
        ]);

        $partnershipInquiry->status = $data['status'];
        $partnershipInquiry->contacted_at = $data['status'] === PartnershipInquiry::STATUS_CONTACTED
            ? ($partnershipInquiry->contacted_at ?: now())
            : null;
        $partnershipInquiry->save();

        return back()->with('success', 'Status data mitra berhasil diperbarui.');
    }

    public function destroy(PartnershipInquiry $partnershipInquiry): RedirectResponse
    {
        $partnershipInquiry->delete();

        return redirect()->route('admin.partnership-inquiries.index')->with('success', 'Data mitra berhasil dihapus.');
    }
}
