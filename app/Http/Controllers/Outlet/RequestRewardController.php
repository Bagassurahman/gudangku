<?php

namespace App\Http\Controllers\Outlet;

use App\Http\Controllers\Controller;
use App\Jobs\SendWhatsAppNotification;
use App\RequestReward;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert as Swal;

class RequestRewardController extends Controller
{
    public function index()
    {
        $requests = RequestReward::where('outlet_id', auth()->user()->outlet->id)->get();

        return view('outlet.request-rewards.index', compact('requests'));
    }

    public function show(Request $request)
    {
        $request = RequestReward::find($request->id);

        return view('outlet.request-rewards.show', compact('request'));
    }

    public function update(Request $request)
    {
        $requestReward = RequestReward::find($request->id);
        $requestReward->status = 'completed';
        $requestReward->completed_at = now();
        $requestReward->proof = $request->file('proof')->store('assets/bukti-penukaran', 'public');
        $requestReward->save();

        $message = "Halo, " . $requestReward->user->name . PHP_EOL .
            "Kamu telah melakukan pengambilan hadiah dengan kode " . $requestReward->code . PHP_EOL .
            "Hadiah: " . $requestReward->reward->name . PHP_EOL .
            "Bukti penukaran: " . asset('storage/' . $requestReward->proof) . PHP_EOL .
            "Terima kasih.";

        SendWhatsAppNotification::dispatch($requestReward->user->phone, $message);

        Swal::success('Berhasil', 'Bukti penukaran hadiah telah diunggah');

        return redirect()->route('outlet.request-reward.index');
    }
}
