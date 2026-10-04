@props(['src' => null, 'title' => 'Operational Audio Briefing'])

<div 
    x-data="{
        isPlaying: false,
        playbackRate: 1.0,
        rates: [1.0, 1.25, 1.5],
        rateIndex: 0,
        progress: 0,
        currentTime: '0:00',
        duration: '0:00',
        audio: null,

        init() {
            this.audio = this.$refs.audioElement;
            this.audio.addEventListener('timeupdate', () => {
                if (this.audio.duration) {
                    this.progress = (this.audio.currentTime / this.audio.duration) * 100;
                    this.currentTime = this.formatTime(this.audio.currentTime);
                    this.duration = this.formatTime(this.audio.duration);
                }
            });
            this.audio.addEventListener('ended', () => {
                this.isPlaying = false;
                this.progress = 0;
            });
        },

        togglePlay() {
            if (this.audio.paused) {
                this.audio.play();
                this.isPlaying = true;
            } else {
                this.audio.pause();
                this.isPlaying = false;
            }
        },

        skip(seconds) {
            this.audio.currentTime = Math.min(Math.max(this.audio.currentTime + seconds, 0), this.audio.duration || 0);
        },

        cycleRate() {
            this.rateIndex = (this.rateIndex + 1) % this.rates.length;
            this.playbackRate = this.rates[this.rateIndex];
            this.audio.playbackRate = this.playbackRate;
        },

        formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
        }
    }"
    class="rounded-xl border border-surface-border bg-surface-base p-4 sm:p-5 shadow-lg my-6"
>
    <!-- Hidden HTML5 Audio Element -->
    <audio x-ref="audioElement" preload="metadata">
        <source src="{{ $src ?? 'https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3' }}" type="audio/mpeg">
    </audio>

    <!-- Top Label -->
    <div class="flex items-center justify-between text-xs font-mono text-content-muted mb-3">
        <div class="flex items-center gap-2">
            <span class="h-2 w-2 rounded-full bg-tactical-steel" :class="{ 'animate-pulse': isPlaying }"></span>
            <span class="text-content-primary font-bold">COMMUTE AUDIO BRIEFING</span>
        </div>
        <span x-text="`${currentTime} / ${duration}`"></span>
    </div>

    <!-- Progress Scrubber -->
    <div class="h-1.5 w-full bg-surface-card rounded-full overflow-hidden border border-surface-border mb-4">
        <div 
            class="h-full bg-tactical-steel transition-all duration-150"
            :style="`width: ${progress}%`"
        ></div>
    </div>

    <!-- Controls Row -->
    <div class="flex items-center justify-between">
        <!-- 15s Skip Backward -->
        <button 
            type="button" 
            @click="skip(-15)"
            class="p-2 text-content-secondary hover:text-content-primary font-mono text-xs transition"
            title="Rewind 15 seconds"
        >
            ↺ 15s
        </button>

        <!-- Main Play / Pause Button -->
        <button 
            type="button" 
            @click="togglePlay()"
            class="flex h-12 w-12 items-center justify-center rounded-full bg-content-primary text-surface-base hover:bg-white shadow-lg transition"
            title="Play or Pause"
        >
            <svg x-show="!isPlaying" class="h-5 w-5 fill-current ml-0.5" viewBox="0 0 24 24">
                <path d="M8 5v14l11-7z"/>
            </svg>
            <svg x-show="isPlaying" x-cloak class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/>
            </svg>
        </button>

        <!-- 15s Skip Forward -->
        <button 
            type="button" 
            @click="skip(15)"
            class="p-2 text-content-secondary hover:text-content-primary font-mono text-xs transition"
            title="Fast forward 15 seconds"
        >
            15s ↻
        </button>

        <!-- Variable Speed Toggle -->
        <button 
            type="button" 
            @click="cycleRate()"
            class="rounded border border-surface-border bg-surface-card px-2.5 py-1 text-xs font-mono text-tactical-steel hover:bg-surface-hover transition"
            title="Toggle playback speed"
        >
            <span x-text="`${playbackRate}x`"></span>
        </button>
    </div>
</div>