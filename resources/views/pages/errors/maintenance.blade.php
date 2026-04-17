<x-layouts.error pageTitle="Maintenance Mode">
    <div class="text-center px-6 animate-fade-in-up">
        <div class="w-24 h-24 rounded-2xl flex items-center justify-center mx-auto mb-8 animate-bounce-soft" style="background: rgba(99,102,241,0.15); backdrop-filter: blur(20px);">
            <svg class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.65-5.65a8 8 0 1111.4-1.06l-.22.22a8 8 0 01-1.06 11.4l-5.65-5.65M11.42 15.17L17.5 21M11.42 15.17L5.35 21M11.42 15.17l6.08-6.08" />
            </svg>
        </div>

        <h1 class="text-3xl sm:text-5xl font-bold text-white mb-4">Under Maintenance</h1>
        <p class="text-lg text-indigo-200 mb-2 max-w-lg mx-auto">We're performing scheduled maintenance to improve your experience.</p>
        <p class="text-indigo-300 mb-10">Expected to be back online by <strong class="text-white">March 30, 2024 at 04:00 UTC</strong></p>

        {{-- Progress --}}
        <div class="max-w-md mx-auto mb-10">
            <div class="flex justify-between text-sm text-indigo-200 mb-2">
                <span>Progress</span>
                <span>72%</span>
            </div>
            <div class="w-full h-2 rounded-full" style="background: rgba(255,255,255,0.1);">
                <div class="h-full rounded-full animate-pulse-soft" style="width: 72%; background: linear-gradient(90deg, #6366f1, #d946ef);"></div>
            </div>
        </div>

        {{-- Status Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-w-2xl mx-auto mb-10">
            @php
                $checks = [
                    ['label' => 'Database Migration', 'status' => 'complete'],
                    ['label' => 'Server Upgrade', 'status' => 'progress'],
                    ['label' => 'Cache Clear', 'status' => 'pending'],
                ];
            @endphp
            @foreach($checks as $check)
                <div class="rounded-xl p-4" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.08);">
                    <div class="flex items-center gap-2 justify-center mb-2">
                        @if($check['status'] === 'complete')
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                        @elseif($check['status'] === 'progress')
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-pulse-soft"></span>
                        @else
                            <span class="w-2.5 h-2.5 rounded-full bg-white/30"></span>
                        @endif
                        <span class="text-xs font-medium uppercase tracking-wide {{ $check['status'] === 'complete' ? 'text-emerald-300' : ($check['status'] === 'progress' ? 'text-amber-300' : 'text-white/50') }}">{{ $check['status'] }}</span>
                    </div>
                    <p class="text-sm text-white/80">{{ $check['label'] }}</p>
                </div>
            @endforeach
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('dashboard') }}" class="btn btn-primary py-3 px-8 text-base" style="text-decoration: none;">
                Try Again
            </a>
            <a href="{{ route('help') }}" class="btn py-3 px-8 text-base text-white/80 border border-white/20 hover:bg-white/10" style="text-decoration: none;">
                Contact Support
            </a>
        </div>
    </div>
</x-layouts.error>
