@extends('layouts.admin')

@section('title', 'Detail Pesan')

@section('content')
<div class="message-detail-container">
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

    <!-- Back Button -->
    <a href="{{ route('admin.notifications.index') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i>
        Kembali ke Daftar Pesan
    </a>

    <!-- Message Thread -->
    <div class="message-thread">
        <!-- Original Message -->
        <div class="thread-message original">
            <div class="message-header">
                <div class="sender-info">
                    <div class="sender-avatar">
                        {{ strtoupper(substr($message->user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <div class="sender-name">{{ $message->user->name ?? 'User' }}</div>
                        <div class="sender-meta">
                            <span><i class="fas fa-phone"></i> {{ $message->user->no_telp ?? '-' }}</span>
                            <span><i class="fas fa-clock"></i> {{ $message->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
                @if($message->status == 'unread')
                <span class="status-badge unread">Belum Dibaca</span>
                @else
                <span class="status-badge read">Sudah Dibaca</span>
                @endif
            </div>

            <div class="message-subject">
                <i class="fas fa-envelope"></i>
                {{ $message->subject }}
            </div>

            <div class="message-body">
                {{ $message->message }}
            </div>

            <div class="message-footer">
                <form action="{{ route('admin.notifications.destroy', $message->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">
                        <i class="fas fa-trash"></i> Hapus Pesan
                    </button>
                </form>
            </div>
        </div>

        <!-- Replies -->
        @foreach($message->replies as $reply)
        <div class="thread-message reply">
            <div class="message-header">
                <div class="sender-info">
                    <div class="sender-avatar admin">
                        A
                    </div>
                    <div>
                        <div class="sender-name">Admin</div>
                        <div class="sender-meta">
                            <span><i class="fas fa-clock"></i> {{ $reply->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
                <span class="status-badge sent">Terkirim</span>
            </div>

            <div class="message-body">
                {{ $reply->message }}
            </div>
        </div>
        @endforeach
    </div>

    <!-- Reply Form -->
    <div class="reply-form-section">
        <h3 class="reply-title">
            <i class="fas fa-reply"></i>
            Balas Pesan
        </h3>

        <form action="{{ route('admin.notifications.reply', $message->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="message">Pesan Balasan</label>
                <textarea 
                    id="message" 
                    name="message" 
                    rows="5" 
                    placeholder="Tulis balasan Anda di sini..."
                    required
                >{{ old('message') }}</textarea>
                @error('message')
                <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i>
                    Kirim Balasan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.message-detail-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
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

/* Back Button */
.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    background: white;
    color: #374151;
    text-decoration: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    transition: all 0.3s ease;
    margin-bottom: 20px;
}

.back-btn:hover {
    background: #f9fafb;
    transform: translateX(-4px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.back-btn i {
    color: #10b981;
}

/* Message Thread */
.message-thread {
    margin-bottom: 24px;
}

.thread-message {
    background: white;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 16px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
}

.thread-message.original {
    border-left: 4px solid #10b981;
}

.thread-message.reply {
    background: #f9fafb;
    margin-left: 40px;
    border-left: 4px solid #6b7280;
}

/* Message Header */
.message-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 16px;
    padding-bottom: 12px;
    border-bottom: 1px solid #e5e7eb;
}

.sender-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.sender-avatar {
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

.sender-avatar.admin {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    box-shadow: 0 3px 10px rgba(99, 102, 241, 0.3);
}

.sender-name {
    font-size: 16px;
    font-weight: 700;
    color: #065f46;
    margin-bottom: 4px;
}

.sender-meta {
    display: flex;
    gap: 16px;
    font-size: 12px;
    color: #6b7280;
}

.sender-meta span {
    display: flex;
    align-items: center;
    gap: 5px;
}

.sender-meta i {
    font-size: 11px;
    color: #10b981;
}

.status-badge {
    padding: 5px 12px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.unread {
    background: #fef3c7;
    color: #92400e;
}

.status-badge.read {
    background: #d1fae5;
    color: #065f46;
}

.status-badge.sent {
    background: #dbeafe;
    color: #1e40af;
}

/* Message Subject */
.message-subject {
    font-size: 18px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.message-subject i {
    color: #10b981;
    font-size: 16px;
}

/* Message Body */
.message-body {
    font-size: 14px;
    color: #374151;
    line-height: 1.7;
    white-space: pre-wrap;
}

/* Message Footer */
.message-footer {
    margin-top: 16px;
    padding-top: 12px;
    border-top: 1px solid #e5e7eb;
}

.btn-delete {
    padding: 8px 14px;
    background: #fee2e2;
    color: #dc2626;
    border: none;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-delete:hover {
    background: #fecaca;
    transform: translateY(-1px);
}

/* Reply Form */
.reply-form-section {
    background: white;
    border-radius: 10px;
    padding: 24px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
}

.reply-title {
    font-size: 18px;
    font-weight: 700;
    color: #065f46;
    margin: 0 0 20px 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.reply-title i {
    color: #10b981;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.form-group textarea {
    width: 100%;
    padding: 12px 14px;
    border: 1.5px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
    resize: vertical;
    transition: all 0.3s ease;
}

.form-group textarea:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.error-text {
    display: block;
    color: #dc2626;
    font-size: 12px;
    margin-top: 6px;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
}

.btn-submit {
    padding: 12px 24px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 3px 10px rgba(16, 185, 129, 0.3);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
}

/* Responsive */
@media (max-width: 768px) {
    .thread-message.reply {
        margin-left: 20px;
    }
    
    .message-header {
        flex-direction: column;
        gap: 12px;
    }
    
    .sender-meta {
        flex-direction: column;
        gap: 4px;
    }
}
</style>
@endsection
