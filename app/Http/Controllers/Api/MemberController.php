<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function getMemberByPhoneNumber($phoneNumber)
    {
        $member = User::where('phone', $phoneNumber)->first();

        if ($member) {
            return response()->json([
                'status' => 'success',
                'message' => 'Member ditemukan',
                'data' => $member
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Member tidak ditemukan',
                'data' => null
            ], 404);
        }
    }
}
