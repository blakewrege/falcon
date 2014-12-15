// PROGRAM:  UseMySqlDb
// AUTHOR:  D. Kaminski
// SOFTWARE:  NetBeans IDE 7.1.2, MySQL 5.5.1; MySQL Connector Java 5.1.21
//
// *************************************************************************************
// ATTRIBUTION: The World DB data files are from the MySQL website tutorial.
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
//          SQL commands which affect the DB Schema) COULD have been done by a Java
//          program instead.  That's something you can explore later in a DBS course.
//      This program only queries & manipulates the DATA itself using DML (Data
//          Manipulation Language) SQL commands: SELECT, INSERT, DELETE, UPDATE.
//
// *************************************************************************************
// DISCLAIMER:  This program is simplified in order to demonstrate what's needed for
//      a Java program to access a MySQL database.  It uses hard-coded SQL strings right
//      in the program itself, each in its own specific method.  This is poor 
//      programming practice.  First, it is not generic and robust, with the SQL
//      commands actually hard-coded in the program and an individual method defined
//      for each SQL statement.  Secondly, this approach leaves the database open
//      to security problems, allowing the general program direct access to the
//      database, with possibly questionable SQL statements.
// A PARAMETERIZED approach is a much safer (and more generic/robust) way to access a
//      database.  (An example of such a program will be posted soon).  A generic set
//      of database access methods are provided for the general program to use.  The
//      program supplies parameter values to indicate which columns, tables, conditions,
//      etc. are wanted, and the database access methods construct the SQL statement
//      based on those parameters, then sends the statement to the database server
//      for processing.
//
// *************************************************************************************
// DISCLAIMER:  This program's series of 9 transactions have some dependencies - e.g.,
//      if the INSERT didn't work, then the subsequent DELETE won't work.  The error
//      trapping needs to be expanded to more appropriately handle various types of
//      problems.
//
// *************************************************************************************
// WHAT'S NEEDED FOR A Java PROGRAM TO ACCESS A MYSQL DB:
//
// NOTE: NetBeans IDE already includes the necessary JDBC Driver for MySQL (Connector/J)
//       If you are missing it, or using a different IDE, you can download the driver 
//       from this website: http://www.mysql.com/products/connector/
//
// 1. Make sure that "MySQL (Connector/J driver)" is listed under Services -> Databases 
//      -> Drivers.  If it is not, you can add it by right-clicking Drivers -> New Driver.
//      Browse to the .jar file downloaded from above link, and hit OK.
//
// 2. ADD THE MySQL JDBC DRIVER LIBRARY:
//      - find your project under Projects on the upper left, expand to show Libraries.
//      - right-click Libraries & select Add Library...
//      - select MySQL JDBC Driver & select Add Library
//
// 3. GET JDBC URL (and test connection)
//      - Services -> Databases -> Drivers -> right-click MySQL (Connector/J driver) ->
//      Connect Using... (this will bring up the New Connection Wizard)
//      - Make sure Driver Name: MySQL (Connector/J driver)
//      - Host: localhost (if MySQL is installed on your machine)
//      - Port: 3306 (default)
//      - Database: world (or whatever you named your database)
//      - User Name: (your user name - in my case, "root")
//      - Password: (your password)
//      
//      - Hit Test Connection, you should see "Connection Succeeded"
//      - COPY the JDBC URL: this is what you will be using to make the connection
//      - Hit Finish - you will now see the added connection listed under 
//        Services -> Databases  (should look something like 
//                  "jdbc:mysql://localhost:3306/world [root on Default schema]")
//      - you can browse Tables, Views, Procedures, and more
//
// 4. IMPORT the SQL LIBRARY so that you have the necessary tools
//      (import java.sql.*;)
//
// 5. OPEN the connection by declaring a Connection object, providing the
//          constructor with the url string, username and password (see below).
//    Note that a program could ask an interactive user for data like userName &
//          password to use in building a connection string.
//    IF THE CONNECTION FAILS TO OPEN, start the DB SERVER itself by starting up mysql
//          by opening the Command Prompt client, starting mysql and logging in.
//
// 6. Create a Statement object to RETRIEVE/CHANGE the DB's data: two of the most
//      useful methods are:
//      executeQuery - used to query the DB - results typically returned in a
//                  ResultSet object
//      executeUpdate -  used to INSERT, DELETE, UPDATE data
//
// 7. CLOSE the connection to release resources
// *************************************************************************************
//
// HELPFUL SITES:
//      - http://netbeans.org/kb/docs/ide/mysql.html
//      - http://dev.mysql.com/doc/refman/5.0/en/connector-j-examples.html
//      - http://zetcode.com/databases/mysqljavatutorial/
//
// *************************************************************************************

package usemysqldb;

import java.io.*;
import java.sql.*;

public class UseMySQLDb 
{
    public static void main(String[] args) throws SQLException, IOException
    {               
        String url = "jdbc:mysql://localhost:3306/world";
        String user = "root";
        String password = "pass";
        
        FileWriter file = new FileWriter("WorldLogFile.txt");
        
        file.write("Connecting to MySQL...\r\n");

        try
        {
            //Create a connection to the database
            Connection conn = DriverManager.getConnection(url, user, password);
            file.write("OK, the DB Connection is OPENED\r\n");

            DataRetrieval.DoQueryWhichGetsMultRows(conn, file, 1);
            DataRetrieval.DoQueryWhichGetsSingleValue(conn, file, 2);
            DataUpdate.DoUpdate(conn, file, 3);
            DataRetrieval.DoQueryToCheckUpdate(conn, file, 4);
            DataUpdate.DoInsert(conn, file, 5);
            DataRetrieval.DoQueryOnCK(conn, file, 6);
            DataRetrieval.DoQueryWhichGetsSingleValue(conn, file, 7);
            DataUpdate.DoDelete(conn, file, 8);
            DataRetrieval.DoQueryWhichGetsSingleValue(conn, file, 9);          

            conn.close();
            System.out.println("See WorldLogFile.txt in project folder");
        }
        catch (Exception ex)
        {
            file.write("\r\nERROR, DB Connection didn't work - no trans done\r\n");
            file.write(ex.toString());
            System.out.println("ERROR, DB Connection didn't work - no trans done");
        }
        
        file.write("\r\nEXITING PROGRAM");
        file.close();
    }
}