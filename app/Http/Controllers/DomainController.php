<?php

namespace App\Http\Controllers;

use App\Http\Requests\Domain\StoreDomainRequest;
use App\Http\Resources\PingResource;
use App\Models\Domain;
use App\Models\Ping;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function store(StoreDomainRequest $request)
    {
        $data = $request->validated();
        $domain = Domain::firstOrCreate($data);
        return response()->json([
            "message" => "success",
            "desc" => "Domain: " . $domain->name . " successfully added"
        ]);
    }

    public function show(Domain $domain)
    {
        //->diffForHumans()
        $pings = PingResource::collection($domain->pings)->resolve();
        return inertia('Pings/SinglePage', [
            "pings" => $pings,
            'domain' => $domain
        ]);
    }
}
