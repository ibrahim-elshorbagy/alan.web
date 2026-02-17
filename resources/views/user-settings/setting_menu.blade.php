<div id="mySidebar" class="me-5 sidebar" style="width: 0;">
  <a href="javascript:void(0)" class="closebtn d-lg-none d-block pt-3" onclick="closeNav()">×</a>
  <div class="setting-tab mb-sm-7 mb-5">
    <ul class="nav nav-tabs-1 flex-nowrap text-nowrap flex-sm-column d-sm-flex d-block">
      <div class="d-sm-flex flex-sm-column overflow-auto">
        <li class="nav-item nav-item-1 position-relative">
          <a class="nav-link-1 nav-link p-3 {{ isset($sectionName) && $sectionName == 'general' ? 'active' : '' }}" href="{{ route('user.setting.index', ['section' => 'general']) }}" onclick="closeNav()">
            <i class="fa-solid fa-gears icon-color-bs-blue me-2"></i>
            {{ __('messages.setting.general') }}
          </a>
        </li>
        <li class="nav-item nav-item-1 position-relative">
          <a class="nav-link-1 nav-link p-3 {{ isset($sectionName) && $sectionName == 'payment_method' ? 'active' : '' }}" href="{{ route('user.setting.index', ['section' => 'payment_method']) }}" data-turbo="false" onclick="closeNav()">
            <i class="fa-solid fa-money-bill-1-wave icon-color-bs-green me-2"></i>
            {{ __('messages.vcard.payment_config') }}
          </a>
        </li>
        @if ($isAllowCustomDomain)
        <li class="nav-item nav-item-1 position-relative">
          <a class="nav-link-1 nav-link p-3 {{ isset($sectionName) && $sectionName == 'custom_domain' ? 'active' : '' }}" href="{{ route('user.setting.index', ['section' => 'custom_domain']) }}" data-turbo="false" onclick="closeNav()">
            <i class="fa-solid fa-globe icon-color-bs-green me-2"></i>
            {{ __('messages.custom_domain.custom_domain') }}
          </a>
        </li>
        @endif
      </div>
    </ul>
  </div>
</div>

<script>
  function openNav() {
    document.getElementById("mySidebar").style.width = "250px";
  }

  function closeNav() {
    document.getElementById("mySidebar").style.width = "0";
  }

</script>
