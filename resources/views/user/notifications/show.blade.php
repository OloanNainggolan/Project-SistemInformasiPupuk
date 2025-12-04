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
                    <div class="sender-avatar {{ $message->sender_type === 'admin' ? 'admin' : 'user' }}">
                        @if($message->sender_type === 'admin')
                            A
                        @else
                            {{ strtoupper(substr($message->user->name ?? 'U', 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div class="sender-name">
                            {{ $message->sender_type === 'admin' ? 'Admin' : $message->user->name }}
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
                    <div class="sender-avatar {{ $reply->sender_type === 'admin' ? 'admin' : 'user' }}">
                        @if($reply->sender_type === 'admin')
                            A
                        @else
                            {{ strtoupper(substr($reply->user->name ?? 'U', 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <div class="sender-name">
                            {{ $reply->sender_type === 'admin' ? 'Admin' : $reply->user->name }}
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
