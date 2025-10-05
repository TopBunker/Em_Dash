<div class="p-4 pb-40 mx-auto max-w-3xl">
        <h1 class="text-brand-dark mb-2">CONNECT</h1>
        <p class="py-4" >Reach out with inquiries, invitations or feedback.</p>
        <form wire:submit="send" class="mt-8 space-y-5">
            @csrf
            <!--Name-->
            <div>
                <label class="text-sm text-brand font-medium mb-2 block" for="sender_name">Name/Company</label>
                <input id="sender_name" type="text" wire:model="name" placeholder="Enter Name"
                class="w-full py-2.5 px-4 text-slate-800 bg-gray-100 border border-gray-200 focus:border-slate-900 text-sm outline-0 transition-all" />
                <div>@error('name') <span class="error">{{ $message }}</span> @enderror</div>
            </div>
            <!--Email-->
            <div>
                <label class="text-sm text-brand font-medium mb-2 block" for="sender_email">Email</label>
                <input id="sender_email" type="email" wire:model="email" placeholder="Enter Email"
                class="w-full py-2.5 px-4 text-slate-800 bg-gray-100 border border-gray-200 focus:border-slate-900 text-sm outline-0 transition-all" />
                <div>@error('email') <span class="error">{{ $message }}</span> @enderror</div>
            </div>
            <!--Subject-->
            <div>
                <label class="text-sm text-brand font-medium mb-2 block" for="subject">Subject</label>
                <input id="subject" type="text" wire:model="subject" placeholder="Enter Subject"
                class="w-full py-2.5 px-4 text-slate-800 bg-gray-100 border border-gray-200 focus:border-slate-900 text-sm outline-0 transition-all" />
                <div>@error('subject') <span class="error">{{ $message }}</span> @enderror</div>
            </div>
            <!--Message-->
            <div>
                <label class="text-sm text-brand font-medium mb-2 block" for="message">Message</label>
                <textarea id="message" wire:model="message" placeholder="Enter Message" rows="6"
                class="w-full px-4 text-slate-800 bg-gray-100 border border-gray-200 focus:border-slate-900 text-sm pt-3 outline-0 transition-all"></textarea>
                <div>@error('message') <span class="error">{{ $message }}</span> @enderror</div>
            </div>
            <!--File Input-->
            <div
                x-data="{ uploading: false, progress: 0 }"
                x-on:livewire-upload-start="uploading = true"
                x-on:livewire-upload-finish="uploading = false"
                x-on:livewire-upload-cancel="uploading = false"
                x-on:livewire-upload-error="uploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress"
                >
                <input wire:model="uploads" class="text-sm text-brand 
                    file:mr-5 file:py-1 file:px-3 file:rounded-full
                    file:border-1 file:border-brand-dark file:text-xs file:font-medium 
                    file:bg-stone-50 file:text-brand-dark
                    hover:file:cursor-pointer hover:file:bg-brand-dark hover:file:text-white" 
                    aria-describedby="file_input_help" id="file_input" type="file" multiple/>
                <p class="mt-1 text-sm text-brand-light" id="file_input_help">PDF, DOC, DOCX</p>
                <div>@error('uploads.*') <span class="error">{{ $message }}</span> @enderror</div>
                <!--Upload Progress Bar-->
                <div x-show="uploading">
                    <progress max="100" x-bind:value="progress"></progress>
                </div>
            </div>
            <!--Submit button-->
            <button type="submit"class="btn-cta">Send message</button>
        </form>
        @session('success')
            <div class="alert alert-success" role="alert">
                {{ $value }}
            </div>
        @endsession
        @session('error')
            <div class="alert alert-error" role="alert">
                {{ $value }}
            </div>
        @endsession
</div>