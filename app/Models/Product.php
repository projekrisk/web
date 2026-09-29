<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'category', 'meta_description', 
        'description', 'price', 'strike_price', 
        'featured_image', 'gallery', 'status',
        'download_type', 'download_link', 'download_file', 'demo_url'
    ];

    protected $casts = [
        'gallery' => 'array', 
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating(): float
    {
        return (float) ($this->reviews()->where('status', 'approved')->avg('rating') ?? 0);
    }

    public function reviewsCount(): int
    {
        return $this->reviews()->where('status', 'approved')->count();
    }
}