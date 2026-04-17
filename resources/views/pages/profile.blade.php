<x-layouts.app :sidebarMenu="$sidebarMenu" :currentRoute="$currentRoute" :currentRole="$currentRole" :roleInfo="$roleInfo" :currentUser="$currentUser" :notifications="$notifications"
    pageTitle="My Profile" pageDescription="Manage your personal information and account settings.">

    @php $breadcrumbs = [['label' => 'Profile']]; @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Profile Card --}}
        <div>
            <x-card class="text-center">
                <div class="flex flex-col items-center">
                    <x-avatar :initials="$currentUser['initials']" size="xl" status="active" />
                    <h3 class="mt-4 text-xl font-bold" style="color: var(--text-primary);">{{ $profileData['name'] }}</h3>
                    <p class="text-sm" style="color: var(--text-secondary);">{{ $profileData['position'] }}</p>
                    <x-badge variant="primary" class="mt-2">{{ $roleInfo['label'] }}</x-badge>

                    <div class="w-full mt-6 pt-6 space-y-3" style="border-top: 1px solid var(--border-secondary);">
                        <div class="flex items-center gap-3 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" style="color: var(--text-tertiary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
                            <span style="color: var(--text-secondary);">{{ $profileData['email'] }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" style="color: var(--text-tertiary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>
                            <span style="color: var(--text-secondary);">{{ $profileData['phone'] }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" style="color: var(--text-tertiary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                            <span style="color: var(--text-secondary);">{{ $profileData['location'] }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <svg class="w-4 h-4 flex-shrink-0" style="color: var(--text-tertiary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                            <span style="color: var(--text-secondary);">Joined {{ $profileData['joinDate'] }}</span>
                        </div>
                    </div>

                    <div class="w-full mt-4 pt-4" style="border-top: 1px solid var(--border-secondary);">
                        <p class="text-xs font-semibold uppercase tracking-wide mb-2" style="color: var(--text-tertiary);">Skills</p>
                        <div class="flex flex-wrap gap-1.5 justify-center">
                            @foreach($profileData['skills'] as $skill)
                                <x-badge variant="primary">{{ $skill }}</x-badge>
                            @endforeach
                        </div>
                    </div>
                </div>
            </x-card>
        </div>

        {{-- Profile Edit --}}
        <div class="lg:col-span-2 space-y-6">
            <x-card>
                <x-slot:header><h3 class="font-semibold" style="color: var(--text-primary);">Personal Information</h3></x-slot:header>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4">
                    <x-form-input label="First Name" name="first_name" value="Andhika" />
                    <x-form-input label="Last Name" name="last_name" value="Pratama" />
                    <x-form-input label="Email" name="email" type="email" value="{{ $profileData['email'] }}" />
                    <x-form-input label="Phone" name="phone" value="{{ $profileData['phone'] }}" />
                    <x-form-select label="Department" name="dept" :options="['technology' => 'Technology', 'engineering' => 'Engineering', 'product' => 'Product']" selected="technology" />
                    <x-form-input label="Location" name="location" value="{{ $profileData['location'] }}" />
                </div>
                <x-form-input label="Bio" name="bio" type="textarea" :value="$profileData['bio']" />
                <x-slot:footer>
                    <x-button variant="primary" onclick="showToast('success', 'Profile Updated', 'Your personal information has been saved.')">Save Changes</x-button>
                </x-slot:footer>
            </x-card>

            <x-card>
                <x-slot:header><h3 class="font-semibold" style="color: var(--text-primary);">Change Password</h3></x-slot:header>
                <div class="max-w-md">
                    <x-form-input label="Current Password" name="current_password" type="password" placeholder="Enter current password" />
                    <x-form-input label="New Password" name="new_password" type="password" placeholder="Enter new password" />
                    <x-form-input label="Confirm New Password" name="confirm_password" type="password" placeholder="Confirm new password" />
                </div>
                <x-slot:footer>
                    <x-button variant="primary" onclick="showToast('success', 'Password Changed', 'Your password has been updated successfully.')">Update Password</x-button>
                </x-slot:footer>
            </x-card>
        </div>
    </div>

</x-layouts.app>
