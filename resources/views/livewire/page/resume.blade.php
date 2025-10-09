<div x-data id="resume" class="relative flex flex-col md:flex-row">
        <div id="left-col" class="max-md:hidden md:basis-2/6"></div>
        <div class="relative basis-auto flex flex-col justify-between gap-y-24 pb-40 px-4 pt-8"> 
                <!-- Background Section-->
                <section data-section="background" class="">
                        <x-resume.background :params="$background" />
                </section>

                <!-- Experience Section -->
                <section data-section="experience">
                        <x-resume.experience :params="$experience" />
                </section>
                <!-- Skills Section -->
                <section data-section="skills">
                        <x-resume.skills :params="$skills" />
                </section>

                @if (count($references) > 0)
                <!-- References Section -->
                <section data-section="references">
                <x-resume.references :params="$references" />
                </section> 
                @else
                <p>References available on request.</p>
                @endif

                @session('error')
                <div 
                        x-data="{ open: true }" 
                        x-show="open" 
                        x-init="document.body.style.overflow = 'hidden';" 
                        x-on:click.away="open = false; document.body.style.overflow = ''" 
                        x-on:close.window="open = false; document.body.style.overflow = ''"
                        x-transition.opacity
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
                        style="backdrop-filter: blur(2px);">

                        <div class="bg-white rounded-lg shadow-lg p-6 relative max-w-md w-full">
                                <button 
                                        type="button" 
                                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700"
                                        x-on:click="open = false; document.body.style.overflow = ''"
                                        aria-label="Close">
                                        &times;
                                </button>
                                <div class="alert alert-error" role="alert">
                                        {{ $value }}
                                </div>
                        </div>
                </div>
                @endsession
        </div>
        <div id="right-col" class="md:max-xl:basis-3xl xl:basis-2/5">
        <!---Section Nav-->
        <template x-teleport="#sectionNav">
                <nav x-data="scrollSpy(document.querySelectorAll('#resume section[data-section]'), 'background', 'resume')" class="sub-nav">
                        <a href="#background" x-bind:aria-current="current === 'background' ? 'true' : null" x-on:click="section='background'; $store.page.scrollTo(document.querySelector('section[data-section=background]'))" class="shrink-0 section-nav">Background</a>
                        <a href="#experience" x-bind:aria-current="current === 'experience' ? 'true' : null" x-on:click="section='experience'; $store.page.scrollTo(document.querySelector('section[data-section=experience]'))" class="shrink-0 section-nav">Experience</a>
                        <a href="#skills" x-bind:aria-current="current === 'skills' ? 'true' : null" x-on:click="section='skills'; $store.page.scrollTo(document.querySelector('section[data-section=skills]'))" class="shrink-0 section-nav">Skills</a>
                        @if (count($references) > 0)
                        <a href="#references" x-bind:aria-current="current === 'references' ? 'true' : null" x-on:click="section='references'; $store.page.scrollTo(document.querySelector('section[data-section=references]'))" class="shrink-0 section-nav">References </a>
                        @endif
                        @if (session('resume_download'))
                        <livewire:page.components.resume-download />
                        @endif
                </nav>
        </template>
        </div>
</div>