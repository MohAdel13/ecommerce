<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Modules\Category\Models\Category;

class CategoryDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $images = collect(File::files(__DIR__ . '/media'))
            ->sortBy(fn($file) => $file->getFilename())
            ->values();

        $categories = [
            [
                'name_en' => 'Electronics',
                'name_ar' => 'الإلكترونيات',
                'parent' => null,
            ],
            [
                'name_en' => 'Mobile Phones',
                'name_ar' => 'الهواتف المحمولة',
                'parent' => 'Electronics',
            ],
            [
                'name_en' => 'Laptops',
                'name_ar' => 'أجهزة الكمبيوتر المحمولة',
                'parent' => 'Electronics',
            ],
            [
                'name_en' => 'Headphones',
                'name_ar' => 'سماعات الرأس',
                'parent' => 'Electronics',
            ],
            [
                'name_en' => 'Cameras',
                'name_ar' => 'الكاميرات',
                'parent' => 'Electronics',
            ],

            [
                'name_en' => 'Fashion',
                'name_ar' => 'الأزياء',
                'parent' => null,
            ],
            [
                'name_en' => "Men's Clothing",
                'name_ar' => 'ملابس رجالية',
                'parent' => 'Fashion',
            ],
            [
                'name_en' => "Women's Clothing",
                'name_ar' => 'ملابس نسائية',
                'parent' => 'Fashion',
            ],
            [
                'name_en' => 'Shoes',
                'name_ar' => 'الأحذية',
                'parent' => 'Fashion',
            ],
            [
                'name_en' => 'Bags',
                'name_ar' => 'الحقائب',
                'parent' => 'Fashion',
            ],

            [
                'name_en' => 'Home & Furniture',
                'name_ar' => 'المنزل والأثاث',
                'parent' => null,
            ],
            [
                'name_en' => 'Kitchen',
                'name_ar' => 'المطبخ',
                'parent' => 'Home & Furniture',
            ],
            [
                'name_en' => 'Home Appliances',
                'name_ar' => 'الأجهزة المنزلية',
                'parent' => 'Home & Furniture',
            ],

            [
                'name_en' => 'Beauty',
                'name_ar' => 'الجمال',
                'parent' => null,
            ],
            [
                'name_en' => 'Sports',
                'name_ar' => 'الرياضة',
                'parent' => null,
            ],
            [
                'name_en' => 'Toys',
                'name_ar' => 'الألعاب',
                'parent' => null,
            ],
            [
                'name_en' => 'Books',
                'name_ar' => 'الكتب',
                'parent' => null,
            ],
            [
                'name_en' => 'Groceries',
                'name_ar' => 'البقالة',
                'parent' => null,
            ],
            [
                'name_en' => 'Automotive',
                'name_ar' => 'السيارات',
                'parent' => null,
            ],
            [
                'name_en' => 'Pet Supplies',
                'name_ar' => 'مستلزمات الحيوانات الأليفة',
                'parent' => null,
            ],
        ];

        $categoryIds = [];

        foreach ($categories as $index => $data) {
            $parentId = $data['parent']
                ? $categoryIds[$data['parent']]
                : null;

            $category = Category::create([
                'name_en' => $data['name_en'],
                'name_ar' => $data['name_ar'],
                'parent_id' => $parentId,
            ]);

            $categoryIds[$data['name_en']] = $category->id;

            if (isset($images[$index])) {
                $category
                    ->addMedia($images[$index]->getPathname())
                    ->preservingOriginal()
                    ->toMediaCollection('categories');
            }
        }
    }
}