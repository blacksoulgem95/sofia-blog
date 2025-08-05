<!-- Toast Container -->
<div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

<style>
    .toast {
        background: #10b981;
        color: white;
        padding: 12px 16px;
        border-radius: 8px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transform: translateX(100%);
        transition: transform 0.3s ease-in-out;
        max-width: 300px;
        word-wrap: break-word;
    }

    .toast.show {
        transform: translateX(0);
    }

    .toast.error {
        background: #ef4444;
    }

    .toast.warning {
        background: #f59e0b;
    }

    .toast.info {
        background: #3b82f6;
    }

    /* Mobile responsiveness */
    @media (max-width: 640px) {
        #toast-container {
            top: 1rem;
            right: 1rem;
            left: 1rem;
        }

        .toast {
            max-width: none;
        }
    }
</style>

<script>
    // Generic Toast System
    function showToast(message, type = 'success', duration = 3000) {
        const toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            console.error('Toast container not found');
            return;
        }

        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.textContent = message;

        toastContainer.appendChild(toast);

        // Trigger animation
        setTimeout(() => {
            toast.classList.add('show');
        }, 10);

        // Remove toast
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                if (toastContainer.contains(toast)) {
                    toastContainer.removeChild(toast);
                }
            }, 300);
        }, duration);
    }

    // Toast utility functions for common use cases
    window.toast = {
        success: (message, duration = 3000) => showToast(message, 'success', duration),
        error: (message, duration = 4000) => showToast(message, 'error', duration),
        warning: (message, duration = 3500) => showToast(message, 'warning', duration),
        info: (message, duration = 3000) => showToast(message, 'info', duration)
    };

    // Make showToast globally available
    window.showToast = showToast;
</script>
