<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Str;
use function dd;

class Post extends Model
{
    use HasFactory;
    use Concerns\ConvertMarkdownToHtml;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class,'likeable');
    }

    public function title(): Attribute
    {
        return Attribute::set(fn($value) => Str::title($value));
    }

    public function showRoute(array $parameters = []): string
    {
        return route('posts.show',[$this, Str::slug($this->title), ...$parameters]);
    }
}
