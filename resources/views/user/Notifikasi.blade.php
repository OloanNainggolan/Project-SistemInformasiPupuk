@extends('layouts.user')

@section('title', 'Notifikasi')

@section('content')
<div class="notif-container">
    <div class="notif-header">
        <h1><i class="fas fa-bell"></i> Notifikasi</h1>
        <p>Pantau pembaruan dan informasi penting Anda</p>
        @if($unreadCount > 0)
        <button onclick="markAllAsRead()" class="btn-mark-all">
            <i class="fas fa-check-double"></i> Tandai Semua Dibaca
        </button>
        @endif
    </div>

    <div class="notif-content">
        @forelse($notifications as $notification)
        <div class="notif-item {{ $notification->status == 'unread' ? 'unread' : '' }}" data-id="{{ $notification->id }}">
            <div class="notif-icon {{ $notification->type }}">
                @if($notification->type == 'success')
                    <i class="fas fa-check-circle"></i>
                @elseif($notification->type == 'warning')
                    <i class="fas fa-exclamation-triangle"></i>
                @elseif($notification->type == 'danger')
                    <i class="fas fa-times-circle"></i>
                @else
                    <i class="fas fa-info-circle"></i>
                @endif
            </div>
            <div class="notif-content-text">
                <h3>{{ $notification->title }}</h3>
                <p>{{ $notification->message }}</p>
                <span class="notif-time">
                    <i class="far fa-clock"></i> {{ $notification->created_at->locale('id')->diffForHumans() }}
                </span>
            </div>
            @if($notification->status == 'unread')
            <button onclick="markAsRead({{ $notification->id }})" class="btn-mark-read">
                <i class="fas fa-check"></i>
            </button>
            @endif
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-bell-slash"></i>
            <h3>Tidak Ada Notifikasi</h3>
            <p>Anda belum memiliki notifikasi saat ini</p>
        </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
    <div class="pagination-wrapper">
        {{ $notifications->links() }}
    </div>
    @endif
</div>

<style>
.notif-container {
    max-width: 900px;
    margin: 40px auto;
    padding: 0 20px;
}

.notif-header {
    background: white;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    margin-bottom: 25px;
    position: relative;
}

.notif-header h1 {
    font-size: 2em;
    color: #1a5f3a;
    margin-bottom: 8px;
    font-weight: 800;
}

.notif-header p {
    color: #666;
    font-size: 0.95em;
}

.btn-mark-all {
    position: absolute;
    top: 30px;
    right: 30px;
    padding: 10px 20px;
    background: #00897b;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-mark-all:hover {
    background: #00695c;
    transform: translateY(-2px);
}

.notif-content {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.notif-item {
    background: white;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    gap: 20px;
    align-items: flex-start;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    position: relative;
}

.notif-item.unread {
    background: #e8f5e9;
    border-left: 4px solid #4CAF50;
}

.notif-item:hover {
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    transform: translateY(-2px);
}

.notif-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5em;
    flex-shrink: 0;
}

.notif-icon.success {
    background: #c8e6c9;
    color: #2e7d32;
}

.notif-icon.warning {
    background: #fff3e0;
    color: #f57c00;
}

.notif-icon.danger {
    background: #ffcdd2;
    color: #c62828;
}

.notif-icon.info {
    background: #e3f2fd;
    color: #1976d2;
}

.notif-content-text {
    flex: 1;
}

.notif-content-text h3 {
    font-size: 1.1em;
    color: #212121;
    margin-bottom: 8px;
    font-weight: 700;
}

.notif-content-text p {
    color: #666;
    line-height: 1.6;
    margin-bottom: 10px;
}

.notif-time {
    color: #999;
    font-size: 0.85em;
    display: flex;
    align-items: center;
    gap: 5px;
}

.btn-mark-read {
    width: 35px;
    height: 35px;
    background: #00897b;
    color: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.btn-mark-read:hover {
    background: #00695c;
    transform: scale(1.1);
}

.empty-state {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 16px;
}

.empty-state i {
    font-size: 60px;
    color: #e0e0e0;
    margin-bottom: 20px;
}

.empty-state h3 {
    font-size: 1.5em;
    color: #666;
    margin-bottom: 10px;
}

.empty-state p {
    color: #999;
}

.pagination-wrapper {
    margin-top: 30px;
    display: flex;
    justify-content: center;
}

@media (max-width: 768px) {
    .notif-header {
        padding: 20px;
    }

    .notif-header h1 {
        font-size: 1.5em;
    }

    .btn-mark-all {
        position: static;
        width: 100%;
        margin-top: 15px;
    }

    .notif-item {
        padding: 15px;
        gap: 15px;
    }
}
</style>

<script>
function markAsRead(id) {
    fetch(`/notifikasi/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const item = document.querySelector(`[data-id="${id}"]`);
            item.classList.remove('unread');
            item.querySelector('.btn-mark-read').remove();
            location.reload();
        }
    });
}

function markAllAsRead() {
    fetch('/notifikasi/read-all', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>
@endsection