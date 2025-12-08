@extends('layouts.admin')

@section('title', 'Notifikasi & Pesan Kontak')

@push('styles')
<style>
    :root {
        --green-dark: #065f46;
        --green: #059669;
        --green-light: #10b981;
        --mint: #ecfdf5;
    }

    .notification-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px;
    }

    /* Page Header */
    .page-header {
        margin-bottom: 30px;
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        background: linear-gradient(135deg, var(--green-dark) 0%, var(--green) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 5px;
    }

    .page-title i {
        font-size: 32px;
        background: linear-gradient(135deg, var(--green) 0%, var(--green-light) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .page-subtitle {
        color: #6b7280;
        font-size: 14px;
    }

    /* Tabs */
    .tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 25px;
        border-bottom: 2px solid #e5e7eb;
        padding-bottom: 0;
    }

    .tab-button {
        padding: 12px 24px;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        font-weight: 600;
        font-size: 14px;
        color: #6b7280;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        position: relative;
        margin-bottom: -2px;
    }

    .tab-button:hover {
        color: var(--green);
    }

    .tab-button.active {
        color: var(--green-dark);
        border-bottom-color: var(--green);
    }

    .tab-badge {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        padding: 3px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 700;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Contact Messages */
    .contact-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border-left: 4px solid transparent;
        transition: all 0.3s ease;
    }

    .contact-card.unread {
        border-left-color: var(--green);
        background: linear-gradient(to right, var(--mint) 0%, white 100%);
    }

    .contact-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .contact-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
    }

    .contact-sender {
        flex: 1;
    }

    .contact-name {
        font-size: 16px;
        font-weight: 700;
        color: var(--green-dark);
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .contact-badge {
        background: linear-gradient(135deg, var(--green), var(--green-light));
        color: white;
        padding: 3px 10px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
    }

    .contact-meta {
        display: flex;
        gap: 16px;
        font-size: 13px;
        color: #6b7280;
    }

    .contact-meta i {
        margin-right: 4px;
        color: var(--green);
    }

    .contact-time {
        font-size: 12px;
        color: #9ca3af;
    }

    .contact-message {
        background: #f9fafb;
        padding: 14px;
        border-radius: 8px;
        font-size: 14px;
        line-height: 1.6;
        color: #374151;
        margin-bottom: 12px;
    }

    .contact-actions {
        display: flex;
        gap: 10px;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-mark-read {
        background: linear-gradient(135deg, var(--green), var(--green-light));
        color: white;
    }

    .btn-mark-read:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
    }

    .btn-delete {
        background: linear-gradient(135deg, #ef4444, #f87171);
        color: white;
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .empty-state i {
        font-size: 60px;
        color: #d1d5db;
        margin-bottom: 16px;
    }

    .empty-state h3 {
        font-size: 18px;
        color: #6b7280;
        margin-bottom: 8px;
    }

    .empty-state p {
        font-size: 14px;
        color: #9ca3af;
    }

    /* Alert */
    .alert-success {
        padding: 16px 20px;
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border: 2px solid var(--green-light);
        border-radius: 12px;
        color: var(--green-dark);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
    }

    .alert-success i {
        font-size: 20px;
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 30px;
    }

    .pagination a,
    .pagination span {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        color: #6b7280;
        background: white;
        border: 2px solid #e5e7eb;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .pagination a:hover {
        background: var(--mint);
        border-color: var(--green);
        color: var(--green-dark);
    }

    .pagination .active {
        background: linear-gradient(135deg, var(--green), var(--green-light));
        color: white;
        border-color: var(--green);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .notification-container {
            padding: 16px;
        }
        
        .page-title {
            font-size: 24px;
        }
        
        .tabs {
            overflow-x: auto;
        }
        
        .contact-meta {
            flex-direction: column;
            gap: 8px;
        }
        
        .contact-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="notification-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-bell"></i>
            Notifikasi & Pesan Kontak
        </h1>
        <p class="page-subtitle">Kelola notifikasi dan pesan dari petani</p>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
    <div class="alert-success">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Tabs -->
    <div class="tabs">
        <button class="tab-button active" onclick="switchTab('contacts')">
            <i class="fas fa-envelope"></i>
            Pesan Kontak
            @if($unreadContactsCount > 0)
                <span class="tab-badge">{{ $unreadContactsCount }}</span>
            @endif
        </button>
        <button class="tab-button" onclick="switchTab('notifications')">
            <i class="fas fa-bell"></i>
            Semua Notifikasi
            @if($unreadCount > 0)
                <span class="tab-badge">{{ $unreadCount }}</span>
            @endif
        </button>
    </div>

    <!-- Contacts Tab -->
    <div id="tab-contacts" class="tab-content active">
        @forelse($contacts as $contact)
        <div class="contact-card {{ $contact->status === 'unread' ? 'unread' : '' }}">
            <div class="contact-header">
                <div class="contact-sender">
                    <div class="contact-name">
                        <i class="fas fa-user-circle"></i>
                        {{ $contact->nama }}
                        @if($contact->status === 'unread')
                            <span class="contact-badge">Baru</span>
                        @endif
                    </div>
                    <div class="contact-meta">
                        <span><i class="fas fa-phone"></i>{{ $contact->no_telp }}</span>
                        <span><i class="fas fa-envelope"></i>{{ $contact->email }}</span>
                    </div>
                </div>
                <div class="contact-time">
                    <i class="fas fa-clock"></i> {{ $contact->created_at->diffForHumans() }}
                </div>
            </div>
            
            <div class="contact-message">
                {{ $contact->pesan }}
            </div>

            <div class="contact-actions">
                @if($contact->status === 'unread')
                <form action="{{ route('admin.contact.mark-read', $contact->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-mark-read">
                        <i class="fas fa-check"></i> Tandai Sudah Dibaca
                    </button>
                </form>
                @endif
                
                <form action="{{ route('admin.contact.delete', $contact->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <h3>Belum Ada Pesan</h3>
            <p>Pesan dari petani akan muncul di sini</p>
        </div>
        @endforelse

        @if($contacts->hasPages())
        <div class="pagination">
            {{ $contacts->links() }}
        </div>
        @endif
    </div>

    <!-- Notifications Tab -->
    <div id="tab-notifications" class="tab-content">
        @forelse($notifications as $notification)
        <div class="contact-card {{ $notification->status === 'unread' ? 'unread' : '' }}">
            <div class="contact-header">
                <div class="contact-sender">
                    <div class="contact-name">
                        <i class="fas fa-{{ $notification->type === 'contact' ? 'envelope' : 'bell' }}"></i>
                        {{ $notification->title }}
                        @if($notification->status === 'unread')
                            <span class="contact-badge">Baru</span>
                        @endif
                    </div>
                </div>
                <div class="contact-time">
                    <i class="fas fa-clock"></i> {{ $notification->created_at->diffForHumans() }}
                </div>
            </div>
            
            <div class="contact-message">
                {{ $notification->message }}
            </div>

            <div class="contact-actions">
                @if($notification->status === 'unread')
                <form action="{{ route('admin.notification.mark-read', $notification->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-mark-read">
                        <i class="fas fa-check"></i> Tandai Sudah Dibaca
                    </button>
                </form>
                @endif
            </div>
        </div>
        @empty
        <div class="empty-state">
            <i class="fas fa-bell-slash"></i>
            <h3>Belum Ada Notifikasi</h3>
            <p>Notifikasi sistem akan muncul di sini</p>
        </div>
        @endforelse

        @if($notifications->hasPages())
        <div class="pagination">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function switchTab(tabName) {
        // Hide all tabs
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.remove('active');
        });
        
        // Remove active from all buttons
        document.querySelectorAll('.tab-button').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Show selected tab
        document.getElementById('tab-' + tabName).classList.add('active');
        
        // Add active to clicked button
        event.target.closest('.tab-button').classList.add('active');
    }
</script>
@endpush
