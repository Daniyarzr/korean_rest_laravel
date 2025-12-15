<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Dish;
use App\Models\Category;

class DishesSeeder extends Seeder
{
    public function run(): void
    {
        // Сначала создадим категории если их нет
        $categories = [
            [
                'name' => 'Супы',
                'slug' => 'soups',
                'description' => 'Горячие корейские супы',
                'sort_order' => 1,
            ],
            [
                'name' => 'Основные блюда',
                'slug' => 'main-dishes',
                'description' => 'Основные корейские блюда',
                'sort_order' => 2,
            ],
            [
                'name' => 'Закуски',
                'slug' => 'appetizers',
                'description' => 'Корейские закуски и салаты',
                'sort_order' => 3,
            ],
            [
                'name' => 'Напитки',
                'slug' => 'drinks',
                'description' => 'Традиционные корейские напитки',
                'sort_order' => 4,
            ],
            [
                'name' => 'Сладости',
                'slug' => 'desserts',
                'description' => 'Корейские десерты',
                'sort_order' => 5,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }

        // Получаем ID категорий
        $soupsCategory = Category::where('slug', 'soups')->first();
        $mainCategory = Category::where('slug', 'main-dishes')->first();
        $appetizersCategory = Category::where('slug', 'appetizers')->first();
        $drinksCategory = Category::where('slug', 'drinks')->first();
        $dessertsCategory = Category::where('slug', 'desserts')->first();

        // Массив корейских блюд
        $dishes = [
            // СУПЫ
            [
                'name' => 'Кимчи-чигэ',
                'description' => 'Острый корейский суп с кимчи, тофу и свининой',
                'price' => 450,
                'url_image' => 'kimchi-jijgae.jpg',
                'is_spicy' => true,
                'is_vegetarian' => false,
                'category_id' => $soupsCategory->id,
            ],
            [
                'name' => 'Сундубу-чигэ',
                'description' => 'Острый суп с мягким тофу, морепродуктами и яйцом',
                'price' => 480,
                'url_image' => 'sundubu-jijgae.jpg',
                'is_spicy' => true,
                'is_vegetarian' => false,
                'category_id' => $soupsCategory->id,
            ],
            [
                'name' => 'Твенджан-чигэ',
                'description' => 'Суп из соевой пасты с овощами и тофу',
                'price' => 420,
                'url_image' => 'doenjang-jijgae.jpg',
                'is_spicy' => false,
                'is_vegetarian' => true,
                'category_id' => $soupsCategory->id,
            ],
            [
                'name' => 'Чонголь',
                'description' => 'Корейское тушеное блюдо с мясом и овощами',
                'price' => 550,
                'url_image' => 'jeongol.jpg',
                'is_spicy' => false,
                'is_vegetarian' => false,
                'category_id' => $soupsCategory->id,
            ],

            // ОСНОВНЫЕ БЛЮДА
            [
                'name' => 'Бибимбап',
                'description' => 'Рис с овощами, мясом, яйцом и кочхуджан',
                'price' => 380,
                'url_image' => 'bibimbap.jpg',
                'is_spicy' => true,
                'is_vegetarian' => false,
                'category_id' => $mainCategory->id,
            ],
            [
                'name' => 'Кимчи-боккымбап',
                'description' => 'Жареный рис с кимчи, овощами и мясом',
                'price' => 350,
                'url_image' => 'kimchi-bokkeumbap.jpg',
                'is_spicy' => true,
                'is_vegetarian' => false,
                'category_id' => $mainCategory->id,
            ],
            [
                'name' => 'Даккальби',
                'description' => 'Острое тушеное куриное блюдо с овощами',
                'price' => 520,
                'url_image' => 'dakgalbi.jpg',
                'is_spicy' => true,
                'is_vegetarian' => false,
                'category_id' => $mainCategory->id,
            ],
            [
                'name' => 'Карбонара',
                'description' => 'Паста с беконом, сливками и сыром',
                'price' => 420,
                'url_image' => 'carbonara.jpg',
                'is_spicy' => false,
                'is_vegetarian' => false,
                'category_id' => $mainCategory->id,
            ],

            // ЗАКУСКИ
            [
                'name' => 'Кимчи',
                'description' => 'Острые ферментированные овощи по-корейски',
                'price' => 150,
                'url_image' => 'kimchi.jpg',
                'is_spicy' => true,
                'is_vegetarian' => true,
                'category_id' => $appetizersCategory->id,
            ],
            [
                'name' => 'Манду',
                'description' => 'Корейские пельмени с мясной или овощной начинкой',
                'price' => 280,
                'url_image' => 'mandu.jpg',
                'is_spicy' => false,
                'is_vegetarian' => false,
                'category_id' => $appetizersCategory->id,
            ],
            [
                'name' => 'Одэн',
                'description' => 'Корейские рыбные котлеты в бульоне',
                'price' => 220,
                'url_image' => 'odeng.jpg',
                'is_spicy' => false,
                'is_vegetarian' => false,
                'category_id' => $appetizersCategory->id,
            ],
            [
                'name' => 'Твигим',
                'description' => 'Хрустящие жареные куриные крылышки',
                'price' => 320,
                'url_image' => 'twigin.jpg',
                'is_spicy' => true,
                'is_vegetarian' => false,
                'category_id' => $appetizersCategory->id,
            ],

            // НАПИТКИ
            [
                'name' => 'Борича',
                'description' => 'Традиционный корейский ячменный чай',
                'price' => 120,
                'url_image' => 'boricha.jpg',
                'is_spicy' => false,
                'is_vegetarian' => true,
                'category_id' => $drinksCategory->id,
            ],
            [
                'name' => 'Юджа-ча',
                'description' => 'Цитрусовый чай из юдзы с медом',
                'price' => 140,
                'url_image' => 'yuja-cha.jpg',
                'is_spicy' => false,
                'is_vegetarian' => true,
                'category_id' => $drinksCategory->id,
            ],
            [
                'name' => 'Гамгвача',
                'description' => 'Корейский чай из хурмы',
                'price' => 130,
                'url_image' => 'gamgwacha.jpg',
                'is_spicy' => false,
                'is_vegetarian' => true,
                'category_id' => $drinksCategory->id,
            ],

            // СЛАДОСТИ
            [
                'name' => 'Сонпхён',
                'description' => 'Корейские рисовые лепешки с начинкой',
                'price' => 180,
                'url_image' => 'songpyeon.jpg',
                'is_spicy' => false,
                'is_vegetarian' => true,
                'category_id' => $dessertsCategory->id,
            ],
        ];

        // Добавляем блюда
        foreach ($dishes as $dishData) {
            Dish::firstOrCreate(
                ['name' => $dishData['name']],
                $dishData
            );
        }

        $this->command->info('✅ Добавлено ' . count($dishes) . ' корейских блюд!');
    }
}