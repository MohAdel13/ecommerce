<?php

namespace Modules\Banner\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Modules\Banner\Models\Banner;
use Modules\Category\Models\Category;

class BannerDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $images = collect(File::files(__DIR__ . '/media'))
            ->keyBy(fn($file) => $file->getFilename());

        $categories = Category::pluck('id', 'name_en');

        $banners = [
            [
                'is_external' => false,
                'category' => 'Electronics',
                'link' => null,
                'image' => 'Electronics.jpg',
            ],
            [
                'is_external' => false,
                'category' => 'Fashion',
                'link' => null,
                'image' => 'Fashion.jpg',
            ],
            [
                'is_external' => false,
                'category' => 'Home & Kitchen',
                'link' => null,
                'image' => 'Home & Kitchen.jpg',
            ],
            [
                'is_external' => false,
                'category' => 'Sports',
                'link' => null,
                'image' => 'Sport.jpg',
            ],
            [
                'is_external' => true,
                'category' => null,
                'link' => 'https://www.google.com/',
                'image' => 'Google.jpg',
            ],
            [
                'is_external' => true,
                'category' => null,
                'link' => 'https://www.tiktok.com/',
                'image' => 'Tiktok.jpg',
            ],
        ];

        foreach ($banners as $bannerData) {
            $categoryId = null;

            if ($bannerData['category']) {
                $categoryKey = strtolower($bannerData['category']);

                $categoryId = $categories->first(
                    fn($id, $name) => strtolower($name) === $categoryKey
                );
            }

            $banner = Banner::create([
                'is_external' => $bannerData['is_external'],
                'link' => $bannerData['link'],
                'category_id' => $categoryId,
            ]);

            $image = $images->get($bannerData['image']);

            if ($image) {
                $banner
                    ->addMedia($image->getPathname())
                    ->preservingOriginal()
                    ->usingName(pathinfo($bannerData['image'], PATHINFO_FILENAME))
                    ->usingFileName($bannerData['image'])
                    ->toMediaCollection('banners');
            }
        }
    }
}