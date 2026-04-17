<x-layouts.app :sidebarMenu="$sidebarMenu" :currentRoute="$currentRoute" :currentRole="$currentRole" :roleInfo="$roleInfo" :currentUser="$currentUser" :notifications="$notifications"
    pageTitle="Help & Support" pageDescription="Find answers, browse documentation, and contact our support team.">

    @php $breadcrumbs = [['label' => 'Help & Support']]; @endphp

    {{-- Quick Help Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        @php
            $helpCards = [
                ['icon' => 'document-chart-bar', 'title' => 'Documentation', 'description' => 'Browse guides and API references', 'color' => '#6366f1'],
                ['icon' => 'question-mark-circle', 'title' => 'Submit Ticket', 'description' => 'Create a support request', 'color' => '#10b981'],
                ['icon' => 'users', 'title' => 'Community', 'description' => 'Join discussions and share ideas', 'color' => '#d946ef'],
            ];
        @endphp
        @foreach($helpCards as $card)
            <div class="card card-interactive p-6 text-center cursor-pointer" onclick="showToast('info', '{{ $card['title'] }}', 'This would navigate to {{ strtolower($card['title']) }}')">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3" style="background: {{ $card['color'] }}15; color: {{ $card['color'] }};">
                    <x-icon :name="$card['icon']" class="w-6 h-6" />
                </div>
                <h3 class="font-semibold mb-1" style="color: var(--text-primary);">{{ $card['title'] }}</h3>
                <p class="text-sm" style="color: var(--text-secondary);">{{ $card['description'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- FAQ --}}
        <div class="lg:col-span-2">
            <x-card>
                <x-slot:header>
                    <h3 class="font-semibold" style="color: var(--text-primary);">Frequently Asked Questions</h3>
                </x-slot:header>
                <x-accordion :items="$faqs" />
            </x-card>
        </div>

        {{-- Contact Form --}}
        <div>
            <x-card>
                <x-slot:header>
                    <h3 class="font-semibold" style="color: var(--text-primary);">Contact Support</h3>
                </x-slot:header>
                <x-form-input label="Subject" name="subject" placeholder="Brief description of your issue" />
                <x-form-select label="Category" name="category" :options="['general' => 'General Question', 'bug' => 'Bug Report', 'feature' => 'Feature Request', 'account' => 'Account Issue', 'billing' => 'Billing']" />
                <x-form-select label="Priority" name="priority" :options="['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'urgent' => 'Urgent']" selected="medium" />
                <x-form-input label="Message" name="message" type="textarea" placeholder="Describe your issue in detail..." />
                <x-slot:footer>
                    <x-button variant="primary" class="w-full" onclick="showToast('success', 'Ticket Created', 'Your support request has been submitted. We will respond within 24 hours.')">Submit Ticket</x-button>
                </x-slot:footer>
            </x-card>
        </div>
    </div>

</x-layouts.app>
