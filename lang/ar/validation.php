<?php

return [

    /*
    |--------------------------------------------------------------------------
    | سطور التحقق
    |--------------------------------------------------------------------------
    |
    | السطور التالية تحتوي على رسائل الخطأ الافتراضية المستخدمة من قبل
    | فئة المحقق. بعض هذه القواعد لها إصدارات متعددة مثل
    | قواعد الحجم. يمكنك تعديل كل من هذه الرسائل هنا.
    |
    */

    'accepted' => 'يجب قبول :attribute.',
    'accepted_if' => 'يجب قبول :attribute عندما يكون :other يساوي :value.',
    'active_url' => 'حقل :attribute لا يمثل رابطاً صالحاً.',
    'after' => 'يجب أن يكون حقل :attribute تاريخاً بعد :date.',
    'after_or_equal' => 'يجب أن يكون حقل :attribute تاريخاً بعد أو يساوي :date.',
    'alpha' => 'يجب أن يحتوي حقل :attribute على أحرف فقط.',
    'alpha_dash' => 'يجب أن يحتوي حقل :attribute على أحرف وأرقام وشرطات وشرطات سفلية فقط.',
    'alpha_num' => 'يجب أن يحتوي حقل :attribute على أحرف وأرقام فقط.',
    'array' => 'يجب أن يكون حقل :attribute مصفوفة.',
    'before' => 'يجب أن يكون حقل :attribute تاريخاً قبل :date.',
    'before_or_equal' => 'يجب أن يكون حقل :attribute تاريخاً قبل أو يساوي :date.',
    'between' => [
        'array' => 'يجب أن يحتوي حقل :attribute على :min إلى :max عنصر.',
        'file' => 'يجب أن يكون حجم حقل :attribute بين :min و :max كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute بين :min و :max.',
        'string' => 'يجب أن يكون طول حقل :attribute بين :min و :max حرفاً.',
    ],
    'boolean' => 'يجب أن يكون حقل :attribute صحيحاً أو خاطئاً.',
    'confirmed' => 'تأكيد حقل :attribute غير مطابق.',
    'current_password' => 'كلمة المرور غير صحيحة.',
    'date' => 'حقل :attribute ليس تاريخاً صالحاً.',
    'date_equals' => 'يجب أن يكون حقل :attribute تاريخاً يساوي :date.',
    'date_format' => 'حقل :attribute لا يتطابق مع التنسيق :format.',
    'declined' => 'يجب رفض :attribute.',
    'declined_if' => 'يجب رفض :attribute عندما يكون :other يساوي :value.',
    'different' => 'يجب أن يكون حقل :attribute و :other مختلفين.',
    'digits' => 'يجب أن يحتوي حقل :attribute على :digits أرقام.',
    'digits_between' => 'يجب أن يحتوي حقل :attribute على :min إلى :max أرقام.',
    'dimensions' => 'حقل :attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct' => 'حقل :attribute يحتوي على قيمة مكررة.',
    'doesnt_end_with' => 'حقل :attribute يجب ألا ينتهي بأي مما يلي: :values.',
    'doesnt_start_with' => 'حقل :attribute يجب ألا يبدأ بأي مما يلي: :values.',
    'email' => 'يجب أن يكون حقل :attribute عنوان بريد إلكتروني صالح.',
    'ends_with' => 'يجب أن ينتهي حقل :attribute بأي مما يلي: :values.',
    'enum' => 'حقل :attribute المحدد غير صالح.',
    'exists' => 'حقل :attribute المحدد غير صالح.',
    'file' => 'يجب أن يكون حقل :attribute ملفاً.',
    'filled' => 'حقل :attribute يجب أن يحتوي على قيمة.',
    'gt' => [
        'array' => 'يجب أن يحتوي حقل :attribute على أكثر من :value عنصر.',
        'file' => 'يجب أن يكون حجم حقل :attribute أكبر من :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute أكبر من :value.',
        'string' => 'يجب أن يكون طول حقل :attribute أكبر من :value حرف.',
    ],
    'gte' => [
        'array' => 'يجب أن يحتوي حقل :attribute على :value عنصر على الأقل.',
        'file' => 'يجب أن يكون حجم حقل :attribute أكبر من أو يساوي :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute أكبر من أو تساوي :value.',
        'string' => 'يجب أن يكون طول حقل :attribute أكبر من أو يساوي :value حرف.',
    ],
    'image' => 'يجب أن يكون حقل :attribute صورة.',
    'in' => 'حقل :attribute المحدد غير صالح.',
    'in_array' => 'حقل :attribute غير موجود في :other.',
    'integer' => 'يجب أن يكون حقل :attribute عدداً صحيحاً.',
    'ip' => 'يجب أن يكون حقل :attribute عنوان IP صالحاً.',
    'ipv4' => 'يجب أن يكون حقل :attribute عنوان IPv4 صالحاً.',
    'ipv6' => 'يجب أن يكون حقل :attribute عنوان IPv6 صالحاً.',
    'json' => 'يجب أن يكون حقل :attribute نصاً بصيغة JSON صالحة.',
    'lt' => [
        'array' => 'يجب أن يحتوي حقل :attribute على أقل من :value عنصر.',
        'file' => 'يجب أن يكون حجم حقل :attribute أقل من :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute أقل من :value.',
        'string' => 'يجب أن يكون طول حقل :attribute أقل من :value حرف.',
    ],
    'lte' => [
        'array' => 'يجب ألا يحتوي حقل :attribute على أكثر من :value عنصر.',
        'file' => 'يجب أن يكون حجم حقل :attribute أقل من أو يساوي :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute أقل من أو تساوي :value.',
        'string' => 'يجب أن يكون طول حقل :attribute أقل من أو يساوي :value حرف.',
    ],
    'mac_address' => 'يجب أن يكون حقل :attribute عنوان MAC صالحاً.',
    'max' => [
        'array' => 'يجب ألا يحتوي حقل :attribute على أكثر من :max عنصر.',
        'file' => 'يجب ألا يتجاوز حجم حقل :attribute :max كيلوبايت.',
        'numeric' => 'يجب ألا تتجاوز قيمة حقل :attribute :max.',
        'string' => 'يجب ألا يتجاوز طول حقل :attribute :max حرف.',
    ],
    'max_digits' => 'يجب ألا يحتوي حقل :attribute على أكثر من :max أرقام.',
    'mimes' => 'يجب أن يكون حقل :attribute ملفاً من نوع: :values.',
    'mimetypes' => 'يجب أن يكون حقل :attribute ملفاً من نوع: :values.',
    'min' => [
        'array' => 'يجب أن يحتوي حقل :attribute على :min عنصر على الأقل.',
        'file' => 'يجب أن يكون حجم حقل :attribute :min كيلوبايت على الأقل.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute :min على الأقل.',
        'string' => 'يجب أن يكون طول حقل :attribute :min حرف على الأقل.',
    ],
    'min_digits' => 'يجب أن يحتوي حقل :attribute على :min أرقام على الأقل.',
    'multiple_of' => 'يجب أن تكون قيمة حقل :attribute مضاعفاً لـ :value.',
    'not_in' => 'حقل :attribute المحدد غير صالح.',
    'not_regex' => 'تنسيق حقل :attribute غير صالح.',
    'numeric' => 'يجب أن يكون حقل :attribute رقماً.',
    'password' => [
        'letters' => 'يجب أن يحتوي حقل :attribute على حرف واحد على الأقل.',
        'mixed' => 'يجب أن يحتوي حقل :attribute على حرف كبير وحرف صغير على الأقل.',
        'numbers' => 'يجب أن يحتوي حقل :attribute على رقم واحد على الأقل.',
        'symbols' => 'يجب أن يحتوي حقل :attribute على رمز واحد على الأقل.',
        'uncompromised' => 'ظهر حقل :attribute المحدد في تسريب بيانات. يرجى اختيار :attribute مختلف.',
    ],
    'present' => 'يجب أن يكون حقل :attribute موجوداً.',
    'prohibited' => 'حقل :attribute محظور.',
    'prohibited_if' => 'حقل :attribute محظور عندما يكون :other يساوي :value.',
    'prohibited_unless' => 'حقل :attribute محظور إلا إذا كان :other ضمن :values.',
    'prohibits' => 'حقل :attribute يمنع وجود :other.',
    'regex' => 'تنسيق حقل :attribute غير صالح.',
    'required' => 'حقل :attribute مطلوب.',
    'required_array_keys' => 'يجب أن يحتوي حقل :attribute على إدخالات لـ: :values.',
    'required_if' => 'حقل :attribute مطلوب عندما يكون :other يساوي :value.',
    'required_if_accepted' => 'حقل :attribute مطلوب عندما يتم قبول :other.',
    'required_unless' => 'حقل :attribute مطلوب إلا إذا كان :other ضمن :values.',
    'required_with' => 'حقل :attribute مطلوب عندما تكون :values موجودة.',
    'required_with_all' => 'حقل :attribute مطلوب عندما تكون جميع :values موجودة.',
    'required_without' => 'حقل :attribute مطلوب عندما لا تكون :values موجودة.',
    'required_without_all' => 'حقل :attribute مطلوب عندما لا تكون أي من :values موجودة.',
    'same' => 'يجب أن يتطابق حقل :attribute مع :other.',
    'size' => [
        'array' => 'يجب أن يحتوي حقل :attribute على :size عنصر.',
        'file' => 'يجب أن يكون حجم حقل :attribute :size كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute :size.',
        'string' => 'يجب أن يكون طول حقل :attribute :size حرف.',
    ],
    'starts_with' => 'يجب أن يبدأ حقل :attribute بأي مما يلي: :values.',
    'string' => 'يجب أن يكون حقل :attribute نصاً.',
    'timezone' => 'يجب أن يكون حقل :attribute منطقة زمنية صالحة.',
    'unique' => 'حقل :attribute مستخدم بالفعل.',
    'uploaded' => 'فشل تحميل حقل :attribute.',
    'url' => 'يجب أن يكون حقل :attribute رابطاً صالحاً.',
    'uuid' => 'يجب أن يكون حقل :attribute UUID صالحاً.',

    /*
    |--------------------------------------------------------------------------
    | رسائل التحقق المخصصة
    |--------------------------------------------------------------------------
    |
    | هنا يمكنك تحديد رسائل تحقق مخصصة للحقول باستخدام
    | الاصطلاح "اسم-الحقل.القاعدة" لتسمية السطور. هذا يجعل من السهل
    | تحديد رسالة مخصصة لقاعدة تحقق محددة.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'رسالة-مخصصة',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | أسماء الحقول المخصصة
    |--------------------------------------------------------------------------
    |
    | السطور التالية تستخدم لاستبدال العنصر النائب للحقل
    | بشيء أكثر وضوحاً للقارئ مثل "عنوان البريد الإلكتروني" بدلاً من
    | "email". هذا يساعدنا في جعل رسائلنا أكثر تعبيرية.
    |
    */

    'attributes' => [
        'location_url' => 'رابط الموقع',
        'service_url' => 'رابط الخدمة',
        'name' => 'الاسم',
        'email' => 'البريد الإلكتروني',
        'phone' => 'الهاتف',
        'message' => 'الرسالة',
        'Password' => 'كلمة المرور',
        'expire_at' => 'تنتهي في',
        'current_password' => 'كلمة المرور الحالية',
        'new_password' => 'كلمة المرور الجديدة',
        'confirm_password' => 'تأكيد كلمة المرور',
        'video_file' => 'ملف الفيديو',
        'audio_file' => 'ملف الصوت',
        'gallery_upload_file' => 'ملف رفع المعرض',
        'image' => 'الصورة',
        'link' => 'الرابط',
        'amount' => 'المبلغ',
        'short_code' => 'الرمز القصير',
        'occupation' => 'المهنة',
        'ecard-logo' => 'شعار البطاقة الإلكترونية',
    ],

    'coupon_code' => [
        'not_found' => 'رمز القسيمة غير موجود',
        'expired' => 'رمز القسيمة هذا منتهي الصلاحية',
    ],

];