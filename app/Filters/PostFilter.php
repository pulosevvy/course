<?php

namespace App\Filters;

class PostFilter extends QueryFilter {

    public function filterCategoryId($id = null){
        return $this->builder->when($id, function($query) use($id) {
            $query->where('category_id', $id);
        });
    }

    public function search($search_string = '') {
        return $this->builder
        ->where('title', 'like', '%' . $search_string . '%')
        ->orWhere('body', 'like', '%' . $search_string . '%');
        
    }
}