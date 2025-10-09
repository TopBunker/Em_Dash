<div x-data="{menuOpen: false}" class="relative flex flex-col px-4 backdrop-blur-md" x-transition>
    <!-- Mobile Nav-->
    <div  class="@md:hidden flex flex-col py-2">
        <div id="mobile-menu" class="flex flex-col pb-2 origin-bottom" 
            x-show="menuOpen" x-transition>
            <a href="#" class="px-4 py-2 link-nav" x-bind:aria-current="$store.app.currentPage === 'resume' ? 'page' : null" x-on:click.prevent="$store.app.currentPage='resume'; menuOpen = false; $dispatch('switchTo', {active: 'resume'})" aria-label="View Resume">
                Résumé
            </a>
            <a href="#" class="px-4 pt-2 link-nav" x-bind:aria-current="$store.app.currentPage === 'portfolio' ? 'page' : null" x-on:click.prevent="$store.app.currentPage='portfolio'; menuOpen = false; $dispatch('switchTo', {active: 'portfolio'})" aria-label="View Portfolio">
                Portfolio
            </a>
        </div>
        <div class="flex flex-row justify-between">
            <!--Menu button (mobile only)-->
            <button id="menu-btn" class="text-brand focus:outline-none" 
                    aria-label="Toggle display menu on mobile"
                    x-on:click="menuOpen = !menuOpen"
                    :aria-expanded="menuOpen.toString()">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path class="" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <!--Contact button-->
            <a href="#" class="btn-cta shadow-xl/30" x-bind:aria-current="$store.app.currentPage === 'contact' ? 'page' : null" x-on:click.prevent="$store.app.currentPage='contact'; menuOpen = false; $dispatch('switchTo', {active: 'contact'})" aria-label="View Contact">
                Contact
            </a>
        </div>
    </div>
    <div class="text-center text-xs mt-2">
        <div class="sm:hidden mb-2">
            <a href="{{ route('terms') }}" class="underline hover:text-brand" target="_blank" rel="noopener">Terms of Use</a> &middot; 
            <a href="{{ route('privacy') }}" class="underline hover:text-brand" target="_blank" rel="noopener">Privacy Policy</a>     
        </div>
        <div class="hidden sm:inline-block">
            &copy; {{date('Y')}} {{ config('app.name') }}. All rights reserved.
            <a href="{{ route('terms') }}" class="underline hover:text-brand" target="_blank" rel="noopener">Terms of Use</a> &middot; 
            <a href="{{ route('privacy') }}" class="underline hover:text-brand" target="_blank" rel="noopener">Privacy Policy</a>
        </div>
        <div class="my-1 hidden sm:block">
            Built with <a href="https://laravel.com" target="_blank" rel="noopener" class="underline hover:text-brand">Laravel/Livewire</a> &amp; <a href="https://alpinejs.dev" target="_blank" rel="noopener" class="underline hover:text-brand">Alpine.js</a>.
        </div>
    
    </div>
</div>
