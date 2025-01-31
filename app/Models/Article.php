<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Article extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',      // The title of the article
        'content',    // The content of the article
        'url',        // The URL of the article
        'source_id',  // Foreign key for the source
    ];

    /**
     * Define the relationship with the Source model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function source()
    {
        return $this->belongsTo(Source::class);
    }

   
    protected static function booted()
    {
        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    public function getSlugAttribute($value)
    {
        return $value ?: Str::slug($this->title);
    }

     // Define the category relationship
     public function category()
     {
         return $this->belongsTo(Category::class);
     }
}
