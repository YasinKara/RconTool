@echo off
TITLE RCON TOOL
cd /d %~dp0

if exist bin\php\php.exe (
    set PHPRC=""
    set PHP_BINARY="bin\php\php.exe"
) else (
    set PHP_BINARY="php"
)

if exist src\YasinK\Starter.php (
    set RUNNER_FILE="src\YasinK\Starter.php"
) else (
    echo We can't find starter!
    pause
    exit 1
)

%PHP_BINARY% -c bin\php %RUNNER_FILE% %* || pause