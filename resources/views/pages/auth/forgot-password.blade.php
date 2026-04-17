<x-layouts.auth pageTitle="Forgot Password">
    <div class="animate-fade-in-up">
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-6" style="background: rgba(99,102,241,0.1);">
            <svg class="w-7 h-7" style="color: var(--color-brand-500);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" /></svg>
        </div>
        <h2 class="text-2xl sm:text-3xl font-bold mb-2 text-center" style="color: var(--text-primary);">Forgot password?</h2>
        <p class="text-sm mb-8 text-center" style="color: var(--text-secondary);">No worries. Enter your email address and we'll send you a reset link.</p>

        <form class="space-y-5">
            <x-form-input label="Email address" name="reset_email" type="email" placeholder="Enter your email address" required class="mb-0" />
            <button type="button" class="btn btn-primary w-full py-3 text-base font-semibold" onclick="this.innerHTML='<svg class=\'w-5 h-5 animate-spin\' fill=\'none\' viewBox=\'0 0 24 24\'><circle class=\'opacity-25\' cx=\'12\' cy=\'12\' r=\'10\' stroke=\'currentColor\' stroke-width=\'4\'></circle><path class=\'opacity-75\' fill=\'currentColor\' d=\'M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z\'></path></svg> Sending...'; setTimeout(() => this.innerHTML='Reset link sent!', 1500)">Send Reset Link</button>
        </form>

        <p class="mt-8 text-center text-sm">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-1 font-medium" style="color: var(--text-secondary);">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
                Back to sign in
            </a>
        </p>
    </div>
</x-layouts.auth>
