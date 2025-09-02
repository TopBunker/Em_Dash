<div x-data="{menuOpen: false}" class="relative flex flex-col px-4 bg-accent backdrop-blur-md">
    <!-- Mobile Nav-->
    <nav class="flex flex-col @md:hidden py-2">
        <div id="mobile-menu" class="flex flex-col pb-2 origin-bottom transition-all duration-300 ease-in-out transform scale-y-0 opacity-0" 
            :class="menuOpen ? 'scale-y-100 opacity-100' : 'scale-y-0 opacity-0 hidden'">
            <a href="#" class="px-4 py-2 link-nav" :aria-current="view === 'classic' ? 'page' : null" wire:click="$dispatch('switchTo', {active: 'classic'})" aria-label="Classic view for mobile">
                Classic
            </a>
            <a href="#" class="px-4 pt-2 link-nav" :aria-current="view === 'bubble' ? 'page' : null" wire:click="$dispatch('switchTo', {active: 'bubble'})" aria-label="Bubble view for mobile" >
                Bubble
            </a>
        </div>
        <div class="flex flex-row justify-between">
            <!--Menu button (mobile only)-->
            <button id="menu-btn" class="text-brand focus:outline-none" 
                    @click="menuOpen = !menuOpen"
                    aria-label="Toggle display menu on mobile"
                    :aria-expanded="menuOpen.toString()">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path class="" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <!--Contact button-->
            <button class="text-accent-dark px-3 py-1 btn-cta" :aria-current="view === 'contact' ? 'page' : null" @click="view = 'contact'; $dispatch('switchTo', {'active': 'contact'});" aria-label="Contact">
                Contact
            </button>
        </div>
    </nav>

    <div class="text-center">&copy; {{date('Y')}} Em-Dash. All rights reserved.</div>
</div>
