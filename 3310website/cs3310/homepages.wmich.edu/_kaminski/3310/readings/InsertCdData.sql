###################################################################################
# InsertCdData.sql   (a script file)
#
# Populates the cds table (in the music database) with data using regular SQL
#     INSERT commands.
# IMPORTANT:  The database and the cds table MUST have already been created.
#
# Several different INSERT formats are used just to demonstrate them.
#
# After all the INSERTs are done, there are 2 SELECT commands at the end to display
#     the data that actually got stored in the table.
#
# CAUTION:  Note where commas vs. semi-colons are used below.
###################################################################################

INSERT INTO cds VALUES
  (54, 'Your Honor',           'Foo Fighters', 'POP',  22, 18.99);

INSERT INTO cds VALUES
  (96, 'Monkeybusiness',       'Black Eyed P', 'POP',  12, 13.50);


-- Note: to put a quote in a string preceed it with a '\'.

INSERT INTO cds VALUES
  ( 6, 'It\'s GOT A QUOTE',    'O\'Leary',     'LAT',   1,  9.99);


-- Note commas at the end of each line of data (except the last one since this
--	INSERT is a single command.

INSERT INTO cds VALUES
  (77, 'Out Of Season',        'Beth Gibbons', 'ALT',  21, 16.98),
  (90, 'Love, Angel, Music',   'Gwen Stefani', 'POP',  15, 17.95),
  (43, 'Breakaway',            'Kelly Clarks', 'COU',   9, 12.00);


-- Note that NULL (or null) in the id column is OK since that column has the
--	AUTO_INCREMENT option specified (in CREATE).
-- Note what values they'll get (which will be different each time, if you
--	repeatedly run this (since the INCREMENTER is NOT automatically
--	reinitialized until you start a new MySQL session, or ...).

INSERT INTO cds VALUES
  (84,  'X & Y',               'Coldplay',     'POP',  30, 13.99),
  (NULL,'O Sole Mio',          'Pavarotti',    'CLA',   2,  9.00),
  (null,'Round Midnight',      'Charlie Park',  NULL,   0, 15.00),
  (null,'Forget About It',     'Alison Kraus',  NULL,   0, 15.00);


-- The 3rd, 4th, 5th, 6th, 7th data lines have errors:
--    - a NULL in title (and title's specifications says NOT NULL)
--    - 54 is a duplicate ID (the PK) matching the very 1st INSERT
--    - 'Your Honor' is a duplicate title, but title must be UNIQUE
--    - NULL in price is not allowed (specs say NOT NULL)
--    - category must be no more than 3 characters.
-- However, since this is a SINGLE INSERT, when an error occurs,
--	1) none of the good data lines (the 1st 2) are inserted
--	2) and no further error-checking is done on 4th-7th lines.

INSERT INTO cds VALUES
  (59,  'Survivor',            'Destinys Ch',  'SOU', 211,  4.91),
  (44,  'Fireflies',           'Faith Hill',   'COU',   9,  9.99),
  (50,   NULL,                 'BadNullTitle', 'OLD',  48, 15.99),
  (54,  'DUPL ID (1st Insert)','Dup ID (1st)', 'POP',   0,  9.99),
  ( 2,  'Your Honor',          'DupTitle(1st)','ROC', 123, 45.67),
  (11,  'American Idiot',      'Green Day',    'POP',  24,  NULL),
  (83,  'Our Love is a Ghost', 'Bowery',       'BALLAD', 1, 9.99);


-- So it's better to do single INSERT's, so any bad data line doesn't affect any
--	other data from being inserted.
-- The next two have duplicate ID and duplicate title errors.

INSERT INTO cds VALUES
  (96, 'USA:  United States',  'Ying Yang Tw', 'POP',  31, 13.01);

INSERT INTO cds VALUES 
  (10, 'Monkeybusiness',       'U2',           'ROC', 123, 45.67);


-- These next 2 INSERTs specify column names for the values to be set, and don't
--	specify data for all 6 table columns.  Such columns will get the DEFAULT
--	values or AUTO_INCREMENT specified when CREATE-ing the table.
-- Note the 2 different formats to do this.

INSERT INTO cds (id, title, artist) VALUES
  (34, 'Emancipation of Mimi', 'Mariah Carey');
  				# this row gets 'POP', 0, 9.50
				# for category, numInStock, price
INSERT INTO cds SET
  title = '4th Door',
  artist = 'Randon Myles',
  category = 'WOR',
  numInStock = 10;
  				# this row gets AUTO_INCREMENT
				# for id, and 9.50 for price

#----------------------------------------------------------------------------------

-- This is to check what data actually got stored in the table.
--     There should be 12 ROWS.
--     Note that the rows are NOT in the same order as the INSERTs happened.
--         [A table (relation) contains a SET of rows (tuples), so is NOT ordered].

SELECT * FROM cds;

SELECT * FROM cds
  ORDER BY title;
