
@echo off

rem Define variables
set SERVER_PATH=%cd%\server
set CLIENT_PATH=%cd%\client

rem Log paths
echo Current working directory: %cd%
echo Server path: %SERVER_PATH%
echo Client path: %CLIENT_PATH%
where php

rem Targets
call :check_composer || exit /b 1
call :install_composer_packages || exit /b 1
call :check_env || exit /b 1
call :update_env || exit /b 1
call :run_migrations || exit /b 1
call :serve || exit /b 1
call :check_client_deps || exit /b 1
call :install_client_deps || exit /b 1
call :serve_client || exit /b 1
goto :eof

:check_composer
rem Check if composer is installed
where composer >nul 2>nul
if %errorlevel% neq 0 (
    echo ERROR: Composer is not installed.
    exit /b 1
)
exit /b 0

:install_composer_packages
rem Install PHP dependencies
cd %SERVER_PATH%
composer install || exit /b 1
cd ..
exit /b 0

:check_env
rem Check if .env exists
cd %SERVER_PATH%
if not exist "%SERVER_PATH%"\.env (
    copy "%SERVER_PATH%"\.env.example "%SERVER_PATH%"\.env
)
cd ..
exit /b 0

:update_env
rem Update .env with current path
set DB_DATABASE=%SERVER_PATH%\database\database.sqlite
call :replace_str "%SERVER_PATH%\.env" "DB_DATABASE" "%DB_DATABASE%"
exit /b 0


:replace_str
rem Replace key=value pair in a .env file
setlocal enabledelayedexpansion

set "file=%~1"
set "search=%~2"
set "replace=%~3"
set "tempfile=%file%.tmp"

rem Ensure input file exists
if not exist "%file%" (
    echo ERROR: The file "%file%" does not exist.
    endlocal
    exit /b 1
)

rem Debug: Display search and replace
echo Replacing "%search%" with "%replace%" in "%file%".

rem Replace line by line
(for /f "usebackq tokens=1* delims==" %%a in ("%file%") do (
    if "%%a"=="%search%" (
        echo %%a=%replace%
    ) else (
        echo %%a=%%b
    )
)) > "%tempfile%"

rem Replace original file with updated content
if exist "%tempfile%" (
    move /y "%tempfile%" "%file%" > nul
    echo Update complete.
    endlocal
    exit /b 0
) else (
    echo ERROR: Temporary file creation failed.
    endlocal
    exit /b 1
)

:run_migrations
rem Navigate to the server path
cd %SERVER_PATH%

rem Run Laravel commands
php artisan migrate:rollback || exit /b 1
php artisan migrate || exit /b 1
php artisan make:seeder DatabaseSeeder || exit /b 1
php artisan db:seed || exit /b 1

rem Navigate back to the previous directory
cd ..
exit /b 0

:serve
rem Start PHP server
cd %SERVER_PATH%
start php artisan serve --port 3000 || exit /b 1
cd ..
exit /b 0

:check_client_deps
rem Check if npm is installed
where npm >nul 2>nul
if %errorlevel% neq 0 (
    echo ERROR: npm is not installed.
    exit /b 1
)
exit /b 0

:install_client_deps
rem Install client dependencies
cd %CLIENT_PATH%
npm install || exit /b 1
cd ..
exit /b 0

:serve_client
rem Serve client
cd %CLIENT_PATH%
npm run dev || exit /b 1
cd ..
exit /b 0
