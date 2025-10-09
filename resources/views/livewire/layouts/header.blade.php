<div x-data class="relative flex flex-col justify-between items-center px-4 pt-4" x-on:getHeight.window="$store.app.headHeight = $el.offsetHeight" x-init="$dispatch('getHeight')">
    <!--Default Profile Header-->
    <div class="flex flex-row justify-around">
        <div class="shrink-0 sm:mx-3">
            @if ($authorized)
            <img src="{{ asset('storage/images/'.$image) }}" 
            class="w-24 h-24 border-2 border-gray-300 shadow-xl/30 rounded-full aspect-square object-cover" 
            alt="User profile picture">
            @else
            <img src="{{ asset('storage/images/system/profile-picture-placeholder.png') }}" 
            class="w-24 h-24 border-2 border-gray-300 shadow-xl/30 rounded-full aspect-square object-cover" 
            alt="Placeholder profile picture">
            @endif
        </div>
        <div class="flex flex-col justify-around text-center ml-2 @sm:mx-3 @sm:ml-auto">
            <h1 class="text-2xl @sm:text-3xl font-medium">{{$fName}} {{$lName}}</h1>
            <h2 class="text-xl @sm:text-2xl font-normal">{{$title}}</h2>
        </div>
    </div>
    <!--Contact Details-->
    <div id="contact-details" class="flex flex-col justify-around my-2">
        <!--Chevron Button-->
        @if ($authorized)
        <button id="links-toggle" 
            class="hover:text-accent-light transition mx-auto lg:hidden"
            x-on:click="$store.app.toggleInfo(); $dispatch('getHeight');"
            :aria-expanded="$store.app.showInfo.toString()" aria-label="Toggle contact display for mobile">
            <svg id="chevron" width="16" height="16" fill="currentColor" 
                class="w-4 h-4 transition-transform duration-500" viewBox="0 0 16 16"
                :class="$store.app.showInfo ? 'rotate-180' : 'rotate-0'">
                <path stroke="black" stroke-width="2" fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708z"/>
            </svg>
        </button>
            <!--Contact/Links-->
        <div id="contact-links" 
            class="flex flex-col lg:flex-row flex-nowrap lg:gap-x-9 text-center lg-h-40 opacity-100 transition-all duration-300 ease-in-out" 
            :class="$store.app.showInfo ? 'max-h-40 opacity-100' : 'max-lg:max-h-0 max-lg:opacity-0 max-lg:hidden'">
            <p class="text-brand-light">
                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" class="inline-block fill-brand" viewBox="0 0 16 16">
                    <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
                </svg> 
                {{$contact['address']->city.', '.$contact['address']->country->name}}
            </p>
            <p class="text-brand-light">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="inline-block fill-brand" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/>
                </svg> 
                <span class="highlight"><span>{{ $contact['tel'][0] }}</span><span>+1</span><span>897</span>{{ ' '.$contact['tel'][1].' ' }}<span>573-6739</span>{{ $contact['tel'][2] }}</span>
            </p>
            <p class="text-brand-light">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="inline-block fill-brand" viewBox="0 0 16 16">
                    <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586zm3.436-.586L16 11.801V4.697z"/>
                </svg> 
                <span class="highlight"><span>{{ $contact['email'][0] }}</span><span>client</span>@<span>emdash.</span><span>gmail.</span>{{ $contact['email'][1] }}<span>org</span>{{ '.'.$contact['email'][2] }}</span>
            </p>
        </div>
        @else
        <p>Unlock résumé to view contact details and links.</p>
        @endif
    </div>

    <!--Desktop nav-->
    <div  class="hidden @md:flex flex-row justify-between items-center border-t border-black py-2 px-8 w-full">
        <div class="flex flex-row items-center gap-x-4">
            <a href="#" class="link-nav" x-bind:aria-current="$store.app.currentPage === 'resume' ? 'page' : null" x-on:click.prevent="$store.app.currentPage = 'resume'; $dispatch('switchTo', {active: 'resume'})" aria-label="View Resume">
                Résumé
            </a>
            <span>|</span>
            <a href="#" class="link-nav" x-bind:aria-current="$store.app.currentPage === 'portfolio' ? 'page' : null" x-on:click.prevent="$store.app.currentPage = 'portfolio'; $dispatch('switchTo', {active: 'portfolio'})" aria-label="View Portfolio">
                Portfolio
            </a>
        </div>
        <a href="#" class="btn-cta" x-bind:aria-current="$store.app.currentPage === 'contact' ? 'page' : null" x-on:click.prevent="$store.app.currentPage = 'contact'; $dispatch('switchTo', {active: 'contact'})" aria-current="" aria-label="View Contact">
            Contact
        </a>
    </div>
</div>
