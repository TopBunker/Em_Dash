<div id="app" x-data class="@container/main h-dvh grid grid-rows-[auto_1fr_auto]">
    <!--Header-->
    <header class="relative bg-white/50 backdrop-blur-md shadow-md border-b border-black">
        <livewire:layouts.header :$userId />
    </header>
    <!--Main-->
    <main class="relative overflow-y-auto max-md:p-4">
            <!-- Show loading spinner first time a component is loaded -->
            @if (!in_array($activeComponent, $loadedComponents))
            <div class="fixed z-50 h-dvh w-dvw text-center">
                <div role="status">
                    <span class="inset-0"> 
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="animate-spin w-3 h-3 inline-block" viewBox="0 0 16 16">
                        <path d="M7.996 0A8 8 0 0 0 0 8a8 8 0 0 0 6.93 7.93v-1.613a1.06 1.06 0 0 0-.717-1.008A5.6 5.6 0 0 1 2.4 7.865 5.58 5.58 0 0 1 8.054 2.4a5.6 5.6 0 0 1 5.535 5.81l-.002.046-.012.192-.005.061a5 5 0 0 1-.033.284l-.01.068c-.685 4.516-6.564 7.054-6.596 7.068A7.998 7.998 0 0 0 15.992 8 8 8 0 0 0 7.996.001Z"/>
                    </svg> Loading...</span>
                </div>
            </div>
            @else
            <!-- Dynamically load view Livewire child component-->
            <livewire:dynamic-component :is="$activeComponent" :$userId :key="$activeComponent.'-'.$userId"/>
            @endif
    </main>
    <!--Footer-->
    <footer class="fixed z-20 bottom-0 left-0 right-0">
        <div id="sectionNav"></div>
        <livewire:layouts.footer />
    </footer>
</div>

@script
<script>
    let lastPage = sessionStorage.getItem('active');
    let active = $wire.activeComponent.split('.').pop();
    if(lastPage && (lastPage !== active)){
        $wire.setComponent(lastPage);
        active = lastPage;
    }else if(!lastPage){
        sessionStorage.setItem('active', active);
    }

    Alpine.store('app').currentPage = active;   

    Livewire.hook('morphed',() => {
        document.querySelector('main').scrollTop = 0;
        if ((Alpine.store('app').currentPage !== 'portfolio')) {
            document.dispatchEvent(new Event('portfolio:off'));
        }else{
            document.dispatchEvent(new Event('portfolio:ready'));
        }
    });
</script>
@endscript