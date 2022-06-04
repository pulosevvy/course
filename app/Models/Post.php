<?php

namespace App\Models;

use App\Models\Category;

use App\Filters\QueryFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'category_id'];
    
    public function category() {
        return $this->BelongsTo(Category::class);
    }

    // public function scopeFilter($query, array $filters) {
        
    //     // if($filters['search'] ?? false) {
    //     //     $query->where( 'title', 'like', '%' . request('search') . '%' )
    //     //     ->orWhere('body', 'like', '%' . request('search') . '%' );
    //     // }
    // }

    public function scopeFilter(Builder $builder, QueryFilter $filter) {
        return $filter->apply($builder);
    }

    
}
