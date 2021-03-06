<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            {{ link_to_route('home', 'Lajvrättning.se', null, array('class' => 'navbar-brand')) }}
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">

                {{-- If user is not logged in --}}
                @if(Auth::guest())
                @else
                    @if(Auth::user()->isAdmin())
                        <li>{{ link_to_route('admin', 'Admin') }}</li>
                    @endif
                @endif
                <li>{{ link_to_route('member', 'Medlemmar') }}</li>

                <li>{{ link_to_route('coupon', 'Kupong') }}</li>

                <li>
                    <a href="http://tipszonen.se" target="_blank">
                        Krönikor
                    </a>
                </li>
                <li>
                    <a href="http://tipszonen.se/forum/vb" target="_blank">
                        Forum
                    </a>
                </li>

                <li class="hidden dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li class="dropdown-header">Nav header</li>
                        <li><a href="#">Separated link</a></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>
            @if( ! Auth::guest() )
                <ul class="nav navbar-nav navbar-right">
                    <li>{{ link_to_route('logout', 'Logga ut') }}</li>
                </ul>

                <a href="{{ route('member.edit', Auth::user()->id) }}">
                    <img class="nav navbar-right navbar-image img-rounded gravatar-image" src="{{ gravatar_url(Auth::user()->email) }}" alt="{{ Auth::user()->email }}" />

                    <p class="navbar-text navbar-right">
                        Inloggad som {{ Auth::user()->username }}
                    </p>
                </a>
            @else
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#loginModal" data-toggle='modal' data-target='#loginModal'>Logga in</a>
                    </li>
                    <li>{{ link_to_route('register', 'Registrera dig') }}</li>
                </ul>
            @endif
        </div><!--/.nav-collapse -->
    </div>
</div>