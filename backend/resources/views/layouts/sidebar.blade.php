<aside 
    class="group fixed top-0 left-0 h-screen bg-white shadow transition-all duration-300 
           w-16 hover:w-64 overflow-hidden">

    <div class="p-6 border-b">
        <h2 class="text-xl font-semibold whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity">
            Panel de administración
        </h2>
    </div>

    <nav class="mt-4">

        {{-- Dashboard --}}
        <div class="pt-2 pb-3 space-y-1 flex items-center gap-3 px-4">
           
            <span class="opacity-0 group-hover:opacity-100 transition-opacity w-full">
                <x-responsive-nav-link 
                    :href="route('dashboard')" 
                    :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            </span>
        </div>

        {{-- Usuarios --}}
        <div class="pt-2 pb-3 space-y-1 flex items-center gap-3 px-4">
            
            <span class="opacity-0 group-hover:opacity-100 transition-opacity w-full">
                <x-responsive-nav-link 
                    :href="route('backoffice.users.index')" 
                    :active="request()->routeIs('backoffice.users.*')">
                    {{ __('Usuarios') }}
                </x-responsive-nav-link>
            </span>
        </div>

        {{-- Municipis --}}
        <div class="pt-2 pb-3 space-y-1 flex items-center gap-3 px-4">
            
            <span class="opacity-0 group-hover:opacity-100 transition-opacity w-full">
                <x-responsive-nav-link 
                    :href="route('backoffice.municipalities.index')" 
                    :active="request()->routeIs('backoffice.municipalities.*')">
                    {{ __('Municipis') }}
                </x-responsive-nav-link>
            </span>
        </div>

        {{-- Treks --}}
        <div class="pt-2 pb-3 space-y-1 flex items-center gap-3 px-4">
            
            <span class="opacity-0 group-hover:opacity-100 transition-opacity w-full">
                <x-responsive-nav-link 
                    :href="route('backoffice.treks.index')" 
                    :active="request()->routeIs('backoffice.treks.*')">
                    {{ __('Treks') }}
                </x-responsive-nav-link>
            </span>
        </div>

        {{-- Meetings --}}
        <div class="pt-2 pb-3 space-y-1 flex items-center gap-3 px-4">
            
            <span class="opacity-0 group-hover:opacity-100 transition-opacity w-full">
                <x-responsive-nav-link 
                    :href="route('backoffice.meetings.index')" 
                    :active="request()->routeIs('backoffice.meetings.*')">
                    {{ __('Meetings') }}
                </x-responsive-nav-link>
            </span>
        </div>

        {{-- Places --}}
        <div class="pt-2 pb-3 space-y-1 flex items-center gap-3 px-4">
        
            <span class="opacity-0 group-hover:opacity-100 transition-opacity w-full">
                <x-responsive-nav-link 
                    :href="route('backoffice.interestingplaces.index')" 
                    :active="request()->routeIs('backoffice.interestingplaces.*')">
                    {{ __('Places') }}
                </x-responsive-nav-link>
            </span>
        </div>

    </nav>
</aside>