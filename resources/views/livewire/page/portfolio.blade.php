<div id="portfolio" x-data="{section: ''}" class="relative flex flex-col md:flex-row">
    <div id="left-col" class="max-md:hidden md:basis-[10dvw]">
    </div>
    <div class="relative basis-full flex pb-40 px-4 pt-8"> 
    @foreach ( $portfolios as $portfolio )
    <section x-show="section === '{{ $portfolio['title'] }}' ? true : false" data-section="{{ $portfolio['title'] }}" class="flex flex-col justify-between gap-y-4"
        x-transition:enter="transition ease-out duration-700"
        x-transition:enter-start="opacity-0 scale-0"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-0">
        <div class="flex flex-col justify-between">
            <h1>{{ $portfolio['title'] }}</h1>
            <hr class="mb-4">
            <p id="description">{{ $portfolio['description'] }}</p>
            @if ( $portfolio['file_location'] !== null )
            <p class="my-4"><a href="{{ asset('storage/'.$portfolio['file_location']) }}" rel="noopener noreferrer" target="_blank" class="link-nav underline" aria-label="Open portfolio document">Open Portfolio</a></p>
            <p class="my-4"><a href="#" wire:click.prevent="download('{{ $portfolio['file_location'] }}')" class="link-nav underline" aria-label="Download portfolio document">Download Portfolio</a></p>
            @session('error')
            <div class="alert alert-error" role="alert">
                    {{ $value }}
            </div>
            @endsession
            @endif
            @if ( $portfolio['link'] !== null )
            <p class="my-4"><a href="{{ $portfolio['link'] }}" rel="noopener noreferrer" target="_blank" class="link-nav underline" aria-label="Visit portfolio website">Visit Portfolio</a></p>
            @endif
        </div>
        @if ( !empty($portfolio['projects']) )
        <h2 id="projects" class="mt-10">Projects</h2>
        @php
            $projectTitles = array_map(fn($p) => $p['title'], $portfolio['projects']);
        @endphp
        <div x-data="{
                projects: JSON.parse($el.dataset.items),
                projectIndex: 0,
                startX: 0,
                endX: 0,
                get project() { return this.projects[this.projectIndex]; },
                next() { this.projectIndex = $store.page.cycleIndex(this.projectIndex, 1, this.projects.length); this.reposition();},
                prev() { this.projectIndex = $store.page.cycleIndex(this.projectIndex, -1, this.projects.length); this.reposition();},
                handleSwipe() {
                    if (this.startX - this.endX > 50) { this.next(); }
                    if (this.endX - this.startX > 50) { this.prev(); }
                },
                reposition() {
                    document.querySelector(`#projects`).scrollIntoView({ behavior: 'smooth', block: 'start' });
                    this.background();
                },
                background() {
                    if($el.classList.contains(`from-cyan-500`)) {
                        $el.classList.remove('from-cyan-500', 'to-indigo-500');
                        $el.classList.add('from-indigo-500', 'to-cyan-500');
                    } else {
                        $el.classList.remove('from-indigo-500', 'to-cyan-500');
                        $el.classList.add('from-cyan-500', 'to-indigo-500');
                    }
                }
            }" 
            data-items='@json($projectTitles)'
            class="flex flex-col justify-between bg-linear-45 from-cyan-500 to-indigo-500"
            x-on:touchstart="startX = $event.touches[0].clientX"
            x-on:touchend="endX = $event.changedTouches[0].clientX; handleSwipe()">
            
            @foreach ($portfolio['projects'] as $project)
            <div id="{{ $project['title'] }}" x-show="project === '{{ $project['title'] }}'"
                class="flex flex-col gap-4 rounded-lg shadow-lg bg-white/80 p-8 border border-gray-200 hover:shadow-2xl transition-shadow duration-300"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 scale-0"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-0">
                <h2 class="mb-2">{{ $project['title'] }}</h2>
                <p class="mb-4">{{ $project['details'] ? $project['details'] : '' }}</p>
                @if ($project['link'])
                <p class="my-4"><a href="{{ $project['link'] }}" rel="noopener noreferrer" target="_blank" class="link-nav underline" aria-label="Visit project website">View Project</a><p class="my-4">
                @endif
                @if (!empty($project['project_media']))
                <div class="relative flex flex-col justify-between gap-4 mt-2">
                    @php
                        $index = 0;
                        $pm = $project['project_media'] ?? [];
                        $media = array_map(function ($p) {

                             if (str_contains( $p['type'], 'image') || str_contains($p['type'], 'video')) {
                                return $p;
                            }
                        }, $pm);
                    @endphp
                    <div x-data="gallery({media: JSON.parse($el.dataset.items)})" data-items='@json($media)' class="relative">
                        <!-- Thumbnails -->
                        <div class="grid gri-cols-3 gap-2 sm:grid-cols-4 md:grid-cols-5">
                            <template x-for="(item, i) in media" :key="i">                                    
                                <template x-if="item?.type.includes('image')">
                                    <img :src="`storage/${item.thumb}`" :alt="`Dynamically loaded project image ${item.title ?? item.thumb}`"
                                    x-on:click="open(i)" class="cursor-pointer rounded-lg object-cover w-full aspect-square hover:opacity-80 transition"
                                    loading="lazy" tabindex="0" aria-label="Open gallery">
                                </template>
                                <template x-if="item?.type.includes('video')">
                                    <div class="relative cursor-pointer rounded-lg overflow-hidden" x-on:click="open(i)" tabindex="0" aria-label="Open gallery">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="absolute inset-0 flex items-center justify-center" viewBox="0 0 16 16" aria-hidden="true">
                                            <path d="M6 10.117V5.883a.5.5 0 0 1 .757-.429l3.528 2.117a.5.5 0 0 1 0 .858l-3.528 2.117a.5.5 0 0 1-.757-.43z"/>
                                            <path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1"/>
                                        </svg>
                                    </div>
                                </template>
                            </template>
                        </div>
                        <!-- Modals -->
                        <template x-if="activeIndex !== null" >
                            <div class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center"
                                x-on:click="close"
                                x-on:keyup.escape.window="close"
                                x-on:touchstart="startX = $event.touches[0].clientX"
                                x-on:touchend="endX = $event.changedTouches[0].clientX; handleSwipe()"
                                role="dialog"
                                aria-modal="true">
                                <!-- Close -->
                                <button x-on:click="close" class="absolute top-4 right-6 text-white text-3xl" aria-lable="Close">&times;</button>

                                <!-- Previous -->
                                <button x-on:click.stop="prev" class="absolute left-4 md:left-8 text-white text-3xl" aria-label="Previous media">&#10094;</button>

                                <!-- Media display -->
                                <div class="max-w-[90dvw] max-h-[85dvh]">
                                    <template x-if="media[activeIndex].type.includes('image')">
                                        <img :src="`storage/${media[activeIndex].location}`" :alt="`Dynamically loaded project image ${media[activeIndex].title ?? media[activeIndex].location}`" class="max-h-[85dvh] max-w-full rounded-lg shadow-lg" x-transition>
                                    </template>

                                    <template x-if="media[activeIndex].type.includes('video')">
                                        <iframe :src="media[activeIndex].location" frameborder="0" allow="autoplay; fullscreen" allowfullscreen class="w-[80dvh] h-[45dvw] rounded-lg"></iframe>
                                    </template>
                                </div>

                                <!-- Next -->
                                <button x-on:click.stop="next" class="absolute right-4 md:right-8 text-white text-3xl" aria-label="Next media">&#10095;</button>

                            </div>
                        </template>
                    </div>
                    @foreach ($project['project_media'] as $media)
                    @if (str_contains($media['type'],'link'))
                    <p class="my-2"><a href="{{ $media['location'] }}" rel="noopener noreferrer" target="_blank" class="link-nav underline" aria-label="Visit project resources">Project Resources</a></p>
                    @endif
                    @endforeach
                </div>
                @endif
                </template>
                <div id="project-navigation" class="mt-4 h-18 flex flex-row space-x-5 self-center">
                    <button x-on:click.prevent="prev()" aria-label="Previous project">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" >
                            <path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"/>
                        </svg>
                    </button>
                    <div class="flex flex-row space-x-5 overflow-x-auto self-center masked-scroll overflow-y-hidden"
                         scroll-snap-type="x mandatory"
                         scroll-behavior="smooth">
                        @foreach ($portfolio['projects'] as $i => $project)
                        <a href="#" 
                           x-bind:aria-current="projectIndex === {{ $i }} ? 'true' : null" 
                           x-on:click.prevent="projectIndex = {{ $i }}; reposition();" 
                           x-on:keyup.right="next()"
                           x-on:keyup.left="prev()"
                           class="p-4 text-brand-dark text-xl shadow-none section-nav"
                           scroll-snap-align="center"
                           aria-label="Show project"> {{ $i + 1 }} </a>
                        @endforeach
                    </div>
                    <button x-on:click.prevent="next()" aria-label="Next project">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                            <path d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z"/>
                        </svg>
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </section>
    @endforeach
    </div>
    <div id="right-col" class=""></div>
    <nav class="invisible flex flex-row md:flex-col section-nav">
        @foreach ($portfolios as $portfolio)
        <a href="#" x-bind:aria-current="section === '{{ $portfolio['title'] }}' ? 'true' : null" class="bubble-node p-4 text-brand-dark text-xl shadow-none"> {{ $portfolio['title'] }} </a>
        @endforeach
    </nav>
</div> 