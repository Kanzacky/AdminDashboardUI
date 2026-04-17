<div class="modal-overlay" id="confirm-dialog" onclick="if(event.target===this) closeModal('confirm-dialog')">
    <div class="modal-container modal-sm">
        <div class="p-6 text-center">
            <div class="w-14 h-14 rounded-full flex items-center justify-center mx-auto mb-4" style="background: rgba(239, 68, 68, 0.1);">
                <svg class="w-7 h-7" style="color: var(--color-danger-500);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold mb-2" style="color: var(--text-primary);" id="confirm-title">Are you sure?</h3>
            <p class="text-sm mb-6" style="color: var(--text-secondary);" id="confirm-message">This action cannot be undone.</p>
            <div class="flex items-center justify-center gap-3">
                <button class="btn btn-secondary" onclick="closeModal('confirm-dialog')">Cancel</button>
                <button class="btn btn-danger" id="confirm-action-btn" onclick="closeModal('confirm-dialog')">Confirm</button>
            </div>
        </div>
    </div>
</div>
