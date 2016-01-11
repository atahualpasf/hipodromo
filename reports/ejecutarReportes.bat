echo off
SET FILENAME=%1
jasperstarter pr %FILENAME% -f pdf -o pdf/%FILENAME% @conf/db.conf