<div x-data="{menuOpen: false}" class="relative flex flex-col px-4 bg-accent backdrop-blur-md">
    <!-- Mobile Nav-->
    <div  class="@md:hidden flex flex-col py-2">
        <div id="mobile-menu" class="flex flex-col pb-2 origin-bottom" 
            x-show="menuOpen" x-transition>
            <a href="#" class="px-4 py-2 link-nav" x-bind:aria-current="currentPage === 'resume' ? 'page' : null" x-on:click.prevent="currentPage='resume';$dispatch('switchTo', {active: 'resume'})" aria-label="View Resume">
                Resume
            </a>
            <a href="#" class="px-4 pt-2 link-nav" x-bind:aria-current="currentPage === 'portfolio' ? 'page' : null" x-on:click.prevent="currentPage='portfolio';$dispatch('switchTo', {active: 'portfolio'})" aria-label="View Portfolio">
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
            <a href="#" class="text-accent-dark px-3 py-1 btn-cta" x-bind:aria-current="currentPage === 'contact' ? 'page' : null" x-on:click.prevent="currentPage='contact';$dispatch('switchTo', {active: 'contact'})" aria-label="View Contact">
                Contact
            </a>
        </div>
    </div>
    <div class="text-center">&copy; {{date('Y')}} Em-Dash. All rights reserved.</div>
</div>
