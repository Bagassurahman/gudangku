<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Jobs\SendWhatsAppNotification;
use App\Outlet;
use App\RequestReward;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert as Swal;

class RequestRewardController extends Controller
{
    public function index()
    {
        $requests = RequestReward::all();

        return view('warehouse.request-rewards.index', compact('requests'));
    }

    public function show(Request $request)
    {
        $request = RequestReward::find($request->id);
        $outlets = Outlet::all();

        return view('warehouse.request-rewards.show', compact('request', 'outlets'));
    }

    public function approve(Request $request)
    {
        $rewardRequest = RequestReward::find($request->id);

        $rewardRequest->update([
            'outlet_id' => $request->outlet_id,
            'status' => 'approved',
            'note' => $request->note,
            'approved_at' => now(),
        ]);


        $message = "Halo, " . $rewardRequest->user->name . PHP_EOL .
            "Permintaan reward Anda telah disetujui." . PHP_EOL .
            "Kode reward: " . $rewardRequest->code . PHP_EOL .
            "Reward: " . $rewardRequest->reward->name . PHP_EOL .
            "Catatan: " . $rewardRequest->note . PHP_EOL .
            "Silakan datang ke outlet " . $rewardRequest->outlet->outlet_name . " untuk melakukan redeem reward." . PHP_EOL .
            "Terima kasih.";

        SendWhatsAppNotification::dispatch($rewardRequest->user->phone, $message);

        Swal::success('Berhasil', 'Permintaan reward telah disetujui');

        return redirect()->route('warehouse.request-reward.index');
    }

    public function reject(Request $request)
    {
        $request = RequestReward::find($request->id);

        $request->update([
            'status' => 'rejected',
            'note' => $request->note,
            'rejected_at' => now(),
        ]);

        $request->user->point += $request->point;

        $request->user->points()->create([
            'point' => $request->point,
            'date' => now(),
        ]);

        $request->user->save();

        $message = "Halo, " . $request->user->name . PHP_EOL .
            "Permintaan reward Anda telah ditolak." . PHP_EOL .
            "Reward: " . $request->reward->name . PHP_EOL .
            "Catatan: " . $request->note . PHP_EOL .
            "Point Anda telah dikembalikan." . PHP_EOL .
            "Terima kasih.";

        SendWhatsAppNotification::dispatch($request->user->phone, $message);

        Swal::success('Berhasil', 'Permintaan reward telah ditolak');

        return redirect()->route('warehouse.request-reward.index');
    }
}
