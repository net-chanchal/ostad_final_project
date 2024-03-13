@php use App\Helpers\CoreHelper; @endphp
<ul class="nav nav-pills flex-column">
    <li class="nav-item">
        <a href="{{ route("admin.settings.general") }}"
           class="nav-link {{ CoreHelper::menuActive('admin.settings.general') }}">General Settings</a>
        <a href="{{ route("admin.settings.google_ads") }}"
           class="nav-link {{ CoreHelper::menuActive('admin.settings.google_ads') }}">Google Ads</a>
        <a href="{{ route("admin.settings.social_urls") }}"
           class="nav-link {{ CoreHelper::menuActive('admin.settings.social_urls') }}">Social URLs</a>
        <a href="{{ route("admin.settings.email_config") }}"
           class="nav-link {{ CoreHelper::menuActive('admin.settings.email_config') }}">Email Config</a>
    </li>
</ul>
