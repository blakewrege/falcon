// CLASS OF STATIC METHODS:  DataUpdate      used by PROGRAM:  UseMySqlDb
// AUTHOR:  D. Kaminski
// *************************************************************************************

using System;
using System.IO;

using System.Data;                          // NOTE THIS
using MySql.Data;                           // NOTE THIS
using MySql.Data.MySqlClient;               // NOTE THIS

namespace UseMySqlDb
{
    class DataUpdate
    {
         // -----------------------------------------------------------------------------
        public static void DoInsert(MySqlConnection conn, StreamWriter file, int transNum)
        {
            string sql = "INSERT INTO Country (Name, HeadOfState, Continent) " +
                "VALUES ('Disneyland','Mickey Mouse', 'North America')";

            file.WriteLine("\r\nSQL ({0}): {1}", transNum, sql);

            MySqlCommand cmd = new MySqlCommand(sql, conn);

            try
            {
                cmd.ExecuteNonQuery();
                file.WriteLine("\r\nOK, INSERT of Disneyland was done");
            }
            catch (Exception ex)
            {
                file.WriteLine("\r\nERROR on {0}, INSERT not done", transNum);
                file.WriteLine(ex.ToString());
                Console.WriteLine("ERROR on {0}, INSERT not done", transNum);
            }
        }
        // -----------------------------------------------------------------------------
        public static void DoUpdate(MySqlConnection conn, StreamWriter file, int transNum)
        {
            string sql = "UPDATE Country SET HeadOfState = 'Barack Obama'" +
                "WHERE Name = 'United States'";

            file.WriteLine("\r\nSQL ({0}): {1}", transNum, sql);

            MySqlCommand cmd = new MySqlCommand(sql, conn);

            try
            {
                cmd.ExecuteNonQuery();
                file.WriteLine("\r\nOK, UPDATE of USA's HeadOfState done");
            }
            catch (Exception ex)
            {
                file.WriteLine("\r\nERROR on {0}, UPDATE not done", transNum);
                file.WriteLine(ex.ToString());
                Console.WriteLine("ERROR on {0}, UPDATE not done", transNum);
            }
        }
        // -----------------------------------------------------------------------------
        public static void DoDelete(MySqlConnection conn, StreamWriter file, int transNum)
        {
            string sql = "DELETE FROM Country WHERE Name = 'Disneyland'";

            file.WriteLine("\r\nSQL ({0}): {1}", transNum, sql);

            MySqlCommand cmd = new MySqlCommand(sql, conn);

            try
            {
                cmd.ExecuteNonQuery();
                file.WriteLine("\r\nOK, DELETE of Disneyland was done");
            }
            catch (Exception ex)
            {
                file.WriteLine("\r\nERROR on {0}, DELETE not done", transNum);
                file.WriteLine(ex.ToString());
                Console.WriteLine("ERROR on {0}, DELETE not done", transNum);
            }
        }
        // -----------------------------------------------------------------------------
    }
}
