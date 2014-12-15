###################################################################################
# CreateMusicDB.sql   (a script file)
#
#     Creates the music database & in that DB, it creates 1 table called cds.
#     It then displays the meta-data about the table.
#         ("Meta data" is "data ABOUT the actual data").
###################################################################################

-- Drop the existing music DB (if there is one) including all its tables
--     and any data in those tables.
-- [The "if exists" option stops errors from occurring if no DB with that
--		name exists].
-- DROP-ing a DB before CREATE-ing it is useful during testing so you can keep 
--     re-executing this script file as you make corrections/changes/additions.

DROP DATABASE IF EXISTS music;


-- Create the actual DB

CREATE DATABASE music;


-- Ensure subsequent commands apply to the music database

USE music;


-- Create the TABLE schema, specifying column (attribute) details

DROP TABLE IF EXISTS cds;

CREATE TABLE cds
(
  id		int		AUTO_INCREMENT	PRIMARY KEY,
  title		varchar(30)	UNIQUE		NOT NULL,
  artist	varchar(20),
  category	char(3)		DEFAULT 'POP',
  numInStock	smallint	DEFAULT 0,
  price		decimal(5,2)	DEFAULT 9.50	NOT NULL	
);

#----------------------------------------------------------------

-- Check the metadata - what actually got stored in the DB

SHOW TABLES;

SHOW COLUMNS IN cds;

# NOTE:  DESC cds; would do the same thing as the above statement
