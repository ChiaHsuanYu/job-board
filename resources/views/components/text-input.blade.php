<div class="relative">
    @if ('textarea' !== $type)
        @if ($formid)
            <buttin type="button" class="close_btn" onclick="clean_input('{{ $name }}','{{ $formid }}');">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-slate-400">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </buttin>
        @endif
        
        <input type="{{ $type }}" placeholder="{{ $placeholder }}"
            id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value) }}"
            @class([
                'filter-input',
                'ring-slate-300' => !$errors->has($name),
                'ring-red-300' => $errors->has($name)
            ]) />
    
    @else
        <textarea id="{{ $name }}" name="{{ $name }}" @class([
            'filter-input',
            'ring-slate-300' => !$errors->has($name),
            'ring-red-300' => $errors->has($name)
        ])> {{ old($name, $value) }} </textarea>

    @endif

    @error($name)
        <div class="mt-1 text-xs text-red-500">
            {{ $message }}
        </div>
        
    @enderror
</div>

<script>
    function clean_input(name,formid){
        document.getElementById(name).value='';
        document.getElementById(formid).submit(); 
    }
</script>