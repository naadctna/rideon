import React from 'react';
import { createRoot } from 'react-dom/client';

export default function ConfirmModal({ isOpen, onClose, onConfirm, title, message, confirmText = 'OK', cancelText = 'Cancel', confirmStyle = 'blue' }) {
    if (!isOpen) return null;

    const iconColors = {
        blue: { bg: 'bg-blue-50', text: 'text-blue-600' },
        red: { bg: 'bg-red-50', text: 'text-red-600' },
        green: { bg: 'bg-green-50', text: 'text-green-600' }
    };

    const confirmColors = {
        blue: 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500',
        red: 'bg-red-600 hover:bg-red-700 focus:ring-red-500',
        green: 'bg-green-600 hover:bg-green-700 focus:ring-green-500'
    };

    const icons = {
        blue: (
            <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        ),
        red: (
            <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        ),
        green: (
            <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        )
    };

    return (
        <div className="fixed inset-0 z-[9999] overflow-y-auto" style={{ fontFamily: 'system-ui, -apple-system, sans-serif' }}>
            <div className="flex items-center justify-center min-h-screen p-4">
                {/* Backdrop */}
                <div 
                    className="fixed inset-0 bg-black/40 backdrop-blur-sm transition-opacity" 
                    onClick={cancelText ? onClose : undefined}
                />

                {/* Modal */}
                <div className="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all">
                    {/* Content */}
                    <div className="p-6">
                        <div className="flex items-start gap-4">
                            {/* Icon */}
                            <div className={`flex-shrink-0 w-12 h-12 rounded-full ${iconColors[confirmStyle].bg} flex items-center justify-center ${iconColors[confirmStyle].text}`}>
                                {icons[confirmStyle]}
                            </div>

                            {/* Text */}
                            <div className="flex-1 pt-1">
                                {title && (
                                    <h3 className="text-lg font-semibold text-gray-900 mb-2">
                                        {title}
                                    </h3>
                                )}
                                <p className="text-sm text-gray-600 leading-relaxed">
                                    {message}
                                </p>
                            </div>
                        </div>
                    </div>

                    {/* Buttons */}
                    <div className="bg-gray-50 px-6 py-4 flex gap-3 justify-end">
                        {cancelText && (
                            <button
                                type="button"
                                className="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 transition-all"
                                onClick={onClose}
                            >
                                {cancelText}
                            </button>
                        )}
                        <button
                            type="button"
                            className={`px-5 py-2.5 text-sm font-medium text-white rounded-lg ${confirmColors[confirmStyle]} focus:outline-none focus:ring-4 transition-all`}
                            onClick={onConfirm}
                        >
                            {confirmText}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
}

// Helper function to show confirmation modal
export function showConfirmModal({ title, message, confirmText = 'OK', cancelText = null, confirmStyle = 'blue' }) {
    return new Promise((resolve) => {
        const container = document.createElement('div');
        document.body.appendChild(container);
        const root = createRoot(container);

        const handleConfirm = () => {
            root.unmount();
            document.body.removeChild(container);
            resolve(true);
        };

        const handleClose = () => {
            root.unmount();
            document.body.removeChild(container);
            resolve(false);
        };

        root.render(
            <ConfirmModal
                isOpen={true}
                onClose={handleClose}
                onConfirm={handleConfirm}
                title={title}
                message={message}
                confirmText={confirmText}
                cancelText={cancelText}
                confirmStyle={confirmStyle}
            />
        );
    });
}
