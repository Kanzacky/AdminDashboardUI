<x-layouts.auth pageTitle="Create Account">
    <div class="animate-fade-in-up">
        <h2 class="text-2xl sm:text-3xl font-bold mb-2" style="color: var(--text-primary);">Create an account</h2>
        <p class="text-sm mb-8" style="color: var(--text-secondary);">Fill in the details below to get started with TeloPanel.</p>

        <form class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <x-form-input label="First Name" name="reg_first" placeholder="John" required class="mb-0" />
                <x-form-input label="Last Name" name="reg_last" placeholder="Doe" required class="mb-0" />
            </div>
            <x-form-input label="Email address" name="reg_email" type="email" placeholder="name@company.com" required class="mb-0" />
            <x-form-input label="Password" name="reg_password" type="password" placeholder="Minimum 8 characters" hint="Must contain at least 8 characters with uppercase and number" required class="mb-0" />
            <x-form-input label="Confirm Password" name="reg_confirm" type="password" placeholder="Confirm your password" required class="mb-0" />

            <div class="flex items-start gap-2 mt-2">
                <input type="checkbox" class="rounded mt-1" style="accent-color: var(--color-brand-500);">
                <span class="text-sm" style="color: var(--text-secondary);">I agree to the <a href="#" class="font-medium" style="color: var(--color-brand-500);">Terms of Service</a> and <a href="#" class="font-medium" style="color: var(--color-brand-500);">Privacy Policy</a></span>
            </div>

            <a href="{{ route('dashboard') }}?role=superadmin" class="btn btn-primary w-full py-3 text-base font-semibold mt-4" style="text-decoration: none;">Create Account</a>
        </form>

        <p class="mt-8 text-center text-sm" style="color: var(--text-secondary);">
            Already have an account? <a href="{{ route('login') }}" class="font-medium" style="color: var(--color-brand-500);">Sign in</a>
        </p>
    </div>
</x-layouts.auth>
