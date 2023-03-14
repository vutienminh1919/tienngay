@inject('sidebar','App\Service\Sidebar')
@php( $menu = $sidebar->loadMenu() )
<aside class="navbar navbar-vertical navbar-expand-lg sidebar">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="{{route('dashboard.index')}}">
                <img src="{{asset('images/Logo_new_2.png')}}" width="210" alt="Tabler">
            </a>
        </h1>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav pt-lg-3">
                @if($menu)
                    @foreach( $menu as $item )
                        @if( is_null($item['parent']) )
                            <li class="nav-item mb-2">
                                <a class="nav-link dropdown-toggle mb-2" data-bs-toggle="dropdown" role="button"
                                   aria-expanded="false">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <img src="{{ asset('images/icon-folder.svg') }}">
                                </span>
                                <span class="nav-link-title">
                                    {{ $item['name'] }}
                                </span>
                                </a>
                                <div class="dropdown-menu {{ $sidebar->activeMenuParent($item['id'], $menu) }}" >
                                    <div class="dropdown-menu-columns">
                                        <div class="dropdown-menu-columns">
                                            @foreach( $menu as $item_child )
                                                @if( $item['id'] == $item_child['parent'] )
                                                    <a class="dropdown-item {{ $sidebar->activeMenu($item_child['url']) }} mb-2"
                                                       href="{{ $sidebar->urlMenu($item_child['url']) }}">
                                                        {{ $item_child['name'] }}
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</aside>
