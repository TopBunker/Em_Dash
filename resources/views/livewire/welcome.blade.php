<div x-data="{view: 'classic', showContact: true, current: 'background'}" class="@container/main relative inset-0 h-dvh bg-transparent">
    <!--Header-->
    <header class="fixed z-10 top-0 left-0 right-0 bg-white/30 backdrop-blur-md shadow-md border-b border-accent-dark">
        <livewire:layouts.header :$userId />
    </header>

    <!--Main Content-->
    <main class="relative">

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
            <livewire:dynamic-component :is="$activeComponent" :key="$activeComponent" :$userId />
        @endif

    </main>

    <!--Footer-->
    <footer class="fixed z-10 bottom-0 left-0 right-0">
            <nav class="flex-row justify-between @md:fixed @md:flex-col @md:top-60 right-40 space-x-5 px-2 overflow-x-auto md:overflow-y-auto bg-white/30 backdrop-blur-md">
                <a href="#" aria-current="" class="section-nav" >nav</a>                             
            </nav>
        <livewire:layouts.footer />
    </footer>

    <!-- 
        localStorage synchronization:
        - On page load, read last active tab and switch to it.
        - On component update, save current tab to localStorage.
    -->
    <script>
        document.addEventListener('livewire:init', event => {

            // Restore last selected tab from localStorage
            let lastTab = localStorage.getItem('active');
            if (lastTab && lastTab !== @this.get('activeComponent')) {
                @this.setComponent(lastTab);
            }

            // After Livewire updates, save active tab in localStorage
            Livewire.hook('message.processed', (message, component) => {
                if (component.fingerprint.name === 'welcome') {
                    localStorage.setItem('active', @this.get('activeComponent'));
                }
            });
        });
    </script>
</div>
