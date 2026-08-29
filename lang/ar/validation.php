<?php

return [

    /*
    |--------------------------------------------------------------------------
    | رسائل التحقق من صحة البيانات
    |--------------------------------------------------------------------------
    |
    | تحتوي رسائل اللغة التالية على رسائل الخطأ الافتراضية المستخدمة
    | بواسطة أداة التحقق من صحة البيانات. بعض القواعد لها عدة صيغ
    | مثل قواعد الحجم. يمكنك تعديل هذه الرسائل حسب احتياجات تطبيقك.
    |
    */

    'accepted' => 'يجب قبول حقل :attribute.',
    'accepted_if' => 'يجب قبول حقل :attribute عندما تكون قيمة :other هي :value.',
    'active_url' => 'يجب أن يكون حقل :attribute رابط URL صالحًا.',
    'after' => 'يجب أن يكون تاريخ حقل :attribute بعد :date.',
    'after_or_equal' => 'يجب أن يكون تاريخ حقل :attribute بعد أو مساويًا لـ :date.',
    'alpha' => 'يجب أن يحتوي حقل :attribute على حروف فقط.',
    'alpha_dash' => 'يجب أن يحتوي حقل :attribute على حروف وأرقام وشرطات وشرطات سفلية فقط.',
    'alpha_num' => 'يجب أن يحتوي حقل :attribute على حروف وأرقام فقط.',
    'any_of' => 'قيمة حقل :attribute غير صالحة.',
    'array' => 'يجب أن يكون حقل :attribute مصفوفة.',
    'array_keys' => 'يجب أن يحتوي حقل :attribute على المفاتيح التالية فقط: :values.',
    'ascii' => 'يجب أن يحتوي حقل :attribute على أحرف ورموز من نوع ASCII فقط.',
    'base64' => 'يجب أن يكون حقل :attribute نص Base64 صالحًا.',
    'before' => 'يجب أن يكون تاريخ حقل :attribute قبل :date.',
    'before_or_equal' => 'يجب أن يكون تاريخ حقل :attribute قبل أو مساويًا لـ :date.',

    'between' => [
        'array' => 'يجب أن يحتوي حقل :attribute على عدد من العناصر بين :min و :max.',
        'file' => 'يجب أن يكون حجم حقل :attribute بين :min و :max كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute بين :min و :max.',
        'string' => 'يجب أن يحتوي حقل :attribute على عدد من الأحرف بين :min و :max.',
    ],

    'boolean' => 'يجب أن تكون قيمة حقل :attribute صحيحة أو خاطئة.',
    'can' => 'يحتوي حقل :attribute على قيمة غير مصرح بها.',
    'confirmed' => 'تأكيد حقل :attribute غير متطابق.',
    'contains' => 'يفتقد حقل :attribute قيمة مطلوبة.',
    'current_password' => 'كلمة المرور غير صحيحة.',
    'date' => 'يجب أن يكون حقل :attribute تاريخًا صالحًا.',
    'date_equals' => 'يجب أن يكون تاريخ حقل :attribute مساويًا لـ :date.',
    'date_format' => 'يجب أن يتطابق حقل :attribute مع التنسيق :format.',
    'decimal' => 'يجب أن يحتوي حقل :attribute على :decimal من المنازل العشرية.',
    'declined' => 'يجب رفض حقل :attribute.',
    'declined_if' => 'يجب رفض حقل :attribute عندما تكون قيمة :other هي :value.',
    'different' => 'يجب أن يختلف حقل :attribute عن :other.',
    'digits' => 'يجب أن يتكون حقل :attribute من :digits أرقام.',
    'digits_between' => 'يجب أن يحتوي حقل :attribute على عدد من الأرقام بين :min و :max.',
    'dimensions' => 'أبعاد الصورة في حقل :attribute غير صالحة.',
    'distinct' => 'يحتوي حقل :attribute على قيمة مكررة.',
    'doesnt_contain' => 'يجب ألا يحتوي حقل :attribute على أي من القيم التالية: :values.',
    'doesnt_end_with' => 'يجب ألا ينتهي حقل :attribute بإحدى القيم التالية: :values.',
    'doesnt_start_with' => 'يجب ألا يبدأ حقل :attribute بإحدى القيم التالية: :values.',
    'email' => 'يجب أن يكون حقل :attribute عنوان بريد إلكتروني صالحًا.',
    'encoding' => 'يجب أن يكون حقل :attribute مشفرًا باستخدام :encoding.',
    'ends_with' => 'يجب أن ينتهي حقل :attribute بإحدى القيم التالية: :values.',
    'enum' => 'القيمة المحددة لحقل :attribute غير صالحة.',
    'exists' => 'القيمة المحددة لحقل :attribute غير صالحة.',
    'extensions' => 'يجب أن يكون امتداد ملف :attribute أحد الامتدادات التالية: :values.',
    'file' => 'يجب أن يكون حقل :attribute ملفًا.',
    'filled' => 'يجب أن يحتوي حقل :attribute على قيمة.',

    'gt' => [
        'array' => 'يجب أن يحتوي حقل :attribute على أكثر من :value من العناصر.',
        'file' => 'يجب أن يكون حجم حقل :attribute أكبر من :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute أكبر من :value.',
        'string' => 'يجب أن يحتوي حقل :attribute على أكثر من :value من الأحرف.',
    ],

    'gte' => [
        'array' => 'يجب أن يحتوي حقل :attribute على :value من العناصر أو أكثر.',
        'file' => 'يجب أن يكون حجم حقل :attribute أكبر من أو مساويًا لـ :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute أكبر من أو مساوية لـ :value.',
        'string' => 'يجب أن يحتوي حقل :attribute على :value من الأحرف أو أكثر.',
    ],

    'hex_color' => 'يجب أن يكون حقل :attribute لونًا سداسيًا صالحًا.',
    'image' => 'يجب أن يكون حقل :attribute صورة.',
    'in' => 'القيمة المحددة لحقل :attribute غير صالحة.',
    'in_array' => 'يجب أن تكون قيمة حقل :attribute موجودة في :other.',
    'in_array_keys' => 'يجب أن يحتوي حقل :attribute على مفتاح واحد على الأقل من المفاتيح التالية: :values.',
    'integer' => 'يجب أن يكون حقل :attribute عددًا صحيحًا.',
    'ip' => 'يجب أن يكون حقل :attribute عنوان IP صالحًا.',
    'ipv4' => 'يجب أن يكون حقل :attribute عنوان IPv4 صالحًا.',
    'ipv6' => 'يجب أن يكون حقل :attribute عنوان IPv6 صالحًا.',
    'json' => 'يجب أن يكون حقل :attribute نص JSON صالحًا.',
    'list' => 'يجب أن يكون حقل :attribute قائمة.',
    'lowercase' => 'يجب أن يكون حقل :attribute بأحرف صغيرة.',
    'lt' => [
        'array' => 'يجب أن يحتوي حقل :attribute على أقل من :value من العناصر.',
        'file' => 'يجب أن يكون حجم حقل :attribute أقل من :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute أقل من :value.',
        'string' => 'يجب أن يحتوي حقل :attribute على أقل من :value من الأحرف.',
    ],

    'lte' => [
        'array' => 'يجب ألا يحتوي حقل :attribute على أكثر من :value من العناصر.',
        'file' => 'يجب أن يكون حجم حقل :attribute أقل من أو مساويًا لـ :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute أقل من أو مساوية لـ :value.',
        'string' => 'يجب أن يحتوي حقل :attribute على :value من الأحرف أو أقل.',
    ],

    'mac_address' => 'يجب أن يكون حقل :attribute عنوان MAC صالحًا.',
    'max' => [
        'array' => 'يجب ألا يحتوي حقل :attribute على أكثر من :max من العناصر.',
        'file' => 'يجب ألا يتجاوز حجم حقل :attribute :max كيلوبايت.',
        'numeric' => 'يجب ألا تكون قيمة حقل :attribute أكبر من :max.',
        'string' => 'يجب ألا يحتوي حقل :attribute على أكثر من :max من الأحرف.',
    ],

    'max_digits' => 'يجب ألا يحتوي حقل :attribute على أكثر من :max من الأرقام.',
    'mimes' => 'يجب أن يكون حقل :attribute ملفًا من أحد الأنواع التالية: :values.',
    'mimetypes' => 'يجب أن يكون نوع ملف :attribute أحد الأنواع التالية: :values.',

    'min' => [
        'array' => 'يجب أن يحتوي حقل :attribute على :min من العناصر على الأقل.',
        'file' => 'يجب ألا يقل حجم حقل :attribute عن :min كيلوبايت.',
        'numeric' => 'يجب ألا تقل قيمة حقل :attribute عن :min.',
        'string' => 'يجب ألا يقل عدد أحرف حقل :attribute عن :min.',
    ],

    'min_digits' => 'يجب أن يحتوي حقل :attribute على :min من الأرقام على الأقل.',
    'missing' => 'يجب ألا يكون حقل :attribute موجودًا.',
    'missing_if' => 'يجب ألا يكون حقل :attribute موجودًا عندما تكون قيمة :other هي :value.',
    'missing_unless' => 'يجب ألا يكون حقل :attribute موجودًا إلا إذا كانت قيمة :other هي :value.',
    'missing_with' => 'يجب ألا يكون حقل :attribute موجودًا عند وجود :values.',
    'missing_with_all' => 'يجب ألا يكون حقل :attribute موجودًا عند وجود جميع القيم التالية: :values.',
    'multiple_of' => 'يجب أن تكون قيمة حقل :attribute من مضاعفات :value.',
    'not_in' => 'القيمة المحددة لحقل :attribute غير صالحة.',
    'not_regex' => 'تنسيق حقل :attribute غير صالح.',
    'numeric' => 'يجب أن يكون حقل :attribute رقمًا.',

    'password' => [
        'letters' => 'يجب أن يحتوي حقل :attribute على حرف واحد على الأقل.',
        'mixed' => 'يجب أن يحتوي حقل :attribute على حرف كبير وحرف صغير على الأقل.',
        'numbers' => 'يجب أن يحتوي حقل :attribute على رقم واحد على الأقل.',
        'symbols' => 'يجب أن يحتوي حقل :attribute على رمز واحد على الأقل.',
        'uncompromised' => 'ظهرت قيمة :attribute في تسريب للبيانات. يرجى اختيار قيمة أخرى لـ :attribute.',
    ],

    'present' => 'يجب أن يكون حقل :attribute موجودًا.',
    'present_if' => 'يجب أن يكون حقل :attribute موجودًا عندما تكون قيمة :other هي :value.',
    'present_unless' => 'يجب أن يكون حقل :attribute موجودًا إلا إذا كانت قيمة :other هي :value.',
    'present_with' => 'يجب أن يكون حقل :attribute موجودًا عند وجود :values.',
    'present_with_all' => 'يجب أن يكون حقل :attribute موجودًا عند وجود جميع القيم التالية: :values.',
    'prohibited' => 'يُمنع استخدام حقل :attribute.',
    'prohibited_if' => 'يُمنع استخدام حقل :attribute عندما تكون قيمة :other هي :value.',
    'prohibited_if_accepted' => 'يُمنع استخدام حقل :attribute عندما تكون قيمته مقبولة.',
    'prohibited_if_declined' => 'يُمنع استخدام حقل :attribute عندما تكون قيمته مرفوضة.',
    'prohibited_unless' => 'يُمنع استخدام حقل :attribute إلا إذا كانت قيمته ضمن: :values.',
    'prohibits' => 'يمنع حقل :attribute وجود :other.',
    'regex' => 'تنسيق حقل :attribute غير صالح.',
    'required' => 'حقل :attribute مطلوب.',
    'required_array_keys' => 'يجب أن يحتوي حقل :attribute على القيم الخاصة بالمفاتيح التالية: :values.',
    'required_if' => 'حقل :attribute مطلوب عندما تكون قيمة :other هي :value.',
    'required_if_accepted' => 'حقل :attribute مطلوب عندما تكون قيمته مقبولة.',
    'required_if_declined' => 'حقل :attribute مطلوب عندما تكون قيمته مرفوضة.',
    'required_unless' => 'حقل :attribute مطلوب إلا إذا كانت قيمة :other ضمن: :values.',
    'required_with' => 'حقل :attribute مطلوب عند وجود :values.',
    'required_with_all' => 'حقل :attribute مطلوب عند وجود جميع القيم التالية: :values.',
    'required_without' => 'حقل :attribute مطلوب عندما لا تكون :values موجودة.',
    'required_without_all' => 'حقل :attribute مطلوب عند عدم وجود أي من القيم التالية: :values.',
    'same' => 'يجب أن يتطابق حقل :attribute مع :other.',

    'size' => [
        'array' => 'يجب أن يحتوي حقل :attribute على :size من العناصر.',
        'file' => 'يجب أن يكون حجم حقل :attribute :size كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute مساوية لـ :size.',
        'string' => 'يجب أن يحتوي حقل :attribute على :size من الأحرف.',
    ],

    'starts_with' => 'يجب أن يبدأ حقل :attribute بإحدى القيم التالية: :values.',
    'string' => 'يجب أن يكون حقل :attribute نصًا.',
    'timezone' => 'يجب أن يكون حقل :attribute منطقة زمنية صالحة.',
    'unique' => 'قيمة :attribute مستخدمة بالفعل.',
    'uploaded' => 'فشل تحميل :attribute.',
    'uppercase' => 'يجب أن يكون حقل :attribute بأحرف كبيرة.',
    'url' => 'يجب أن يكون حقل :attribute رابط URL صالحًا.',
    'ulid' => 'يجب أن يكون حقل :attribute معرف ULID صالحًا.',
    'uuid' => 'يجب أن يكون حقل :attribute معرف UUID صالحًا.',

    /*
    |--------------------------------------------------------------------------
    | رسائل التحقق المخصصة
    |--------------------------------------------------------------------------
    |
    | يمكنك هنا تحديد رسائل تحقق مخصصة للحقول باستخدام الصيغة
    | "attribute.rule". ويساعد ذلك على تحديد رسالة مخصصة
    | لقاعدة تحقق معينة لحقل محدد.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'رسالة مخصصة.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | أسماء الحقول المخصصة
    |--------------------------------------------------------------------------
    |
    | تُستخدم الأسطر التالية لاستبدال اسم الحقل الافتراضي باسم أكثر
    | وضوحًا للمستخدم، مثل استخدام "البريد الإلكتروني" بدلًا من "email".
    | وهذا يجعل رسائل الخطأ أكثر وضوحًا للمستخدم.
    |
    */

    'attributes' => [
        'name' => 'الاسم',
        'email' => 'البريد الإلكتروني',
        'phone' => 'رقم الهاتف',
        'password' => 'كلمة المرور',
        'password_confirmation' => 'تأكيد كلمة المرور',
        'current_password' => 'كلمة المرور الحالية',
        'new_password' => 'كلمة المرور الجديدة',
        'role' => 'الدور / الصلاحية',
        'provider' => 'مزود تسجيل الدخول',
        'uuid' => 'المعرف الفريد',
        'fcm_token' => 'رمز جهاز الإشعارات',
        'fcm_tokens' => 'رموز أجهزة الإشعارات',
        'tokens' => 'الرموز المميزة',
        'image' => 'الصورة',
        'images' => 'الصور',
        'images.*' => 'الصورة',
        'avatar' => 'الصورة الشخصية',

        'name_en' => 'الاسم باللغة الإنجليزية',
        'name_ar' => 'الاسم باللغة العربية',
        'description_en' => 'الوصف باللغة الإنجليزية',
        'description_ar' => 'الوصف باللغة العربية',
        'price' => 'السعر',
        'stock' => 'الكمية في المخزون',
        'sku' => 'رمز المنتج (SKU)',
        'is_default' => 'الحالة الافتراضية',
        'tax_id' => 'الضريبة',
        'product_id' => 'المنتج',
        'product_variant_id' => 'خيار المنتج',
        'category_id' => 'القسم',
        'category_ids' => 'الأقسام',
        'category_ids.*' => 'القسم',
        'parent_id' => 'القسم الرئيسي',
        'offer_id' => 'العرض',
        'offer_ids' => 'العروض',
        'offer_ids.*' => 'العرض',
        'delete_images_ids' => 'الصور المطلوب حذفها',
        'delete_images_ids.*' => 'الصورة المطلوب حذفها',

        'features' => 'المواصفات',
        'features.*' => 'المواصفة',
        'features.*.title_en' => 'عنوان المواصفة بالإنجليزية',
        'features.*.title_ar' => 'عنوان المواصفة بالعربية',
        'features.*.description_en' => 'وصف المواصفة بالإنجليزية',
        'features.*.description_ar' => 'وصف المواصفة بالعربية',

        'variants' => 'خيارات المنتج',
        'variants.*' => 'خيار المنتج',
        'variants.*.price' => 'سعر خيار المنتج',
        'variants.*.stock' => 'مخزون خيار المنتج',
        'variants.*.sku' => 'رمز خيار المنتج (SKU)',
        'variants.*.attributes' => 'سمات خيار المنتج',
        'variants.*.attributes.*' => 'السمة',
        'variants.*.attributes.*.name_en' => 'اسم السمة بالإنجليزية',
        'variants.*.attributes.*.name_ar' => 'اسم السمة بالعربية',
        'variants.*.attributes.*.value_en' => 'قيمة السمة بالإنجليزية',
        'variants.*.attributes.*.value_ar' => 'قيمة السمة بالعربية',

        'rating' => 'التقييم',
        'comment' => 'التعليق',

        'title' => 'العنوان',
        'title_en' => 'العنوان باللغة الإنجليزية',
        'title_ar' => 'العنوان باللغة العربية',

        'quantity' => 'الكمية',
        'address_id' => 'عنوان الشحن',
        'coupon_code' => 'كود الخصم',
        'payment_method' => 'طريقة الدفع',
        'status' => 'الحالة',
        'user_id' => 'المستخدم',
        'subtotal' => 'المجموع الفرعي',
        'discount' => 'قيمة الخصم',
        'coupon_amount' => 'قيمة خصم الكوبون',
        'tax' => 'قيمة الضريبة',
        'total_amount' => 'المبلغ الإجمالي',
        'amount' => 'المبلغ',
        'paid_at' => 'تاريخ السداد',
        'transaction_id' => 'رقم المعاملة',

        'code' => 'كود الكوبون',
        'discount_type' => 'نوع الخصم',
        'discount_value' => 'قيمة الخصم',
        'starts_at' => 'تاريخ البدء',
        'ends_at' => 'تاريخ الانتهاء',
        'is_active' => 'حالة التفعيل',
        'usage_limit' => 'الحد الأقصى للاستخدام',
        'usage_per_user' => 'الحد الأقصى للاستخدام لكل مستخدم',
        'min_subtotal' => 'الحد الأدنى للطلب',

        'rate' => 'نسبة الضريبة',

        'address_name' => 'اسم العنوان / التسمية',
        'address_line' => 'تفاصيل العنوان',
        'lat' => 'خط العرض',
        'lng' => 'خط الطول',
        'note' => 'الملاحظات',

        'subject' => 'موضوع التذكرة',
        'message' => 'نص الرسالة',
        'ticket_id' => 'التذكرة',
        'priority' => 'الأولوية',
        'sender_id' => 'المرسل',
        'sender_type' => 'نوع المرسل',

        'body' => 'نص الإشعار',
        'notifiable_type' => 'نوع الكيان المستهدف',
        'notifiable_id' => 'معرف الكيان المستهدف',
        'is_read' => 'حالة القراءة',

        'search' => 'كلمة البحث',
        'page' => 'رقم الصفحة',
        'per_page' => 'عدد العناصر في الصفحة',
        'sort_by' => 'الترتيب حسب',
        'sort_order' => 'اتجاه الترتيب',
        'max_offers' => 'فلتر أعلى العروض',
    ],
];