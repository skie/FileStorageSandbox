@echo off
SET app=%0
SET app1=%CD%
REM cd ..\cakephp\lib\Cake\Console
SET lib=..\lib\Cake\Console
 echo "%lib%\cake.php" -working "%app1%"  %*

php -q "%lib%\cake.php" -working "%app1%"  %*
:: echo.
REM cd %app1%
@echo on
