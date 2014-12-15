// CLASS OF STATIC METHODS:  DataUpdate      used by PROGRAM:  UseMySqlDb
// AUTHOR:  D. Kaminski
// *************************************************************************************

package usemysqldb;

import java.io.*;
import java.sql.*;

public class DataUpdate 
{
    // -----------------------------------------------------------------------------
    public static void DoInsert(Connection conn, FileWriter file, int transNum) throws IOException
    {
        String sql = "INSERT INTO Country (Name, HeadOfState, Continent) " +
            "VALUES ('Disneyland','Mickey Mouse', 'North America')";

        file.write(String.format("\r\nSQL (%d): %s\r\n", transNum, sql));

        try
        {
            //create a Statement object
            Statement stmt = conn.createStatement();
            int result = stmt.executeUpdate(sql);
            if (result != 0)
            {
                file.write("\r\nOK, INSERT of Disneyland was done\r\n");
            }
        }
        catch (Exception ex)
        {
            file.write("\r\nERROR on " + transNum + ", INSERT not done\r\n");
            file.write(ex.toString() + "\r\n");
            System.out.println("ERROR on " + transNum + ", INSERT not done\r\n");
        }
    }
    // -----------------------------------------------------------------------------
    public static void DoUpdate(Connection conn, FileWriter file, int transNum) throws IOException
    {
        String sql = "UPDATE Country SET HeadOfState = 'Barack Obama' " +
            "WHERE Name = 'United States'";

        file.write(String.format("\r\nSQL (%d): %s\r\n", transNum, sql));

        try
        {
            Statement stmt = conn.createStatement();
            int result = stmt.executeUpdate(sql);
            if (result != 0)
            {
                file.write("\r\nOK, UPDATE of USA's HeadOfState done\r\n");
            }
        }
        catch (Exception ex)
        {
            file.write("\r\nERROR on " + transNum + ", INSERT not done\r\n");
            file.write(ex.toString() + "\r\n");
            System.out.println("ERROR on " + transNum + ", INSERT not done\r\n");
        }
    }
    // -----------------------------------------------------------------------------
    public static void DoDelete(Connection conn, FileWriter file, int transNum) throws IOException
    {
        String sql = "DELETE FROM Country WHERE Name = 'Disneyland'";

        file.write(String.format("\r\nSQL (%d): %s\r\n", transNum, sql));

        try
        {
            Statement stmt = conn.createStatement();
            int result = stmt.executeUpdate(sql);
            if (result != 0)
            {
                file.write("\r\nOK, DELETE of Disneyland was done\r\n");
            }
        }
        catch (Exception ex)
        {
            file.write("\r\nERROR on " + transNum + ", INSERT not done\r\n");
            file.write(ex.toString() + "\r\n");
            System.out.println("ERROR on " + transNum + ", INSERT not done\r\n");
        }
    }
}
