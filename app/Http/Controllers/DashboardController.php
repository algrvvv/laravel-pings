<?php

namespace App\Http\Controllers;

use App\Http\Resources\PingResource;
use App\Models\Domain;
use App\Models\Ping;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(): \Inertia\Response|\Inertia\ResponseFactory
    {
        //TODO вернуть последние 100 пингов

        //Ping::latest()->paginate(20)
//        $info = PingResource::collection(Ping::latest()->get())->resolve();
        $domains = Domain::select('id', 'name')->get();
        return inertia('Dashboard', compact('domains'));
    }
}
