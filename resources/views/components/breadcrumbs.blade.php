<nav {{ $attributes }}>
    <ul class="nav-ul">
        <li class="nav-li">
            <a href="/">{{ __('Home') }}</a>
        </li>
        @foreach ($links as $label => $link)
            <li class="arrow">⟩ </li>
            <li class="nav-li">
                <a href="{{ $link }}">{{ __($label) }}</a>
            </li>
        @endforeach
    </ul>
</nav>