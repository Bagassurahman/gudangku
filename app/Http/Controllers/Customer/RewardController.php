<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Jobs\SendWhatsAppNotification;
use App\Reward;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert as Swal;

class RewardController extends Controller
{
    public function index()
    {
        $rewards = Reward::paginate(10);

        return view('customer.rewards.index', compact('rewards'));
    }

    public function show($slug)
    {
        $reward = Reward::where('slug', $slug)->firstOrFail();

        return view('customer.rewards.show', compact('reward'));
    }

    public function redeem($id)
    {
        $reward = Reward::findOrFail($id);

        $user = auth()->user();

        if ($user->point < $reward->point) {
            Swal::error('Failed', 'Kamu tidak memiliki cukup poin untuk menukarkan hadiah ini');

            return redirect()->back();
        }

        $user->point -= $reward->point;

        $user->save();

        $user->request_rewards()->create([
            'code' => 'REQ' . now()->format('YmdHis') . $user->id,
            'reward_id' => $reward->id,
            'point' => $reward->point,
            'status' => 'pending',
        ]);

        $user->points()->create([
            'point' => -$reward->point,
            'date' => now(),
        ]);

        SendWhatsAppNotification::dispatch($user->phone, "Halo {$user->name}, terima kasih telah menukarkan poin kamu dengan hadiah {$reward->name}. Silahkan tunggu konfirmasi dari admin ya.");

        Swal::success('Success', 'Hadiah berhasil ditukarkan, silahkan tunggu konfirmasi dari admin');

        return redirect()->back();
    }
}
