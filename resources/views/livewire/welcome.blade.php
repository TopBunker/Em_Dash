<div x-data="{view: 'classic', showContact: true}" class="relative h-dvh grid grid-rows-[auto_1fr_auto] bg-transparent" x-init>
    <!--Header-->
    <header class="bg-white/30 backdrop-blur-md shadow-md border-b border-accent-dark">
        <livewire:layouts.header :$userId />
    </header>

    <!--Main Content-->
    <main class="overflow-y-auto pt-7 pb-32 px-6" tabindex="0"
        @pointerdown="if($el.scrollTop === 0) {startY = $event.clientY; dragging = true;}"
        @pointermove="if (!dragging) return; const dy = $event.clientY-startY; if (dy < 0) {showContact = false;} else if (dy > 10) {showContact = true}"
        @pointerup.window="dragging=false"
        x-data="{startY: 0, dragging: false}"
        x-ref="scrollableMain"
        x-transition>

        <!-- Show loading spinner first time a component is loaded -->
        @if (!in_array($activeComponent, $loadedComponents))
            <div class="flex flex-col justify-center text-center py-5">
                <div role="status">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="animate-spin" viewBox="0 0 16 16">
                    <path d="M7.996 0A8 8 0 0 0 0 8a8 8 0 0 0 6.93 7.93v-1.613a1.06 1.06 0 0 0-.717-1.008A5.6 5.6 0 0 1 2.4 7.865 5.58 5.58 0 0 1 8.054 2.4a5.6 5.6 0 0 1 5.535 5.81l-.002.046-.012.192-.005.061a5 5 0 0 1-.033.284l-.01.068c-.685 4.516-6.564 7.054-6.596 7.068A7.998 7.998 0 0 0 15.992 8 8 8 0 0 0 7.996.001Z"/>
                    </svg>
                   Loading...
                </div>
            </div>
        @else
            <!-- Dynamically load view Livewire child component-->
            <livewire:dynamic-component :is="$activeComponent" :key="$activeComponent" :$userId />
        @endif

    </main>

    <!--Footer-->
    <footer class="relative bg-transparent backdrop-blur-md">
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
