<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Category\Models\Category;
use Modules\Product\Models\Product;
use Modules\Product\Models\ProductVariant;

class ProductDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $categories = Category::pluck('id', 'name_en')
                ->mapWithKeys(fn($id, $name) => [
                    strtolower($name) => $id
                ])
                ->toArray();

            $images = collect(File::files(__DIR__ . '/media'))
                ->keyBy(fn($file) => $file->getFilename());

            $products = [
                // Electronics
                [
                    'name_en' => 'iPhone 15 Pro',
                    'name_ar' => 'آيفون 15 برو',
                    'description_en' => 'Premium smartphone with advanced camera and powerful performance.',
                    'description_ar' => 'هاتف ذكي متميز بكاميرا متطورة وأداء قوي.',
                    'category' => 'mobile phones',
                    'price' => 49999,
                    'stock' => 25,
                    'sku' => 'IPH15PRO-001',
                    'images' => [
                        '01_iphone_15_pro.jpg',
                        '01_iphone_15_pro_back.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Pro Camera System',
                            'title_ar' => 'نظام كاميرا احترافي',
                            'description_en' => 'Advanced camera system for professional-quality photos and videos.',
                            'description_ar' => 'نظام كاميرا متطور لالتقاط صور وفيديوهات بجودة احترافية.',
                        ],
                        [
                            'title_en' => 'Titanium Design',
                            'title_ar' => 'تصميم من التيتانيوم',
                            'description_en' => 'Premium lightweight titanium construction with a durable finish.',
                            'description_ar' => 'تصميم فاخر وخفيف مصنوع من التيتانيوم مع تشطيب متين.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Samsung Galaxy S24',
                    'name_ar' => 'سامسونج جالكسي S24',
                    'description_en' => 'Flagship Android smartphone with a high-resolution display.',
                    'description_ar' => 'هاتف أندرويد رائد بشاشة عالية الدقة.',
                    'category' => 'mobile phones',
                    'price' => 39999,
                    'stock' => 30,
                    'sku' => 'SAM-S24-001',
                    'images' => [
                        '02_samsung_galaxy_s24.jpg',
                        '02_samsung_galaxy_s24_back.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Dynamic AMOLED Display',
                            'title_ar' => 'شاشة Dynamic AMOLED',
                            'description_en' => 'Bright and detailed display with vivid colors.',
                            'description_ar' => 'شاشة مشرقة وعالية التفاصيل بألوان حيوية.',
                        ],
                        [
                            'title_en' => 'AI Features',
                            'title_ar' => 'مميزات الذكاء الاصطناعي',
                            'description_en' => 'Smart AI-powered tools for productivity and photography.',
                            'description_ar' => 'أدوات ذكية مدعومة بالذكاء الاصطناعي للإنتاجية والتصوير.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'MacBook Air M3',
                    'name_ar' => 'ماك بوك إير M3',
                    'description_en' => 'Lightweight laptop powered by the Apple M3 chip.',
                    'description_ar' => 'حاسوب محمول خفيف يعمل بمعالج Apple M3.',
                    'category' => 'laptops',
                    'price' => 64999,
                    'stock' => 15,
                    'sku' => 'MBA-M3-001',
                    'images' => [
                        '03_macbook_air_m3.jpg',
                        '03_macbook_air_m3_open.jpg',
                        '03_macbook_air_m3_side.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Apple M3 Chip',
                            'title_ar' => 'معالج Apple M3',
                            'description_en' => 'Powerful and efficient Apple silicon for everyday productivity.',
                            'description_ar' => 'معالج Apple Silicon قوي وفعال للاستخدام اليومي والإنتاجية.',
                        ],
                        [
                            'title_en' => 'Lightweight Design',
                            'title_ar' => 'تصميم خفيف',
                            'description_en' => 'Slim and lightweight design that is easy to carry.',
                            'description_ar' => 'تصميم نحيف وخفيف يسهل حمله والتنقل به.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Dell XPS 15',
                    'name_ar' => 'ديل XPS 15',
                    'description_en' => 'Premium performance laptop with a high-quality display.',
                    'description_ar' => 'حاسوب محمول عالي الأداء بشاشة عالية الجودة.',
                    'category' => 'laptops',
                    'price' => 72999,
                    'stock' => 10,
                    'sku' => 'DELL-XPS15-001',
                    'images' => [
                        '04_dell_xps_15.jpg',
                        '04_dell_xps_15_open.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'High Performance',
                            'title_ar' => 'أداء عالي',
                            'description_en' => 'Powerful hardware designed for demanding applications.',
                            'description_ar' => 'مكونات قوية مصممة للتطبيقات والمهام الصعبة.',
                        ],
                        [
                            'title_en' => 'InfinityEdge Display',
                            'title_ar' => 'شاشة InfinityEdge',
                            'description_en' => 'Premium display with thin bezels and excellent image quality.',
                            'description_ar' => 'شاشة متميزة بحواف رفيعة وجودة صورة عالية.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Sony WH-1000XM5',
                    'name_ar' => 'سوني WH-1000XM5',
                    'description_en' => 'Wireless noise-cancelling headphones with premium sound.',
                    'description_ar' => 'سماعات لاسلكية بخاصية عزل الضوضاء وصوت متميز.',
                    'category' => 'headphones',
                    'price' => 15999,
                    'stock' => 20,
                    'sku' => 'SONY-XM5-001',
                    'images' => [
                        '05_sony_wh1000xm5.jpg',
                        '05_sony_wh1000xm5_side.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Active Noise Cancellation',
                            'title_ar' => 'عزل الضوضاء النشط',
                            'description_en' => 'Advanced noise cancellation for an immersive listening experience.',
                            'description_ar' => 'تقنية متقدمة لعزل الضوضاء لتجربة استماع غامرة.',
                        ],
                        [
                            'title_en' => 'Premium Sound',
                            'title_ar' => 'صوت متميز',
                            'description_en' => 'Detailed audio with rich bass and clear vocals.',
                            'description_ar' => 'صوت غني بالتفاصيل مع جهير قوي ونقاء في الأصوات.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Apple AirPods Pro 2',
                    'name_ar' => 'آبل AirPods Pro 2',
                    'description_en' => 'Premium wireless earbuds with active noise cancellation.',
                    'description_ar' => 'سماعات أذن لاسلكية بخاصية عزل الضوضاء النشط.',
                    'category' => 'headphones',
                    'price' => 10999,
                    'stock' => 35,
                    'sku' => 'AIRPODS-PRO2-001',
                    'images' => [
                        '06_airpods_pro_2.jpg',
                        '06_airpods_pro_2_case.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Active Noise Cancellation',
                            'title_ar' => 'عزل الضوضاء النشط',
                            'description_en' => 'Reduces surrounding noise for focused listening.',
                            'description_ar' => 'تقلل الضوضاء المحيطة للحصول على تجربة استماع أكثر تركيزًا.',
                        ],
                        [
                            'title_en' => 'Wireless Charging Case',
                            'title_ar' => 'علبة شحن لاسلكية',
                            'description_en' => 'Compact charging case for convenient everyday use.',
                            'description_ar' => 'علبة شحن مدمجة للاستخدام اليومي بسهولة.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Canon EOS R6',
                    'name_ar' => 'كانون EOS R6',
                    'description_en' => 'Professional mirrorless camera for photography and video.',
                    'description_ar' => 'كاميرا احترافية بدون مرآة للتصوير والفيديو.',
                    'category' => 'cameras',
                    'price' => 84999,
                    'stock' => 8,
                    'sku' => 'CANON-R6-001',
                    'images' => [
                        '07_canon_eos_r6.jpg',
                        '07_canon_eos_r6_back.jpg',
                        '07_canon_eos_r6_side.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Full-Frame Sensor',
                            'title_ar' => 'مستشعر إطار كامل',
                            'description_en' => 'Full-frame sensor for detailed images and excellent low-light performance.',
                            'description_ar' => 'مستشعر إطار كامل للحصول على صور عالية التفاصيل وأداء ممتاز في الإضاءة المنخفضة.',
                        ],
                        [
                            'title_en' => 'Fast Autofocus',
                            'title_ar' => 'تركيز تلقائي سريع',
                            'description_en' => 'Fast and accurate autofocus for photography and video.',
                            'description_ar' => 'تركيز تلقائي سريع ودقيق للتصوير والفيديو.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Sony Alpha A7 IV',
                    'name_ar' => 'سوني Alpha A7 IV',
                    'description_en' => 'Full-frame mirrorless camera for professional creators.',
                    'description_ar' => 'كاميرا احترافية بدون مرآة بإطار كامل.',
                    'category' => 'cameras',
                    'price' => 94999,
                    'stock' => 6,
                    'sku' => 'SONY-A7IV-001',
                    'images' => [
                        '08_sony_a7iv.jpg',
                        '08_sony_a7iv_back.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Full-Frame Sensor',
                            'title_ar' => 'مستشعر إطار كامل',
                            'description_en' => 'High-resolution sensor for professional photography.',
                            'description_ar' => 'مستشعر عالي الدقة للتصوير الاحترافي.',
                        ],
                        [
                            'title_en' => 'Professional Video',
                            'title_ar' => 'فيديو احترافي',
                            'description_en' => 'Advanced video capabilities for professional content creation.',
                            'description_ar' => 'إمكانيات فيديو متقدمة لصناعة المحتوى الاحترافي.',
                        ],
                    ],
                ],

                // Fashion
                [
                    'name_en' => 'Classic Cotton T-Shirt',
                    'name_ar' => 'تيشيرت قطني كلاسيك',
                    'description_en' => 'Comfortable everyday cotton t-shirt.',
                    'description_ar' => 'تيشيرت قطني مريح للاستخدام اليومي.',
                    'category' => "men's clothing",
                    'price' => 599,
                    'stock' => 100,
                    'sku' => 'MENS-TSHIRT-001',
                    'images' => [
                        '09_mens_cotton_tshirt.jpg',
                        '09_mens_cotton_tshirt_back.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => '100% Cotton',
                            'title_ar' => 'قطن 100%',
                            'description_en' => 'Soft and breathable cotton fabric for everyday comfort.',
                            'description_ar' => 'قماش قطني ناعم وقابل للتنفس لراحة يومية.',
                        ],
                        [
                            'title_en' => 'Regular Fit',
                            'title_ar' => 'قصة عادية',
                            'description_en' => 'Classic fit suitable for casual everyday wear.',
                            'description_ar' => 'قصة كلاسيكية مناسبة للاستخدام اليومي.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Slim Fit Jeans',
                    'name_ar' => 'جينز بقصة ضيقة',
                    'description_en' => 'Modern slim-fit denim jeans.',
                    'description_ar' => 'بنطلون جينز عصري بقصة ضيقة.',
                    'category' => "men's clothing",
                    'price' => 1299,
                    'stock' => 70,
                    'sku' => 'MENS-JEANS-001',
                    'images' => [
                        '10_mens_slim_jeans.jpg',
                        '10_mens_slim_jeans_back.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Slim Fit',
                            'title_ar' => 'قصة ضيقة',
                            'description_en' => 'Modern slim silhouette for a stylish appearance.',
                            'description_ar' => 'قصة عصرية ضيقة لمظهر أنيق.',
                        ],
                        [
                            'title_en' => 'Durable Denim',
                            'title_ar' => 'دينم متين',
                            'description_en' => 'Durable denim fabric designed for everyday wear.',
                            'description_ar' => 'قماش دينم متين مصمم للاستخدام اليومي.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Women Floral Dress',
                    'name_ar' => 'فستان نسائي مزهر',
                    'description_en' => 'Elegant floral dress for everyday occasions.',
                    'description_ar' => 'فستان نسائي أنيق بنقوش زهور.',
                    'category' => "women's clothing",
                    'price' => 1499,
                    'stock' => 45,
                    'sku' => 'WOMEN-DRESS-001',
                    'images' => [
                        '11_womens_floral_dress.jpg',
                        '11_womens_floral_dress_back.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Floral Pattern',
                            'title_ar' => 'نقوش زهور',
                            'description_en' => 'Elegant floral pattern suitable for casual occasions.',
                            'description_ar' => 'نقوش زهور أنيقة مناسبة للمناسبات اليومية.',
                        ],
                        [
                            'title_en' => 'Comfortable Fabric',
                            'title_ar' => 'قماش مريح',
                            'description_en' => 'Lightweight fabric designed for comfortable wear.',
                            'description_ar' => 'قماش خفيف مصمم لراحة الاستخدام.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Women Oversized Hoodie',
                    'name_ar' => 'هودي نسائي واسع',
                    'description_en' => 'Comfortable oversized hoodie.',
                    'description_ar' => 'هودي نسائي مريح بقصة واسعة.',
                    'category' => "women's clothing",
                    'price' => 999,
                    'stock' => 50,
                    'sku' => 'WOMEN-HOODIE-001',
                    'images' => [
                        '12_womens_hoodie.jpg',
                        '12_womens_hoodie_back.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Oversized Fit',
                            'title_ar' => 'قصة واسعة',
                            'description_en' => 'Relaxed oversized fit for maximum comfort.',
                            'description_ar' => 'قصة واسعة ومريحة لتوفير أقصى درجات الراحة.',
                        ],
                        [
                            'title_en' => 'Soft Fabric',
                            'title_ar' => 'قماش ناعم',
                            'description_en' => 'Soft fabric suitable for everyday casual wear.',
                            'description_ar' => 'قماش ناعم مناسب للاستخدام اليومي.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Nike Air Max',
                    'name_ar' => 'نايكي Air Max',
                    'description_en' => 'Comfortable lifestyle sneakers.',
                    'description_ar' => 'حذاء رياضي مريح للاستخدام اليومي.',
                    'category' => 'shoes',
                    'price' => 4999,
                    'stock' => 40,
                    'sku' => 'NIKE-AIRMAX-001',
                    'images' => [
                        '13_nike_air_max.jpg',
                        '13_nike_air_max_side.jpg',
                        '13_nike_air_max_back.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Air Cushioning',
                            'title_ar' => 'وسادة هوائية',
                            'description_en' => 'Responsive cushioning provides comfort during everyday movement.',
                            'description_ar' => 'وسادة مرنة توفر الراحة أثناء الحركة اليومية.',
                        ],
                        [
                            'title_en' => 'Lifestyle Design',
                            'title_ar' => 'تصميم عصري',
                            'description_en' => 'Modern design suitable for casual everyday outfits.',
                            'description_ar' => 'تصميم عصري مناسب للإطلالات اليومية.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Adidas Running Shoes',
                    'name_ar' => 'أديداس أحذية جري',
                    'description_en' => 'Lightweight running shoes designed for daily training.',
                    'description_ar' => 'حذاء جري خفيف مصمم للتدريب اليومي.',
                    'category' => 'shoes',
                    'price' => 3999,
                    'stock' => 35,
                    'sku' => 'ADIDAS-RUN-001',
                    'images' => [
                        '14_adidas_running_shoes.jpg',
                        '14_adidas_running_shoes_side.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Lightweight Construction',
                            'title_ar' => 'تصميم خفيف',
                            'description_en' => 'Lightweight construction helps reduce fatigue during running.',
                            'description_ar' => 'تصميم خفيف يساعد على تقليل التعب أثناء الجري.',
                        ],
                        [
                            'title_en' => 'Breathable Upper',
                            'title_ar' => 'جزء علوي قابل للتنفس',
                            'description_en' => 'Breathable material helps keep feet comfortable.',
                            'description_ar' => 'خامة قابلة للتنفس تساعد على الحفاظ على راحة القدمين.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Leather Shoulder Bag',
                    'name_ar' => 'حقيبة كتف جلدية',
                    'description_en' => 'Elegant leather shoulder bag.',
                    'description_ar' => 'حقيبة كتف جلدية أنيقة.',
                    'category' => 'bags',
                    'price' => 2499,
                    'stock' => 25,
                    'sku' => 'LEATHER-BAG-001',
                    'images' => [
                        '15_leather_shoulder_bag.jpg',
                        '15_leather_shoulder_bag_inside.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Premium Leather',
                            'title_ar' => 'جلد فاخر',
                            'description_en' => 'Premium leather construction with an elegant appearance.',
                            'description_ar' => 'مصنوعة من جلد فاخر بمظهر أنيق.',
                        ],
                        [
                            'title_en' => 'Multiple Compartments',
                            'title_ar' => 'جيوب متعددة',
                            'description_en' => 'Multiple compartments for organized storage.',
                            'description_ar' => 'جيوب متعددة لتنظيم وحفظ الأغراض.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Travel Backpack',
                    'name_ar' => 'حقيبة ظهر للسفر',
                    'description_en' => 'Durable backpack suitable for travel and everyday use.',
                    'description_ar' => 'حقيبة ظهر متينة مناسبة للسفر والاستخدام اليومي.',
                    'category' => 'bags',
                    'price' => 1799,
                    'stock' => 30,
                    'sku' => 'TRAVEL-BAG-001',
                    'images' => [
                        '16_travel_backpack.jpg',
                        '16_travel_backpack_open.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Large Capacity',
                            'title_ar' => 'سعة كبيرة',
                            'description_en' => 'Spacious interior for clothes, electronics and travel essentials.',
                            'description_ar' => 'مساحة داخلية واسعة للملابس والإلكترونيات ومستلزمات السفر.',
                        ],
                        [
                            'title_en' => 'Durable Material',
                            'title_ar' => 'خامة متينة',
                            'description_en' => 'Durable material designed to withstand frequent travel.',
                            'description_ar' => 'خامة متينة مصممة لتحمل السفر المتكرر.',
                        ],
                    ],
                ],

                // Home & Furniture
                [
                    'name_en' => 'Stainless Steel Cookware Set',
                    'name_ar' => 'طقم أواني طبخ من الستانلس ستيل',
                    'description_en' => 'Complete stainless steel cookware set.',
                    'description_ar' => 'طقم متكامل من أواني الطبخ المصنوعة من الستانلس ستيل.',
                    'category' => 'kitchen',
                    'price' => 3999,
                    'stock' => 20,
                    'sku' => 'COOKWARE-001',
                    'images' => [
                        '17_stainless_cookware.jpg',
                        '17_stainless_cookware_pots.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Stainless Steel',
                            'title_ar' => 'ستانلس ستيل',
                            'description_en' => 'Durable stainless steel construction for everyday cooking.',
                            'description_ar' => 'مصنوع من الستانلس ستيل المتين للاستخدام اليومي.',
                        ],
                        [
                            'title_en' => 'Complete Set',
                            'title_ar' => 'طقم متكامل',
                            'description_en' => 'Includes multiple cookware pieces for versatile cooking.',
                            'description_ar' => 'يحتوي على عدة قطع للطهي المتنوع.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Non-Stick Frying Pan',
                    'name_ar' => 'مقلاة غير لاصقة',
                    'description_en' => 'Durable non-stick frying pan.',
                    'description_ar' => 'مقلاة متينة بطبقة غير لاصقة.',
                    'category' => 'kitchen',
                    'price' => 799,
                    'stock' => 60,
                    'sku' => 'PAN-NONSTICK-001',
                    'images' => [
                        '18_nonstick_frying_pan.jpg',
                        '18_nonstick_frying_pan_side.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Non-Stick Coating',
                            'title_ar' => 'طبقة غير لاصقة',
                            'description_en' => 'Non-stick surface makes cooking and cleaning easier.',
                            'description_ar' => 'سطح غير لاصق يجعل الطهي والتنظيف أكثر سهولة.',
                        ],
                        [
                            'title_en' => 'Heat Resistant Handle',
                            'title_ar' => 'مقبض مقاوم للحرارة',
                            'description_en' => 'Comfortable handle designed for safe cooking.',
                            'description_ar' => 'مقبض مريح مصمم للطهي بأمان.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Air Fryer 5L',
                    'name_ar' => 'قلاية هوائية 5 لتر',
                    'description_en' => 'Large-capacity air fryer for healthier cooking.',
                    'description_ar' => 'قلاية هوائية بسعة كبيرة للطهي الصحي.',
                    'category' => 'home appliances',
                    'price' => 3999,
                    'stock' => 25,
                    'sku' => 'AIRFRYER-5L-001',
                    'images' => [
                        '19_air_fryer.jpg',
                        '19_air_fryer_open.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => '5 Liter Capacity',
                            'title_ar' => 'سعة 5 لتر',
                            'description_en' => 'Large cooking capacity suitable for family meals.',
                            'description_ar' => 'سعة طهي كبيرة مناسبة للوجبات العائلية.',
                        ],
                        [
                            'title_en' => 'Low Oil Cooking',
                            'title_ar' => 'طهي بزيت قليل',
                            'description_en' => 'Cook crispy meals using significantly less oil.',
                            'description_ar' => 'تحضير وجبات مقرمشة باستخدام كمية أقل بكثير من الزيت.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Robot Vacuum Cleaner',
                    'name_ar' => 'مكنسة روبوت',
                    'description_en' => 'Smart robotic vacuum cleaner for automated cleaning.',
                    'description_ar' => 'مكنسة روبوت ذكية للتنظيف الآلي.',
                    'category' => 'home appliances',
                    'price' => 8999,
                    'stock' => 12,
                    'sku' => 'ROBOT-VAC-001',
                    'images' => [
                        '20_robot_vacuum.jpg',
                        '20_robot_vacuum_top.jpg',
                        '20_robot_vacuum_dock.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Smart Navigation',
                            'title_ar' => 'ملاحة ذكية',
                            'description_en' => 'Smart navigation helps the robot efficiently cover the cleaning area.',
                            'description_ar' => 'الملاحة الذكية تساعد الروبوت على تغطية مساحة التنظيف بكفاءة.',
                        ],
                        [
                            'title_en' => 'Automatic Charging',
                            'title_ar' => 'شحن تلقائي',
                            'description_en' => 'Automatically returns to its charging station when needed.',
                            'description_ar' => 'يعود تلقائيًا إلى قاعدة الشحن عند الحاجة.',
                        ],
                    ],
                ],

                // Beauty
                [
                    'name_en' => 'Hydrating Face Cream',
                    'name_ar' => 'كريم مرطب للوجه',
                    'description_en' => 'Daily moisturizing cream for healthy-looking skin.',
                    'description_ar' => 'كريم مرطب للاستخدام اليومي لبشرة صحية.',
                    'category' => 'beauty',
                    'price' => 699,
                    'stock' => 80,
                    'sku' => 'BEAUTY-CREAM-001',
                    'images' => [
                        '21_face_cream.jpg',
                        '21_face_cream_open.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Deep Hydration',
                            'title_ar' => 'ترطيب عميق',
                            'description_en' => 'Helps maintain skin moisture throughout the day.',
                            'description_ar' => 'يساعد على الحفاظ على ترطيب البشرة طوال اليوم.',
                        ],
                        [
                            'title_en' => 'Daily Use',
                            'title_ar' => 'للاستخدام اليومي',
                            'description_en' => 'Lightweight formula suitable for everyday skincare routines.',
                            'description_ar' => 'تركيبة خفيفة مناسبة لروتين العناية بالبشرة اليومي.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Vitamin C Serum',
                    'name_ar' => 'سيروم فيتامين C',
                    'description_en' => 'Lightweight vitamin C facial serum.',
                    'description_ar' => 'سيروم خفيف للوجه بفيتامين C.',
                    'category' => 'beauty',
                    'price' => 899,
                    'stock' => 65,
                    'sku' => 'VITC-SERUM-001',
                    'images' => [
                        '22_vitamin_c_serum.jpg',
                        '22_vitamin_c_serum_dropper.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Vitamin C Formula',
                            'title_ar' => 'تركيبة فيتامين C',
                            'description_en' => 'Lightweight serum formulated with vitamin C.',
                            'description_ar' => 'سيروم خفيف بتركيبة تحتوي على فيتامين C.',
                        ],
                        [
                            'title_en' => 'Lightweight Texture',
                            'title_ar' => 'قوام خفيف',
                            'description_en' => 'Fast-absorbing texture suitable for daily skincare.',
                            'description_ar' => 'قوام سريع الامتصاص مناسب للعناية اليومية بالبشرة.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Professional Hair Dryer',
                    'name_ar' => 'مجفف شعر احترافي',
                    'description_en' => 'Powerful professional hair dryer.',
                    'description_ar' => 'مجفف شعر احترافي بقوة عالية.',
                    'category' => 'beauty',
                    'price' => 1999,
                    'stock' => 30,
                    'sku' => 'HAIR-DRYER-001',
                    'images' => [
                        '23_hair_dryer.jpg',
                        '23_hair_dryer_side.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Powerful Motor',
                            'title_ar' => 'محرك قوي',
                            'description_en' => 'High-performance motor for fast and efficient drying.',
                            'description_ar' => 'محرك عالي الأداء لتجفيف سريع وفعال.',
                        ],
                        [
                            'title_en' => 'Multiple Heat Settings',
                            'title_ar' => 'إعدادات حرارة متعددة',
                            'description_en' => 'Multiple temperature settings for different hair types.',
                            'description_ar' => 'إعدادات حرارة متعددة تناسب أنواع الشعر المختلفة.',
                        ],
                    ],
                ],

                // Sports
                [
                    'name_en' => 'Professional Football',
                    'name_ar' => 'كرة قدم احترافية',
                    'description_en' => 'Durable football suitable for training and matches.',
                    'description_ar' => 'كرة قدم متينة مناسبة للتدريب والمباريات.',
                    'category' => 'sports',
                    'price' => 899,
                    'stock' => 50,
                    'sku' => 'FOOTBALL-001',
                    'images' => [
                        '24_football.jpg',
                        '24_football_closeup.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Durable Construction',
                            'title_ar' => 'تصميم متين',
                            'description_en' => 'Durable outer construction designed for frequent use.',
                            'description_ar' => 'تصميم خارجي متين للاستخدام المتكرر.',
                        ],
                        [
                            'title_en' => 'Match Size',
                            'title_ar' => 'حجم المباريات',
                            'description_en' => 'Designed according to standard football dimensions.',
                            'description_ar' => 'مصممة وفق أبعاد كرة القدم القياسية.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Yoga Mat',
                    'name_ar' => 'سجادة يوغا',
                    'description_en' => 'Non-slip exercise and yoga mat.',
                    'description_ar' => 'سجادة تمارين ويوغا مقاومة للانزلاق.',
                    'category' => 'sports',
                    'price' => 599,
                    'stock' => 75,
                    'sku' => 'YOGA-MAT-001',
                    'images' => [
                        '25_yoga_mat.jpg',
                        '25_yoga_mat_rolled.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Non-Slip Surface',
                            'title_ar' => 'سطح مقاوم للانزلاق',
                            'description_en' => 'Provides reliable grip during yoga and exercise.',
                            'description_ar' => 'توفر ثباتًا جيدًا أثناء اليوغا والتمارين.',
                        ],
                        [
                            'title_en' => 'Comfortable Padding',
                            'title_ar' => 'وسادة مريحة',
                            'description_en' => 'Cushioned surface provides comfort during floor exercises.',
                            'description_ar' => 'سطح مبطن يوفر الراحة أثناء التمارين الأرضية.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Adjustable Dumbbells',
                    'name_ar' => 'دمبل قابل للتعديل',
                    'description_en' => 'Adjustable dumbbell set for home workouts.',
                    'description_ar' => 'مجموعة دمبل قابلة للتعديل للتمارين المنزلية.',
                    'category' => 'sports',
                    'price' => 2999,
                    'stock' => 20,
                    'sku' => 'DUMBBELLS-001',
                    'images' => [
                        '26_adjustable_dumbbells.jpg',
                        '26_adjustable_dumbbells_set.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Adjustable Weight',
                            'title_ar' => 'وزن قابل للتعديل',
                            'description_en' => 'Adjust the weight according to different workout requirements.',
                            'description_ar' => 'يمكن تعديل الوزن حسب متطلبات التمرين المختلفة.',
                        ],
                        [
                            'title_en' => 'Space Saving',
                            'title_ar' => 'موفرة للمساحة',
                            'description_en' => 'One adjustable set replaces multiple traditional dumbbells.',
                            'description_ar' => 'مجموعة واحدة قابلة للتعديل تحل محل عدة أوزان تقليدية.',
                        ],
                    ],
                ],

                // Toys
                [
                    'name_en' => 'Building Blocks Set',
                    'name_ar' => 'مجموعة مكعبات بناء',
                    'description_en' => 'Creative building blocks set for children.',
                    'description_ar' => 'مجموعة مكعبات بناء إبداعية للأطفال.',
                    'category' => 'toys',
                    'price' => 999,
                    'stock' => 60,
                    'sku' => 'BLOCKS-001',
                    'images' => [
                        '27_building_blocks.jpg',
                        '27_building_blocks_built.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Creative Play',
                            'title_ar' => 'لعب إبداعي',
                            'description_en' => 'Encourages creativity and imaginative building.',
                            'description_ar' => 'تشجع على الإبداع والبناء باستخدام الخيال.',
                        ],
                        [
                            'title_en' => 'Colorful Pieces',
                            'title_ar' => 'قطع ملونة',
                            'description_en' => 'Includes colorful pieces for engaging play.',
                            'description_ar' => 'تحتوي على قطع ملونة لتجربة لعب ممتعة.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Remote Control Car',
                    'name_ar' => 'سيارة تحكم عن بعد',
                    'description_en' => 'Fun remote control car for children.',
                    'description_ar' => 'سيارة ممتعة للأطفال تعمل بالتحكم عن بعد.',
                    'category' => 'toys',
                    'price' => 1299,
                    'stock' => 40,
                    'sku' => 'RC-CAR-001',
                    'images' => [
                        '28_remote_control_car.jpg',
                        '28_remote_control_car_remote.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Remote Controlled',
                            'title_ar' => 'تحكم عن بعد',
                            'description_en' => 'Easy-to-use remote control for interactive play.',
                            'description_ar' => 'جهاز تحكم سهل الاستخدام لتجربة لعب تفاعلية.',
                        ],
                        [
                            'title_en' => 'Durable Body',
                            'title_ar' => 'هيكل متين',
                            'description_en' => 'Durable body designed to handle everyday play.',
                            'description_ar' => 'هيكل متين مصمم لتحمل الاستخدام اليومي.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Plush Teddy Bear',
                    'name_ar' => 'دبدوب قطيفة',
                    'description_en' => 'Soft plush teddy bear.',
                    'description_ar' => 'دبدوب قطيفة ناعم.',
                    'category' => 'toys',
                    'price' => 599,
                    'stock' => 70,
                    'sku' => 'TEDDY-BEAR-001',
                    'images' => [
                        '29_teddy_bear.jpg',
                        '29_teddy_bear_side.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Soft Plush',
                            'title_ar' => 'قطيفة ناعمة',
                            'description_en' => 'Soft plush material that is comfortable to touch.',
                            'description_ar' => 'خامة قطيفة ناعمة ومريحة عند اللمس.',
                        ],
                        [
                            'title_en' => 'Cute Design',
                            'title_ar' => 'تصميم لطيف',
                            'description_en' => 'Friendly teddy bear design suitable for children.',
                            'description_ar' => 'تصميم لطيف مناسب للأطفال.',
                        ],
                    ],
                ],

                // Books
                [
                    'name_en' => 'The Great Adventure',
                    'name_ar' => 'المغامرة الكبرى',
                    'description_en' => 'An exciting adventure novel.',
                    'description_ar' => 'رواية مغامرات مشوقة.',
                    'category' => 'books',
                    'price' => 399,
                    'stock' => 100,
                    'sku' => 'BOOK-ADVENTURE-001',
                    'images' => [
                        '30_adventure_book.jpg',
                        '30_adventure_book_back.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Adventure Story',
                            'title_ar' => 'قصة مغامرات',
                            'description_en' => 'An engaging story filled with exciting adventures.',
                            'description_ar' => 'قصة ممتعة مليئة بالمغامرات المشوقة.',
                        ],
                        [
                            'title_en' => 'Easy Reading',
                            'title_ar' => 'قراءة سهلة',
                            'description_en' => 'Accessible writing style suitable for casual reading.',
                            'description_ar' => 'أسلوب كتابة سهل ومناسب للقراءة الترفيهية.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Learn Programming',
                    'name_ar' => 'تعلم البرمجة',
                    'description_en' => 'A practical introduction to programming.',
                    'description_ar' => 'مقدمة عملية لتعلم البرمجة.',
                    'category' => 'books',
                    'price' => 699,
                    'stock' => 50,
                    'sku' => 'BOOK-PROGRAMMING-001',
                    'images' => [
                        '31_programming_book.jpg',
                        '31_programming_book_back.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Practical Examples',
                            'title_ar' => 'أمثلة عملية',
                            'description_en' => 'Learn programming concepts through practical examples.',
                            'description_ar' => 'تعلم مفاهيم البرمجة من خلال أمثلة عملية.',
                        ],
                        [
                            'title_en' => 'Beginner Friendly',
                            'title_ar' => 'مناسب للمبتدئين',
                            'description_en' => 'Designed to introduce programming concepts in a simple way.',
                            'description_ar' => 'مصمم لتقديم مفاهيم البرمجة بطريقة مبسطة.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'World History',
                    'name_ar' => 'تاريخ العالم',
                    'description_en' => 'An illustrated overview of world history.',
                    'description_ar' => 'نظرة شاملة ومصورة على تاريخ العالم.',
                    'category' => 'books',
                    'price' => 599,
                    'stock' => 45,
                    'sku' => 'BOOK-HISTORY-001',
                    'images' => [
                        '32_history_book.jpg',
                        '32_history_book_back.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'World History',
                            'title_ar' => 'تاريخ العالم',
                            'description_en' => 'Covers major events and civilizations throughout history.',
                            'description_ar' => 'يتناول أهم الأحداث والحضارات عبر التاريخ.',
                        ],
                        [
                            'title_en' => 'Illustrated Content',
                            'title_ar' => 'محتوى مصور',
                            'description_en' => 'Illustrations help make historical topics easier to understand.',
                            'description_ar' => 'تساعد الصور التوضيحية على فهم الموضوعات التاريخية بسهولة.',
                        ],
                    ],
                ],

                // Groceries
                [
                    'name_en' => 'Premium Basmati Rice',
                    'name_ar' => 'أرز بسمتي فاخر',
                    'description_en' => 'Premium long-grain basmati rice.',
                    'description_ar' => 'أرز بسمتي فاخر طويل الحبة.',
                    'category' => 'groceries',
                    'price' => 249,
                    'stock' => 150,
                    'sku' => 'RICE-BASMATI-001',
                    'images' => [
                        '33_basmati_rice.jpg',
                        '33_basmati_rice_package.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Long Grain',
                            'title_ar' => 'حبة طويلة',
                            'description_en' => 'Premium long-grain rice with a delicate texture.',
                            'description_ar' => 'أرز فاخر طويل الحبة بقوام مميز.',
                        ],
                        [
                            'title_en' => 'Aromatic',
                            'title_ar' => 'رائحة عطرية',
                            'description_en' => 'Naturally aromatic basmati rice.',
                            'description_ar' => 'أرز بسمتي ذو رائحة عطرية طبيعية.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Extra Virgin Olive Oil',
                    'name_ar' => 'زيت زيتون بكر ممتاز',
                    'description_en' => 'Premium extra virgin olive oil.',
                    'description_ar' => 'زيت زيتون بكر ممتاز.',
                    'category' => 'groceries',
                    'price' => 499,
                    'stock' => 90,
                    'sku' => 'OLIVE-OIL-001',
                    'images' => [
                        '34_olive_oil.jpg',
                        '34_olive_oil_bottle.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Extra Virgin',
                            'title_ar' => 'بكر ممتاز',
                            'description_en' => 'Premium extra virgin olive oil suitable for everyday cooking.',
                            'description_ar' => 'زيت زيتون بكر ممتاز مناسب للاستخدام اليومي في الطهي.',
                        ],
                        [
                            'title_en' => 'Rich Flavor',
                            'title_ar' => 'نكهة غنية',
                            'description_en' => 'Rich natural olive flavor for salads and cooking.',
                            'description_ar' => 'نكهة زيتون طبيعية وغنية للسلطات والطهي.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Organic Honey',
                    'name_ar' => 'عسل عضوي',
                    'description_en' => 'Natural organic honey.',
                    'description_ar' => 'عسل طبيعي عضوي.',
                    'category' => 'groceries',
                    'price' => 399,
                    'stock' => 75,
                    'sku' => 'HONEY-001',
                    'images' => [
                        '35_organic_honey.jpg',
                        '35_organic_honey_jar.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Natural Honey',
                            'title_ar' => 'عسل طبيعي',
                            'description_en' => 'Natural honey with a rich sweet flavor.',
                            'description_ar' => 'عسل طبيعي بنكهة غنية وحلوة.',
                        ],
                        [
                            'title_en' => 'Organic',
                            'title_ar' => 'عضوي',
                            'description_en' => 'Organic honey selected for everyday use.',
                            'description_ar' => 'عسل عضوي مختار للاستخدام اليومي.',
                        ],
                    ],
                ],

                // Automotive
                [
                    'name_en' => 'Car Phone Holder',
                    'name_ar' => 'حامل هاتف للسيارة',
                    'description_en' => 'Universal phone holder for cars.',
                    'description_ar' => 'حامل هاتف عالمي للسيارة.',
                    'category' => 'automotive',
                    'price' => 399,
                    'stock' => 100,
                    'sku' => 'CAR-HOLDER-001',
                    'images' => [
                        '36_car_phone_holder.jpg',
                        '36_car_phone_holder_installed.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Universal Fit',
                            'title_ar' => 'توافق عالمي',
                            'description_en' => 'Compatible with a wide range of smartphones.',
                            'description_ar' => 'متوافق مع مجموعة واسعة من الهواتف الذكية.',
                        ],
                        [
                            'title_en' => 'Secure Mount',
                            'title_ar' => 'تثبيت آمن',
                            'description_en' => 'Securely holds the phone while driving.',
                            'description_ar' => 'يثبت الهاتف بأمان أثناء القيادة.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Car Vacuum Cleaner',
                    'name_ar' => 'مكنسة كهربائية للسيارة',
                    'description_en' => 'Compact vacuum cleaner designed for cars.',
                    'description_ar' => 'مكنسة كهربائية صغيرة مخصصة للسيارات.',
                    'category' => 'automotive',
                    'price' => 999,
                    'stock' => 45,
                    'sku' => 'CAR-VAC-001',
                    'images' => [
                        '37_car_vacuum.jpg',
                        '37_car_vacuum_nozzle.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Compact Design',
                            'title_ar' => 'تصميم مدمج',
                            'description_en' => 'Compact size makes it easy to store inside the vehicle.',
                            'description_ar' => 'حجم مدمج يسهل تخزينه داخل السيارة.',
                        ],
                        [
                            'title_en' => 'Powerful Suction',
                            'title_ar' => 'شفط قوي',
                            'description_en' => 'Powerful suction for removing dirt and debris.',
                            'description_ar' => 'قوة شفط عالية لإزالة الأوساخ والمخلفات.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'LED Car Headlight',
                    'name_ar' => 'مصباح LED للسيارة',
                    'description_en' => 'Bright LED headlight replacement.',
                    'description_ar' => 'مصباح LED ساطع للسيارة.',
                    'category' => 'automotive',
                    'price' => 1499,
                    'stock' => 30,
                    'sku' => 'CAR-LED-001',
                    'images' => [
                        '38_car_led_headlight.jpg',
                        '38_car_led_headlight_installed.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Bright LED Light',
                            'title_ar' => 'إضاءة LED ساطعة',
                            'description_en' => 'Bright LED lighting improves visibility on the road.',
                            'description_ar' => 'إضاءة LED ساطعة تساعد على تحسين الرؤية على الطريق.',
                        ],
                        [
                            'title_en' => 'Energy Efficient',
                            'title_ar' => 'موفر للطاقة',
                            'description_en' => 'LED technology provides efficient lighting performance.',
                            'description_ar' => 'تقنية LED توفر إضاءة فعالة في استهلاك الطاقة.',
                        ],
                    ],
                ],

                // Pet Supplies
                [
                    'name_en' => 'Premium Dog Food',
                    'name_ar' => 'طعام كلاب فاخر',
                    'description_en' => 'Balanced premium dog food.',
                    'description_ar' => 'طعام متوازن فاخر للكلاب.',
                    'category' => 'pet supplies',
                    'price' => 899,
                    'stock' => 50,
                    'sku' => 'DOG-FOOD-001',
                    'images' => [
                        '39_dog_food.jpg',
                        '39_dog_food_package.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Balanced Nutrition',
                            'title_ar' => 'تغذية متوازنة',
                            'description_en' => 'Balanced nutritional formula designed for dogs.',
                            'description_ar' => 'تركيبة غذائية متوازنة مصممة للكلاب.',
                        ],
                        [
                            'title_en' => 'Premium Ingredients',
                            'title_ar' => 'مكونات فاخرة',
                            'description_en' => 'Made with selected ingredients for everyday feeding.',
                            'description_ar' => 'مصنوع من مكونات مختارة للتغذية اليومية.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Cat Scratching Post',
                    'name_ar' => 'عمود خدش للقطط',
                    'description_en' => 'Durable scratching post for cats.',
                    'description_ar' => 'عمود خدش متين للقطط.',
                    'category' => 'pet supplies',
                    'price' => 799,
                    'stock' => 35,
                    'sku' => 'CAT-SCRATCH-001',
                    'images' => [
                        '40_cat_scratching_post.jpg',
                        '40_cat_scratching_post_side.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Durable Scratching Surface',
                            'title_ar' => 'سطح خدش متين',
                            'description_en' => 'Designed to withstand regular scratching and play.',
                            'description_ar' => 'مصمم لتحمل الخدش واللعب بشكل متكرر.',
                        ],
                        [
                            'title_en' => 'Stable Base',
                            'title_ar' => 'قاعدة ثابتة',
                            'description_en' => 'Stable base helps keep the scratching post secure.',
                            'description_ar' => 'قاعدة ثابتة تساعد على إبقاء العمود آمنًا أثناء الاستخدام.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Pet Water Fountain',
                    'name_ar' => 'نافورة مياه للحيوانات الأليفة',
                    'description_en' => 'Automatic drinking fountain for pets.',
                    'description_ar' => 'نافورة مياه أوتوماتيكية للحيوانات الأليفة.',
                    'category' => 'pet supplies',
                    'price' => 1199,
                    'stock' => 25,
                    'sku' => 'PET-FOUNTAIN-001',
                    'images' => [
                        '41_pet_water_fountain.jpg',
                        '41_pet_water_fountain_top.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Automatic Water Flow',
                            'title_ar' => 'تدفق مياه تلقائي',
                            'description_en' => 'Continuous water circulation encourages regular drinking.',
                            'description_ar' => 'تدوير مستمر للمياه يشجع الحيوانات الأليفة على الشرب.',
                        ],
                        [
                            'title_en' => 'Quiet Pump',
                            'title_ar' => 'مضخة هادئة',
                            'description_en' => 'Quiet pump operation for comfortable indoor use.',
                            'description_ar' => 'مضخة هادئة للاستخدام المريح داخل المنزل.',
                        ],
                    ],
                ],

                // More Electronics
                [
                    'name_en' => 'Google Pixel 9',
                    'name_ar' => 'جوجل بيكسل 9',
                    'description_en' => 'Modern Android smartphone with an advanced camera.',
                    'description_ar' => 'هاتف أندرويد حديث بكاميرا متطورة.',
                    'category' => 'mobile phones',
                    'price' => 34999,
                    'stock' => 20,
                    'sku' => 'PIXEL9-001',
                    'images' => [
                        '42_google_pixel_9.jpg',
                        '42_google_pixel_9_back.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Advanced Camera',
                            'title_ar' => 'كاميرا متطورة',
                            'description_en' => 'Advanced camera system for detailed everyday photography.',
                            'description_ar' => 'نظام كاميرا متطور للتصوير اليومي عالي التفاصيل.',
                        ],
                        [
                            'title_en' => 'Clean Android Experience',
                            'title_ar' => 'تجربة أندرويد نقية',
                            'description_en' => 'Smooth Android experience with integrated Google services.',
                            'description_ar' => 'تجربة أندرويد سلسة مع خدمات Google المدمجة.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Lenovo ThinkPad X1',
                    'name_ar' => 'لينوفو ThinkPad X1',
                    'description_en' => 'Business laptop designed for productivity.',
                    'description_ar' => 'حاسوب محمول للأعمال مصمم للإنتاجية.',
                    'category' => 'laptops',
                    'price' => 57999,
                    'stock' => 12,
                    'sku' => 'THINKPAD-X1-001',
                    'images' => [
                        '43_lenovo_thinkpad_x1.jpg',
                        '43_lenovo_thinkpad_x1_open.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Business Performance',
                            'title_ar' => 'أداء للأعمال',
                            'description_en' => 'Designed for productivity and professional workloads.',
                            'description_ar' => 'مصمم للإنتاجية ومهام العمل الاحترافية.',
                        ],
                        [
                            'title_en' => 'Durable Design',
                            'title_ar' => 'تصميم متين',
                            'description_en' => 'Durable construction designed for everyday business use.',
                            'description_ar' => 'تصميم متين مناسب للاستخدام اليومي في بيئة العمل.',
                        ],
                    ],
                ],

                // More Fashion
                [
                    'name_en' => 'Men Leather Jacket',
                    'name_ar' => 'جاكيت جلد رجالي',
                    'description_en' => 'Classic leather jacket for men.',
                    'description_ar' => 'جاكيت جلد كلاسيكي للرجال.',
                    'category' => "men's clothing",
                    'price' => 4999,
                    'stock' => 20,
                    'sku' => 'MENS-JACKET-001',
                    'images' => [
                        '44_mens_leather_jacket.jpg',
                        '44_mens_leather_jacket_back.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Genuine Leather Look',
                            'title_ar' => 'مظهر جلدي فاخر',
                            'description_en' => 'Classic leather-inspired appearance for a timeless style.',
                            'description_ar' => 'مظهر جلدي كلاسيكي يمنح إطلالة أنيقة.',
                        ],
                        [
                            'title_en' => 'Classic Fit',
                            'title_ar' => 'قصة كلاسيكية',
                            'description_en' => 'Classic silhouette suitable for casual outfits.',
                            'description_ar' => 'قصة كلاسيكية مناسبة للإطلالات اليومية.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Women Running Shoes',
                    'name_ar' => 'حذاء جري نسائي',
                    'description_en' => 'Lightweight running shoes for women.',
                    'description_ar' => 'حذاء جري خفيف للنساء.',
                    'category' => 'shoes',
                    'price' => 3299,
                    'stock' => 35,
                    'sku' => 'WOMEN-RUN-001',
                    'images' => [
                        '45_womens_running_shoes.jpg',
                        '45_womens_running_shoes_side.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Lightweight',
                            'title_ar' => 'خفيف الوزن',
                            'description_en' => 'Lightweight construction designed for comfortable running.',
                            'description_ar' => 'تصميم خفيف الوزن لراحة أكبر أثناء الجري.',
                        ],
                        [
                            'title_en' => 'Comfortable Cushioning',
                            'title_ar' => 'وسادة مريحة',
                            'description_en' => 'Cushioned sole provides comfortable support during movement.',
                            'description_ar' => 'نعل مبطن يوفر دعمًا مريحًا أثناء الحركة.',
                        ],
                    ],
                ],

                // More Home
                [
                    'name_en' => 'Electric Kettle',
                    'name_ar' => 'غلاية كهربائية',
                    'description_en' => 'Fast-boiling electric kettle.',
                    'description_ar' => 'غلاية كهربائية سريعة الغليان.',
                    'category' => 'home appliances',
                    'price' => 999,
                    'stock' => 60,
                    'sku' => 'KETTLE-001',
                    'images' => [
                        '46_electric_kettle.jpg',
                        '46_electric_kettle_open.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Fast Boiling',
                            'title_ar' => 'غليان سريع',
                            'description_en' => 'Powerful heating system brings water to a boil quickly.',
                            'description_ar' => 'نظام تسخين قوي يساعد على غلي الماء بسرعة.',
                        ],
                        [
                            'title_en' => 'Automatic Shutoff',
                            'title_ar' => 'إيقاف تلقائي',
                            'description_en' => 'Automatically switches off when the water reaches boiling point.',
                            'description_ar' => 'تتوقف تلقائيًا عند وصول الماء إلى درجة الغليان.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Coffee Maker',
                    'name_ar' => 'ماكينة صنع القهوة',
                    'description_en' => 'Home coffee maker for freshly brewed coffee.',
                    'description_ar' => 'ماكينة لصنع القهوة الطازجة في المنزل.',
                    'category' => 'kitchen',
                    'price' => 2499,
                    'stock' => 30,
                    'sku' => 'COFFEE-MAKER-001',
                    'images' => [
                        '47_coffee_maker.jpg',
                        '47_coffee_maker_side.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Freshly Brewed Coffee',
                            'title_ar' => 'قهوة طازجة',
                            'description_en' => 'Brew fresh coffee conveniently at home.',
                            'description_ar' => 'تحضير القهوة الطازجة بسهولة في المنزل.',
                        ],
                        [
                            'title_en' => 'Easy Operation',
                            'title_ar' => 'تشغيل سهل',
                            'description_en' => 'Simple controls make everyday coffee preparation easy.',
                            'description_ar' => 'أدوات تحكم بسيطة تجعل تحضير القهوة يوميًا سهلًا.',
                        ],
                    ],
                ],

                // More Beauty / Sports / Toys
                [
                    'name_en' => 'Makeup Brush Set',
                    'name_ar' => 'مجموعة فرش مكياج',
                    'description_en' => 'Complete makeup brush set.',
                    'description_ar' => 'مجموعة متكاملة من فرش المكياج.',
                    'category' => 'beauty',
                    'price' => 799,
                    'stock' => 55,
                    'sku' => 'MAKEUP-BRUSH-001',
                    'images' => [
                        '48_makeup_brushes.jpg',
                        '48_makeup_brushes_case.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Complete Set',
                            'title_ar' => 'مجموعة متكاملة',
                            'description_en' => 'Includes multiple brushes for different makeup applications.',
                            'description_ar' => 'تحتوي على عدة فرش لاستخدامات المكياج المختلفة.',
                        ],
                        [
                            'title_en' => 'Soft Bristles',
                            'title_ar' => 'شعيرات ناعمة',
                            'description_en' => 'Soft bristles provide comfortable and smooth application.',
                            'description_ar' => 'شعيرات ناعمة توفر تطبيقًا مريحًا وسلسًا.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Basketball',
                    'name_ar' => 'كرة سلة',
                    'description_en' => 'Durable basketball for training and matches.',
                    'description_ar' => 'كرة سلة متينة للتدريب والمباريات.',
                    'category' => 'sports',
                    'price' => 799,
                    'stock' => 45,
                    'sku' => 'BASKETBALL-001',
                    'images' => [
                        '49_basketball.jpg',
                        '49_basketball_closeup.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Durable Surface',
                            'title_ar' => 'سطح متين',
                            'description_en' => 'Durable outer material designed for regular training.',
                            'description_ar' => 'خامة خارجية متينة مصممة للتدريب المنتظم.',
                        ],
                        [
                            'title_en' => 'Good Grip',
                            'title_ar' => 'قبضة جيدة',
                            'description_en' => 'Textured surface provides a reliable grip during play.',
                            'description_ar' => 'سطح محكم يوفر قبضة جيدة أثناء اللعب.',
                        ],
                    ],
                ],
                [
                    'name_en' => 'Kids Wooden Puzzle',
                    'name_ar' => 'أحجية خشبية للأطفال',
                    'description_en' => 'Educational wooden puzzle for children.',
                    'description_ar' => 'أحجية خشبية تعليمية للأطفال.',
                    'category' => 'toys',
                    'price' => 499,
                    'stock' => 65,
                    'sku' => 'WOOD-PUZZLE-001',
                    'images' => [
                        '50_wooden_puzzle.jpg',
                        '50_wooden_puzzle_pieces.jpg',
                    ],
                    'features' => [
                        [
                            'title_en' => 'Educational Play',
                            'title_ar' => 'لعب تعليمي',
                            'description_en' => 'Encourages problem-solving and logical thinking.',
                            'description_ar' => 'تشجع على حل المشكلات والتفكير المنطقي.',
                        ],
                        [
                            'title_en' => 'Wooden Pieces',
                            'title_ar' => 'قطع خشبية',
                            'description_en' => 'Durable wooden pieces designed for repeated play.',
                            'description_ar' => 'قطع خشبية متينة مصممة للاستخدام المتكرر.',
                        ],
                    ],
                ],
            ];

            foreach ($products as $data) {
                $categoryName = strtolower($data['category']);

                if (!isset($categories[$categoryName])) {
                    throw new \RuntimeException(
                        "Category [{$data['category']}] was not found."
                    );
                }

                // $imageName = $data['image'];
                // unset($data['category'], $data['image']);

                $product = Product::create([
                    'name_en' => $data['name_en'],
                    'name_ar' => $data['name_ar'],
                    'description_en' => $data['description_en'],
                    'description_ar' => $data['description_ar'],
                    'features' => $data['features'],
                ]);

                ProductVariant::create([
                    'product_id' => $product->id,
                    'price' => $data['price'],
                    'stock' => $data['stock'],
                    'sku' => $data['sku'],
                    'is_default' => true,
                ]);

                $product->categories()->sync([
                    $categories[$categoryName],
                ]);

                foreach ($data['images'] as $image) {
                    $product->addMedia($images[$image]->getPathname())
                        ->preservingOriginal()
                        ->toMediaCollection('products');
                }
            }
        });
    }
}