###################################################################################
# MusicDriver.sql   (a script file)
# 
# To run this script in MySQL at the mysql> prompt I did:
# source c:/documents and settings/kaminski/my documents/mysql/MusicFiles/MusicDriver.sql
#
# Before YOU run this example, fix all the paths to correspond to where YOU are
#	storing the files.  [Fix 4 paths below and the path in LoadCdData.sql].
# 
# OR
# Store all the files on your DESKTOP and run it from there.
# 1) Move the files to the desktop including:
#	- this driver script file
#	- the 3 script files used below
#	- the data file which LoadCdData uses, RawCdData.csv
# 2) Remove the paths:
#	- from the 4 files below
# 	- from LoadCdData.sql script file (for where its data file is)
# 3) Once you start MySQL, at the mysql> prompt do:
#	cd desktop
# 4) To run this script file just do:
#	source MusicDriver.sql
#
# NOTE:  The tee command makes the screen RESULTS echo to the specified file.
#        The notee command turns the tee option off.
#
# NOTE:  The source command causes the SQL command to be read from the file.
#	 \. is the same as the source command
###################################################################################

tee c:/documents and settings/kaminski/my documents/mysql/MusicFiles/MusicLogFile.txt

source c:/documents and settings/kaminski/my documents/mysql/MusicFiles/CreateMusicDB.sql

source c:/documents and settings/kaminski/my documents/mysql/MusicFiles/InsertCdData.sql

source c:/documents and settings/kaminski/my documents/mysql/MusicFiles/LoadCdData.sql

notee
