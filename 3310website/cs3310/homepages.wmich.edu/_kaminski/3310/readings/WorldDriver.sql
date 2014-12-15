##############################################################################
# WorldDriver.sql   (a script file)
# 
# Fix the paths to correspond to where YOU are storing the files.
# The source command requests that SQL commands are to be read from the file.
#
# To run this script file at the mysql> prompt do:
#   source c:/users/donna/documents/mysql/WorldFiles/WorldDriver.sql
##############################################################################

source c:/users/donna/documents/mysql/WorldFiles/CreateWorldDB.sql

source c:/users/donna/documents/mysql/WorldFiles/InsertCountryData.sql
source c:/users/donna/documents/mysql/WorldFiles/InsertCountryLanguageData.sql
source c:/users/donna/documents/mysql/WorldFiles/InsertCityData.sql

