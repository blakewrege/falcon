// CLASS OF STATIC METHODS:  DataRetrieval      used by PROGRAM:  UseMySqlDb
// AUTHOR:  D. Kaminski
//
// DISCLAIMER:  This program is simplified in order to demonstrate what's needed for
//      a Java program to do DB access with an SQL query.  But this isn't realistic,
//      with the hardcoded SQL queries, but also the hardcoded labels, placeholders,
//      number of parameters, and certainty that a result will contain at least one
//      row.  Such hardcoding is not good programming practice.  A more generic
//      approach is needed.
// A more generic approach would have the program access the DB's schema to determine
//      the names, data types, widths, etc. of each column that was accessed, and use
//      this data to construct the write labels and placeholder details.
// *************************************************************************************

package usemysqldb;

import java.io.*;
import java.sql.*;
import java.text.NumberFormat;

public class DataRetrieval 
{
    // -----------------------------------------------------------------------------
    // Since the query could return MANY rows of the table:
    //      - a ResultSet object is used with the ExecuteQuery method
    //      - a loop is used to go through the multi-row result set
    //          (A pre-test while loop is used since potentially there could be
    //              0 rows returned).
    // NOTE: A ResultSet object is a table of data representing a database result set.
    //      It maintains a cursor pointing to the current row of data.  Initially the
    //      cursor is positioned before the first row, thus the need for "rs.next()"
    //      to start the loop.  When there are no more rows in the ResultSet object, 
    //      it returns "false", and the loop is stopped.
    // NOTE2: ResultSet interface provides getter methods (getInt, getString, etc.)
    //      for retrieving column values from the current row. You can retrieve values 
    //      using either the index number of the column or the alias or name of the 
    //      column. COLUMNS ARE NUMBERED STARTING AT 1.
    // (for more info, see http://docs.oracle.com/javase/1.4.2/docs/api/java/sql/ResultSet.html)
    // -----------------------------------------------------------------------------
    public static void DoQueryWhichGetsMultRows(Connection conn,
                        FileWriter file, int transNum) throws IOException
    {
        String sql = "SELECT Name, Population FROM Country WHERE " +
            "Region = 'Western Europe' OR Region = 'British Islands'";

        file.write(String.format("\r\nSQL (%d): %s\r\n", transNum, sql));

        file.write(String.format("\r\n%-14s:  %10s\r\n", "Country", "Population"));

        try
        {
            //create a Statement object
            Statement stmt = conn.createStatement();
            //Send the statement to the DBMS
            ResultSet rs = stmt.executeQuery(sql);

            while (rs.next())
            {
                file.write(String.format("%-14s:  %10s\r\n", rs.getString(1), 
                        NumberFormat.getInstance().format(rs.getDouble(2))));
            }
            stmt.close();
        }
        catch (Exception ex)
        {
            file.write("\r\nERROR on " + transNum + ", QUERY not done\r\n");
            file.write(ex.toString() + "\r\n");
            System.out.println("\r\nERROR on " + transNum + ", QUERY not done");
        }
    }
    // -----------------------------------------------------------------------------
    public static void DoQueryWhichGetsSingleValue(Connection conn,
                        FileWriter file, int transNum) throws IOException
    {
        String sql = "SELECT COUNT(*) FROM Country";

        file.write(String.format("\r\nSQL (%d): %s\r\n", transNum, sql));

        try
        {
            Statement stmt = conn.createStatement();
            ResultSet rs = stmt.executeQuery(sql);

            if (rs.next())
            {
                int number = rs.getInt(1);
                file.write(String.format("\r\n%d countries in the World database\r\n", 
                        number));
            }
            stmt.close();
        }
        catch (Exception ex)
        {
            file.write("\r\nERROR on " + transNum + ", QUERY not done\r\n");
            file.write(ex.toString() + "\r\n");
            System.out.println("\r\nERROR on " + transNum + ", QUERY not done");
        }
    }
    // -----------------------------------------------------------------------------
    // Similar to the above - this method returns a SINGLE VALUE, a string
    //------------------------------------------------------------------------------
    public static void DoQueryToCheckUpdate(Connection conn,
                        FileWriter file, int transNum) throws IOException
    {
        String sql = "SELECT HeadOfState FROM Country WHERE Name = 'United States'";

        file.write(String.format("\r\nSQL (%d): %s\r\n", transNum, sql));

        try
        {
            Statement stmt = conn.createStatement();
            ResultSet rs = stmt.executeQuery(sql);
            
            if (rs.next())
            {
                file.write("\r\nNEW Head of USA is " + rs.getString(1) + "\r\n");
            }
            stmt.close();
        }
        catch (Exception ex)
        {
            file.write("\r\nERROR on " + transNum + ", QUERY not done\r\n");
            file.write(ex.toString() + "\r\n");
            System.out.println("\r\nERROR on " + transNum + ", QUERY not done");
        }
    }
    // -----------------------------------------------------------------------------
    // This query could return ONE row at most since the WHERE condition specifies a
    // "candidate key" (a field which uniquely identifies a row) (although the DB
    // schema didn't specify this when the DB was created - it should have!).
    // So 0 or 1 row could be return, no more.
    // -----------------------------------------------------------------------------
    public static void DoQueryOnCK(Connection conn,
                        FileWriter file, int transNum) throws IOException
    {
        String sql = "SELECT * FROM Country WHERE Name = 'Disneyland'";

        file.write(String.format("\r\nSQL (%d): %s\r\n", transNum, sql));

        try
        {
            Statement stmt = conn.createStatement();
            ResultSet rs = stmt.executeQuery(sql);
            // NOTE:  rs contains ALL columns as specified in the SELECT *.
            //      These are retrieved using index number of the column (1-15)
            
            if (rs.next())
            {
                file.write("\r\nThe data for " + rs.getString(2) + "\r\n");
                file.write(String.format("   Code: %s, Continent: %s, Region: %s, "
                        + "HeadOfState: %s\r\n", rs.getString(1), rs.getString(3), 
                        rs.getString(4), rs.getString(13)));
                file.write(String.format("   SurfaceArea: %s, IndepYear: %s, "
                        + "Population: %s, LifeExpectancy: %s\r\n", rs.getString(5), 
                        rs.getString(6), rs.getString(7), rs.getString(8)));
                file.write(String.format("   GNP: %s, GNPOld: %s, LocalName: %s, "
                        + "GovernmentForm: %s, Capital: %s, Code2: %s\r\n", 
                        rs.getString(9), rs.getString(10), rs.getString(11), 
                        rs.getString(12), rs.getString(14), rs.getString(15)));
                file.write("   NOTE: Most are default values since " +
                        "no data inserted for most columns\r\n");
            }

            stmt.close();
        }
        catch (Exception ex)
        {
            file.write("\r\nERROR on " + transNum + ", QUERY not done\r\n");
            file.write(ex.toString() + "\r\n");
            System.out.println("\r\nERROR on " + transNum + ", QUERY not done");
        }
    }
}
