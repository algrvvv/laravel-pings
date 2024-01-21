<?php

namespace App\Http\Resources;

use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            //TODO удалить домен
            "info" => $this->info,
            "time" => $this->created_at->diffForHumans(),
            "chartTime" => $this->created_at->format('H:i:s'),
        ];
    }
}
