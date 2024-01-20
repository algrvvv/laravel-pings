<?php

namespace App\Http\Controllers;

use App\Http\Resources\PingResource;
use App\Models\Ping;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        //TODO сделать пагинацию
        $info = PingResource::collection(Ping::latest()->paginate(20))->resolve();
        return inertia('Dashboard', compact('info'));
    }
}
