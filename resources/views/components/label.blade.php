

<label class="login_label" 
    for="{{ $for }}">
    @if ($required)
        <span class="text-red-400">*</span>
    @endif
    {{ $slot }}
</label>