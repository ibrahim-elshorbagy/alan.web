<div id="mySidebar" class="sidebar d-lg-block d-xl-block">
    <a href="javascript:void(0)" class="closebtn d-lg-none d-block pt-3" onclick="closeNav()">×</a>
    <div class="setting-tab mb-sm-7 mb-5">
        <ul class="nav nav-tabs-1 flex-nowrap text-nowrap flex-sm-column d-sm-flex d-block">
            <div class="d-sm-flex flex-sm-column overflow-auto">
                <li class="nav-item nav-item-1 position-relative">
                    @if (isset($whatsappStore))
                        <a class="nav-link-1 nav-link p-3 {{ isset($partName) && $partName == 'basics' ? 'active' : '' }} "
                            href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $whatsappStore->id, 'part' => 'basics']) }}">
                            <i class="fa-solid fa-circle-question me-2 icon-color-bs-blue"></i>
                            {{ __('messages.vcard.basic_details') }}
                        </a>
                    @else
                        <a class="nav-link-1 nav-link p-3 {{ isset($partName) && $partName == 'basics' ? 'active' : '' }} "
                            href="{{ route('whatsapp.stores') . '?part=basics' }}">
                            <i class="fa-solid fa-circle-question me-2 icon-color-bs-blue"></i>
                            {{ __('messages.vcard.basic_details') }}
                        </a>
                    @endif
                </li>
                <li class="nav-item nav-item-1 position-relative">
                    @if (isset($whatsappStore))
                        <a class="nav-link-1 nav-link p-3  {{ isset($partName) && $partName == 'whatsapp-template' ? 'active' : '' }} "
                            href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $whatsappStore->id, 'part' => 'whatsapp-template']) }}">
                            <i class="fa-solid fa-file-lines me-2 text-success"></i>
                            {{ __('messages.whatsapp_stores.whatsapp_templates') }}
                        </a>
                    @else
                        <a class="nav-link-1 nav-link p-3 opacity-50  disabled" href="#">
                            <i class="fa-solid fa-file-lines me-2 text-success"></i>
                            {{ __('messages.whatsapp_stores.whatsapp_templates') }}
                        </a>
                    @endif

                </li>
                <li class="nav-item nav-item-1 position-relative">
                    @if (isset($whatsappStore))
                        <a class="nav-link-1 nav-link p-3  {{ isset($partName) && $partName == 'business-hours' ? 'active' : '' }} "
                            href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $whatsappStore->id, 'part' => 'business-hours']) }}">
                            <i class="fa-solid fa-clock me-2 icon-color-bs-yellow"></i>
                            {{ __('messages.vcard.business_hours') }}
                        </a>
                    @else
                        <a class="nav-link-1 nav-link p-3 opacity-50  disabled" href="#">
                            <i class="fa-solid fa-clock me-2 icon-color-bs-yellow"></i>
                            {{ __('messages.vcard.business_hours') }}
                        </a>
                    @endif

                </li>
                <li class="nav-item nav-item-1 position-relative">
                    @if (isset($whatsappStore))
                        <a class="nav-link-1 nav-link p-3  {{ isset($partName) && $partName == 'products-categories' ? 'active' : '' }} "
                            href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $whatsappStore->id, 'part' => 'products-categories']) }}">
                            <i class="fa-solid fa-layer-group me-2 text-warning"></i>
                            {{ __('messages.whatsapp_stores.products_categories') }}
                        </a>
                    @else
                        <a class="nav-link-1 nav-link p-3 opacity-50 disabled " href="#">
                            <i class="fa-solid fa-layer-group me-2 text-warning"></i>
                            {{ __('messages.whatsapp_stores.products_categories') }}
                        </a>
                    @endif
                </li>
                <li class="nav-item nav-item-1 position-relative">
                    @if (isset($whatsappStore))
                        <a class="nav-link-1 nav-link p-3  {{ isset($partName) && $partName == 'products' ? 'active' : '' }}"
                            href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $whatsappStore->id, 'part' => 'products']) }}">
                            <i class="fa-solid fa-boxes-stacked me-2 text-primary"></i>
                            {{ __('messages.whatsapp_stores.products') }}
                        </a>
                    @else
                        <a class="nav-link-1 nav-link p-3 opacity-50  disabled" href="#">
                            <i class="fa-solid fa-boxes-stacked me-2 text-primary"></i>
                            {{ __('messages.whatsapp_stores.products') }}
                        </a>
                    @endif
                </li>
                <li class="nav-item nav-item-1 position-relative">
                    @if (isset($whatsappStore))
                        <a class="nav-link-1 nav-link p-3  {{ isset($partName) && $partName == 'product-orders' ? 'active' : '' }}"
                            href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $whatsappStore->id, 'part' => 'product-orders']) }}">
                            <i class="fas fa-money-bills me-2 icon-color-bs-darkyellow"></i>
                            {{ __('messages.product_orders') }}
                        </a>
                    @else
                        <a class="nav-link-1 nav-link p-3 opacity-50  disabled" href="#">
                            <i class="fas fa-money-bills me-2 icon-color-bs-darkyellow"></i>
                            {{ __('messages.product_orders') }}
                        </a>
                    @endif
                </li>
                <li class="nav-item nav-item-1 position-relative">
                    @if (isset($whatsappStore))
                        <a class="nav-link-1 nav-link p-3  {{ isset($partName) && $partName == 'advanced' ? 'active' : '' }}"
                            href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $whatsappStore->id, 'part' => 'advanced']) }}">
                            <i class="fa-solid fa-gears me-2 icon-color-bs-orange"></i>
                            {{ __('messages.vcard.advanced') }}
                        </a>
                    @else
                        <a class="nav-link-1 nav-link p-3 opacity-50  disabled" href="#">
                            <i class="fa-solid fa-gears me-2 icon-color-bs-orange"></i>
                            {{ __('messages.vcard.advanced') }}
                        </a>
                    @endif
                </li>
                <li class="nav-item nav-item-1 position-relative">
                    @if (isset($whatsappStore))
                        <a class="nav-link-1 nav-link p-3  {{ isset($partName) && $partName == 'custom-fonts' ? 'active' : '' }}"
                            href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $whatsappStore->id, 'part' => 'custom-fonts']) }}">
                            <i class="fa-solid fa-font me-2 icon-color-bs-yellow"></i>
                            {{ __('messages.font.fonts') }}
                        </a>
                    @else
                        <a class="nav-link-1 nav-link p-3 opacity-50  disabled" href="#">
                            <i class="fa-solid fa-font me-2 icon-color-bs-yellow"></i>
                            {{ __('messages.font.fonts') }}
                        </a>
                    @endif
                </li>
                <li class="nav-item nav-item-1 position-relative">
                    @if (isset($whatsappStore))
                        <a class="nav-link-1 nav-link p-3  {{ isset($partName) && $partName == 'seo' ? 'active' : '' }}"
                            href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $whatsappStore->id, 'part' => 'seo']) }}">
                            <i class="fa-solid fa-magnifying-glass me-2 icon-color-bs-green"></i>
                            {{ __('messages.plan.seo') }}
                        </a>
                    @else
                        <a class="nav-link-1 nav-link p-3 opacity-50  disabled" href="#">
                            <i class="fa-solid fa-magnifying-glass me-2 icon-color-bs-green"></i>
                            {{ __('messages.plan.seo') }}
                        </a>
                    @endif
                </li>
                <li class="nav-item nav-item-1 position-relative">
                    @if (isset($whatsappStore))
                        <a class="nav-link-1 nav-link p-3  {{ isset($partName) && $partName == 'trending-video' ? 'active' : '' }}"
                            href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $whatsappStore->id, 'part' => 'trending-video']) }}">
                            <i class="fa-brands fa-youtube me-2 icon-color-bs-red"></i>
                            {{ __('messages.plan.trending_video') }}
                        </a>
                    @else
                        <a class="nav-link-1 nav-link p-3 opacity-50  disabled" href="#">
                            <i class="fa-brands fa-youtube me-2 icon-color-bs-red"></i>
                            {{ __('messages.plan.trending_video') }}
                        </a>
                    @endif
                </li>
                <li class="nav-item nav-item-1 position-relative">
                    @if (isset($whatsappStore))
                        <a class="nav-link-1 nav-link p-3  {{ isset($partName) && $partName == 'terms-conditions' ? 'active' : '' }}"
                            href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $whatsappStore->id, 'part' => 'terms-conditions']) }}">
                            <i class="fa-solid fa-clipboard-list me-2 icon-color-bs-lightred"></i>
                            {{ __('messages.vcard.term_condition') }}
                        </a>
                    @else
                        <a class="nav-link-1 nav-link p-3 opacity-50  disabled" href="#">
                            <i class="fa-solid fa-clipboard-list me-2 icon-color-bs-lightred"></i>
                            {{ __('messages.vcard.term_condition') }}
                        </a>
                    @endif
                </li>
            </div>
        </ul>
    </div>
</div>


<script>
    function openNav() {
        document.getElementById("mySidebar").style.width = "250px";
        //   document.getElementById("main").style.marginLeft = "250px";
    }

    function closeNav() {
        document.getElementById("mySidebar").style.width = "0";
        //   document.getElementById("main").style.marginLeft= "0";
    }
</script>
