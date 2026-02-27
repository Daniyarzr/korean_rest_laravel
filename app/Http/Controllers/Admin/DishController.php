<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DishController extends Controller
{
    public function index()
    {
        $dishes = Dish::with('category')->latest()->paginate(20);

        return view('admin.dishes.index', compact('dishes'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.dishes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'price'       => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);

        if ($request->hasFile('image')) {
            $validated['url_image'] = $request->file('image')->store('dishes', 'public');
        }

        Dish::create($validated);

        return redirect()->route('admin.dishes.index')
            ->with('success', 'Блюдо создано');
    }

    public function edit(Dish $dish)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();

        return view('admin.dishes.edit', compact('dish', 'categories'));
    }

    public function update(Request $request, Dish $dish)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'price'       => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);

        if ($request->hasFile('image')) {
            // удаляем старое фото
            if ($dish->url_image) {
                Storage::disk('public')->delete($dish->url_image);
            }
            $validated['url_image'] = $request->file('image')->store('dishes', 'public');
        }

        $dish->update($validated);

        return redirect()->route('admin.dishes.index')
            ->with('success', 'Блюдо обновлено');
    }

    public function destroy(Dish $dish)
    {
        if ($dish->url_image) {
            Storage::disk('public')->delete($dish->url_image);
        }

        $dish->delete();

        return redirect()->route('admin.dishes.index')
            ->with('success', 'Блюдо удалено');
    }
}