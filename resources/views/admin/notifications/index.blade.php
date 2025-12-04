@extends('layouts.admin')

@section('title', 'Notifikasi & Pesan')

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

    <!-- Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Notifikasi & Pesan</h1>
            <p class="page-subtitle">Kelola pesan, kontak, dan pesanan dari petani</p>
        </div>
        <div class="header-stats">
            <div class="stat-badge">
                <i class="fas fa-envelope"></i>
                <span>{{ $notifications->total() }} Total</span>
            </div>
            <div class="stat-badge unread">
                <i class="fas fa-bell"></i>
                <span>{{ $unreadCount }} Belum Dibaca</span>
            </div>
            @if($unreadCount > 0)
            <form action="{{ route('admin.notifications.markAllRead') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-mark-all-read">
                    <i class="fas fa-check-double"></i>
                    Tandai Semua Dibaca
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <button class="tab-btn active" onclick="filterNotifications('all')">
            <i class="fas fa-th"></i>
            Semua
            <span class="tab-count">{{ $notifications->total() }}</span>
        </button>
        <button class="tab-btn" onclick="filterNotifications('message')">
            <i class="fas fa-comment"></i>
            Pesan
            <span class="tab-count">{{ $notifications->where('type', 'message')->count() }}</span>
        </button>
        <button class="tab-btn" onclick="filterNotifications('contact')">
            <i class="fas fa-envelope"></i>
            Kontak
            <span class="tab-count">{{ $notifications->where('type', 'contact')->count() }}</span>
        </button>
        <button class="tab-btn" onclick="filterNotifications('order')">
            <i class="fas fa-shopping-cart"></i>
            Pesanan
            <span class="tab-count">{{ $notifications->where('type', 'order')->count() }}</span>
        </button>
    </div>

    <!-- Messages List -->
    @if($notifications->count() > 0)
    <div class="messages-list">
        @foreach($notifications as $notif)
        <div class="message-card {{ $notif['status'] == 'unread' ? 'unread' : '' }} notif-type-{{ $notif['type'] }}" data-notif-id="{{ $notif['id'] }}" data-notif-type="{{ $notif['type'] }}">
            <a href="{{ $notif['type'] === 'message' ? route('admin.notifications.show', $notif['id']) : ($notif['type'] === 'order' ? route('admin.orders.show', $notif['data']->order_number) : route('admin.notifications.contact', $notif['id'])) }}" 
               class="message-link">
            
                <div class="message-avatar">
                    <div class="avatar-circle {{ $notif['type'] === 'order' ? 'order-icon' : ($notif['type'] === 'contact' ? 'contact-icon' : '') }}">
                        @if($notif['type'] === 'order')
                            <i class="fas fa-shopping-cart"></i>
                        @elseif($notif['type'] === 'contact')
                            {{ strtoupper(substr($notif['data']->nama ?? 'C', 0, 1)) }}
                        @else
                            {{ strtoupper(substr($notif['user']->name ?? 'U', 0, 1)) }}
                        @endif
                    </div>
                    @if($notif['status'] == 'unread')
                    <div class="unread-dot"></div>
                    @endif
                </div>
                
                <div class="message-content">
                    <div class="message-header-row">
                        <div class="message-from">
                            @if($notif['type'] === 'order')
                                <span class="sender-name">
                                    <i class="fas fa-box"></i>
                                    {{ $notif['user']->name ?? 'User' }}
                                </span>
                                <span class="order-number">{{ $notif['data']->order_number }}</span>
                            @elseif($notif['type'] === 'contact')
                                <span class="sender-name">
                                    <i class="fas fa-envelope"></i>
                                    {{ $notif['data']->nama }}
                                </span>
                                <span class="sender-phone">{{ $notif['data']->no_telp ?? '-' }}</span>
                            @else
                                <span class="sender-name">{{ $notif['user']->name ?? 'User' }}</span>
                                <span class="sender-phone">{{ $notif['user']->no_telp ?? '-' }}</span>
                            @endif
                        </div>
                        <div class="message-time">
                            <i class="fas fa-clock"></i>
                            {{ $notif['created_at']->diffForHumans() }}
                        </div>
                    </div>
                    
                    <div class="message-subject">
                        @if($notif['status'] == 'unread')
                        <span class="new-badge">BARU</span>
                        @endif
                        
                        @if($notif['type'] === 'order')
                            <span class="type-badge order-badge">
                                <i class="fas fa-shopping-cart"></i> Pesanan Baru
                            </span>
                        @elseif($notif['type'] === 'contact')
                            <span class="type-badge contact-badge">
                                <i class="fas fa-envelope"></i> Kontak
                            </span>
                        @else
                            <span class="type-badge message-badge">
                                <i class="fas fa-comment"></i> Pesan
                            </span>
                        @endif
                        
                        {{ $notif['subject'] }}
                    </div>
                    
                    <div class="message-preview">
                        @if($notif['type'] === 'order')
                            <strong>Produk:</strong> {{ $notif['preview'] }}<br>
                            <strong>Total:</strong> Rp {{ number_format($notif['data']->total_price ?? 0, 0, ',', '.') }}
                        @elseif($notif['type'] === 'message' && isset($notif['reply_count']) && $notif['reply_count'] > 0)
                            @php
                                $lastReply = $notif['data']->replies->last();
                                $lastSender = $lastReply->sender_type === 'admin' ? 'Anda' : $notif['user']->name;
                            @endphp
                            <span class="preview-sender {{ $lastReply->sender_type }}">{{ $lastSender }}:</span>
                            {{ Str::limit($lastReply->message, 100) }}
                        @else
                            <span class="preview-sender user">{{ $notif['user']->name ?? 'User' }}:</span>
                            {{ Str::limit($notif['preview'], 120) }}
                        @endif
                    </div>
                    
                    @if($notif['type'] === 'message')
                    <div class="message-replies">
                        <i class="fas fa-comments"></i>
                        {{ ($notif['reply_count'] ?? 0) + 1 }} Pesan
                        @if(($notif['reply_count'] ?? 0) > 0)
                            <span class="conversation-active">• Percakapan Aktif</span>
                        @endif
                    </div>
                    @endif
                </div>
            </a>
            
            <!-- Action Buttons -->
            <div class="message-action-btns" onclick="event.stopPropagation()">
                @if($notif['status'] == 'unread' && $notif['type'] !== 'order')
                <button class="action-btn mark-read" onclick="markAsRead({{ $notif['id'] }}, '{{ $notif['type'] }}')" title="Tandai Dibaca">
                    <i class="fas fa-check"></i>
                </button>
                @endif
                @if($notif['type'] !== 'order')
                <button class="action-btn delete" onclick="deleteNotification({{ $notif['id'] }}, '{{ $notif['type'] }}')" title="Hapus">
                    <i class="fas fa-trash-alt"></i>
                </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="pagination-section">
        {{ $notifications->links() }}
    </div>
    @else
    <div class="empty-state">
        <i class="fas fa-inbox"></i>
        <p>Belum ada notifikasi</p>
    </div>
    @endif
</div>

<style>
.notifications-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

/* Filter Tabs */
.filter-tabs {
    display: flex;
    gap: 10px;
    margin-bottom: 24px;
    padding: 6px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.tab-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 16px;
    background: transparent;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.3s ease;
}

.tab-btn i {
    font-size: 16px;
}

.tab-btn:hover {
    background: #f3f4f6;
    color: #374151;
}

.tab-btn.active {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    box-shadow: 0 3px 10px rgba(16, 185, 129, 0.3);
}

.tab-count {
    padding: 2px 8px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    font-size: 12px;
    font-weight: 700;
}

.tab-btn:not(.active) .tab-count {
    background: #e5e7eb;
    color: #374151;
}


/* Alert */
.alert {
    padding: 14px 18px;
    border-radius: 8px;
    margin-bottom: 20px;
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

.alert i:first-child {
    font-size: 18px;
}

.alert span {
    flex: 1;
    font-size: 14px;
    font-weight: 500;
}

.alert-close {
    background: none;
    border: none;
    color: inherit;
    cursor: pointer;
    padding: 5px;
    opacity: 0.7;
    transition: opacity 0.3s;
}

.alert-close:hover {
    opacity: 1;
}

/* Page Header */
.page-header {
    margin-bottom: 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}

.page-title {
    font-size: 24px;
    font-weight: 700;
    color: #065f46;
    margin: 0 0 5px 0;
}

.page-subtitle {
    font-size: 13px;
    color: #6b7280;
    margin: 0;
}

.header-stats {
    display: flex;
    gap: 12px;
}

.stat-badge {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    font-size: 13px;
    font-weight: 600;
    color: #374151;
}

.stat-badge i {
    color: #10b981;
    font-size: 14px;
}

.stat-badge.unread {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
}

.stat-badge.unread i {
    color: #f59e0b;
}

/* Messages List */
.messages-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 20px;
}

.message-card {
    background: white;
    border-radius: 10px;
    padding: 18px 20px;
    display: flex;
    align-items: start;
    gap: 16px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
    text-decoration: none;
    border-left: 4px solid transparent;
}

.message-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
    transform: translateX(4px);
    border-left-color: #10b981;
}

.message-card.unread {
    background: linear-gradient(135deg, #ecfdf5 0%, #ffffff 100%);
    border-left-color: #10b981;
}

/* Avatar */
.message-avatar {
    position: relative;
    flex-shrink: 0;
}

.avatar-circle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 18px;
    box-shadow: 0 3px 10px rgba(16, 185, 129, 0.3);
}

.unread-dot {
    position: absolute;
    top: 0;
    right: 0;
    width: 14px;
    height: 14px;
    background: #ef4444;
    border-radius: 50%;
    border: 3px solid white;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

/* Message Content */
.message-content {
    flex: 1;
    min-width: 0;
}

.message-header-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
    gap: 12px;
}

.message-from {
    display: flex;
    align-items: center;
    gap: 10px;
}

.sender-name {
    font-size: 15px;
    font-weight: 700;
    color: #065f46;
}

.sender-phone {
    font-size: 12px;
    color: #6b7280;
}

.message-time {
    font-size: 12px;
    color: #9ca3af;
    display: flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
}

.message-time i {
    font-size: 11px;
}

.message-subject {
    font-size: 14px;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.new-badge {
    display: inline-block;
    padding: 2px 8px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border-radius: 4px;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.5px;
}

.type-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.3px;
    margin-left: 8px;
}

.type-badge i {
    font-size: 10px;
}

.order-badge {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
}

.contact-badge {
    background: linear-gradient(135deg, #fce7f3 0%, #fbcfe8 100%);
    color: #9f1239;
}

.message-badge {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
}

.order-number {
    font-size: 11px;
    padding: 3px 8px;
    background: #e0e7ff;
    color: #4338ca;
    border-radius: 4px;
    font-weight: 600;
}

.avatar-circle.order-icon {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    box-shadow: 0 3px 10px rgba(59, 130, 246, 0.3);
}

.avatar-circle.contact-icon {
    background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
    box-shadow: 0 3px 10px rgba(236, 72, 153, 0.3);
}

.avatar-circle i {
    font-size: 18px;
}

.notif-type-order:hover {
    border-left-color: #3b82f6;
}

.notif-type-contact:hover {
    border-left-color: #ec4899;
}


.message-preview {
    font-size: 13px;
    color: #6b7280;
    line-height: 1.5;
    margin-bottom: 8px;
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

.message-replies {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    background: #f3f4f6;
    border-radius: 6px;
    font-size: 12px;
    color: #374151;
    font-weight: 500;
}

.message-replies i {
    color: #10b981;
    font-size: 11px;
}

.conversation-active {
    color: #10b981;
    font-weight: 600;
    font-size: 11px;
}

/* Message Actions */
.message-actions {
    flex-shrink: 0;
    color: #9ca3af;
    font-size: 14px;
}

/* Action Buttons */
.message-action-btns {
    position: absolute;
    top: 12px;
    right: 12px;
    display: flex;
    gap: 8px;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 10;
}

.message-card:hover .message-action-btns {
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

/* Button Mark All Read */
.btn-mark-all-read {
    padding: 10px 18px;
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
    gap: 8px;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
}

.btn-mark-all-read:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
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

/* Empty State */
.empty-state {
    background: white;
    border-radius: 10px;
    padding: 60px 20px;
    text-align: center;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
}

.empty-state i {
    font-size: 48px;
    color: #d1d5db;
    margin-bottom: 15px;
}

.empty-state p {
    font-size: 14px;
    color: #6b7280;
    margin: 0;
}

/* Pagination */
.pagination-section {
    margin-top: 20px;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        align-items: start;
    }
    
    .header-stats {
        width: 100%;
        flex-wrap: wrap;
    }
    
    .stat-badge {
        flex: 1;
        min-width: 150px;
    }
    
    .message-card {
        padding: 14px 16px;
    }
    
    .message-header-row {
        flex-direction: column;
        align-items: start;
        gap: 4px;
    }
    
    .sender-phone {
        display: none;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function filterNotifications(type) {
    // Update active tab
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.closest('.tab-btn').classList.add('active');
    
    // Filter cards
    const cards = document.querySelectorAll('.message-card');
    cards.forEach(card => {
        if (type === 'all') {
            card.style.display = 'flex';
        } else {
            if (card.classList.contains('notif-type-' + type)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        }
    });
}

// Mark notification as read
function markAsRead(notifId, notifType) {
    event.preventDefault();
    event.stopPropagation();
    
    const url = notifType === 'message' 
        ? `/admin/notifications/${notifId}/mark-read`
        : `/admin/notifications/contact/${notifId}/mark-read`;
    
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
            Swal.fire({
                title: 'Memproses...',
                html: '<i class="fas fa-spinner fa-spin" style="font-size: 32px; color: #3b82f6;"></i>',
                showConfirmButton: false,
                allowOutsideClick: false
            });
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
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
                        const card = document.querySelector(`[data-notif-id="${notifId}"][data-notif-type="${notifType}"]`);
                        if (card) {
                            card.classList.remove('unread');
                            const badge = card.querySelector('.new-badge');
                            const dot = card.querySelector('.unread-dot');
                            const btn = card.querySelector('.mark-read');
                            
                            if (badge) badge.remove();
                            if (dot) dot.remove();
                            if (btn) btn.remove();
                        }
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
function deleteNotification(notifId, notifType) {
    event.preventDefault();
    event.stopPropagation();
    
    const url = notifType === 'message' 
        ? `/admin/notifications/${notifId}`
        : `/admin/notifications/contact/${notifId}`;
    
    Swal.fire({
        title: 'Hapus Notifikasi?',
        text: notifType === 'message' ? 'Pesan ini akan dihapus secara permanen' : 'Kontak ini akan dihapus secara permanen',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash-alt"></i> Ya, Hapus',
        cancelButtonText: '<i class="fas fa-times"></i> Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Menghapus...',
                html: '<i class="fas fa-spinner fa-spin" style="font-size: 32px; color: #ef4444;"></i>',
                showConfirmButton: false,
                allowOutsideClick: false
            });
            
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
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
                        const card = document.querySelector(`[data-notif-id="${notifId}"][data-notif-type="${notifType}"]`);
                        if (card) {
                            card.classList.add('deleting');
                            setTimeout(() => {
                                card.remove();
                                
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
</script>
@endsection
