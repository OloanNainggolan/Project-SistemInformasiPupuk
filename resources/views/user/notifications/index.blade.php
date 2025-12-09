@extends('layouts.user')

@section('title', 'Notifikasi Saya')

@section('content')
<div class="notifications-container">
    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
        <button type="button" class="alert-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
        <div class="header-title">
            <i class="fas fa-bell"></i>
            <h1>Notifikasi Saya</h1>
        </div>
        <div class="header-stats">
            <span class="stat-badge">
                <i class="fas fa-envelope"></i>
                Total Pesan: <strong>{{ $messages->total() }}</strong>
            </span>
            @if(isset($notifications))
            <span class="stat-badge">
                <i class="fas fa-bell"></i>
                Total Notifikasi: <strong>{{ $notifications->total() }}</strong>
            </span>
            @endif
            @if($unreadCount > 0 || (isset($unreadNotifications) && $unreadNotifications > 0))
            <span class="stat-badge unread">
                <i class="fas fa-envelope-open"></i>
                Belum Dibaca: <strong>{{ $unreadCount + ($unreadNotifications ?? 0) }}</strong>
            </span>
            <form action="{{ route('user.notifications.markAllRead') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-mark-read">
                    <i class="fas fa-check-double"></i>
                    Tandai Semua Dibaca
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- Notifications from Notifications Table + System Messages -->
    @if(isset($allNotifications) && $allNotifications->count() > 0)
    <div class="notifications-section">
        <h2 class="section-title">
            <i class="fas fa-bell"></i>
            Notifikasi Sistem
            <span class="badge-count">{{ $allNotifications->count() }}</span>
        </h2>
        <div class="notifications-grid">
            @foreach($allNotifications as $notification)
            <div class="notification-card {{ !$notification->is_read ? 'unread' : '' }}" data-notification-id="{{ $notification->id }}">
                <div class="notification-icon {{ $notification->type }}">
                    @if($notification->type == 'order')
                        <i class="fas fa-shopping-cart"></i>
                    @elseif($notification->type == 'info')
                        <i class="fas fa-info-circle"></i>
                    @elseif($notification->type == 'success')
                        <i class="fas fa-check-circle"></i>
                    @elseif($notification->type == 'warning')
                        <i class="fas fa-exclamation-triangle"></i>
                    @elseif($notification->type == 'important')
                        <i class="fas fa-exclamation-circle"></i>
                    @else
                        <i class="fas fa-bell"></i>
                    @endif
                </div>
                <div class="notification-content">
                    <div class="notification-header">
                        <h3 class="notification-title">{{ $notification->title }}</h3>
                        @if(!$notification->is_read)
                        <span class="badge-new">BARU</span>
                        @endif
                    </div>
                    <p class="notification-message">{{ $notification->message }}</p>
                    <div class="notification-footer">
                        <span class="notification-date">
                            <i class="fas fa-clock"></i>
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                        @if(!$notification->is_read)
                        <button class="btn-mark-read-small" onclick="markNotificationAsRead('{{ $notification->id }}', {{ isset($notification->is_message) && $notification->is_message ? 'true' : 'false' }})">
                            <i class="fas fa-check"></i>
                            Tandai Dibaca
                        </button>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Messages List -->
    <h2 class="section-title">
        <i class="fas fa-envelope"></i>
        Pesan & Percakapan
    </h2>
    @if($messages->count() > 0)
    <div class="messages-list">
        @foreach($messages as $message)
        @php
            // Check if there are unread replies from admin
            $hasUnreadReply = $message->replies->where('sender_type', 'admin')->where('status', 'unread')->count() > 0;
            $isUnread = ($message->sender_type === 'admin' && $message->status === 'unread') || $hasUnreadReply;
            
            // Get last activity (either original message or last reply)
            $lastActivity = $message->replies->count() > 0 ? $message->replies->last()->created_at : $message->created_at;
        @endphp
        <div class="message-card {{ $isUnread ? 'unread' : '' }}" data-message-id="{{ $message->id }}">
            <a href="{{ route('notifikasi.show', $message->id) }}" class="message-link">
                <div class="message-header">
                    <div class="sender-info">
                        @if(Auth::user()->photo_profile)
                            <img src="{{ asset('images/profiles/' . Auth::user()->photo_profile) }}" alt="{{ Auth::user()->name }}" class="sender-avatar-img user" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        @endif
                        <div class="sender-avatar user" style="{{ Auth::user()->photo_profile ? 'display:none;' : '' }}">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="sender-details">
                            <div class="sender-name">
                                Percakapan dengan Admin
                                @if($isUnread)
                                <span class="badge-new">BARU</span>
                                @endif
                            </div>
                            <div class="message-date">
                                <i class="fas fa-clock"></i>
                                Terakhir: {{ $lastActivity->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    @if($isUnread)
                    <div class="unread-dot"></div>
                    @endif
                </div>

                <div class="message-subject">
                    <i class="fas fa-envelope"></i>
                    {{ $message->subject }}
                </div>

                <div class="message-preview">
                    @if($message->replies->count() > 0)
                        @php
                            $lastReply = $message->replies->last();
                            $lastSender = $lastReply->sender_type === 'admin' ? 'Admin' : 'Anda';
                        @endphp
                        <span class="preview-sender {{ $lastReply->sender_type }}">{{ $lastSender }}:</span> 
                        {{ Str::limit($lastReply->message, 100) }}
                    @else
                        <span class="preview-sender user">Anda:</span>
                        {{ Str::limit($message->message, 120) }}
                    @endif
                </div>

                <div class="message-footer">
                    <span class="reply-count">
                        <i class="fas fa-comments"></i>
                        {{ $message->replies->count() + 1 }} Pesan
                    </span>
                    @if($message->replies->count() > 0)
                    <span class="message-type conversation">
                        <i class="fas fa-exchange-alt"></i>
                        Percakapan Aktif
                    </span>
                    @else
                    <span class="message-type user-msg">
                        <i class="fas fa-paper-plane"></i>
                        Menunggu Balasan
                    </span>
                    @endif
                </div>
            </a>
            
            <!-- Action Buttons -->
            <div class="message-actions" onclick="event.stopPropagation()">
                @if($isUnread)
                <button class="action-btn mark-read" onclick="markAsRead({{ $message->id }})" title="Tandai Dibaca">
                    <i class="fas fa-check"></i>
                </button>
                @endif
                <button class="action-btn delete" onclick="deleteMessage({{ $message->id }})" title="Hapus Thread">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="pagination-section">
        {{ $messages->links() }}
    </div>
    @else
    <!-- Empty State -->
    <div class="empty-state">
        <i class="fas fa-inbox"></i>
        <h3>Belum Ada Notifikasi</h3>
        <p>Anda belum memiliki notifikasi. Kirim pesan melalui halaman kontak untuk berkomunikasi dengan admin.</p>
        <a href="{{ route('kontak') }}" class="btn-contact">
            <i class="fas fa-paper-plane"></i>
            Hubungi Admin
        </a>
    </div>
    @endif
</div>

<style>
.notifications-container {
    max-width: 1000px;
    margin: 40px auto;
    padding: 0 20px;
}

/* Alert */
.alert {
    padding: 14px 18px;
    border-radius: 8px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.alert-success {
    background: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
}

.alert i:first-child { font-size: 18px; }
.alert span { flex: 1; font-size: 14px; font-weight: 500; }

.alert-close {
    background: none;
    border: none;
    color: inherit;
    cursor: pointer;
    padding: 5px;
    opacity: 0.7;
    transition: opacity 0.3s;
}

.alert-close:hover { opacity: 1; }

/* Page Header */
.page-header {
    background: white;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.header-title {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
}

.header-title i {
    font-size: 28px;
    color: #10b981;
}

.header-title h1 {
    font-size: 24px;
    font-weight: 700;
    color: #065f46;
    margin: 0;
}

.header-stats {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: center;
}

.stat-badge {
    padding: 8px 14px;
    background: #f3f4f6;
    border-radius: 8px;
    font-size: 13px;
    color: #6b7280;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.stat-badge i {
    color: #10b981;
}

.stat-badge.unread {
    background: #fef3c7;
    color: #92400e;
}

.stat-badge.unread i {
    color: #f59e0b;
}

.btn-mark-read {
    padding: 8px 16px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-mark-read:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

/* Messages List */
.messages-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.message-card {
    background: white;
    border-radius: 10px;
    border-left: 4px solid #e5e7eb;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
}

.message-card.unread {
    background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%);
    border-left-color: #10b981;
}

.message-card:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-left-color: #10b981;
}

.message-link {
    display: block;
    padding: 20px;
    text-decoration: none;
    color: inherit;
}

/* Message Header */
.message-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    padding-bottom: 10px;
    border-bottom: 1px solid #f3f4f6;
}

.sender-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.sender-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    flex-shrink: 0;
}

.sender-avatar-img {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
}

.sender-avatar-img.user {
    border: 2px solid #10b981;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
}

.sender-avatar.user {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.sender-avatar.admin {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
}

.sender-name {
    font-size: 14px;
    font-weight: 700;
    color: #065f46;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.badge-new {
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    color: white;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.5px;
}

.message-date {
    font-size: 12px;
    color: #9ca3af;
    display: flex;
    align-items: center;
    gap: 4px;
}

.message-date i {
    font-size: 11px;
    color: #10b981;
}

.unread-dot {
    width: 12px;
    height: 12px;
    background: #ef4444;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.7; transform: scale(1.1); }
}

/* Message Content */
.message-subject {
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.message-subject i {
    color: #10b981;
    font-size: 14px;
}

.message-preview {
    font-size: 14px;
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 12px;
}

.preview-sender {
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 4px;
    font-size: 13px;
}

.preview-sender.admin {
    color: #6366f1;
    background: #eef2ff;
}

.preview-sender.user {
    color: #10b981;
    background: #d1fae5;
}

/* Message Footer */
.message-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
}

.reply-count {
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 5px;
}

.reply-count i {
    color: #10b981;
}

.message-type {
    padding: 4px 10px;
    border-radius: 6px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.message-type.admin-msg {
    background: #dbeafe;
    color: #1e40af;
}

.message-type.user-msg {
    background: #d1fae5;
    color: #065f46;
}

.message-type.conversation {
    background: #dbeafe;
    color: #1e40af;
}

/* Pagination */
.pagination-section {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

/* Empty State */
.empty-state {
    background: white;
    border-radius: 12px;
    padding: 60px 40px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.empty-state i {
    font-size: 64px;
    color: #d1d5db;
    margin-bottom: 20px;
}

.empty-state h3 {
    font-size: 20px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 12px;
}

.empty-state p {
    font-size: 14px;
    color: #6b7280;
    margin-bottom: 24px;
    line-height: 1.6;
}

.btn-contact {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 3px 10px rgba(16, 185, 129, 0.3);
}

.btn-contact:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
}

/* Action Buttons */
.message-actions {
    position: absolute;
    top: 12px;
    right: 12px;
    display: flex;
    gap: 8px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.message-card:hover .message-actions {
    opacity: 1;
}

.action-btn {
    width: 36px;
    height: 36px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    font-size: 14px;
}

.action-btn.mark-read {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
}

.action-btn.mark-read:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

.action-btn.delete {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
}

.action-btn.delete:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
}

.action-btn:active {
    transform: scale(0.95);
}

/* Section Title */
.section-title {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 18px;
    font-weight: 700;
    color: #065f46;
    margin: 32px 0 16px 0;
    padding-bottom: 8px;
    border-bottom: 2px solid #10b981;
}

.section-title i {
    color: #10b981;
}

.section-title .badge-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 24px;
    height: 24px;
    padding: 0 8px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 700;
    margin-left: auto;
}

/* Notifications Section */
.notifications-section {
    margin-bottom: 40px;
}

.notifications-grid {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 20px;
}

.notification-card {
    background: white;
    border-radius: 10px;
    padding: 16px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    display: flex;
    gap: 16px;
    align-items: flex-start;
    transition: all 0.3s ease;
    border-left: 4px solid #e5e7eb;
}

.notification-card.unread {
    background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%);
    border-left-color: #10b981;
}

.notification-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.notification-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
    flex-shrink: 0;
}

.notification-icon.order {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.notification-icon.info {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
}

.notification-icon.success {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
}

.notification-icon.warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.notification-icon.important {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

.notification-content {
    flex: 1;
}

.notification-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 8px;
    gap: 12px;
}

.notification-title {
    font-size: 16px;
    font-weight: 700;
    color: #065f46;
    margin: 0;
}

.notification-message {
    font-size: 14px;
    color: #4b5563;
    line-height: 1.6;
    margin: 0 0 12px 0;
    white-space: pre-wrap;
}

.notification-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
}

.notification-date {
    font-size: 12px;
    color: #9ca3af;
    display: flex;
    align-items: center;
    gap: 4px;
}

.btn-mark-read-small {
    padding: 6px 12px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}

.btn-mark-read-small:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

/* Animation for deleted cards */
@keyframes fadeOut {
    from {
        opacity: 1;
        transform: translateX(0);
    }
    to {
        opacity: 0;
        transform: translateX(100%);
    }
}

.message-card.deleting {
    animation: fadeOut 0.4s ease forwards;
}

.notification-card.deleting {
    animation: fadeOut 0.4s ease forwards;
}

/* Responsive */
@media (max-width: 768px) {
    .header-stats {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .message-footer {
        flex-direction: column;
        gap: 8px;
        align-items: flex-start;
    }
    
    .notification-card {
        flex-direction: column;
    }
    
    .notification-footer {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Mark message as read
function markAsRead(messageId) {
    event.preventDefault();
    event.stopPropagation();
    
    Swal.fire({
        title: 'Tandai Dibaca?',
        text: 'Pesan ini akan ditandai sebagai sudah dibaca',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-check"></i> Ya, Tandai Dibaca',
        cancelButtonText: '<i class="fas fa-times"></i> Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Memproses...',
                html: '<i class="fas fa-spinner fa-spin" style="font-size: 32px; color: #3b82f6;"></i>',
                showConfirmButton: false,
                allowOutsideClick: false
            });
            
            // Send AJAX request
            fetch(`/notifikasi/${messageId}/mark-read`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        // Remove unread styling
                        const card = document.querySelector(`[data-message-id="${messageId}"]`);
                        if (card) {
                            card.classList.remove('unread');
                            const badgeNew = card.querySelector('.badge-new');
                            const unreadDot = card.querySelector('.unread-dot');
                            const markReadBtn = card.querySelector('.mark-read');
                            
                            if (badgeNew) badgeNew.remove();
                            if (unreadDot) unreadDot.remove();
                            if (markReadBtn) markReadBtn.remove();
                        }
                        
                        // Update counter
                        location.reload();
                    });
                } else {
                    throw new Error(data.message || 'Gagal menandai pesan');
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: error.message || 'Terjadi kesalahan',
                    confirmButtonColor: '#ef4444'
                });
            });
        }
    });
}

// Delete message
function deleteMessage(messageId) {
    event.preventDefault();
    event.stopPropagation();
    
    Swal.fire({
        title: 'Hapus Percakapan?',
        text: 'Seluruh percakapan (termasuk balasan) akan dihapus secara permanen',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash-alt"></i> Ya, Hapus Percakapan',
        cancelButtonText: '<i class="fas fa-times"></i> Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Menghapus...',
                html: '<i class="fas fa-spinner fa-spin" style="font-size: 32px; color: #ef4444;"></i>',
                showConfirmButton: false,
                allowOutsideClick: false
            });
            
            // Send AJAX request
            fetch(`/notifikasi/${messageId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        // Animate and remove card
                        const card = document.querySelector(`[data-message-id="${messageId}"]`);
                        if (card) {
                            card.classList.add('deleting');
                            setTimeout(() => {
                                card.remove();
                                
                                // Check if no messages left
                                const messagesList = document.querySelector('.messages-list');
                                if (messagesList && messagesList.children.length === 0) {
                                    location.reload();
                                }
                            }, 400);
                        }
                    });
                } else {
                    throw new Error(data.message || 'Gagal menghapus pesan');
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: error.message || 'Terjadi kesalahan',
                    confirmButtonColor: '#ef4444'
                });
            });
        }
    });
}

// Mark notification as read
function markNotificationAsRead(notificationId, isMessage = false) {
    event.preventDefault();
    event.stopPropagation();
    
    // Show loading
    Swal.fire({
        title: 'Memproses...',
        html: '<i class="fas fa-spinner fa-spin" style="font-size: 32px; color: #10b981;"></i>',
        showConfirmButton: false,
        allowOutsideClick: false
    });
    
    // Determine endpoint based on source
    let endpoint;
    if (isMessage) {
        // Extract message ID (remove 'msg_' prefix)
        const messageId = notificationId.toString().replace('msg_', '');
        endpoint = `/user/messages/${messageId}/mark-read`;
    } else {
        endpoint = `/user/notifications/${notificationId}/mark-read`;
    }
    
    // Send AJAX request
    fetch(endpoint, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Notifikasi ditandai sebagai dibaca',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                // Remove unread styling
                const card = document.querySelector(`[data-notification-id="${notificationId}"]`);
                if (card) {
                    card.classList.remove('unread');
                    const badgeNew = card.querySelector('.badge-new');
                    const markReadBtn = card.querySelector('.btn-mark-read-small');
                    
                    if (badgeNew) badgeNew.remove();
                    if (markReadBtn) markReadBtn.remove();
                }
                
                // Update counter
                setTimeout(() => {
                    location.reload();
                }, 500);
            });
        } else {
            throw new Error(data.message || 'Gagal menandai notifikasi sebagai dibaca');
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: error.message || 'Terjadi kesalahan',
            confirmButtonColor: '#ef4444'
        });
    });
}
</script>
@endpush
