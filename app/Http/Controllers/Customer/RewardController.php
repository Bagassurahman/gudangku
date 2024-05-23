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

        $message = "Pengajuan Penukaran point berhasil." . PHP_EOL .
            "Selanjutnya akan kami informasikan jika hadiah sudah bisa diambil." . PHP_EOL .
            "Sehat dan sukses selalu Ka " . $user->name . PHP_EOL .
            "Jangan lupa ajak teman daftar di sobtime.com";

        SendWhatsAppNotification::dispatch($user->phone, "Halo {$user->name}, " . $message);

        Swal::success('Success', 'Hadiah berhasil ditukarkan, silahkan tunggu konfirmasi dari admin');

        return redirect()->back();
    }
}
