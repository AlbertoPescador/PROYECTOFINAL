<nav class="bg-white border-b border-gray-100 hidden sm:block">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex w-full">
                <!-- Logo -->
                <div class="shrink-0 flex items-center mx-4">
                    <a href="{{ route('user.principal') }}">
                        <img src="{{ asset('assets/logo.png') }}" width="100" height="200" x="0" y="0" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="space-x-2 sm:-my-px sm:ml-10 sm:flex justify-between items-center w-full">
                    <div class="mx-4">
                        <x-nav-link :href="route('products.list')" :active="request()->routeIs('products.list')">
                            {{ __('Productos') }}
                        </x-nav-link>
                    </div>
                    
                    <div class="hidden sm:flex sm:items-center sm:ms-2">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                    <span>Categorías</span>
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content" style="margin-top: 12px;">
                                <a href="{{ route('products.category', ['category_id' => 1]) }}">Ternera</a>
                                <a href="{{ route('products.category', ['category_id' => 2]) }}">Vaca</a>
                                <a href="{{ route('products.category', ['category_id' => 3]) }}">Cerdo</a>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    
                    <div class="mx-4">
                        <x-nav-link :href="route('product.sales')" :active="request()->routeIs('product.sales')">
                            {{ __('Ofertas') }}
                        </x-nav-link>
                    </div>

                    <div class="mx-4">
                        <x-nav-link :href="route('invoice.myinvoices')" :active="request()->routeIs('invoice.myinvoices')">
                            {{ __('Mis Pedidos') }}
                        </x-nav-link>
                    </div>
                </div>

                <!-- Cart Icon -->
                <a href="{{ route('cart.list') }}" class="flex items-center mx-4 space-x-1">
                    <svg class="w-5 h-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 36 36"><circle cx="13.5" cy="29.5" r="2.5" fill="currentColor" class="clr-i-solid clr-i-solid-path-1"/><circle cx="26.5" cy="29.5" r="2.5" fill="currentColor" class="clr-i-solid clr-i-solid-path-2"/><path fill="currentColor" d="M33.1 6.39a1 1 0 0 0-.79-.39H9.21l-.45-1.43a1 1 0 0 0-.66-.65L4 2.66a1 1 0 1 0-.59 1.92L7 5.68l4.58 14.47l-1.63 1.34l-.13.13A2.66 2.66 0 0 0 9.74 25A2.75 2.75 0 0 0 12 26h16.69a1 1 0 0 0 0-2H11.84a.67.67 0 0 1-.56-1l2.41-2h15.43a1 1 0 0 0 1-.76l3.2-13a1 1 0 0 0-.22-.85Z" class="clr-i-solid clr-i-solid-path-3"/><path fill="none" d="M0 0h36v36H0z"/></svg>
                    <span class="text-gray-700">{{ Cart::getTotalQuantity() }}</span> 
                </a>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
            
                    <x-slot name="content">
                        @if(Auth::user()->role !=='admin')
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Mi Perfil') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('contact.index')">
                                {{ __('Contacto') }}
                            </x-dropdown-link>
                        @endif
            
                        @if(Auth::user()->role === 'admin')
                            <x-dropdown-link :href="route('admin.principal')">
                                {{ __('Vista de Administrador') }}
                            </x-dropdown-link>
                        @endif

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
            
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            
        </div>
    </div>
</nav>

<!-- Menú Responsivo -->
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 block sm:hidden">
    <div class="flex justify-between h-16">
        <!-- Logo -->
        <div class="shrink-0 flex items-center mx-4">
            <a href="{{ route('user.principal') }}">
                <img src="{{ asset('assets/logo.png') }}" width="100" height="200" x="0" y="0" />
            </a>
        </div>

        <!-- Botón para el menú responsivo -->
        <div class="flex items-center sm:hidden">
            <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-nav-link :href="route('products.list')" :active="request()->routeIs('products.list')">
                {{ __('Productos') }}
            </x-nav-link>
            
            <x-nav-link :href="route('products.category', ['category_id' => 1])">
                {{ __('Ternera') }}
            </x-nav-link>
            <x-nav-link :href="route('products.category', ['category_id' => 2])">
                {{ __('Vaca') }}
            </x-nav-link>
            <x-nav-link :href="route('products.category', ['category_id' => 3])">
                {{ __('Cerdo') }}
            </x-nav-link>
            
            <x-nav-link :href="route('product.sales')" :active="request()->routeIs('product.sales')">
                {{ __('Ofertas') }}
            </x-nav-link>

            <x-nav-link :href="route('invoice.myinvoices')" :active="request()->routeIs('invoice.myinvoices')">
                {{ __('Mis Pedidos') }}
            </x-nav-link>
        </div>

        <!-- Cart Icon -->
        <a href="{{ route('cart.list') }}" class="flex items-center mx-4 space-x-1">
            <svg class="w-5 h-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid meet" viewBox="0 0 36 36"><circle cx="13.5" cy="29.5" r="2.5" fill="currentColor" class="clr-i-solid clr-i-solid-path-1"/><circle cx="26.5" cy="29.5" r="2.5" fill="currentColor" class="clr-i-solid clr-i-solid-path-2"/><path fill="currentColor" d="M33.1 6.39a1 1 0 0 0-.79-.39H9.21l-.45-1.43a1 1 0 0 0-.66-.65L4 2.66a1 1 0 1 0-.59 1.92L7 5.68l4.58 14.47l-1.63 1.34l-.13.13A2.66 2.66 0 0 0 9.74 25A2.75 2.75 0 0 0 12 26h16.69a1 1 0 0 0 0-2H11.84a.67.67 0 0 1-.56-1l2.41-2h15.43a1 1 0 0 0 1-.76l3.2-13a1 1 0 0 0-.22-.85Z" class="clr-i-solid clr-i-solid-path-3"/><path fill="none" d="M0 0h36v36H0z"/></svg>
            <span class="text-gray-700">{{ Cart::getTotalQuantity() }}</span> 
        </a>

        <!-- Separación de Administrador y Cerrar Sesión -->
        <div class="border-t border-gray-200 pt-2 pb-3 space-y-1">
            @if(Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.principal')">
                    {{ __('Vista de Administrador') }}
                </x-responsive-nav-link>
            @endif
            
            @if(Auth::user()->role !=='admin')
            <x-responsive-nav-link :href="route('profile.edit')">
                {{ __('Mi Perfil') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('contact.index')">
                {{ __('Contacto') }}
            </x-responsive-nav-link>
            @endif

            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Cerrar Sesión') }}
                </x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>
