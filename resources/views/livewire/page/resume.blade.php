<div x-data id="resume" class="relative flex flex-col">
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

        <nav id="resumeNav" x-data="{section: 'background'}" class="@md:fixed @md:bottom-5 @md:right-12 @md:top-52 md:w-auto bg-white/30 backdrop-blur-md max-md:border-t border-accent flex md:flex-col overflow-x-auto no-scrollbar space-x-6 md:space-x-0 md:space-y-4 px-4 max-md:py-2 py-12">
                <a href="#background" x-bind:aria-current="section === 'background' ? 'true' : null" x-on:click="section='background'; $store.page.scrollTo('background')" class="shrink-0 section-nav">Background</a>
                <a href="#experience" x-bind:aria-current="section === 'experience' ? 'true' : null" x-on:click="section='experience'; $store.page.scrollTo('experience')" class="shrink-0 section-nav">Experience</a>
                <a href="#skills" x-bind:aria-current="section === 'skills' ? 'true' : null" x-on:click="section='skills'; $store.page.scrollTo('skills')" class="shrink-0 section-nav">Skills</a>
                @if (count($references) > 0)
                <a href="#references" x-bind:aria-current="section === 'references' ? 'true' : null" x-on:click="section='references'; $store.page.scrollTo('references')" class="shrink-0 section-nav">References </a>
                @endif
        </nav>
</div>
<script>       
        const settings = {resume: ()=>{
                        // setup nav menu 
                        if(Alpine.store('app').currentPage === 'resume'){
                                const root = document.querySelector('footer');
                                const stage = document.createElement('div');
                                stage.id = "innerNav";
                                const nav = document.querySelector('#resumeNav');
                                stage.append(nav);
                                const current = document.querySelector('footer #innerNav');
                                if(current){
                                        current.replaceWith(stage);
                                }else{
                                        root.prepend(stage);
                                }
                        }
                        // setup scrollspy
                        const sections = document.querySelectorAll('section[data-section]');
                        sections.forEach(s => Alpine.store('page').observer.observe(s));
                        Alpine.store('page').fallbackScrollSpy(sections);
                        }
                }
</script>
