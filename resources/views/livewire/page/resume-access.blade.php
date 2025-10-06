<div x-data>
        <div class="max-w-md mx-auto mt-12 p-6 bg-white shadow-lg rounded">
            <p>Enter password to view résumé. Other pages are open.</p>
            <form wire:submit.prevent="checkPassword" class="space-y-8 mt-8">
                @csrf
                <input type="text" name="username" value="visitor" autocomplete="off" class="hidden">
                <input type="password" name="password" wire:model.defer="password" placeholder="Password" class="w-full px-3 py-2 border rounded" autocomplete="current-password">
                @session('error')
                    <div class="alert alert-error" role="alert">
                        {{ $value }}
                    </div>
                @endsession
                <button type="submit" class="btn-cta">Unlock</button>
            </form>
        </div>
</div>