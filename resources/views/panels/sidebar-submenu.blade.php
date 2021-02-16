{{-- vertical-menu-submenu --}}
@if($configData['mainLayoutType'] == 'vertical-menu')
  <ul class="menu-content">
      @if (isset($menu))
        @foreach ($menu as $submenu)
          <li {{(request()->is($submenu->url.'*')) ? 'class=active' : '' }}>
            <a href="@isset($submenu->url) {{asset($submenu->url)}} @endisset" @if(isset($submenu->newTab)){{"target=_blank"}}@endif>
              <i class="bx bx-right-arrow-alt"></i>
            <span class="menu-item">{{ __('locale.'.$submenu->name)}}</span>
            </a>
            @if(isset($submenu->submenu))
              @include('panels.sidebar-submenu',['menu'=>$submenu->submenu])
            @endif
          </li>
        @endforeach
      @endif
  </ul>
  {{-- horizontal-menu submenu --}}
@elseif($configData['mainLayoutType'] == 'horizontal-menu')
  <ul class="dropdown-menu">
      @if(isset($menu))
        @foreach ($menu as $submenu)
          <li class="@if(isset($submenu->submenu)){{'dropdown dropdown-submenu'}}@endif {{(request()->is($submenu->url.'*')) ? 'active' : '' }}" data-menu="@if(isset($submenu->submenu)){{'dropdown-submenu'}} @endif">
          <a class="dropdown-item align-items-center @if(isset($submenu->submenu)){{'dropdown-toggle'}}@endif" href="{{asset($submenu->url)}}" data-toggle="dropdown" @if(isset($submenu->newTab)){{"target=_blank"}}@endif>
              <i class="bx bx-right-arrow-alt"></i>
              <span>{{ __('locale.'.$submenu->name)}}</span>
          </a>
          @if(isset($submenu->submenu))
            @include('panels.sidebar-submenu',['menu' => $submenu->submenu])
          @endif
          </li>
        @endforeach
      @endif
  </ul>
@endif

{{-- vertical-box-menu --}}
@if($configData['mainLayoutType'] == 'vertical-menu-boxicons')
<ul class="menu-content">
  @if (isset($menu))
    @foreach ($menu as $submenu)
      <li {{(request()->is($submenu->url.'*')) ? 'class=active' : '' }}>
        <a href="@isset($submenu->url) {{asset($submenu->url)}} @endisset" @if(isset($submenu->newTab)){{"target=_blank"}}@endif>
          <i class="bx bx-right-arrow-alt"></i>
        <span class="menu-item">{{ __('locale.'.$submenu->name)}}</span>
        </a>
        @if(isset($submenu->submenu))
          @include('panels.sidebar-submenu',['menu'=>$submenu->submenu])
        @endif
      </li>
    @endforeach
  @endif
</ul>
@endif