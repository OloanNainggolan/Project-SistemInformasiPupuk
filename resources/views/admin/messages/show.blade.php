@extends('layouts.admin')

@section('title', 'Detail Pesan')

@section('content')
<div class="message-detail-container">
    <div class="page-header">
        <a href="{{ route('admin.messages.inbox') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Inbox</span>
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="message-thread">
        <!-- Original Message -->
        <div class="thread-card">
            <div class="thread-header">
                <div class="sender-info">
                    <div class="sender-avatar">
                        {{ strtoupper(substr($message->user->nama_lengkap ?? 'U', 0, 1)) }}
                    </div>
                    <div class="sender-details">
                        <h3 class="sender-name">{{ $message->user->nama_lengkap ?? 'User' }}</h3>
                        <p class="sender-email">{{ $message->user->email ?? '-' }}</p>
                    </div>
                </div>
                <div class="message-time">
                    <i class="far fa-clock"></i>
                    {{ $message->created_at->format('d M Y, H:i') }}
                </div>
            </div>

            <div class="thread-body">
                <h2 class="message-subject">{{ $message->title ?? 'Pesan dari User' }}</h2>
                <div class="message-text">
                    {{ $message->message }}
                </div>
            </div>
        </div>

        <!-- Replies -->
        @if($message->replies && $message->replies->count() > 0)
        <div class="replies-section">
            <h3 class="replies-title">
                <i class="fas fa-comments"></i>
                Balasan ({{ $message->replies->count() }})
            </h3>

            @foreach($message->replies as $reply)
            <div class="thread-card reply-card {{ $reply->sender_type == 'admin' ? 'admin-reply' : '' }}">
                <div class="thread-header">
                    <div class="sender-info">
                        <div class="sender-avatar {{ $reply->sender_type == 'admin' ? 'admin-avatar' : '' }}">
                            @if($reply->sender_type == 'admin')
                                <i class="fas fa-user-shield"></i>
                            @else
                                {{ strtoupper(substr($reply->user->nama_lengkap ?? 'U', 0, 1)) }}
                            @endif
                        </div>
                        <div class="sender-details">
                            <h4 class="sender-name">
                                @if($reply->sender_type == 'admin')
                                    <span class="admin-badge">
                                        <i class="fas fa-shield-alt"></i>
                                        Admin
                                    </span>
                                @else
                                    {{ $reply->user->nama_lengkap ?? 'User' }}
                                @endif
                            </h4>
                        </div>
                    </div>
                    <div class="message-time">
                        <i class="far fa-clock"></i>
                        {{ $reply->created_at->format('d M Y, H:i') }}
                    </div>
                </div>

                <div class="thread-body">
                    <div class="message-text">
                        {{ $reply->message }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Reply Form -->
        <div class="reply-form-card">
            <h3 class="form-title">
                <i class="fas fa-reply"></i>
                Balas Pesan
            </h3>

            <form action="{{ route('admin.messages.reply', $message->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="message" class="form-textarea" rows="5" 
                              placeholder="Tulis balasan Anda..." required></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i>
                        Kirim Balasan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.message-detail-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 24px;
}

.page-header {
    margin-bottom: 24px;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    color: #374151;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-back:hover {
    background: #f3f4f6;
    border-color: #10b981;
    color: #10b981;
    transform: translateX(-4px);
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

.message-thread {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.thread-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    overflow: hidden;
}

.reply-card {
    margin-left: 40px;
}

.admin-reply {
    background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
    border-left: 4px solid #10b981;
}

.thread-header {
    padding: 20px 24px;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.sender-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.sender-avatar {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 18px;
    font-weight: 700;
}

.admin-avatar {
    background: linear-gradient(135deg, #10b981, #059669);
}

.sender-details {
    flex: 1;
}

.sender-name {
    font-size: 16px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 2px 0;
}

.sender-email {
    font-size: 13px;
    color: #666;
    margin: 0;
}

.admin-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border-radius: 6px;
    font-size: 13px;
}

.message-time {
    font-size: 12px;
    color: #666;
    display: flex;
    align-items: center;
    gap: 4px;
}

.thread-body {
    padding: 24px;
}

.message-subject {
    font-size: 20px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 16px 0;
}

.message-text {
    font-size: 14px;
    line-height: 1.8;
    color: #374151;
    white-space: pre-wrap;
}

.replies-section {
    margin-top: 16px;
}

.replies-title {
    font-size: 16px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 16px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.replies-title i {
    color: #10b981;
}

.reply-form-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    margin-top: 24px;
}

.form-title {
    font-size: 16px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0 0 16px 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.form-title i {
    color: #10b981;
}

.form-group {
    margin-bottom: 16px;
}

.form-textarea {
    width: 100%;
    padding: 14px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    font-family: inherit;
    line-height: 1.6;
    resize: vertical;
    transition: all 0.3s;
}

.form-textarea:focus {
    outline: none;
    border-color: #10b981;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.form-actions {
    display: flex;
    justify-content: flex-end;
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);
}

@media (max-width: 768px) {
    .reply-card {
        margin-left: 20px;
    }

    .thread-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
}
</style>
@endsection
