import React from 'react';
import { createRoot } from 'react-dom/client';
import { showConfirmModal } from './components/ConfirmModal';

// Initialize the user management functionality
window.toggleBlockUser = async function(userId) {
    const confirmed = await showConfirmModal({
        title: 'Konfirmasi',
        message: 'Apakah Anda yakin ingin mengubah status user ini?',
        confirmText: 'OK',
        cancelText: 'Cancel',
        confirmStyle: 'blue'
    });

    if (!confirmed) {
        return;
    }

    fetch(`/admin/users/${userId}/toggle-block`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success modal
            showConfirmModal({
                title: 'Berhasil',
                message: data.message,
                confirmText: 'OK',
                confirmStyle: 'green'
            }).then(() => {
                // Update status badge
                const badge = document.getElementById(`status-badge-${userId}`);
                if (data.is_blocked) {
                    badge.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800';
                    badge.textContent = 'Diblokir';
                } else {
                    badge.className = 'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800';
                    badge.textContent = 'Aktif';
                }
                
                // Update button
                const button = document.getElementById(`block-btn-${userId}`);
                if (data.is_blocked) {
                    button.className = 'text-green-600 hover:text-green-900';
                    button.textContent = 'Aktifkan';
                } else {
                    button.className = 'text-red-600 hover:text-red-900';
                    button.textContent = 'Blokir';
                }
            });
        } else {
            showConfirmModal({
                title: 'Error',
                message: 'Terjadi kesalahan: ' + data.message,
                confirmText: 'OK',
                confirmStyle: 'red'
            });
        }
    })
    .catch(error => {
        showConfirmModal({
            title: 'Error',
            message: 'Terjadi kesalahan: ' + error.message,
            confirmText: 'OK',
            confirmStyle: 'red'
        });
    });
};
