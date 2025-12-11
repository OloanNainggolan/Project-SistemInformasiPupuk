@extends('layouts.user')

@section('title', 'Notifikasi Saya')

@push('meta')
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
@endpush

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
                Total: <strong>{{ $notifications->total() }}</strong>
            </span>
            @if($unreadCount > 0)
            <span class="stat-badge unread">
                <i class="fas fa-envelope-open"></i>
                Belum Dibaca: <strong>{{ $unreadCount }}</strong>
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

    <!-- Messages List -->
    @if($notifications->count() > 0)
    <div class="messages-list">
        @foreach($notifications as $item)
        @php
            // Detect if item is Message (conversation) or Notification (system)
            $isMessage = $item instanceof \App\Models\Message;
            $isNotification = $item instanceof \App\Models\Notification;
            
            if ($isMessage) {
                // Check if there are unread replies from admin
                $hasUnreadReply = $item->replies->where('sender_type', 'admin')->where('status', 'unread')->count() > 0;
                $isUnread = ($item->sender_type === 'admin' && $item->status === 'unread') || $hasUnreadReply;
                
                // Get last activity (either original message or last reply)
                $lastActivity = $item->replies->count() > 0 ? $item->replies->last()->created_at : $item->created_at;
            } else {
                // System notification - is_read: 0=unread, 1=read
                $isUnread = ($item->is_read == 0);
                $lastActivity = $item->created_at;
            }
        @endphp
        
        @if($isMessage)
        {{-- Message/Conversation Card --}}
        <div class="message-card type-message {{ $isUnread ? 'unread' : '' }}" data-message-id="{{ $item->id }}">
            <a href="{{ route('notifikasi.show', $item->id) }}" class="message-link">
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
                    {{ $item->subject }}
                    @if($item->sender_type === 'admin' && $item->priority)
                        <span class="priority-badge priority-{{ $item->priority }}">
                            @if($item->priority === 'urgent')
                                <i class="fas fa-exclamation-circle"></i> MENDESAK
                            @elseif($item->priority === 'high')
                                <i class="fas fa-arrow-up"></i> PENTING
                            @elseif($item->priority === 'normal')
                                <i class="fas fa-minus"></i> NORMAL
                            @else
                                <i class="fas fa-arrow-down"></i> RENDAH
                            @endif
                        </span>
                    @endif
                </div>

                <div class="message-preview">
                    @if($item->replies->count() > 0)
                        @php
                            $lastReply = $item->replies->last();
                            $lastSender = $lastReply->sender_type === 'admin' ? 'Admin' : 'Anda';
                        @endphp
                        <span class="preview-sender {{ $lastReply->sender_type }}">{{ $lastSender }}:</span> 
                        {{ Str::limit($lastReply->message, 100) }}
                    @else
                        @php
                            $originalSender = $item->sender_type === 'admin' ? 'Admin' : 'Anda';
                        @endphp
                        <span class="preview-sender {{ $item->sender_type }}">{{ $originalSender }}:</span>
                        {{ Str::limit($item->message, 120) }}
                    @endif
                </div>

                <div class="message-footer">
                    <span class="reply-count">
                        <i class="fas fa-comments"></i>
                        {{ $item->replies->count() + 1 }} Pesan
                    </span>
                    @if($item->replies->count() > 0)
                    <span class="message-type conversation">
                        <i class="fas fa-exchange-alt"></i>
                        Percakapan Aktif
                    </span>
                    @else
                        @if($item->sender_type === 'admin')
                        <span class="message-type admin-msg">
                            <i class="fas fa-bell"></i>
                            Notifikasi dari Admin
                        </span>
                        @else
                        <span class="message-type user-msg">
                            <i class="fas fa-paper-plane"></i>
                            Menunggu Balasan
                        </span>
                        @endif
                    @endif
                </div>
            </a>
            
            <!-- Action Buttons -->
            <div class="message-actions" onclick="event.stopPropagation()">
                @if($isUnread)
                <button class="action-btn mark-read" onclick="markAsRead({{ $item->id }})" title="Tandai Dibaca">
                    <i class="fas fa-check"></i>
                </button>
                @endif
                <button class="action-btn delete" onclick="deleteMessage({{ $item->id }})" title="Hapus Thread">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
        @else
        {{-- System Notification Card - Same style as Message Card --}}
        <div class="message-card type-notification {{ $isUnread ? 'unread' : '' }}" data-notification-id="{{ $item->id }}">
            <a href="{{ route('notifikasi.show', $item->id) }}" class="message-link">
                <div class="message-header">
                    <div class="sender-info">
                        <div class="sender-avatar admin">
                            A
                        </div>
                        <div class="sender-details">
                            <div class="sender-name">
                                Admin:
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
                    @if($item->type === 'info')
                        <i class="fas fa-envelope"></i>
                        <i class="fas fa-check-square" style="color: #10b981; margin-right: 5px;"></i>
                    @elseif($item->type === 'success')
                        <i class="fas fa-check-square" style="color: #10b981; margin-right: 5px;"></i>
                        <i class="fas fa-check-square" style="color: #10b981; margin-right: 5px;"></i>
                    @elseif($item->type === 'warning')
                        <i class="fas fa-exclamation-triangle" style="color: #f59e0b; margin-right: 5px;"></i>
                    @elseif($item->type === 'important')
                        <i class="fas fa-exclamation-circle" style="color: #ef4444; margin-right: 5px;"></i>
                    @endif
                    {{ $item->title }}
                    <span class="priority-badge priority-{{ $item->type === 'important' ? 'urgent' : 'normal' }}" style="background: 
                        @if($item->type === 'info') #dbeafe; color: #1e40af;
                        @elseif($item->type === 'success') #d1fae5; color: #065f46;
                        @elseif($item->type === 'warning') #fed7aa; color: #92400e;
                        @elseif($item->type === 'important') #fee2e2; color: #991b1b;
                        @endif
                        ">
                        @if($item->type === 'info')
                            <i class="fas fa-minus"></i> NORMAL
                        @elseif($item->type === 'success')
                            <i class="fas fa-check-circle"></i> SUKSES
                        @elseif($item->type === 'warning')
                            <i class="fas fa-arrow-up"></i> BARU
                        @elseif($item->type === 'important')
                            <i class="fas fa-exclamation-circle"></i> PENTING
                        @endif
                    </span>
                </div>

                <div class="message-preview">
                    <span class="preview-sender admin">Admin:</span>
                    {{ Str::limit($item->title, 100) }}
                </div>

                <div class="message-footer">
                    <span class="reply-count">
                        <i class="fas fa-comment"></i>
                        1 Pesan
                    </span>
                    <span class="message-type admin-msg">
                        <i class="fas fa-bell"></i>
                        Notifikasi dari Admin
                    </span>
                </div>
            </a>
            
            <!-- Action Buttons -->
            <div class="message-actions" onclick="event.stopPropagation()">
                @if($isUnread)
                <button class="action-btn mark-read" onclick="markNotificationAsRead({{ $item->id }})" title="Tandai Dibaca">
                    <i class="fas fa-check"></i>
                </button>
                @endif
                <button class="action-btn delete" onclick="deleteNotification({{ $item->id }})" title="Hapus Notifikasi">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        </div>
        @endif
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="pagination-section">
        {{ $notifications->links() }}
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

<!-- Notification Detail Modal -->
<div id="notificationModal" class="notification-modal" style="display: none;" onclick="closeNotificationModal(event)">
    <div class="notification-modal-content" onclick="event.stopPropagation()">
        <div class="notification-modal-header">
            <h2 id="modalTitle">Detail Notifikasi</h2>
            <button class="modal-close-btn" onclick="closeNotificationModal()">&times;</button>
        </div>
        <div class="notification-modal-body">
            <div id="modalContent">
                <div style="text-align: center; padding: 40px;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 32px; color: #10b981;"></i>
                    <p style="margin-top: 15px; color: #64748b;">Memuat...</p>
                </div>
            </div>
        </div>
        <div class="notification-modal-footer">
            <button class="btn-modal-close" onclick="closeNotificationModal()">
                <i class="fas fa-times"></i> Tutup
            </button>
        </div>
    </div>
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

/* Consistent green border for all card types */
.message-card.type-message {
    border-left-color: #10b981;
}

.message-card.type-notification {
    border-left-color: #10b981;
}

.message-card.unread {
    background: #ffffff;
    border-left-color: #10b981;
    border-left-width: 5px;
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
    flex-wrap: wrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.message-subject i {
    color: #10b981;
    font-size: 14px;
}

/* Priority Badges */
.priority-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-left: 8px;
}

.priority-badge i {
    font-size: 10px;
}

.priority-urgent {
    background: #fee2e2;
    color: #991b1b;
}

.priority-high {
    background: #fed7aa;
    color: #9a3412;
}

.priority-normal {
    background: #dbeafe;
    color: #1e40af;
}

.priority-low {
    background: #e5e7eb;
    color: #4b5563;
}

.message-preview {
    font-size: 14px;
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 12px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    max-height: 48px;
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

/* System Notification Card */
.notification-card {
    position: relative;
    padding: 20px !important;
}

.notification-card.type-info {
    border-left: 4px solid #3b82f6;
}

.notification-card.type-success {
    border-left: 4px solid #10b981;
}

.notification-card.type-warning {
    border-left: 4px solid #f59e0b;
}

.notification-card.type-important {
    border-left: 4px solid #ef4444;
}

.notification-content {
    display: flex;
    gap: 16px;
}

.notification-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    flex-shrink: 0;
}

.notification-icon.type-info {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
}

.notification-icon.type-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.notification-icon.type-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}

.notification-icon.type-important {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

.notification-body {
    flex: 1;
}

.notification-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 10px;
    gap: 15px;
}

.notification-title {
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 8px;
    flex: 1;
}

.notification-title i {
    color: #10b981;
}

.notification-date {
    font-size: 12px;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
}

.notification-message {
    font-size: 14px;
    color: #475569;
    line-height: 1.6;
    margin-bottom: 12px;
    padding-right: 40px;
}

.notification-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
}

.notification-source {
    font-size: 12px;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 6px;
}

.notification-source i {
    color: #10b981;
}

.notification-type-badge {
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 5px;
    text-transform: uppercase;
}

.notification-type-badge.type-info {
    background: #dbeafe;
    color: #1e40af;
}

.notification-type-badge.type-success {
    background: #d1fae5;
    color: #065f46;
}

.notification-type-badge.type-warning {
    background: #fef3c7;
    color: #92400e;
}

.notification-type-badge.type-important {
    background: #fee2e2;
    color: #991b1b;
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

/* Notification Detail Modal */
.notification-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10000;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.notification-modal-content {
    background: white;
    border-radius: 16px;
    max-width: 600px;
    width: 90%;
    max-height: 80vh;
    display: flex;
    flex-direction: column;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: slideUp 0.3s ease;
}

@keyframes slideUp {
    from { 
        opacity: 0;
        transform: translateY(30px);
    }
    to { 
        opacity: 1;
        transform: translateY(0);
    }
}

.notification-modal-header {
    padding: 24px 28px;
    border-bottom: 2px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.notification-modal-header h2 {
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

.modal-close-btn {
    width: 36px;
    height: 36px;
    border: none;
    background: #f1f5f9;
    color: #64748b;
    border-radius: 8px;
    font-size: 24px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-close-btn:hover {
    background: #ef4444;
    color: white;
    transform: rotate(90deg);
}

.notification-modal-body {
    padding: 28px;
    overflow-y: auto;
    flex: 1;
}

.notification-modal-footer {
    padding: 20px 28px;
    border-top: 2px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.btn-modal-close {
    padding: 12px 24px;
    border: none;
    background: #6b7280;
    color: white;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-modal-close:hover {
    background: #4b5563;
    transform: translateY(-2px);
}

.modal-notification-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    margin: 0 auto 20px;
}

.modal-notification-icon.type-info {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
}

.modal-notification-icon.type-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.modal-notification-icon.type-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}

.modal-notification-icon.type-important {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

.modal-notification-title {
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
    text-align: center;
    margin-bottom: 8px;
}

.modal-notification-date {
    font-size: 13px;
    color: #64748b;
    text-align: center;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.modal-notification-message {
    font-size: 15px;
    color: #475569;
    line-height: 1.7;
    padding: 20px;
    background: #f8fafc;
    border-radius: 12px;
    border-left: 4px solid #10b981;
}

.modal-notification-meta {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-notification-source {
    font-size: 13px;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 6px;
}

.modal-notification-source i {
    color: #10b981;
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
    
    .notification-modal-content {
        width: 95%;
        max-height: 90vh;
    }
    
    .notification-modal-header,
    .notification-modal-body,
    .notification-modal-footer {
        padding: 20px;
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
function markNotificationAsRead(notificationId) {
    event.preventDefault();
    event.stopPropagation();
    
    Swal.fire({
        title: 'Tandai Dibaca?',
        text: 'Notifikasi ini akan ditandai sebagai sudah dibaca',
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
            fetch(`/notifications/${notificationId}/mark-read`, {
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
                        const card = document.querySelector(`[data-notification-id="${notificationId}"]`);
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
                    throw new Error(data.message || 'Gagal menandai notifikasi');
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

// Delete notification
function deleteNotification(notificationId) {
    event.preventDefault();
    event.stopPropagation();
    
    Swal.fire({
        title: 'Hapus Notifikasi?',
        text: 'Notifikasi akan dihapus secara permanen',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash-alt"></i> Ya, Hapus Notifikasi',
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
            fetch(`/notifications/${notificationId}`, {
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
                        const card = document.querySelector(`[data-notification-id="${notificationId}"]`);
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
                    throw new Error(data.message || 'Gagal menghapus notifikasi');
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

// Show notification detail modal
function showNotificationDetail(notificationId) {
    const modal = document.getElementById('notificationModal');
    modal.style.display = 'flex';
    
    // Fetch notification data
    const notifications = @json($notifications->items());
    const notification = notifications.find(n => n.id === notificationId && n.title !== undefined);
    
    if (notification) {
        const typeIcons = {
            'info': '<i class="fas fa-info-circle"></i>',
            'success': '<i class="fas fa-check-circle"></i>',
            'warning': '<i class="fas fa-exclamation-circle"></i>',
            'important': '<i class="fas fa-exclamation-triangle"></i>'
        };
        
        const typeLabels = {
            'info': '<i class="fas fa-info-circle"></i> INFO',
            'success': '<i class="fas fa-check-circle"></i> SUKSES',
            'warning': '<i class="fas fa-exclamation-circle"></i> PERINGATAN',
            'important': '<i class="fas fa-exclamation-triangle"></i> PENTING'
        };
        
        const createdAt = new Date(notification.created_at);
        const formattedDate = createdAt.toLocaleString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        
        document.getElementById('modalContent').innerHTML = `
            <div class="modal-notification-icon type-${notification.type}">
                ${typeIcons[notification.type]}
            </div>
            <div class="modal-notification-title">
                ${notification.title}
            </div>
            <div class="modal-notification-date">
                <i class="fas fa-clock"></i>
                ${formattedDate}
            </div>
            <div class="modal-notification-message">
                ${notification.message}
            </div>
            <div class="modal-notification-meta">
                <span class="modal-notification-source">
                    <i class="fas fa-user-shield"></i>
                    Notifikasi dari Admin
                </span>
                <span class="notification-type-badge type-${notification.type}">
                    ${typeLabels[notification.type]}
                </span>
            </div>
        `;
        
        // Mark as read if unread
        if (!notification.is_read) {
            fetch(`/notifications/${notificationId}/mark-read`, {
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
                    // Update UI
                    const card = document.querySelector(`[data-notification-id="${notificationId}"]`);
                    if (card) {
                        card.classList.remove('unread');
                        const badgeNew = card.querySelector('.badge-new');
                        const unreadDot = card.querySelector('.unread-dot');
                        const markReadBtn = card.querySelector('.mark-read');
                        
                        if (badgeNew) badgeNew.remove();
                        if (unreadDot) unreadDot.remove();
                        if (markReadBtn) markReadBtn.remove();
                    }
                }
            })
            .catch(error => console.error('Error marking as read:', error));
        }
    }
}

// Close notification modal
function closeNotificationModal(event) {
    if (event) {
        event.stopPropagation();
    }
    const modal = document.getElementById('notificationModal');
    modal.style.display = 'none';
}

// Close modal on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeNotificationModal();
    }
});

// Check if page needs refresh after reading notification or marking all as read
document.addEventListener('DOMContentLoaded', function() {
    // Check if coming back from reading notification
    if (sessionStorage.getItem('notifJustRead') === 'true') {
        console.log('Notifikasi baru saja dibaca, reload untuk update badge...');
        sessionStorage.removeItem('notifJustRead');
        // Force hard reload with cache bust
        setTimeout(function() {
            window.location.href = window.location.pathname + '?t=' + Date.now();
        }, 100);
    }
    
    // Check if "Mark All as Read" was just clicked
    @if(session('success'))
    console.log('Mark all as read successful, forcing reload...');
    // Force hard reload after showing success message
    setTimeout(function() {
        window.location.href = window.location.pathname + '?t=' + Date.now();
    }, 1500);
    @endif
    
    // Also check URL parameter for backward compatibility
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('refresh') === '1' || urlParams.get('t')) {
        // Clean URL after refresh
        const newUrl = window.location.pathname;
        window.history.replaceState({}, document.title, newUrl);
    }
});
</script>
@endpush
