<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'title', 'slug', 'meta_description', 
        'content', 'featured_image', 'status'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}