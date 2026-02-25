<x-guest-layout>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Seleccionamos todos los formularios que tengan validación
            const forms = document.querySelectorAll('form');

            forms.forEach(form => {
                const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');

                inputs.forEach(input => {
                    // Cuando el campo es inválido
                    input.addEventListener('invalid', function () {

                        // Si es un email, validamos manualmente
                        if (this.type === 'email') {

                            // Si NO contiene @
                            if (!this.value.includes('@')) {
                                this.setCustomValidity('El email debe contener un @');
                                return;
                            }

                            // Si contiene @ pero sigue siendo inválido (formato incorrecto)
                            this.setCustomValidity('Introduce un email válido');
                            return;
                        }

                        this.setCustomValidity('Este campo es obligatorio! y este mensaje es personalizado!');
                    });

                    // Limpiar el mensaje cuando el usuario empieza a escribir
                    input.addEventListener('input', function () {
                        this.setCustomValidity('');
                    });
                });
            });
        });
    </script>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div class="mt-4">
            <x-input-label for="lastname" :value="__('Last Name')" />
            <x-text-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')"
                required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
        </div>

        <!-- DNI -->
        <div class="mt-4">
            <x-input-label for="dni" :value="__('DNI')" />
            <x-text-input id="dni" class="block mt-1 w-full" type="text" name="dni" :value="old('dni')" required
                autocomplete="off" />
            <x-input-error :messages="$errors->get('dni')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required
                autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>