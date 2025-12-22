const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/js/app.js', 'public/js').
//     postCss('resources/css/app.css', 'public/css', [
//         require('postcss-import'),
//         // require('tailwindcss'),
//         require('autoprefixer'),
//     ]);

mix.copyDirectory(
    [
        // 'resources/assets/img',
        "node_modules/intl-tel-input/build/img",
    ],
    "public/assets/img"
);
//mix.copyDirectory('resources/theme/images', 'public/images')
//mix.copyDirectory('resources/assets/img/new_front',
//  'public/assets/img/new_front')
mix.copyDirectory("public/web/plugins/global/fonts", "public/assets/css/fonts");
mix.copyDirectory(
    "node_modules/summernote/dist/font",
    "public/assets/css/font"
);
mix.copyDirectory("resources/theme/webfonts", "public/assets/webfonts");
mix.copyDirectory("resources/theme/fonts", "public/assets/fonts");
mix.copyDirectory("resources/fonts/vcard11", "public/assets/fonts/vcard11");
mix.copyDirectory(
    "resources/assets/scss/new_home/bootstrap.min.css",
    "public/assets/css/new_home"
);
mix.copyDirectory(
    "resources/assets/img/dashboard",
    "public/assets/img/dashboard"
);
mix.copyDirectory("resources/assets/img/nfc", "public/assets/img/nfc");

mix.sass('resources/assets/scss/vcard1.scss', 'public/assets/css/vcard1.css').
    sass('resources/assets/scss/vcard2.scss', 'public/assets/css/vcard2.css').
    sass('resources/assets/scss/vcard3.scss', 'public/assets/css/vcard3.css').
    sass('resources/assets/scss/vcard4.scss', 'public/assets/css/vcard4.css').
    sass('resources/assets/scss/vcard5.scss', 'public/assets/css/vcard5.css').
    sass('resources/assets/scss/vcard6.scss', 'public/assets/css/vcard6.css').
    sass('resources/assets/scss/vcard7.scss', 'public/assets/css/vcard7.css').
    sass('resources/assets/scss/vcard8.scss', 'public/assets/css/vcard8.css').
    sass('resources/assets/scss/vcard9.scss', 'public/assets/css/vcard9.css').
    sass('resources/assets/scss/vcard10.scss', 'public/assets/css/vcard10.css').
    sass('resources/assets/scss/vcard16.scss', 'public/assets/css/vcard16.css').
    sass('resources/assets/scss/vcard13.scss', 'public/assets/css/vcard13.css').
    sass('resources/assets/scss/vcard14.scss', 'public/assets/css/vcard14.css').
    sass('resources/assets/scss/vcard15.scss', 'public/assets/css/vcard15.css').
    sass('resources/assets/scss/vcard17.scss', 'public/assets/css/vcard17.css').
    sass('resources/assets/scss/vcard21.scss', 'public/assets/css/vcard21.css').
    sass('resources/assets/scss/vcard22.scss', 'public/assets/css/vcard22.css').
    sass('resources/assets/scss/vcard26.scss', 'public/assets/css/vcard26.css').
    sass('resources/assets/scss/vcard20.scss', 'public/assets/css/vcard20.css').
    sass('resources/assets/scss/vcard18.scss', 'public/assets/css/vcard18.css').
    sass('resources/assets/scss/vcard19.scss', 'public/assets/css/vcard19.css').
    sass('resources/assets/scss/vcard24.scss', 'public/assets/css/vcard24.css').
    sass('resources/assets/scss/vcard25.scss', 'public/assets/css/vcard25.css').
    sass('resources/assets/scss/vcard27.scss', 'public/assets/css/vcard27.css').
    sass('resources/assets/scss/vcard28.scss', 'public/assets/css/vcard28.css').
    sass('resources/assets/scss/vcard31.scss', 'public/assets/css/vcard31.css').
    sass('resources/assets/scss/vcard32.scss', 'public/assets/css/vcard32.css').
    sass('resources/assets/scss/vcard33.scss', 'public/assets/css/vcard33.css').
    sass('resources/assets/scss/vcard34.scss', 'public/assets/css/vcard34.css').
    sass('resources/assets/scss/vcard35.scss', 'public/assets/css/vcard35.css').
    sass('resources/assets/scss/vcard36.scss', 'public/assets/css/vcard36.css').
    sass('resources/assets/scss/vcard37.scss', 'public/assets/css/vcard37.css').
    sass('resources/assets/scss/vcard38.scss', 'public/assets/css/vcard38.css').
    sass('resources/assets/scss/vcard30.scss', 'public/assets/css/vcard30.css').
    sass('resources/assets/scss/vcard29.scss', 'public/assets/css/vcard29.css').
    sass('resources/assets/scss/vcard39.scss', 'public/assets/css/vcard39.css').
    sass('resources/assets/scss/dynamic-vcard.scss', 'public/assets/css/dynamic-vcard.css').
    sass('resources/assets/scss/vcard23.scss', 'public/assets/css/vcard23.css').
    sass('resources/assets/scss/oldVcard/vcard1.scss', 'public/assets/css/oldVcard/vcard1.css').
    sass('resources/assets/scss/oldVcard/vcard12.scss', 'public/assets/css/oldVcard/vcard12.css').
    sass('resources/assets/scss/oldVcard/vcard13.scss', 'public/assets/css/oldVcard/vcard13.css').
    sass('resources/assets/scss/oldVcard/vcard14.scss', 'public/assets/css/oldVcard/vcard14.css').
    sass('resources/assets/scss/oldVcard/vcard15.scss', 'public/assets/css/oldVcard/vcard15.css').
    sass('resources/assets/scss/oldVcard/vcard16.scss', 'public/assets/css/oldVcard/vcard16.css').
    sass('resources/assets/scss/oldVcard/vcard17.scss', 'public/assets/css/oldVcard/vcard17.css').
    sass('resources/assets/scss/oldVcard/vcard18.scss', 'public/assets/css/oldVcard/vcard18.css').
    sass('resources/assets/scss/oldVcard/vcard19.scss', 'public/assets/css/oldVcard/vcard19.css').
    sass('resources/assets/scss/oldVcard/vcard20.scss', 'public/assets/css/oldVcard/vcard20.css').
    sass('resources/assets/scss/oldVcard/vcard21.scss', 'public/assets/css/oldVcard/vcard21.css').
    sass('resources/assets/scss/oldVcard/vcard22.scss', 'public/assets/css/oldVcard/vcard22.css').
    sass('resources/assets/scss/oldVcard/vcard23.scss', 'public/assets/css/oldVcard/vcard23.css').
    sass('resources/assets/scss/oldVcard/vcard24.scss', 'public/assets/css/oldVcard/vcard24.css').
    sass('resources/assets/scss/oldVcard/vcard25.scss', 'public/assets/css/oldVcard/vcard25.css').
    sass('resources/assets/scss/oldVcard/vcard26.scss', 'public/assets/css/oldVcard/vcard26.css').
    sass('resources/assets/scss/oldVcard/vcard27.scss', 'public/assets/css/oldVcard/vcard27.css').
    sass('resources/assets/scss/oldVcard/vcard28.scss', 'public/assets/css/oldVcard/vcard28.css').
    sass('resources/assets/scss/oldVcard/vcard29.scss', 'public/assets/css/oldVcard/vcard29.css').
    sass('resources/assets/scss/oldVcard/vcard30.scss', 'public/assets/css/oldVcard/vcard30.css').
    sass('resources/assets/scss/oldVcard/vcard31.scss', 'public/assets/css/oldVcard/vcard31.css').
    sass('resources/assets/scss/oldVcard/vcard32.scss', 'public/assets/css/oldVcard/vcard32.css').
    sass('resources/assets/scss/oldVcard/vcard33.scss', 'public/assets/css/oldVcard/vcard33.css').
    sass('resources/assets/scss/oldVcard/vcard34.scss', 'public/assets/css/oldVcard/vcard34.css').
    sass('resources/assets/scss/oldVcard/vcard35.scss', 'public/assets/css/oldVcard/vcard35.css').
    sass('resources/assets/scss/oldVcard/vcard36.scss', 'public/assets/css/oldVcard/vcard36.css').
    sass('resources/assets/scss/oldVcard/vcard37.scss', 'public/assets/css/oldVcard/vcard37.css').
    sass('resources/assets/scss/new_vcard/custom.scss', 'public/assets/css/new_vcard/custom.css').
    sass('resources/assets/scss/new_vcard/slick.scss', 'public/assets/css/new_vcard/slick.css').
    sass('resources/assets/scss/new_vcard/slick-theme.scss', 'public/assets/css/new_vcard/slick-theme.css').
    sass('resources/assets/scss/blog.scss', 'public/assets/css/blog.css').
    sass('resources/assets/scss/oldVcard/blog.scss', 'public/assets/css/oldVcard/blog.css').
    sass('resources/assets/scss/vcard12.scss', 'public/assets/css/vcard12.css').
    sass('resources/assets/scss/theme.scss', 'public/assets/css/theme.css').
    sass('resources/assets/scss/front/main.scss',
        'public/assets/css/front/front-custom.css').version()

mix.sass(
    "resources/assets/scss/new_home/index.scss",
    "public/assets/css/new_home/index.css"
)
    .sass(
        "resources/assets/scss/new_home/custom.scss",
        "public/assets/css/new_home/custom.css"
    )
    .sass(
        "resources/assets/scss/faqs/faqs.scss",
        "public/assets/css/faqs/faqs.css"
    )
    .sass(
        "resources/assets/scss/blogs/blogs.scss",
        "public/assets/css/blogs/blogs.css",
    )
    .sass(
        "resources/assets/scss/blogs/blogs1.scss",
        "public/assets/css/blogs/blogs1.css"
    )
    .sass(
        "resources/assets/scss/new_home/slick.scss",
        "public/assets/css/new_home/slick.css"
    )
    .sass(
        "resources/assets/scss/new_home/slick-theme.scss",
        "public/assets/css/new_home/slick-theme.css"
    )
    .sass(
        "resources/assets/scss/new_home/layout.scss",
        "public/assets/css/new_home/layout.css"
    )
    .version();

// mix.styles('resources/assets/scss/vcard11/variable.css',
//     'public/assets/css/variable.css')

mix.sass(
    "resources/assets/scss/vcard11/variables.scss",
    "public/assets/css/variables.css"
)
    .sass(
        "resources/assets/scss/vcard11/blog.scss",
        "public/assets/css/blog.css"
    )
    .sass(
        "resources/assets/scss/vcard11/blog-single.scss",
        "public/assets/css/blog-single.css"
    )
    .sass(
        "resources/assets/scss/vcard11/contact.scss",
        "public/assets/css/contact.css"
    )
    .sass(
        "resources/assets/scss/vcard11/custom.scss",
        "public/assets/css/custom.css"
    )
    .sass(
        "resources/assets/scss/vcard11/home.scss",
        "public/assets/css/home.css"
    )
    .sass(
        "resources/assets/scss/vcard11/layout.scss",
        "public/assets/css/layout.css"
    )
    .sass(
        "resources/assets/scss/vcard11/portfolio.scss",
        "public/assets/css/portfolio.css"
    )
    .sass(
        "resources/assets/scss/vcard11/portfolio-single.scss",
        "public/assets/css/portfolio-single.css"
    )
    .sass(
        "resources/assets/scss/vcard11/portfolio-single-2.scss",
        "public/assets/css/portfolio-single-2.css"
    )
    .sass(
        "resources/assets/scss/vcard11/resume.scss",
        "public/assets/css/resume.css"
    )
    .version();

mix.copyDirectory("resources/assets/js/vcard11", "public/assets/js/vcard11");

mix.js(
    "resources/assets/js/vcards/vcard-view.js",
    "public/assets/js/vcards/vcard-view.js"
)
    .js("resources/assets/js/auth/auth.js", "public/assets/js/auth/auth.js")
    .js(
        "resources/assets/js/custom/phone-number-country-code.js",
        "public/assets/js/custom/phone-number-country-code.js"
    )
    .version();

mix.babel(
    "node_modules/intl-tel-input/build/js/intlTelInput.js",
    "public/assets/js/intl-tel-input/build/intlTelInput.js"
);

// // third-party js
mix.scripts(
    [
        "resources/theme/js/vendor.js",
        "resources/theme/js/plugins.js",
        "node_modules/chart.js/dist/chart.js",
        "node_modules/intl-tel-input/build/js/intlTelInput.js",
        "node_modules/intl-tel-input/build/js/utils.js",
        "node_modules/quill/dist/quill.js",
        "node_modules/summernote/dist/summernote-lite.js",
        "node_modules/@simonwep/pickr/dist/pickr.min.js",
        "node_modules/@simonwep/pickr/dist/pickr.es5.min.js",
    ],
    "public/assets/js/third-party.js"
).version();

mix.scripts(
    "node_modules/intl-tel-input/build/js/utils.js",
    "public/assets/js/inttel/js/utils.min.js"
);

// pages js

mix.js(
    [
        "resources/assets/js/custom/turbo.js",
        "resources/assets/js/custom/helpers.js",
        "resources/assets/js/custom/custom.js",
        "resources/assets/js/roles/create-edit.js",
        "resources/assets/js/email_sub/email-sub.js",
        "resources/assets/js/settings/settings.js",
        "resources/assets/js/dashboard/dashboard.js",
        "resources/assets/js/users/users.js",
        "resources/assets/js/users/create-edit.js",
        "resources/assets/js/vcards/vcards.js",
        "resources/assets/js/vcards/template.js",
        "resources/assets/js/vcards/create-edit.js",
        "resources/assets/js/vcards/services/services.js",
        "resources/assets/js/vcards/blogs/blogs.js",
        "resources/assets/js/vcards/gallery/gallery.js",
        "resources/assets/js/vcards/instagram-embed/instagram-embed.js",
        "resources/assets/js/vcards/products/products.js",
        "resources/assets/js/vcards/custom_link/custom_link.js",
        "resources/assets/js/vcards/analytics/analytics.js",
        "resources/assets/js/vcards/testimonials/testimonials.js",
        "resources/assets/js/subscription/subscription.js",
        "resources/assets/js/subscription/upgrade.js",
        "resources/assets/js/sadmin/plans/plans.js",
        "resources/assets/js/sadmin/plans/create-edit.js",
        "resources/assets/js/enquiry/enquiry.js",
        "resources/assets/js/appointment/appointment.js",
        "resources/assets/js/home/contact.js",
        "resources/assets/js/sadmin/countries/countries.js",
        "resources/assets/js/sadmin/nfc/nfc.js",
        "resources/assets/js/sadmin/testimonial/frontTestimonial.js",
        "resources/assets/js/sadmin/faqs/frontFaqs.js",
        "resources/assets/js/sadmin/send_email/sendEmail.js",
        "resources/assets/js/sadmin/email_template/email_template.js",
        "resources/assets/js/sadmin/blogs/blogs.js",
        "resources/assets/js/sadmin/blogs/create-edit.js",
        "resources/assets/js/sadmin/states/states.js",
        "resources/assets/js/sadmin/cities/cities.js",
        "resources/assets/js/custom/phone-number-country-code.js",
        "resources/assets/js/users/user-profile.js",
        "resources/assets/js/languages/languages.js",
        "resources/assets/js/languages/language_translate.js",
        "resources/assets/js/sidebar_menu_search/sidebar_menu_search.js",
        "resources/assets/js/affiliation_withdraw/affiliation_withdraw.js",
        "resources/assets/js/coupon_code/coupon_code.js",
        "resources/assets/js/vcards/social-links/social-links.js",
        "resources/assets/js/ecard/ecard.js",
        "resources/assets/js/nfc/nfc.js",
        "resources/assets/js/iframes/iframe.js",
        "resources/assets/js/storage/storage.js",
        "resources/assets/js/addon/addon.js",
        "resources/assets/js/whatsapp_store/whatsapp_store.js",
        "resources/assets/js/whatsapp_store/product_category/product_category.js",
        "resources/assets/js/whatsapp_store/products/wp-store-products.js",
        "resources/assets/js/whatsapp_store/analytics/analytics.js",
        "resources/assets/js/wp_product_transactions/wp_product_transaction.js",
        "resources/assets/js/sadmin/custom_page/custom_page.js",
        "resources/assets/js/sadmin/custom_page/create-edit.js",
        "resources/assets/js/vcards/linkedin-embed/linkedin-embed.js",
        "resources/assets/js/image_cropper/image_cropper.js",
    ],
    "public/assets/js/pages.js"
).version();

// third-party css
mix.styles(
    [
        "resources/theme/css/third-party.css",
        "node_modules/intl-tel-input/build/css/intlTelInput.css",
        "node_modules/quill/dist/quill.snow.css",
        "node_modules/quill/dist/quill.bubble.css",
        "node_modules/summernote/dist/summernote-lite.css",
        "node_modules/@simonwep/pickr/dist/themes/classic.min.css",
        "node_modules/@simonwep/pickr/dist/themes/monolith.min.css",
        "node_modules/@simonwep/pickr/dist/themes/nano.min.css",
    ],
    "public/assets/css/third-party.css"
);

// light theme css
mix.styles("resources/theme/css/style.css", "public/assets/css/style.css");
mix.styles("resources/theme/css/plugins.css", "public/css/plugins.css");

// dark theme css
mix.styles(
    "resources/theme/css/style.dark.css",
    "public/assets/css/style.dark.css"
);
mix.styles(
    "resources/theme/css/plugins.dark.css",
    "public/css/plugins.dark.css"
);
mix.styles(
    "resources/assets/css/lazy-loading.css",
    "public/assets/css/lazy-loading.css"
);
mix.sass(
    "resources/assets/css/custom-dark-mode.scss",
    "public/assets/css/custom-pages-dark.css",
).version();

// page css
mix.sass(
    "resources/assets/css/main.scss",
    "public/assets/css/page.css"
).version();

// page dark-css
// mix.sass('resources/assets/css/main-dark-mode.scss','public/assets/css/page-dark.css').version()
mix.sass(
    "resources/assets/scss/custom-vcard.scss",
    "public/assets/css/custom-vcard.css"
).version();

// third-party dark css
// mix.styles([
//     'node_modules/intl-tel-input/build/css/intlTelInput.css',
//     'public/backend/css/vendor.css',
//     'public/backend/css/fonts.css',
//     'public/backend/css/3rd-party.css',
//     'public/backend/css/3rd-party-custom.css',
//     'public/backend/css/style.dark.bundle.css',
// ], 'public/assets/css/third-party-dark.css')

// front-third-party js
mix.scripts(
    [
        "resources/theme/js/vendor.js",
        "resources/theme/js/plugins.js",
        "public/front/js/slick.min.js",
    ],
    "public/assets/js/front-third-party.js"
).version();

mix.scripts(
    [
        "node_modules/flatpickr/dist/flatpickr.js",
        "node_modules/toastr/build/toastr.min.js",
        "node_modules/select2/dist/js/select2.min.js",
        "node_modules/moment/min/moment.min.js",
    ],
    "public/assets/js/front-third-party-vcard11.js"
).version();

mix.copy(
    "node_modules/slick-slider/slick/slick-theme.css",
    "public/assets/css/slider/css/slick-theme.min.css"
);
mix.copy(
    "node_modules/slick-slider/slick/ajax-loader.gif",
    "public/assets/css/slider/css/ajax-loader.gif"
);
mix.copy(
    "node_modules/slick-slider/slick/slick.css",
    "public/assets/css/slider/css/slick.css"
);
mix.copy(
    "node_modules/slick-slider/slick/slick.min.js",
    "public/assets/js/slider/js/slick.min.js"
);

mix.js(
    "resources/assets/js/custom/helpers.js",
    "public/assets/js/custom/helpers.js"
)
    .js(
        "resources/assets/js/home/contact.js",
        "public/assets/js/home/contact.js"
    )
    .js(
        "resources/assets/js/custom/custom.js",
        "public/assets/js/custom/custom.js"
    )
    .js(
        "resources/assets/js/home_page/home_page.js",
        "public/assets/js/home_page/home_page.js"
    )
    .version();

mix.sass(
    "resources/assets/css/front-main.scss",
    "public/assets/css/front-custom.css"
).version();

mix.styles(
    [
        "public/front/css/slick.css",
        // 'public/assets/css/custom.css',
        "public/front/css/slick-theme.css",
        "public/front/scss/style.css",
    ],
    "public/assets/css/public.css"
).version();

mix.js(
    [
        "resources/assets/js/custom/turbo.js",
        "resources/assets/js/custom/helpers.js",
        "resources/assets/js/custom/custom.js",
        "resources/assets/js/home_page/home_page.js",
        "resources/assets/js/auth/auth.js",
        "resources/assets/js/home/contact.js",
    ],
    "public/assets/js/front-pages.js"
).version();

mix.styles(
    "node_modules/lightbox2/dist/css/lightbox.min.css",
    "public/assets/css/lightbox.css"
);
mix.js(
    "node_modules/lightbox2/dist/js/lightbox.min.js",
    "public/assets/js/lightbox.js"
);

mix.copyDirectory("node_modules/lightbox2/dist/images", "public/assets/images");

mix.sass(
    "resources/assets/scss/whatsappp_store/beauty-products.scss",
    "public/assets/css/whatsappp_store/beauty-products.css"
).version();
mix.sass(
    "resources/assets/scss/whatsappp_store/custom.scss",
    "public/assets/css/whatsappp_store/custom.css"
).version();
mix.sass(
    "resources/assets/scss/whatsappp_store/ecommerce.scss",
    "public/assets/css/whatsappp_store/ecommerce.css"
).version();
mix.sass(
    "resources/assets/scss/whatsappp_store/restaurant.scss",
    "public/assets/css/whatsappp_store/restaurant.css"
).version();
mix.sass(
    "resources/assets/scss/whatsappp_store/cloth_store.scss",
    "public/assets/css/whatsappp_store/cloth_store.css"
).version();
mix.js(
    "resources/assets/js/whatsapp_store/template.js",
    "public/assets/js/whatsapp_store_template.js"
).version();

mix.sass(
    "resources/assets/scss/whatsappp_store/grocery_store.scss",
    "public/assets/css/whatsappp_store/grocery_store.css"
).version();

mix.sass(
    "resources/assets/scss/whatsappp_store/home_decor.scss",
    "public/assets/css/whatsappp_store/home_decor.css"
).version();
mix.sass(
    "resources/assets/scss/whatsappp_store/jewellery.scss",
    "public/assets/css/whatsappp_store/jewellery.css"
).version();
mix.sass(
    "resources/assets/scss/whatsappp_store/travel.scss",
    "public/assets/css/whatsappp_store/travel.css"
).version();
