<?php

namespace App\Http\Controllers;

use App\Http\Requests\Domain\StoreDomainRequest;
use App\Models\Domain;
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
}
