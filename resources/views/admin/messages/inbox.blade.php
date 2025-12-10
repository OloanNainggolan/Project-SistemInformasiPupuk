@extends('layouts.admin')

@section('title', 'Pesan Masuk')

@section('content')
<div class="inbox-container">
    <div class="page-header">
        <div class="header-left">
            <h1 class="page-title">
                <i class="fas fa-envelope"></i>
                Pesan Masuk
            </h1>
            <p class="page-subtitle">Pesan dari user dan notifikasi user baru</p>
        </div>
        <div class="header-actions">
            <form action="{{ route('admin.messages.markAllRead') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-secondary">
                    <i class="fas fa-check-double"></i>
                    Tandai Semua Dibaca
                </button>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <button class="tab-btn {{ $filter == 'all' ? 'active' : '' }}" onclick="window.location.href='?filter=all'">
            <i class="fas fa-inbox"></i>
            Semua ({{ $totalAll }})
        </button>
        <button class="tab-btn {{ $filter == 'unread' ? 'active' : '' }}" onclick="window.location.href='?filter=unread'">
            <i class="fas fa-envelope"></i>
            Belum Dibaca ({{ $totalUnread }})
        </button>
        <button class="tab-btn {{ $filter == 'contact' ? 'active' : '' }}" onclick="window.location.href='?filter=contact'">
            <i class="fas fa-comments"></i>
            Pesan User ({{ $totalContactMessages }})
        </button>
        <button class="tab-btn {{ $filter == 'new_user' ? 'active' : '' }}" onclick="window.location.href='?filter=new_user'">
            <i class="fas fa-user-plus"></i>
            User Baru ({{ $totalNewUsers }})
        </button>
        <button class="tab-btn {{ $filter == 'order' ? 'active' : '' }}" onclick="window.location.href='?filter=order'">
            <i class="fas fa-shopping-cart"></i>
            Pesanan Baru ({{ $totalNewOrders }})
        </button>
    </div>

    <!-- Messages List -->
    @if($messages->count() > 0)
    <div class="messages-list">
        @foreach($messages as $message)
        <div class="message-card {{ $message->is_read ? 'read' : 'unread' }}">
            <div class="message-icon">
                @if($message->type == 'new_user')
                    <div class="icon-badge badge-blue">
                        <i class="fas fa-user-plus"></i>
                    </div>
                @elseif($message->type == 'new_order')
                    <div class="icon-badge badge-green">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                @elseif($message->type == 'contact')
                    <div class="icon-badge badge-purple">
                        <i class="fas fa-comments"></i>
                    </div>
                @else
                    <div class="icon-badge badge-gray">
                        <i class="fas fa-envelope"></i>
                    </div>
                @endif
            </div>

            <div class="message-content">
                <div class="message-header">
                    <h3 class="message-title">{{ $message->title }}</h3>
                    <div class="message-meta">
                        <span class="message-time">
                            <i class="far fa-clock"></i>
                            {{ $message->created_at->diffForHumans() }}
                        </span>
                        @if(!$message->is_read)
                        <span class="unread-dot"></span>
                        @endif
                    </div>
                </div>

                <p class="message-preview">{{ Str::limit($message->message, 150) }}</p>

                @if($message->user)
                <div class="message-from">
                    <i class="fas fa-user"></i>
                    Dari: <strong>{{ $message->user->nama_lengkap }}</strong> ({{ $message->user->email }})
                </div>
                @endif

                <div class="message-actions">
                    <a href="{{ route('admin.messages.show', $message->id) }}" class="btn-action btn-view">
                        <i class="fas fa-eye"></i>
                        Lihat Detail
                    </a>

                    @if(!$message->is_read)
                    <form action="{{ route('admin.messages.markRead', $message->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-action btn-mark">
                            <i class="fas fa-check"></i>
                            Tandai Dibaca
                        </button>
                    </form>
                    @endif

                    <form action="{{ route('admin.messages.delete', $message->id) }}" method="POST" 
                          style="display: inline;" 
                          onsubmit="return confirm('Yakin ingin menghapus pesan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-delete">
                            <i class="fas fa-trash"></i>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="pagination-container">
        {{ $messages->appends(['filter' => $filter])->links() }}
    </div>
    @else
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-inbox"></i>
        </div>
        <h3 class="empty-title">Tidak Ada Pesan</h3>
        <p class="empty-text">
            @if($filter == 'unread')
                Semua pesan sudah dibaca
            @elseif($filter == 'contact')
                Belum ada pesan dari user
            @elseif($filter == 'new_user')
                Belum ada user baru hari ini
            @elseif($filter == 'order')
                Belum ada pesanan baru
            @else
                Kotak masuk kosong
            @endif
        </p>
    </div>
    @endif
</div>

<style>
.inbox-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 24px;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a1a;
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0 0 8px 0;
}

.page-title i {
    color: #f59e0b;
}

.page-subtitle {
    color: #666;
    font-size: 14px;
    margin: 0;
}

.alert {
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    font-weight: 500;
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #10b981;
}

.filter-tabs {
    background: white;
    border-radius: 12px;
    padding: 8px;
    display: flex;
    gap: 8px;
    margin-bottom: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    overflow-x: auto;
}

.tab-btn {
    flex: 1;
    min-width: fit-content;
    padding: 12px 20px;
    border: none;
    background: transparent;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    color: #666;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    white-space: nowrap;
}

.tab-btn:hover {
    background: #f3f4f6;
    color: #1a1a1a;
}

.tab-btn.active {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.tab-btn i {
    font-size: 14px;
}

.messages-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.message-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    display: flex;
    gap: 16px;
    transition: all 0.3s;
    border-left: 4px solid transparent;
}

.message-card.unread {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border-left-color: #f59e0b;
}

.message-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}

.message-icon {
    flex-shrink: 0;
}

.icon-badge {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.badge-blue { background: linear-gradient(135deg, #3b82f6, #2563eb); }
.badge-green { background: linear-gradient(135deg, #10b981, #059669); }
.badge-purple { background: linear-gradient(135deg, #a855f7, #9333ea); }
.badge-gray { background: linear-gradient(135deg, #6b7280, #4b5563); }

.message-content {
    flex: 1;
}

.message-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 8px;
}

.message-title {
    font-size: 16px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.message-meta {
    display: flex;
    align-items: center;
    gap: 8px;
}

.message-time {
    font-size: 12px;
    color: #666;
    display: flex;
    align-items: center;
    gap: 4px;
}

.unread-dot {
    width: 8px;
    height: 8px;
    background: #ef4444;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.message-preview {
    font-size: 14px;
    color: #555;
    margin: 0 0 12px 0;
    line-height: 1.6;
}

.message-from {
    font-size: 13px;
    color: #666;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.message-from i {
    color: #10b981;
}

.message-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.btn-action {
    padding: 8px 14px;
    border: none;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    text-decoration: none;
}

.btn-view {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.btn-view:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
}

.btn-mark {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.btn-mark:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(16, 185, 129, 0.3);
}

.btn-delete {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.btn-delete:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(239, 68, 68, 0.3);
}

.btn {
    padding: 10px 18px;
    border: none;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-secondary {
    background: white;
    color: #374151;
    border: 2px solid #e5e7eb;
}

.btn-secondary:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
}

.empty-state {
    background: white;
    border-radius: 16px;
    padding: 80px 40px;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.empty-icon {
    width: 80px;
    height: 80px;
    background: #f3f4f6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
}

.empty-icon i {
    font-size: 36px;
    color: #9ca3af;
}

.empty-title {
    font-size: 20px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 8px 0;
}

.empty-text {
    font-size: 14px;
    color: #666;
    margin: 0;
}

.pagination-container {
    margin-top: 24px;
}

@media (max-width: 768px) {
    .message-card {
        flex-direction: column;
    }

    .message-actions {
        flex-direction: column;
    }

    .btn-action {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection
