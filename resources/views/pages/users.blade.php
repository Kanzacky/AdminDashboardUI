<x-layouts.app :sidebarMenu="$sidebarMenu" :currentRoute="$currentRoute" :currentRole="$currentRole" :roleInfo="$roleInfo" :currentUser="$currentUser" :notifications="$notifications"
    pageTitle="Users" pageDescription="Manage user accounts, roles, and access permissions.">

    @php $breadcrumbs = [['label' => 'Management', 'url' => '#'], ['label' => 'Users']]; @endphp

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
        @php
            $statCards = [
                ['label' => 'Total Users', 'value' => $userStats['total'], 'icon' => 'users', 'color' => 'var(--color-brand-500)'],
                ['label' => 'Active', 'value' => $userStats['active'], 'icon' => 'user', 'color' => 'var(--color-success-500)'],
                ['label' => 'Inactive', 'value' => $userStats['inactive'], 'icon' => 'clock', 'color' => 'var(--color-warning-500)'],
                ['label' => 'Suspended', 'value' => $userStats['suspended'], 'icon' => 'shield', 'color' => 'var(--color-danger-500)'],
            ];
        @endphp
        @foreach($statCards as $stat)
            <div class="card p-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0" style="background: {{ $stat['color'] }}15; color: {{ $stat['color'] }};">
                    <x-icon :name="$stat['icon']" class="w-5 h-5" />
                </div>
                <div>
                    <p class="text-2xl font-bold" style="color: var(--text-primary);">{{ $stat['value'] }}</p>
                    <p class="text-xs" style="color: var(--text-secondary);">{{ $stat['label'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Filters & Actions --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
        <x-search-filter placeholder="Search users by name or email..." :filters="[
            ['label' => 'All Roles', 'options' => ['admin' => 'Admin', 'manager' => 'Manager', 'staff' => 'Staff', 'viewer' => 'Viewer']],
            ['label' => 'All Status', 'options' => ['active' => 'Active', 'inactive' => 'Inactive', 'suspended' => 'Suspended']],
        ]" />
        @if(in_array($currentRole, ['superadmin', 'admin']))
            <div class="flex items-center gap-2 flex-shrink-0">
                <x-button variant="secondary" size="sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                    Export
                </x-button>
                <x-button variant="primary" size="sm" onclick="openModal('create-user-modal')">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Add User
                </x-button>
            </div>
        @endif
    </div>

    {{-- Users Table --}}
    <x-card padding="p-0">
        <div class="table-responsive border-0" style="border: none;">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="w-8"><input type="checkbox" class="rounded" style="accent-color: var(--color-brand-500);"></th>
                        <th>User</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Last Active</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td><input type="checkbox" class="rounded" style="accent-color: var(--color-brand-500);"></td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <x-avatar :initials="$user['initials']" size="sm" :status="$user['status']" />
                                    <div>
                                        <p class="font-medium text-sm" style="color: var(--text-primary);">{{ $user['name'] }}</p>
                                        <p class="text-xs" style="color: var(--text-tertiary);">{{ $user['email'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $roleBadge = ['Admin' => 'primary', 'Manager' => 'accent', 'Staff' => 'success', 'Viewer' => 'neutral', 'Super Admin' => 'danger'];
                                @endphp
                                <x-badge :variant="$roleBadge[$user['role']] ?? 'neutral'">{{ $user['role'] }}</x-badge>
                            </td>
                            <td class="text-sm" style="color: var(--text-secondary);">{{ $user['department'] }}</td>
                            <td>
                                @php $statusBadge = ['active' => 'success', 'inactive' => 'warning', 'suspended' => 'danger']; @endphp
                                <x-badge :variant="$statusBadge[$user['status']] ?? 'neutral'" :dot="true">{{ ucfirst($user['status']) }}</x-badge>
                            </td>
                            <td class="text-sm" style="color: var(--text-tertiary);">{{ $user['lastActive'] }}</td>
                            <td class="text-right">
                                <div class="relative inline-flex" id="user-action-{{ $user['id'] }}-container">
                                    <button class="btn btn-ghost btn-icon btn-sm" onclick="toggleDropdown('user-action-{{ $user['id'] }}')">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" /></svg>
                                    </button>
                                    <div class="dropdown-menu" id="user-action-{{ $user['id'] }}">
                                        <a class="dropdown-item" onclick="openModal('detail-user-modal'); closeDropdown('user-action-{{ $user['id'] }}')">
                                            <svg class="w-4 h-4" style="color: var(--text-tertiary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                            View Details
                                        </a>
                                        @if(in_array($currentRole, ['superadmin', 'admin']))
                                            <a class="dropdown-item" onclick="openModal('edit-user-modal'); closeDropdown('user-action-{{ $user['id'] }}')">
                                                <svg class="w-4 h-4" style="color: var(--text-tertiary);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                                Edit User
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-red-500" onclick="closeDropdown('user-action-{{ $user['id'] }}'); openConfirmDialog('Delete User', 'Are you sure you want to delete this user? This action cannot be undone.')">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                                Delete User
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t" style="border-color: var(--border-primary);">
            <x-pagination :currentPage="1" :totalPages="25" />
        </div>
    </x-card>

    {{-- Detail User Modal --}}
    <x-modal id="detail-user-modal" title="User Details" size="lg">
        <div class="flex flex-col sm:flex-row gap-6">
            <div class="flex flex-col items-center sm:items-start sm:w-48 flex-shrink-0">
                <x-avatar initials="SW" size="xl" status="active" />
                <h3 class="mt-3 font-semibold text-lg" style="color: var(--text-primary);">Sarah Wilson</h3>
                <p class="text-sm" style="color: var(--text-secondary);">sarah.wilson@company.com</p>
                <x-badge variant="success" class="mt-2" :dot="true">Active</x-badge>
            </div>
            <div class="flex-1 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div><p class="text-xs font-medium uppercase tracking-wide mb-1" style="color: var(--text-tertiary);">Role</p><p class="text-sm font-medium" style="color: var(--text-primary);">Admin</p></div>
                    <div><p class="text-xs font-medium uppercase tracking-wide mb-1" style="color: var(--text-tertiary);">Department</p><p class="text-sm font-medium" style="color: var(--text-primary);">Engineering</p></div>
                    <div><p class="text-xs font-medium uppercase tracking-wide mb-1" style="color: var(--text-tertiary);">Join Date</p><p class="text-sm font-medium" style="color: var(--text-primary);">Jan 15, 2023</p></div>
                    <div><p class="text-xs font-medium uppercase tracking-wide mb-1" style="color: var(--text-tertiary);">Last Active</p><p class="text-sm font-medium" style="color: var(--text-primary);">2 min ago</p></div>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide mb-2" style="color: var(--text-tertiary);">Permissions</p>
                    <div class="flex flex-wrap gap-1.5">
                        @foreach(['users.view', 'users.create', 'users.edit', 'content.view', 'reports.view'] as $perm)
                            <span class="badge badge-neutral text-[11px]">{{ $perm }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </x-modal>

    {{-- Edit User Modal --}}
    <x-modal id="edit-user-modal" title="Edit User" size="md">
        <form class="space-y-0">
            <x-form-input label="Full Name" name="name" value="Sarah Wilson" required />
            <x-form-input label="Email Address" name="email" type="email" value="sarah.wilson@company.com" required />
            <x-form-select label="Role" name="role" :options="['admin' => 'Admin', 'manager' => 'Manager', 'staff' => 'Staff', 'viewer' => 'Viewer']" selected="admin" required />
            <x-form-select label="Department" name="department" :options="['engineering' => 'Engineering', 'product' => 'Product', 'marketing' => 'Marketing', 'finance' => 'Finance', 'hr' => 'HR']" selected="engineering" />
            <x-form-select label="Status" name="status" :options="['active' => 'Active', 'inactive' => 'Inactive', 'suspended' => 'Suspended']" selected="active" />
        </form>
        <x-slot:footer>
            <x-button variant="secondary" onclick="closeModal('edit-user-modal')">Cancel</x-button>
            <x-button variant="primary" onclick="closeModal('edit-user-modal'); showToast('success', 'User Updated', 'User details have been saved successfully.')">Save Changes</x-button>
        </x-slot:footer>
    </x-modal>

    {{-- Create User Modal --}}
    <x-modal id="create-user-modal" title="Create New User" size="md">
        <form class="space-y-0">
            <x-form-input label="Full Name" name="new_name" placeholder="Enter full name" required />
            <x-form-input label="Email Address" name="new_email" type="email" placeholder="Enter email address" required />
            <x-form-input label="Password" name="new_password" type="password" placeholder="Minimum 8 characters" required />
            <x-form-select label="Role" name="new_role" :options="['admin' => 'Admin', 'manager' => 'Manager', 'staff' => 'Staff', 'viewer' => 'Viewer']" required />
            <x-form-select label="Department" name="new_department" :options="['engineering' => 'Engineering', 'product' => 'Product', 'marketing' => 'Marketing', 'finance' => 'Finance', 'hr' => 'HR', 'design' => 'Design', 'operations' => 'Operations']" />
        </form>
        <x-slot:footer>
            <x-button variant="secondary" onclick="closeModal('create-user-modal')">Cancel</x-button>
            <x-button variant="primary" onclick="closeModal('create-user-modal'); showToast('success', 'User Created', 'New user account has been created successfully.')">Create User</x-button>
        </x-slot:footer>
    </x-modal>

</x-layouts.app>
