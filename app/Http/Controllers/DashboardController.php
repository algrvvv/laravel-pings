<?php

namespace App\Http\Controllers;

use App\Http\Resources\PingResource;
use App\Models\Ping;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(): \Inertia\Response|\Inertia\ResponseFactory
    {
        //TODO сделать пагинацию на стороне vue

        //Ping::latest()->paginate(20)
        $info = PingResource::collection(Ping::latest()->get())->resolve();
        return inertia('Dashboard', compact('info'));
    }
}
