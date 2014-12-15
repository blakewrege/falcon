#########################################################################
# DescribeWorldDB.sql   (a script file)
#
# To run this script file at the mysql> prompt do:
#    source c:/users/donna/documents/mysql/WorldFiles/DescribeWorldDB.sql
#
# To force the inclusion of both the SQL statement AND the resulting
#    table to print to the file, I started up mysql using the -vvv option
#    - in the plain Command Prompt Window, do:
#        mysql -u kaminski -vvv
#########################################################################

tee c:/users/donna/documents/mysql/WorldFiles/WorldDBDescription.txt

print

select user, host from mysql.user;

show databases;
use world;
show tables;
show columns in city;
show columns in country;
show columns in countrylanguage;

notee