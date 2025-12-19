#!/bin/bash
# ==============================================
# Fix Laravel Hosting Permissions - 403 Error
# ==============================================

echo "🔧 Fixing Laravel permissions for hosting..."
echo ""

# Set correct permissions untuk folder Laravel
echo "📁 Setting folder permissions..."
find . -type d -exec chmod 755 {} \;

echo "📄 Setting file permissions..."
find . -type f -exec chmod 644 {} \;

# Storage dan cache WAJIB writable
echo "🔓 Making storage & cache writable..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Executable untuk artisan
echo "⚡ Making artisan executable..."
chmod 755 artisan

# Symlink storage jika belum
echo "🔗 Creating storage symlink..."
php artisan storage:link 2>/dev/null || echo "Storage link already exists"

# Clear all cache
echo "🧹 Clearing cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan optimize

echo ""
echo "✅ Permissions fixed! Structure:"
echo "   - Folders: 755 (drwxr-xr-x)"
echo "   - Files: 644 (-rw-r--r--)"
echo "   - Storage: 775 (drwxrwxr-x)"
echo "   - bootstrap/cache: 775 (drwxrwxr-x)"
echo ""
echo "🌐 Make sure Document Root points to: public/"
echo ""
