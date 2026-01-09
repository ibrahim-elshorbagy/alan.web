@component('mail::layout')
  {{-- Header --}}
  @slot('header')
    @component('mail::header', ['url' => config('app.url')])
      {{ getAppName() }}
    @endcomponent
  @endslot


  {{-- Body --}}
  @component('mail::panel')
    ### تم تفعيل رمز رابط إعادة التوجيه بنجاح

    تم تفعيل رمز إعادة التوجيه الخاص بأحد العملاء بعد مسح كارت NFC.
  @endcomponent


  ### بيانات العميل

  @component('mail::table')
    | | |
    |--|--|
    | الاسم الكامل | {{ $user->first_name }} {{ $user->last_name }} |
    | البريد الإلكتروني | {{ $user->email }} |
    | الهاتف | {{ $user->contact ?? 'N/A' }} |
  @endcomponent


  ### تفاصيل الطلب

  @component('mail::table')
    | | |
    |--|--|
    | الرمز | **`{{ $redirectLink->uri }}`** |
    | نوع البطاقة | {{ $nfcCard?->name ?? 'N/A' }} |
    | النوع | {{ $redirectType }} |
    | الكمية | 1 |
    | URI | [{{ url('/auto-' . $redirectLink->uri) }}]({{ url('/auto-' . $redirectLink->uri) }}) |
    | حالة الدفع | تم الدفع خارجياً |
    | حالة الطلب | تم التسليم |
    | تاريخ التفعيل | {{ now()->format('Y-m-d H:i:s') }} |
  @endcomponent


  @component('mail::panel')
    **ملاحظة:**
    تم التفعيل بنجاح ولا يتطلب أي إجراء إضافي.
  @endcomponent


  تحياتنا،
  **{{ getAppName() }}**


  {{-- Footer --}}
  @slot('footer')
    @component('mail::footer')
      © {{ date('Y') }} {{ getAppName() }}. جميع الحقوق محفوظة.
    @endcomponent
  @endslot
@endcomponent
