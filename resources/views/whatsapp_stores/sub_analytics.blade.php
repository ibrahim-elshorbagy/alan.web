<ul class="nav nav-tabs mb-5 pb-1 overflow-auto flex-nowrap text-nowrap" id="subAnalytics" role="tablist">
    <li class="nav-item position-relative me-7 mb-3" role="presentation">
        <a class="nav-link {{(isset($partName) && $partName == 'overview') ? 'active' : ''}}"
           href="{{route('whatsapp.store.analytics',$whatsappStore->id)}}" tabindex="-1">{{__('messages.analytics.overview')}}</a>
    </li>
    <li class="nav-item position-relative me-7 mb-3" role="presentation">
        <a class="nav-link {{(isset($partName) && $partName == 'country') ? 'active' : ''}}"
           href="{{route('whatsapp.store.analytics',$whatsappStore->id).'?part=country'}}"
           tabindex="-1">{{__('messages.analytics.countries')}}</a>
    </li>
    <li class="nav-item position-relative me-7 mb-3" role="presentation">
        <a class="nav-link {{(isset($partName) && $partName == 'device') ? 'active' : ''}}"
           href="{{route('whatsapp.store.analytics',$whatsappStore->id).'?part=device'}}"
           tabindex="-1">{{__('messages.analytics.devices')}}</a>
    </li>
    <li class="nav-item position-relative me-7 mb-3" role="presentation">
        <a class="nav-link {{(isset($partName) && $partName == 'os') ? 'active' : ''}}"
           href="{{route('whatsapp.store.analytics',$whatsappStore->id).'?part=os'}}" tabindex="-1">{{__('messages.analytics.os')}}</a>
    </li>
    <li class="nav-item position-relative me-7 mb-3" role="presentation">
        <a class="nav-link {{(isset($partName) && $partName == 'browser') ? 'active' : ''}}"
           href="{{route('whatsapp.store.analytics',$whatsappStore->id).'?part=browser'}}"
           tabindex="-1">{{__('messages.analytics.browsers')}}</a>
    </li>
    <li class="nav-item position-relative me-7 mb-3" role="presentation">
        <a class="nav-link {{(isset($partName) && $partName == 'language') ? 'active' : ''}}"
           href="{{route('whatsapp.store.analytics',$whatsappStore->id).'?part=language'}}"
           tabindex="-1">{{__('messages.analytics.languages')}}</a>
    </li>
</ul>
