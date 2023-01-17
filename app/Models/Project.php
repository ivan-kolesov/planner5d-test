<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string $title
 * @property string $canvas_link
 * @property int $hits
 * @property int $order_pos
 */
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'canvas_link',
        'hits',
        'order_pos'
    ];

    protected $attributes = [
        'hits' => 0
    ];
}
