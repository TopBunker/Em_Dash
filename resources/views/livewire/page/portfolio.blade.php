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
            <p class="my-4"><a href="{{ asset('storage/'.$portfolio['file_location']) }}" rel="noopener noreferrer" target="_blank" class="link-nav underline">Open Portfolio</a></p>
            <p class="my-4"><a href="#" wire:click.prevent="download('{{ $portfolio['file_location'] }}')" class="link-nav underline">Download Portfolio</a></p>
            @session('error')
            <div class="alert alert-error" role="alert">
                    {{ $value }}
            </div>
            @endsession
            @endif
            @if ( $portfolio['link'] !== null )
            <p class="my-4"><a href="{{ $portfolio['link'] }}" rel="noopener noreferrer" target="_blank" class="link-nav underline">Click to view portfolio.</a></p>
            @endif
        </div>
        @if ( !empty($portfolio['projects']) )
        <div class="flex flex-col justify-between gap-y-10 mt-10">
        @foreach ($portfolio['projects'] as $project)
        <div class="flex flex-col justify-between basis-auto">
            <h2>{{ $project['title'] }}</h2>
            <p>{{ $project['details'] ? $project['details'] : '' }}</p>
            @if ($project['link'])
            <iframe
                src="{{ $project['link'] }}"
                class="aspect-auto overflow-hidden"
                width="100%"
                height="500"
                sandbox>
                <p class="my-4">
                    <a href="{{ $project['link'] }}" rel="noopener noreferrer" target="_blank" class="link-nav underline">Fallback link for browsers that cannot display iframe.</a>
                </p>
            </iframe>
            @endif
            @if ( !empty($project['project_media']) )
            @foreach ( $project['project_media'] as $media )
            @if ( str_contains($media['type'],'image') )
            <img src="{{ asset('storage/'.$media['location']) }}" alt="Project media." class="aspect-auto object-center w-100 self-center" />
            @endif
            @if ( str_contains($media['type'],'video') )
            <video controls ><source src="{{ asset('storage/'.$media['location']) }}" type="{{ $media['type'] }}"></video>
            @endif
            @if ( str_contains($media['type'],'link') )
            <p class="my-4"><a href="{{ $media['location'] }}" rel="noopener noreferrer" target="_blank" class="link-nav underline">Project Resources</a></p>
            @endif
            @endforeach
            @endif
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

  