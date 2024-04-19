<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Http;

class FetchCategories extends Command
{
    protected $signature = 'fetch:categories';
    
    protected $description = 'Fetch categories from Mercadona API and store them in the database';
    
    public function handle()
    {
        $response = Http::get('https://tienda.mercadona.es/api/categories/');
        $data = $response->json();
        
        foreach ($data['results'] as $categoryData) {
            $category = Category::updateOrCreate(['id' => $categoryData['id']], $categoryData);
            
            foreach ($categoryData['categories'] as $subcategoryData) {
                Subcategory::updateOrCreate(['id' => $subcategoryData['id']], array_merge($subcategoryData, ['category_id' => $category->id]));
            }
        }
        
        $this->info('Categories fetched and stored successfully!');
    }
}
