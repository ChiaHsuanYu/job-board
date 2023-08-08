<x-layout>
    <h1 class="login_title">
        {{ __('Sign in to your account') }}
    </h1>
    <x-card>
        <form action="{{ route('auth.store') }}" method="POST">
            @csrf
            <div class="mb-8">
                <x-label for="email" :required="true">{{ __('E-mail') }}</x-label>
                <x-text-input name="email"></x-text-input>
            </div>
            <div class="mb-8">
                <x-label for="password" :required="true">{{ __('Password') }}</x-label>
                <x-text-input type="password" name="password"></x-text-input>
            </div>

            <div class="login_fun_box">
                <div>
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="remember" class="login_checkbox">
                        <label for="remember">{{ __('Remember me') }}</label>
                    </div>
                </div>
                <div>
                    <a href="#" class="login_forget">{{ __('Forget password') }}?</a>
                </div>
            </div>

            <x-button class="w-full bg-green-50">{{ __('Login') }}</x-button>
        </form>
    </x-card>
</x-layout>