###################################################################################
# LoadCdData.sql   (a script file)
#
# This is an ALTERNATIVE way to populate the cds table with data
#     (in the music database) RATHER than a script file with a series of INSERT's.
# This uses the LOAD DATA command, where raw data is stored in a plain "CSV"
#     (Comma-Separated-Values) TEXT file.
#
# This first DELETEs any data from the table since the overall project demo
#     (step 3 in the README file) already INSERTed data.
# This then displays the data in the table.
#
# ASSUMPTION:  This script file assumes that:
#     - the database and the cds table were already created
#     - the USE Music; command was already issued
#
# NOTE:  Change the path below to match where YOUR data file is stored on YOUR
#     computer.
#
# NOTE:  On Linux/Unix, change the line-termination to '\n' (that is, just <LF>)
#     since that's likely what your RawCdData.csv file looks like (depending on
#     the file transfer settings) for downloading MY data file.
#     [You can check it using the od command (Octal Dump) on Linux/Unix, which is
#     like a HexEditor on Windows].
###################################################################################

DELETE FROM cds;

LOAD DATA
  INFILE
  'c:/documents and settings/kaminski/my documents/mysql/MusicFiles/RawCdData.csv'
  INTO TABLE cds
  FIELDS TERMINATED BY ','
	OPTIONALLY ENCLOSED BY '\''	# strings as 'hello' or hello
  LINES TERMINATED BY '\r\n'		# that's <CR><LF>
  IGNORE 24 LINES;			# top 24 lines of data file
					#   skipped (comments or not)


-- Check what data actually got stored in the table.

SELECT * FROM cds;