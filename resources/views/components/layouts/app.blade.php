<!DOCTYPE html>
<html lang="en" class="{{ request()->cookie('theme', '') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Enterprise Admin Dashboard — Role-based UI Management System">
    <title>{{ $pageTitle ?? 'Dashboard' }} — TeloPanel</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased" style="background-color: var(--surface-secondary); color: var(--text-primary);">

    {{-- Sidebar --}}
    <x-sidebar :menu="$sidebarMenu" :currentRoute="$currentRoute" :currentRole="$currentRole" :roleInfo="$roleInfo" />

    {{-- Mobile Overlay --}}
    <div id="sidebar-overlay" class="drawer-overlay lg:hidden" onclick="toggleMobileSidebar()"></div>

    {{-- Main Content --}}
    <div class="main-content" id="main-content">
        {{-- Topbar --}}
        <x-topbar :currentUser="$currentUser" :notifications="$notifications" :roleInfo="$roleInfo" :currentRole="$currentRole" />

        {{-- Page Content --}}
        <main class="p-4 sm:p-6 lg:p-8">
            {{-- Breadcrumb --}}
            @if(isset($breadcrumbs))
                <x-breadcrumb :items="$breadcrumbs" />
            @endif

            {{-- Page Header --}}
            @if(isset($pageTitle))
                <div class="mb-6 sm:mb-8">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold" style="color: var(--text-primary);">{{ $pageTitle }}</h1>
                            @if(isset($pageDescription))
                                <p class="mt-1 text-sm" style="color: var(--text-secondary);">{{ $pageDescription }}</p>
                            @endif
                        </div>
                        @if(isset($pageActions))
                            <div class="flex items-center gap-3">
                                {!! $pageActions !!}
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Main Content Slot --}}
            {{ $slot }}
        </main>
    </div>

    {{-- Toast Container --}}
    <div id="toast-container" class="toast-container"></div>

    {{-- Role Switcher (Demo) --}}
    <x-role-switcher :currentRole="$currentRole" />

    {{-- Confirm Dialog --}}
    <x-confirm-dialog />

</body>
</html>
