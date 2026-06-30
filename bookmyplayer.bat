@echo off
title BookMyPlayer - Laravel Dev Server
cd /d "%~dp0"

REM --- Config ---
set "PEM=%USERPROFILE%\Downloads\new_bmp_13_jan_2025.pem"
set "EC2=ec2-user@ec2-65-2-109-243.ap-south-1.compute.amazonaws.com"

REM --- Make PHP available (XAMPP) for this session ---
if exist "C:\xampp\php\php.exe" set "PATH=C:\xampp\php;%PATH%"

echo ============================================
echo   Starting BookMyPlayer (Laravel)
echo ============================================
echo.

where php >nul 2>nul
if errorlevel 1 (
    echo [error] PHP was not found. Install XAMPP or add PHP to your PATH.
    pause
    exit /b 1
)

REM Install PHP dependencies if missing (needs composer on PATH)
if not exist "vendor\autoload.php" (
    echo [setup] vendor folder missing - running composer install...
    call composer install
)

REM Install node modules if missing
if not exist "node_modules" (
    echo [setup] Installing npm dependencies...
    call npm install
)

REM Create .env and generate app key if missing
if not exist ".env" (
    echo [setup] Creating .env from .env.example...
    copy ".env.example" ".env" >nul
    call php artisan key:generate
)

REM --- Open SSH tunnel to the remote database (local 3307 -> EC2 MySQL 3306) ---
if exist "%PEM%" (
    echo [db] Opening SSH tunnel to remote database...
    start "BMP DB Tunnel" /min ssh -i "%PEM%" -o StrictHostKeyChecking=no -o ServerAliveInterval=60 -N -L 3307:127.0.0.1:3306 %EC2%
    REM give the tunnel a moment to establish
    timeout /t 6 >nul
) else (
    echo [warn] PEM key not found at "%PEM%" - database will be unavailable.
)

echo.
echo [run] Starting server at http://localhost:8000
echo [run] Press Ctrl+C in this window to stop the server.
echo.

REM Open the app in the default browser after the server has time to boot
start "" cmd /c "timeout /t 3 >nul & start http://localhost:8000"

REM Start the Laravel development server (blocks this window)
php artisan serve --host=127.0.0.1 --port=8000
