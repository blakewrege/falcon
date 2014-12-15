// PROGRAM:  UseMySqlDb
// AUTHOR:  D. Kaminski
// SOFTWARE:  Visual Studio 2010, MySQL 5.1; MySQL Connector Net 6.3.5
//
// *************************************************************************************
// ATTRIBUTION: The World DB data files are from the MySQL website tutorial.
//      Some of the code in this program was adapted from the tutorial in the MySQL
//      Connection documentation - see:  start / All Programs / MySQL /
//                      MySQL Server 5.1 / MySQL Connector Net 6.3.5 / Documentation
//
// NOTE:  The DB Schema which was set up manually using mysql is lacking some
//      commonly accepted "good DB design practices" (e.g., foreign key
//      specifications for specifying connections between tables, unique
//      (candidate key fields) specifications, disallowing non-unique primary keys,
//      etc.).  I have not changed these.
//
// *************************************************************************************
// DESCRIPTION: This program USES the World DB.  It assumes the DB's already set up.
//      This set up was done directly in mysql by using script files to
//          CREATE the database, CREATE its tables (with column descriptions),
//          and populate the tables with actual data using INSERTs.
//      Such operations as CREATE, DROP, ALTER (i.e., DDL, Data Definition Language,
//          SQL commands which affect the DB Schema) COULD have been done by a C#
//          program instead.  That's something you can explore later in a DBS course.
//      This program only queries & manipulates the DATA itself using DML (Data
//          Manipulation Language) SQL commands: SELECT, INSERT, DELETE, UPDATE.
//
// *************************************************************************************
// DISCLAIMER:  This program is simplified in order to demonstrate what's needed for
//      a C# program to access a MySQL database.  It uses hard-coded SQL strings right
//      in the program itself, each in its own specific method.  This is poor 
//      programming practice.  First, it is not generic and robust, with the SQL
//      commands actually hard-coded in the program and an individual method defined
//      for each SQL statement.  Secondly, this approaches leaves the database open
//      to security problems, allowing the general program direct access to the
//      database, with possibly questionable SQL statements.
// A PARAMETERIZED approach is a much safer (and more generic/robust) way to access a
//      database.  (An example of such a program will be posted soon).  A generic set
//      of database access methods are provided for the general program to use.  The
//      program supplies parameter values to indicate which columns, tables, conditions,
//      etc. are wanted, and the database access methods construct the SQL statement
//      based on those parameters, then sends the statement to the database server
//      for processing.

// *************************************************************************************
// DISCLAIMER:  This program's series of 9 transactions have some dependencies - e.g.,
//      if the INSERT didn't work, then the subsequent DELETE won't work.  The error
//      trapping needs to be expanded to more appropriately handle various types of
//      problems.
//
// *************************************************************************************
// WHAT'S NEEDED FOR A C# PROGRAM TO ACCESS A MYSQL DB:
//
// 1. ADD A CONNECTION to the MySQL DB server and the particular user & DB by doing:
//      - open Server Explorer window (View / Server Explorer)
//      - right-click Data Connections & select Add Connection
//      - select MySQL Database & click continue
//      - enter the following info:   Server name:  localhost
//                                  User name:  root
//                                  Password:  <whatever yours is - mine's MySQL3310>
//                                  check the box:  Save my password
//                                  Database name:  world   <or whatever one you need>
//      - click Test Connection & click OK
//    The connection IS SAVED for when you next open this project.  To establish the 
//          connection again, open Server Explorer and click on localhost(world) if
//          it's flagged in red.
//    Note that you can see the list of tables in the DB as well as the columns in each
//          table by expanding the + signs in the Server Explorer.
//
// 2. ADD A REFERENCE to MySQL.Data library by doing:
//      - in Solution Explorer window (do View / Solution Explorer to open it)
//      - right-click on this project's References & select Add Reference
//      - in Add Reference window (under .NET tab) select MySql.Data & click OK
//    Note:  This is SAVED & only needs to be done when first setting up the project.
//
// 3. INCLUDE the 3 LIBRARIES with using directives (see below):
//          System.Data, MySql.Data, MySql.Data.MySqlClient
//
// 4. OPEN the connection by declaring a MySqlConnection object, providing the
//          constructor with the connection string with the relevant data (see below).
//    Note that a program could ask an interactive user for data like userName &
//          password to use in building a connection string.
//    IF THE CONNECTION FAILS TO OPEN, start the DB SERVER itself by starting up mysql
//          by opening the Command Prompt client, starting mysql and logging in.
//
// 5. Use 1 of MySqlCommand's 3 methods (see below) to RETRIEVE/CHANGE the DB's data:
//      ExecuteReader - used to query the DB - results returned in a
//                  MySqlDataReader object, created by ExecuteReader
//      ExecuteScalar - used to RETURN a single value
//      ExecuteNonQuery - used to INSERT, DELETE, UPDATE data
//
// 6. CLOSE the connection to release resources
// *************************************************************************************
using System;
using System.IO;

using System.Data;                          // NOTE THIS
using MySql.Data;                           // NOTE THIS
using MySql.Data.MySqlClient;               // NOTE THIS

namespace UseMySqlDb
{
    class Program
    {
        static void Main()
        {
            string password = "MySQL3310";          // COULD ASK USER FOR THIS INSTEAD

            string connStr = "server=localhost;user=root;database=world;" +
                "port=3306;password=" + password + ";";

            MySqlConnection conn;

            StreamWriter file = new StreamWriter("..\\..\\..\\WorldLogFile.txt");

            file.WriteLine("Connecting to MySQL...");

            try
            {
                conn = new MySqlConnection(connStr);
                conn.Open();
                file.WriteLine("OK, the DB Connection is OPENED\n");

                DataRetrieval.DoQueryWhichGetsMultRows(conn, file, 1);
                DataRetrieval.DoQueryWhichGetsSingleValue(conn, file, 2);
                DataUpdate.DoUpdate(conn, file, 3);
                DataRetrieval.DoQueryToCheckUpdate(conn, file, 4);
                DataUpdate.DoInsert(conn, file, 5);
                DataRetrieval.DoQueryOnCK(conn, file, 6);
                DataRetrieval.DoQueryWhichGetsSingleValue(conn, file, 7);
                DataUpdate.DoDelete(conn, file, 8);
                DataRetrieval.DoQueryWhichGetsSingleValue(conn, file, 9);

                conn.Close();
                Console.WriteLine("See WorldLogFile.txt in top-level project folder");
            }
            catch (Exception ex)
            {
                file.WriteLine("\r\nERROR, DB Connection didn't work - no trans done");
                file.WriteLine(ex.ToString());
                Console.WriteLine("ERROR, DB Connection didn't work - no trans done");
            }

            file.WriteLine("\r\nEXITING PROGRAM");
            file.Close();

            // ************************************
            Console.Write("\n\nHit ENTER to quit");
            Console.ReadLine();
        }
    }
}
