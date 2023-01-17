<?php declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'order_pos' => $this->order_pos,
            'canvas_link' => $this->canvas_link,
            'hits' => $this->hits
        ];
    }
}
