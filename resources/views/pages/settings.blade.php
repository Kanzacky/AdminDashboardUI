<x-layouts.app :sidebarMenu="$sidebarMenu" :currentRoute="$currentRoute" :currentRole="$currentRole" :roleInfo="$roleInfo" :currentUser="$currentUser" :notifications="$notifications"
    pageTitle="Settings" pageDescription="Configure system preferences, security, and integrations.">

    @php $breadcrumbs = [['label' => 'System', 'url' => '#'], ['label' => 'Settings']]; @endphp

    <x-tabs :tabs="['general' => 'General', 'security' => 'Security', 'notifications_tab' => 'Notifications', 'appearance' => 'Appearance']" active="general" id="settings-tabs">

        {{-- General Tab --}}
        <div class="tab-panel" data-tab="general">
            <x-card>
                <x-slot:header>
                    <h3 class="font-semibold" style="color: var(--text-primary);">General Settings</h3>
                </x-slot:header>
                <div class="max-w-2xl space-y-0">
                    <x-form-input label="Application Name" name="app_name" value="TeloPanel" hint="The name displayed in the browser tab and sidebar" />
                    <x-form-input label="Support Email" name="support_email" type="email" value="support@telopanel.com" />
                    <x-form-select label="Timezone" name="timezone" :options="['utc' => 'UTC', 'asia-jakarta' => 'Asia/Jakarta (UTC+7)', 'us-eastern' => 'US/Eastern (UTC-5)', 'europe-london' => 'Europe/London (UTC+0)']" selected="asia-jakarta" />
                    <x-form-select label="Language" name="language" :options="['en' => 'English', 'id' => 'Bahasa Indonesia', 'ja' => 'Japanese', 'zh' => 'Chinese']" selected="en" />
                    <x-form-select label="Date Format" name="date_format" :options="['mdy' => 'MM/DD/YYYY', 'dmy' => 'DD/MM/YYYY', 'ymd' => 'YYYY-MM-DD']" selected="dmy" />
                </div>
                <x-slot:footer>
                    <x-button variant="primary" onclick="showToast('success', 'Saved', 'General settings updated successfully')">Save Changes</x-button>
                </x-slot:footer>
            </x-card>
        </div>

        {{-- Security Tab --}}
        <div class="tab-panel hidden" data-tab="security">
            <div class="space-y-6">
                <x-card>
                    <x-slot:header>
                        <h3 class="font-semibold" style="color: var(--text-primary);">Password Policy</h3>
                    </x-slot:header>
                    <div class="space-y-4 max-w-2xl">
                        <div class="flex items-center justify-between p-3 rounded-lg" style="background: var(--surface-secondary);">
                            <div><p class="text-sm font-medium" style="color: var(--text-primary);">Minimum password length</p><p class="text-xs" style="color: var(--text-tertiary);">Require at least 8 characters</p></div>
                            <x-toggle :active="true" />
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg" style="background: var(--surface-secondary);">
                            <div><p class="text-sm font-medium" style="color: var(--text-primary);">Require uppercase letters</p><p class="text-xs" style="color: var(--text-tertiary);">Must contain at least one uppercase letter</p></div>
                            <x-toggle :active="true" />
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg" style="background: var(--surface-secondary);">
                            <div><p class="text-sm font-medium" style="color: var(--text-primary);">Require special characters</p><p class="text-xs" style="color: var(--text-tertiary);">Must include symbols like @, #, $</p></div>
                            <x-toggle :active="false" />
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg" style="background: var(--surface-secondary);">
                            <div><p class="text-sm font-medium" style="color: var(--text-primary);">Two-factor authentication</p><p class="text-xs" style="color: var(--text-tertiary);">Require 2FA for all admin accounts</p></div>
                            <x-toggle :active="true" />
                        </div>
                    </div>
                </x-card>
                <x-card>
                    <x-slot:header>
                        <h3 class="font-semibold" style="color: var(--text-primary);">Session Management</h3>
                    </x-slot:header>
                    <div class="max-w-2xl">
                        <x-form-select label="Session Timeout" name="session_timeout" :options="['15' => '15 minutes', '30' => '30 minutes', '60' => '1 hour', '120' => '2 hours', '480' => '8 hours']" selected="60" hint="Users will be logged out after this period of inactivity" />
                    </div>
                    <x-slot:footer>
                        <x-button variant="primary" onclick="showToast('success', 'Saved', 'Security settings updated')">Save Changes</x-button>
                    </x-slot:footer>
                </x-card>
            </div>
        </div>

        {{-- Notifications Tab --}}
        <div class="tab-panel hidden" data-tab="notifications_tab">
            <x-card>
                <x-slot:header>
                    <h3 class="font-semibold" style="color: var(--text-primary);">Email Notifications</h3>
                </x-slot:header>
                <div class="space-y-4 max-w-2xl">
                    @foreach([
                        ['New user registration', 'Receive email when a new user signs up', true],
                        ['Security alerts', 'Get notified about suspicious login attempts', true],
                        ['System updates', 'Notifications about maintenance and updates', true],
                        ['Weekly digest', 'Summary of platform activity sent every Monday', false],
                        ['Report generation', 'Notify when scheduled reports are ready', true],
                        ['Role changes', 'Alert when user roles are modified', false],
                    ] as $setting)
                        <div class="flex items-center justify-between p-3 rounded-lg" style="background: var(--surface-secondary);">
                            <div><p class="text-sm font-medium" style="color: var(--text-primary);">{{ $setting[0] }}</p><p class="text-xs" style="color: var(--text-tertiary);">{{ $setting[1] }}</p></div>
                            <x-toggle :active="$setting[2]" />
                        </div>
                    @endforeach
                </div>
                <x-slot:footer>
                    <x-button variant="primary" onclick="showToast('success', 'Saved', 'Notification preferences updated')">Save Preferences</x-button>
                </x-slot:footer>
            </x-card>
        </div>

        {{-- Appearance Tab --}}
        <div class="tab-panel hidden" data-tab="appearance">
            <x-card>
                <x-slot:header>
                    <h3 class="font-semibold" style="color: var(--text-primary);">Theme & Appearance</h3>
                </x-slot:header>
                <div class="max-w-2xl">
                    <p class="text-sm font-medium mb-3" style="color: var(--text-primary);">Color Theme</p>
                    <div class="grid grid-cols-3 gap-3 mb-6">
                        <button class="p-4 rounded-xl border-2 text-center transition-all hover:shadow-md" style="border-color: var(--color-brand-500); background: var(--surface-secondary);">
                            <div class="w-8 h-8 rounded-full mx-auto mb-2" style="background: linear-gradient(135deg, #6366f1, #d946ef);"></div>
                            <span class="text-xs font-medium" style="color: var(--text-primary);">Indigo</span>
                        </button>
                        <button class="p-4 rounded-xl border-2 text-center transition-all hover:shadow-md" style="border-color: var(--border-primary); background: var(--surface-secondary);">
                            <div class="w-8 h-8 rounded-full mx-auto mb-2" style="background: linear-gradient(135deg, #059669, #10b981);"></div>
                            <span class="text-xs font-medium" style="color: var(--text-primary);">Emerald</span>
                        </button>
                        <button class="p-4 rounded-xl border-2 text-center transition-all hover:shadow-md" style="border-color: var(--border-primary); background: var(--surface-secondary);">
                            <div class="w-8 h-8 rounded-full mx-auto mb-2" style="background: linear-gradient(135deg, #2563eb, #3b82f6);"></div>
                            <span class="text-xs font-medium" style="color: var(--text-primary);">Blue</span>
                        </button>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-lg" style="background: var(--surface-secondary);">
                        <div><p class="text-sm font-medium" style="color: var(--text-primary);">Sidebar collapsed by default</p><p class="text-xs" style="color: var(--text-tertiary);">Start with a compact sidebar layout</p></div>
                        <x-toggle :active="false" />
                    </div>
                </div>
                <x-slot:footer>
                    <x-button variant="primary" onclick="showToast('success', 'Saved', 'Appearance settings updated')">Save Preferences</x-button>
                </x-slot:footer>
            </x-card>
        </div>

    </x-tabs>

</x-layouts.app>
