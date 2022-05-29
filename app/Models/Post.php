<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'category_id'];
    
    public function category() {
        return $this->BelongsTo(Category::class);
    }

    public function scopeFilter($query, array $filters) {
        
        if($filters['search'] ?? false) {
            $query->where( 'title', 'like', '%' . request('search') . '%' )
            ->orWhere('body', 'like', '%' . request('search') . '%' )
            ->orWhere('category_id', 'like', '%' . request('search') . '%' );
        }//project2.test/?search=test
    
    }

    
}
