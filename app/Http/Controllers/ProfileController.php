<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function updateAddress(Request $request): JsonResponse
    {
        $request->validate([
            'shipping_address' => ['required', 'string', 'max:1000'],
        ]);

        $user = Auth::user();
        $user->update([
            'shipping_address' => $request->string('shipping_address'),
        ]);

        return response()->json([
            'message' => 'Shipping address updated successfully.',
            'shipping_address' => $user->shipping_address,
        ]);
    }
}
