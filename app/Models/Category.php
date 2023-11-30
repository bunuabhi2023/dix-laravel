<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

     protected $fillable = ['name', 'parent_id'];

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public static function getCategoriesTree($parentId = null)
    {
        $categories = static::where('parent_id', $parentId)->get();

        $categories->each(function ($category) {
            $category->subcategories = static::getCategoriesTree($category->id);
        });

        return $categories;
    }
}
