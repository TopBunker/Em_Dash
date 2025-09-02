<div x-data class="relative flex flex-col @md:flex-row px-2" >
        <div class="basis-64"></div>
        <div class="relative overflow-y-auto" tabindex="0"
                @pointerdown="if($el.scrollTop === 0) {startY = $event.clientY; dragging = true;}"
                @pointermove="if (!dragging) return; const dy = $event.clientY-startY; if (dy < 0) {showContact = false;} else if (dy > 10) {showContact = true}"
                @pointerup.window="dragging=false"
                x-data="{startY: 0, dragging: false}"
                x-ref="scrollableMain"
                x-transition>
                <!-- Background Section-->
                <section id="background" data-section="background">
                        <x-resume.background :params="$background" />
                </section>
                <!-- Experience Section -->
                <section id="experience" data-section="experience">
                        <x-resume.experience :params="$experience" />
                </section>
                <!-- Skills Section -->
                <section id="skills" data-section="skills">
                        <x-resume.skills :params="$skills" />
                </section>

                @if (count($references)>0)
                <!-- References Section -->
                <section id="references" data-section="references">
                <x-resume.references :params="$references" />
                </section> 
                @endif

                @if (count($portfolio)>0)
                <!-- Portfolio Section -->
                <section id="portfolio" data-section="portfolio" class="hidden">
                <x-resume.portfolio :params="$portfolio" />
                </section>
                @endif
        </div>
        <div class="basis-64"></div>
</div>