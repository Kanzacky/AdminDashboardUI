/**
 * TeloPanel Admin Dashboard
 * Core JavaScript — Handles all UI interactivity
 */

// ============================================================
// DARK MODE
// ============================================================

function initTheme() {
    const savedTheme = localStorage.getItem('telo-theme');
    if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark');
    }
}

function toggleTheme() {
    const html = document.documentElement;
    html.classList.toggle('dark');
    localStorage.setItem('telo-theme', html.classList.contains('dark') ? 'dark' : 'light');
}

// Initialize on load
initTheme();


// ============================================================
// SIDEBAR
// ============================================================

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    if (sidebar) {
        sidebar.classList.toggle('collapsed');
        localStorage.setItem('telo-sidebar', sidebar.classList.contains('collapsed') ? 'collapsed' : 'expanded');
    }
}

function toggleMobileSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    if (sidebar) {
        sidebar.classList.toggle('mobile-open');
        if (overlay) overlay.classList.toggle('active');
    }
}

function toggleSubmenu(element) {
    const parent = element.closest('.sidebar-menu-group');
    if (!parent) return;

    const submenu = parent.querySelector('.sidebar-submenu');
    const chevron = element.querySelector('.sidebar-chevron');

    if (submenu) submenu.classList.toggle('hidden');
    if (chevron) chevron.classList.toggle('rotate-90');
}

function toggleSidebarGroup(element) {
    const parent = element.closest('.sidebar-group-container');
    if (!parent) return;

    const itemsContainer = parent.querySelector('.sidebar-group-items');
    const chevron = element.querySelector('svg');

    if (itemsContainer) {
        itemsContainer.classList.toggle('hidden');
    }
    if (chevron) {
        chevron.classList.toggle('-rotate-90');
    }
}

// Restore sidebar state
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    if (sidebar && localStorage.getItem('telo-sidebar') === 'collapsed' && window.innerWidth >= 1024) {
        sidebar.classList.add('collapsed');
    }
});


// ============================================================
// DROPDOWN SYSTEM
// ============================================================

function toggleDropdown(id) {
    // Close all other dropdowns first
    document.querySelectorAll('.dropdown-menu.active').forEach(menu => {
        if (menu.id !== id) {
            menu.classList.remove('active');
        }
    });

    const dropdown = document.getElementById(id);
    if (dropdown) {
        dropdown.classList.toggle('active');
    }
}

function closeDropdown(id) {
    const dropdown = document.getElementById(id);
    if (dropdown) {
        dropdown.classList.remove('active');
    }
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('[id$="-container"]') && !e.target.closest('.dropdown-menu')) {
        document.querySelectorAll('.dropdown-menu.active').forEach(menu => {
            menu.classList.remove('active');
        });
    }
});


// ============================================================
// MODAL SYSTEM
// ============================================================

function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

// ESC key to close modals
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay.active').forEach(modal => {
            modal.classList.remove('active');
        });
        document.body.style.overflow = '';

        // Also close drawers
        document.querySelectorAll('.drawer-overlay.active').forEach(overlay => {
            overlay.classList.remove('active');
        });
        document.querySelectorAll('.drawer-panel.active').forEach(panel => {
            panel.classList.remove('active');
        });
    }
});


// ============================================================
// DRAWER SYSTEM
// ============================================================

function openDrawer(id) {
    const overlay = document.getElementById(id + '-overlay');
    const panel = document.getElementById(id);
    if (overlay) overlay.classList.add('active');
    if (panel) panel.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeDrawer(id) {
    const overlay = document.getElementById(id + '-overlay');
    const panel = document.getElementById(id);
    if (overlay) overlay.classList.remove('active');
    if (panel) panel.classList.remove('active');
    document.body.style.overflow = '';
}


// ============================================================
// TOAST NOTIFICATION SYSTEM
// ============================================================

function showToast(type, title, message, duration = 4000) {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const iconMap = {
        success: '<svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        error: '<svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
        warning: '<svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg>',
        info: '<svg class="w-5 h-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" /></svg>',
    };

    const toast = document.createElement('div');
    toast.className = 'toast';
    toast.innerHTML = `
        <div class="flex-shrink-0 mt-0.5">${iconMap[type] || iconMap.info}</div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-semibold" style="color: var(--text-primary);">${title}</p>
            <p class="text-xs mt-0.5" style="color: var(--text-secondary);">${message}</p>
        </div>
        <button class="flex-shrink-0 p-1 rounded-lg transition-colors hover:bg-[var(--surface-secondary)]" style="color: var(--text-tertiary);" onclick="dismissToast(this.closest('.toast'))">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
    `;

    container.appendChild(toast);

    // Auto dismiss
    setTimeout(() => dismissToast(toast), duration);
}

function dismissToast(toast) {
    if (!toast || toast.classList.contains('removing')) return;
    toast.classList.add('removing');
    setTimeout(() => toast.remove(), 300);
}


// ============================================================
// TAB SYSTEM
// ============================================================

function switchTab(containerId, tabKey) {
    const nav = document.getElementById(containerId + '-nav');
    const content = document.getElementById(containerId + '-content');
    if (!nav || !content) return;

    // Update tab buttons
    nav.querySelectorAll('.tab-btn').forEach(btn => {
        const isActive = btn.dataset.tab === tabKey;
        btn.className = btn.className.replace(/border-\[var\(--color-brand-500\)\]|text-\[var\(--color-brand-600\)\]|border-transparent|text-\[var\(--text-secondary\)\]|hover:text-\[var\(--text-primary\)\]|hover:border-\[var\(--border-primary\)\]/g, '');
        if (isActive) {
            btn.classList.add('border-[var(--color-brand-500)]', 'text-[var(--color-brand-600)]');
        } else {
            btn.classList.add('border-transparent', 'text-[var(--text-secondary)]', 'hover:text-[var(--text-primary)]', 'hover:border-[var(--border-primary)]');
        }
    });

    // Update tab panels
    content.querySelectorAll('.tab-panel').forEach(panel => {
        if (panel.dataset.tab === tabKey) {
            panel.classList.remove('hidden');
            panel.classList.add('animate-fade-in');
        } else {
            panel.classList.add('hidden');
            panel.classList.remove('animate-fade-in');
        }
    });
}


// ============================================================
// ACCORDION
// ============================================================

function toggleAccordion(button) {
    const item = button.closest('.accordion-item');
    if (!item) return;

    const content = item.querySelector('.accordion-content');
    const chevron = button.querySelector('.accordion-chevron');

    if (content) content.classList.toggle('hidden');
    if (chevron) chevron.classList.toggle('rotate-180');
}


// ============================================================
// CONFIRM DIALOG
// ============================================================

function openConfirmDialog(title, message, onConfirm) {
    const titleEl = document.getElementById('confirm-title');
    const messageEl = document.getElementById('confirm-message');
    const actionBtn = document.getElementById('confirm-action-btn');

    if (titleEl) titleEl.textContent = title || 'Are you sure?';
    if (messageEl) messageEl.textContent = message || 'This action cannot be undone.';

    if (actionBtn && onConfirm) {
        actionBtn.onclick = function() {
            onConfirm();
            closeModal('confirm-dialog');
        };
    }

    openModal('confirm-dialog');
}


// ============================================================
// SEARCH MODAL (Quick Search)
// ============================================================

function openSearchModal() {
    showToast('info', 'Quick Search', 'Global search modal would appear here. Press ⌘K or Ctrl+K to open.');
}

// Keyboard shortcut
document.addEventListener('keydown', function(e) {
    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
        e.preventDefault();
        openSearchModal();
    }
});


// ============================================================
// UTILITIES
// ============================================================

// Close mobile sidebar on resize
window.addEventListener('resize', function() {
    if (window.innerWidth >= 1024) {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        if (sidebar) sidebar.classList.remove('mobile-open');
        if (overlay) overlay.classList.remove('active');
    }
});

// Smooth page load
document.addEventListener('DOMContentLoaded', function() {
    document.body.classList.add('animate-fade-in');
});
