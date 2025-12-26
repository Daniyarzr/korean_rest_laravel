<?php

namespace App\Http\Controllers;
use App\Models\Category;  
use App\Models\Dish; 
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function home()
    {
       
        $categories = Category::where('is_active', true)
                            ->orderBy('sort_order')
                            ->get();
      
        $popularDishes = Dish::where('is_active', true)
                        ->inRandomOrder()
                        ->take(6)
                        ->get();

        
        return view('home', compact('categories', 'popularDishes'));
    }
        
        public function index(Request $request)
    {
        $search = $request->input('search');
        
      
        $query = Dish::with('category')->where('is_active', true);
        
        if ($search) {
            
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }
        
        $allDishes = $query->paginate(12);
        
        $categories = Category::where('is_active', true)
                            ->orderBy('sort_order')
                            ->get();

        return view('menu.index', compact('allDishes', 'categories', 'search'));
    }

    
        public function category(Request $request, Category $category)
    {
        $search = $request->input('search');
        
        $query = $category->dishes()
                        ->where('is_active', true);
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }
        
        $dishes = $query->paginate(12);
        
        $categories = Category::where('is_active', true)
                            ->orderBy('sort_order')
                            ->get();

        return view('menu.category', compact('category', 'dishes', 'categories', 'search'));
    }

    public function show(Dish $dish)
    {
       
        return view('menu.show', compact('dish'));
    }

   
}
