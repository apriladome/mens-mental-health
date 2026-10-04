<div 
    x-data="{
        quickEscape() {
            try {
                // Clear client-side local and session state
                localStorage.removeItem('mmh_guest_token');
                sessionStorage.clear();
            } catch (e) {
                // Ignore storage access errors
            }
            
            // Overwrite browser history state so the Back button cannot return here
            window.history.replaceState(null, '', 'https://www.weather.com');
            window.location.replace('https://www.weather.com');
        }
    }"
    @keydown.window.escape="quickEscape()"
>
    <button 
        @click="quickEscape()" 
        type="button"
        class="inline-flex items-center gap-1.5 rounded border border-tactical-danger/40 bg-tactical-danger/10 px-3 py-1.5 text-xs font-mono font-semibold text-tactical-danger transition hover:bg-tactical-danger hover:text-white focus:ring-2 focus:ring-tactical-danger"
        title="Instantly exit to neutral website and wipe trace [ESC]"
        aria-label="Quick Exit"
    >
        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        <span>QUICK ESCAPE <span class="hidden sm:inline">[ESC]</span></span>
    </button>
</div>