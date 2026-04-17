<x-layouts.error pageTitle="404 - Page Not Found">
    <div class="text-center px-6 animate-fade-in-up">
        <div class="relative inline-block mb-8">
            <span class="text-[160px] sm:text-[200px] font-black leading-none tracking-tighter text-gradient opacity-20">404</span>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-24 h-24 rounded-full flex items-center justify-center" style="background: rgba(99,102,241,0.15); backdrop-filter: blur(20px);">
                    <svg class="w-12 h-12 text-white opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
            </div>
        </div>

        <h1 class="text-3xl sm:text-4xl font-bold text-white mb-4">Page Not Found</h1>
        <p class="text-lg text-indigo-200 mb-8 max-w-md mx-auto">The page you're looking for doesn't exist or has been moved to another location.</p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('dashboard') }}" class="btn btn-primary py-3 px-8 text-base" style="text-decoration: none;">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" /></svg>
                Go to Dashboard
            </a>
            <a href="javascript:history.back()" class="btn py-3 px-8 text-base text-white border border-white/20 hover:bg-white/10" style="text-decoration: none;">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
                Go Back
            </a>
        </div>
    </div>
</x-layouts.error>
