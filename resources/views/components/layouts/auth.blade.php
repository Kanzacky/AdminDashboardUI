<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="TeloPanel — Enterprise Admin Dashboard">
    <title>{{ $pageTitle ?? 'Authentication' }} — TeloPanel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased min-h-screen" style="background-color: var(--surface-secondary);">

    <div class="min-h-screen flex">
        {{-- Left Panel — Branding --}}
        <div class="hidden lg:flex lg:w-1/2 xl:w-[55%] relative overflow-hidden" style="background: linear-gradient(135deg, #1e1b4b 0%, #4338ca 50%, #6366f1 100%);">
            <div class="absolute inset-0 opacity-10">
                <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="0.5"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid)" />
                </svg>
            </div>

            <div class="relative z-10 flex flex-col justify-center px-12 xl:px-20 text-white">
                {{-- Logo --}}
                <div class="flex items-center gap-3 mb-12">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: rgba(255,255,255,0.2);">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight">TeloPanel</span>
                </div>

                <h1 class="text-4xl xl:text-5xl font-bold leading-tight mb-6">
                    Enterprise Grade<br>
                    <span class="text-indigo-200">Admin Dashboard</span>
                </h1>
                <p class="text-lg text-indigo-200 leading-relaxed max-w-md mb-8">
                    A powerful, role-based administration platform designed for modern teams. Manage users, permissions, analytics, and more — all in one place.
                </p>

                {{-- Stats --}}
                <div class="flex gap-8">
                    <div>
                        <div class="text-3xl font-bold">24K+</div>
                        <div class="text-sm text-indigo-200">Active Users</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">99.9%</div>
                        <div class="text-sm text-indigo-200">Uptime</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold">150+</div>
                        <div class="text-sm text-indigo-200">Companies</div>
                    </div>
                </div>
            </div>

            {{-- Decorative circles --}}
            <div class="absolute -bottom-32 -right-32 w-96 h-96 rounded-full" style="background: rgba(255,255,255,0.05);"></div>
            <div class="absolute -top-16 -right-16 w-64 h-64 rounded-full" style="background: rgba(255,255,255,0.03);"></div>
        </div>

        {{-- Right Panel — Form --}}
        <div class="w-full lg:w-1/2 xl:w-[45%] flex items-center justify-center p-6 sm:p-12">
            <div class="w-full max-w-md">
                {{-- Mobile Logo --}}
                <div class="lg:hidden flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: var(--color-brand-600);">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold" style="color: var(--text-primary);">TeloPanel</span>
                </div>

                {{ $slot }}
            </div>
        </div>
    </div>

</body>
</html>
