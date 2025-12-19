#!/bin/bash

# ============================================
# Laravel Production Deployment Script
# ============================================

echo "🚀 Starting Laravel Production Deployment..."
echo ""

# 1. Check if .env exists
if [ ! -f .env ]; then
    echo "❌ ERROR: .env file not found!"
    echo "📝 Creating .env from .env.example..."
    cp .env.example .env
    echo "✅ .env created. Please edit it with production credentials!"
    echo ""
fi

# 2. Install Composer dependencies
echo "📦 Installing Composer dependencies..."
if command -v composer &> /dev/null; then
    composer install --optimize-autoloader --no-dev
    echo "✅ Composer dependencies installed"
else
    echo "⚠️  Composer not found. Please install manually."
fi
echo ""

# 3. Generate APP_KEY if not set
echo "🔐 Checking APP_KEY..."
if grep -q "APP_KEY=$" .env || grep -q "APP_KEY=\"\"" .env; then
    echo "🔑 Generating APP_KEY..."
    php artisan key:generate
    echo "✅ APP_KEY generated"
else
    echo "✅ APP_KEY already set"
fi
echo ""

# 4. Set proper permissions
echo "🔒 Setting directory permissions..."
chmod -R 775 storage
chmod -R 775 bootstrap/cache
chmod -R 775 public/images
echo "✅ Permissions set"
echo ""

# 5. Clear all caches
echo "🧹 Clearing all caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
echo "✅ Caches cleared"
echo ""

# 6. Run migrations
echo "📊 Running database migrations..."
read -p "Run migrations? This will modify your database (y/N): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan migrate --force
    echo "✅ Migrations completed"
else
    echo "⏭️  Skipped migrations"
fi
echo ""

# 7. Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link
echo "✅ Storage link created"
echo ""

# 8. Cache for production
echo "⚡ Caching for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✅ Production caches created"
echo ""

# 9. Optimize autoloader
echo "🔧 Optimizing autoloader..."
composer dump-autoload --optimize
echo "✅ Autoloader optimized"
echo ""

# 10. Check critical files
echo "✅ Checking critical files..."
if [ ! -f public/.htaccess ]; then
    echo "⚠️  WARNING: public/.htaccess not found!"
fi

if [ ! -f public/index.php ]; then
    echo "❌ ERROR: public/index.php not found!"
fi

if [ ! -d storage/framework/sessions ]; then
    echo "📁 Creating sessions directory..."
    mkdir -p storage/framework/sessions
fi

if [ ! -d storage/framework/views ]; then
    echo "📁 Creating views directory..."
    mkdir -p storage/framework/views
fi

if [ ! -d storage/framework/cache ]; then
    echo "📁 Creating cache directory..."
    mkdir -p storage/framework/cache
fi

if [ ! -d storage/logs ]; then
    echo "📁 Creating logs directory..."
    mkdir -p storage/logs
fi

echo "✅ Critical files check completed"
echo ""

# 11. Final checks
echo "🔍 Running final checks..."
php artisan about
echo ""

echo "============================================"
echo "✅ Deployment Complete!"
echo "============================================"
echo ""
echo "📋 Next Steps:"
echo "1. Edit .env with production credentials"
echo "2. Set APP_ENV=production"
echo "3. Set APP_DEBUG=false"
echo "4. Configure database credentials"
echo "5. Point web server document root to /public"
echo "6. Enable HTTPS (SSL certificate)"
echo "7. Test all features"
echo ""
echo "📞 If you encounter issues, check:"
echo "   - storage/logs/laravel.log"
echo "   - Web server error logs"
echo "   - PHP error logs"
echo ""
