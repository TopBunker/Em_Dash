<div class="@container/main relative flex flex-col @md:flex-row">
    @section('header')
        <livewire:layouts.header :$userId />
    @endsection
   <div class="basis-64"></div>
   <main class="relative flex flex-col basis-2/3 ">
    <div class="@md:basis-64"></div>
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
            <livewire:dynamic-component :is="$activeComponent" :key="$activeComponent" :$userId/>
        @endif
    <div class="@md:basis-64"></div>
   </main>
   <div class="basis-64"></div>

   @script
   <script>
        //Wire
        document.addEventListener('livewire:init', () => {
            // wire: Page Load/Reload

            // wire: On main 
            Livewire.hook('component:init', (c) => {
                const active = c.component.name.split('.').pop();
                // Save active tab in localStorage  
                localStorage.setItem('active', active);
            });
        });

        //DOM 

        // Page Switch from Alpine
        document.addEventListener('switchTo', (event) => {
            const innerNav = document.querySelector('footer #innerNav');
            console.log(innerNav);
            if(innerNav){
                innerNav.remove();
            }
        });

        // Page reload
        document.addEventListener('reload', () => {
            // Restore last selected tab from localStorage on reload
            let lastTab = localStorage.getItem('active');
            if (lastTab && lastTab !== active) {
                $wire.setComponent(lastTab);
            }
        });

        // Scroll

        // close header
        const main = document.querySelector('main');
        const app = document.querySelector('#profile');
        let dragging = false;
        let startY = 0;
        let prev = 0;
        
        document.addEventListener('pointerdown', (event) => {
            if((main.offsetHeight <= window.innerHeight) || ((main.offsetHeight > window.innerHeight) && main.scrollTop === 0)){
                dragging=true;
                startY=event.clientY;
            }
        });
        document.addEventListener('pointermove', (event) => {
            if(!dragging){return}
            let dy = event.clientY - startY;
            if(dy < 0){$wire.dispatch('close')}
            if(dy > 10){$wire.dispatch('open')}
        },{passive: true});
        window.addEventListener('pointerup', () => {dragging=false});

        /**to do: page experiation behavior and request hooks */
   </script>
    @endscript
</div>
