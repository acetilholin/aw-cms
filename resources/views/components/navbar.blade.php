<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <a class="navbar-brand" href="#"><img src="{{ asset('pictures/logo-1.png') }}" class="img-spacing" style="height: 40px"></a>
        <div class="form-inline my-2 my-lg-0 ml-auto">
            @unless(request()->routeIs('statistics'))
                <span class="m-item"><a href="{{ route('statistics') }}"><i class="fas fa-chart-line"></i></a></span>
            @endunless
            @unless(request()->routeIs('main'))
                <span class="m-item"><a href="{{ route('main') }}"><i class="fas fa-car"></i></a></span>
            @endunless
            @unless(request()->routeIs('users'))
                <span class="m-item"><a href="{{ route('users') }}"><i class="fas fa-users"></i></a></span>
            @endunless
            @unless(request()->routeIs('reservations'))
                <span class="m-item"><a href="{{ route('reservations') }}"><i class="fas fa-shuttle-van"></i></a></span>
            @endunless
            <form action="{{ route('logout') }}">
                <button class="btn btn-gray btn-sm" type="submit" style="margin: 0">Odjava</button>
            </form>
        </div>
    </div>
</nav>
