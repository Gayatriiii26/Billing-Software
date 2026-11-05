@echo off

cd /d C:\xampp

start "" xampp-control.exe

timeout /t 8 /nobreak >nul

start "" http://localhost/tiles-billing-system

exit