Set shell = CreateObject("WScript.Shell")

shell.Run """C:\laragon\bin\php\php-8.4.6-Win32-vs17-x64\php.exe"" ""artisan"" schedule:run", 0, True
