<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Perfume;
use App\Models\PerfumesCategory;
use App\Models\Sunglasses;
use App\Models\SunglassesCategory;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'perfumes' => Perfume::count(),
            'sunglasses' => Sunglasses::count(),
            'perfume_categories' => PerfumesCategory::count(),
            'sunglasses_categories' => SunglassesCategory::count(),
            'orders' => Order::count(),
            'pending_orders' => Order::query()->where('status', 'pending')->count(),
        ];

        return view('admin.dashboard.index', compact('stats'));
    }
}

