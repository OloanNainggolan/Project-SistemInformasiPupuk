@extends('layouts.user')

@section('title', 'Detail Pesan')

@section('content')
<div class="message-detail-container">
    <!-- Back Button -->
    <a href="{{ route('notifikasi') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i>
        Kembali ke Notifikasi
    </a>

    <!-- Message Thread -->
    <div class="message-thread">
        <!-- Original Message -->
        <div class="thread-message original">
            <div class="message-header">
                <div class="sender-info">
                    @if($message->sender_type === 'admin')
                        <img src="{{ asset('images/admin-avatar.png') }}" alt="Admin" class="sender-avatar-img admin" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="sender-avatar admin" style="display:none;">A</div>
                    @else
                        @if($message->user && $message->user->photo_profile)
                            <img src="{{ asset('images/profiles/' . $message->user->photo_profile) }}" alt="{{ $message->user->name }}" class="sender-avatar-img user" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        @endif
                        <div class="sender-avatar user" style="{{ $message->user && $message->user->photo_profile ? 'display:none;' : '' }}">
                            {{ strtoupper(substr($message->user->name ?? 'U', 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <div class="sender-name">
                            {{ $message->sender_type === 'admin' ? 'Admin' : 'Anda' }}
                            <span class="sender-badge {{ $message->sender_type }}">
                                {{ $message->sender_type === 'admin' ? 'Pengirim' : 'Anda' }}
                            </span>
                        </div>
                        <div class="sender-meta">
                            @if($message->sender_type !== 'admin')
                            <span><i class="fas fa-phone"></i> {{ $message->user->no_telp ?? '-' }}</span>
                            @endif
                            <span><i class="fas fa-clock"></i> {{ $message->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="message-subject">
                <i class="fas fa-envelope"></i>
                {{ $message->subject }}
            </div>

            <div class="message-body">
                {{ $message->message }}
            </div>
        </div>

        <!-- Replies -->
        @foreach($message->replies as $reply)
        <div class="thread-message reply">
            <div class="message-header">
                <div class="sender-info">
                    @if($reply->sender_type === 'admin')
                        <img src="{{ asset('images/admin-avatar.png') }}" alt="Admin" class="sender-avatar-img admin" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="sender-avatar admin" style="display:none;">A</div>
                    @else
                        @if($reply->user && $reply->user->photo_profile)
                            <img src="{{ asset('images/profiles/' . $reply->user->photo_profile) }}" alt="{{ $reply->user->name }}" class="sender-avatar-img user" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        @endif
                        <div class="sender-avatar user" style="{{ $reply->user && $reply->user->photo_profile ? 'display:none;' : '' }}">
                            {{ strtoupper(substr($reply->user->name ?? 'U', 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <div class="sender-name">
                            {{ $reply->sender_type === 'admin' ? 'Admin' : 'Anda' }}
                            <span class="sender-badge {{ $reply->sender_type }}">
                                {{ $reply->sender_type === 'admin' ? 'Pengirim' : 'Anda' }}
                            </span>
                        </div>
                        <div class="sender-meta">
                            <span><i class="fas fa-clock"></i> {{ $reply->created_at->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="message-body">
                {{ $reply->message }}
            </div>
        </div>
        @endforeach
    </div>

    <!-- Reply Form -->
    <div class="reply-form-container">
        <h3 class="reply-title">
            <i class="fas fa-reply"></i>
            Balas Pesan
        </h3>
        
        @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif
        
        <form action="{{ route('notifikasi.reply', $message->id) }}" method="POST" class="reply-form">
            @csrf
            <div class="form-group">
                <label for="replyMessage">Pesan Anda</label>
                <textarea 
                    name="message" 
                    id="replyMessage" 
                    rows="5" 
                    class="form-control @error('message') is-invalid @enderror" 
                    placeholder="Tulis balasan Anda di sini..."
                    required>{{ old('message') }}</textarea>
                @error('message')
                    <div class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i>
                    Kirim Balasan
                </button>
                <button type="button" class="btn-cancel" onclick="document.getElementById('replyMessage').value = '';">
                    <i class="fas fa-eraser"></i>
                    Bersihkan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.message-detail-container {
    max-width: 900px;
    margin: 40px auto;
    padding: 0 20px;
}

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
    border-left: 4px solid #6366f1;
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
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 18px;
    flex-shrink: 0;
}

.sender-avatar-img {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
}

.sender-avatar-img.user {
    border: 3px solid #10b981;
    box-shadow: 0 3px 10px rgba(16, 185, 129, 0.3);
}

.sender-avatar-img.admin {
    border: 3px solid #6366f1;
    box-shadow: 0 3px 10px rgba(99, 102, 241, 0.3);
}

.sender-avatar.user {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
    display: flex;
    align-items: center;
    gap: 8px;
}

.sender-badge {
    font-size: 11px;
    font-weight: 600;
    padding: 3px 10px;
    border-radius: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.sender-badge.admin {
    background: linear-gradient(135deg, #eef2ff, #ddd6fe);
    color: #6366f1;
    border: 1px solid #c7d2fe;
}

.sender-badge.user {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    color: #059669;
    border: 1px solid #6ee7b7;
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

/* Reply Form */
.reply-form-container {
    background: white;
    border-radius: 10px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border-left: 4px solid #10b981;
}

.reply-title {
    font-size: 18px;
    font-weight: 700;
    color: #065f46;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.reply-title i {
    color: #10b981;
    font-size: 16px;
}

.alert-success {
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    border: 2px solid #10b981;
    color: #065f46;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    font-weight: 600;
}

.alert-success i {
    color: #10b981;
    font-size: 18px;
}

.reply-form .form-group {
    margin-bottom: 20px;
}

.reply-form label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.reply-form .form-control {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    font-family: inherit;
    color: #1f2937;
    transition: all 0.3s ease;
    resize: vertical;
}

.reply-form .form-control:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.reply-form .form-control.is-invalid {
    border-color: #ef4444;
}

.invalid-feedback {
    display: block;
    margin-top: 6px;
    font-size: 13px;
    color: #ef4444;
}

.invalid-feedback i {
    margin-right: 4px;
}

.form-actions {
    display: flex;
    gap: 12px;
    align-items: center;
}

.btn-submit {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    padding: 12px 28px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
}

.btn-submit:active {
    transform: translateY(0);
}

.btn-cancel {
    background: #f3f4f6;
    color: #6b7280;
    border: 2px solid #e5e7eb;
    padding: 12px 24px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-cancel:hover {
    background: #e5e7eb;
    border-color: #d1d5db;
    color: #374151;
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
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn-submit, .btn-cancel {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection
