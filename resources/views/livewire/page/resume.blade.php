<div id="resume" class="relative flex flex-col">
        <!-- Background Section-->
        <section data-section="background">
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
        @endif

        <nav id="resumeNav" x-data="{section: 'background'}" class="@md:fixed @md:bottom-5 @md:right-12 @md:top-56 md:w-auto bg-white/30 backdrop-blur-md max-md:border-t border-accent flex md:flex-col overflow-x-auto no-scrollbar space-x-6 md:space-x-0 md:space-y-4 px-4 max-md:py-2 py-12">
                <a href="#background" x-bind:aria-current="section === 'background' ? 'true' : null" x-on:click="section='background'" class="shrink-0 section-nav">Background</a>
                <a href="#experience" x-bind:aria-current="section === 'experience' ? 'true' : null" x-on:click="section='experience'" class="shrink-0 section-nav">Experience</a>
                <a href="#skills" x-bind:aria-current="section === 'skills' ? 'true' : null" x-on:click="section='skills'" class="shrink-0 section-nav">Skills</a>
                @if (count($references) > 0)
                <a href="#references" x-bind:aria-current="section === 'references' ? 'true' : null" x-on:click="section='references'; scrollTo('')" class="shrink-0 section-nav">References </a>
                @endif
        </nav>
</div>

@script
<script>
        // WireDOM section scroll
        document.addEventListener('livewire:initialized', () => {
                $js('scrollTo', (section) => {
                        section.scrollIntoView({scroll: 'smooth', inline: 'center', block: 'nearest'});
                });
        });

        // Deliver page assets on load
        Livewire.hook('component.init',(component) => {
                const root = document.querySelector('footer');
                const filter = component.component.name.split('.').pop();
                const stage = document.createElement('div');
                stage.id = "innerNav";
                if(root && (filter === 'resume')){
                        const nav = document.querySelector('#resumeNav');
                        stage.append(nav);
                        const current = document.querySelector('footer #innerNav');
                        if(current){
                                current.replaceWith(stage);
                        }else{
                                root.prepend(stage);
                        }
                }
        });
</script>
@endscript