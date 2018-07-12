:: Why? because windows can't do an OR within the conditional
IF NOT DEFINED API_KEY GOTO defkeysecret
IF NOT DEFINED API_SECRET GOTO defkeysecret
GOTO skipdef

:defkeysecret

SET API_KEY= 45342972
SET API_SECRET= 802ad098cc7d3386c08a8461f5435d2f88121fc5

:skipdef

RD /q /s cache

php.exe -S localhost -t web web/index.php
