@if ($authorized)
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
                        <div class="alert alert-error" role="alert">
                                {{ $value }}
                        </div>
                @endsession
        </div>
        <div id="right-col" class="md:max-xl:basis-3xl xl:basis-2/5">
        <!---Section Nav-->
        <template x-teleport="#sectionNav">
                <nav x-data="{section: 'background'}" class="sub-nav">
                        <a href="#background" x-bind:aria-current="section === 'background' ? 'true' : null" x-on:click="section='background'; $store.page.scrollTo('background')" class="shrink-0 section-nav">Background</a>
                        <a href="#experience" x-bind:aria-current="section === 'experience' ? 'true' : null" x-on:click="section='experience'; $store.page.scrollTo('experience')" class="shrink-0 section-nav">Experience</a>
                        <a href="#skills" x-bind:aria-current="section === 'skills' ? 'true' : null" x-on:click="section='skills'; $store.page.scrollTo('skills')" class="shrink-0 section-nav">Skills</a>
                        @if (count($references) > 0)
                        <a href="#references" x-bind:aria-current="section === 'references' ? 'true' : null" x-on:click="section='references'; $store.page.scrollTo('references')" class="shrink-0 section-nav">References </a>
                        @endif
                        <a href="#" wire:click.prevent="download" class="shrink-0 section-nav">Download</a> 
                </nav>
        </template>
        </div>
</div>
@script
<script>   
        const settings = {resume: ()=>{
                                const sections = document.querySelectorAll('section[data-section]');
                                sections.forEach(s => Alpine.store('page').observer.observe(s));
                                Alpine.store('page').fallbackScrollSpy(sections);
                                }
                        }
        Alpine.store('page').pageSettings.push(settings['resume']);
        Alpine.store('page').runSettings();     
</script>
@endscript
@endif