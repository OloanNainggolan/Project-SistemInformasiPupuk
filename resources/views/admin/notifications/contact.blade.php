@extends('layouts.admin')

@section('title', 'Detail Kontak')

@section('content')
<div class="contact-detail-container">
    <!-- Back Button -->
    <a href="{{ route('admin.notifications.index') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i>
        Kembali ke Notifikasi
    </a>

    <!-- Contact Card -->
    <div class="contact-card">
        <div class="contact-header">
            <div class="contact-avatar">
                {{ strtoupper(substr($contact->nama, 0, 1)) }}
            </div>
            <div class="contact-info">
                <h2 class="contact-name">{{ $contact->nama }}</h2>
                <div class="contact-meta">
                    <span><i class="fas fa-phone"></i> {{ $contact->no_telp }}</span>
                    <span><i class="fas fa-envelope"></i> {{ $contact->email }}</span>
                    <span><i class="fas fa-clock"></i> {{ $contact->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
            <div class="status-badge {{ $contact->status === 'read' ? 'read' : 'unread' }}">
                <i class="fas fa-{{ $contact->status === 'read' ? 'check-circle' : 'envelope' }}"></i>
                {{ $contact->status === 'read' ? 'Sudah Dibaca' : 'Belum Dibaca' }}
            </div>
        </div>

        <div class="contact-body">
            <div class="message-label">
                <i class="fas fa-comment-dots"></i>
                Pesan
            </div>
            <div class="message-content">
                {{ $contact->pesan }}
            </div>
        </div>

        <div class="contact-footer">
            <div class="footer-info">
                <i class="fas fa-info-circle"></i>
                Kontak ini dikirim oleh pengunjung yang belum terdaftar sebagai user.
            </div>
            <div class="footer-actions">
                <a href="tel:{{ $contact->no_telp }}" class="btn-action btn-phone">
                    <i class="fas fa-phone"></i>
                    Hubungi via Telepon
                </a>
                <a href="mailto:{{ $contact->email }}" class="btn-action btn-email">
                    <i class="fas fa-envelope"></i>
                    Kirim Email
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.contact-detail-container {
    max-width: 900px;
    margin: 0 auto;
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

/* Contact Card */
.contact-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    overflow: hidden;
}

.contact-header {
    padding: 30px;
    background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
    color: white;
    display: flex;
    align-items: center;
    gap: 20px;
}

.contact-avatar {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: 700;
    border: 4px solid rgba(255, 255, 255, 0.5);
}

.contact-info {
    flex: 1;
}

.contact-name {
    font-size: 24px;
    font-weight: 700;
    margin: 0 0 12px 0;
}

.contact-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 16px;
    font-size: 14px;
    opacity: 0.95;
}

.contact-meta span {
    display: flex;
    align-items: center;
    gap: 6px;
}

.contact-meta i {
    font-size: 13px;
}

.status-badge {
    padding: 10px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
    backdrop-filter: blur(10px);
}

.status-badge.read {
    background: rgba(255, 255, 255, 0.3);
}

.status-badge.unread {
    background: rgba(251, 191, 36, 0.3);
}

/* Contact Body */
.contact-body {
    padding: 30px;
}

.message-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 700;
    color: #065f46;
    margin-bottom: 16px;
}

.message-label i {
    color: #ec4899;
}

.message-content {
    font-size: 15px;
    color: #374151;
    line-height: 1.8;
    white-space: pre-wrap;
    padding: 20px;
    background: #f9fafb;
    border-left: 4px solid #ec4899;
    border-radius: 8px;
}

/* Contact Footer */
.contact-footer {
    padding: 24px 30px;
    background: #f9fafb;
    border-top: 1px solid #e5e7eb;
}

.footer-info {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 16px;
    background: #fef3c7;
    border-left: 4px solid #f59e0b;
    border-radius: 6px;
    font-size: 13px;
    color: #92400e;
    margin-bottom: 20px;
}

.footer-info i {
    color: #f59e0b;
}

.footer-actions {
    display: flex;
    gap: 12px;
}

.btn-action {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 20px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-phone {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    box-shadow: 0 3px 10px rgba(16, 185, 129, 0.3);
}

.btn-phone:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
}

.btn-email {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    box-shadow: 0 3px 10px rgba(59, 130, 246, 0.3);
}

.btn-email:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(59, 130, 246, 0.4);
}

/* Responsive */
@media (max-width: 768px) {
    .contact-header {
        flex-direction: column;
        text-align: center;
    }
    
    .contact-meta {
        flex-direction: column;
        gap: 8px;
    }
    
    .footer-actions {
        flex-direction: column;
    }
}
</style>
@endsection
