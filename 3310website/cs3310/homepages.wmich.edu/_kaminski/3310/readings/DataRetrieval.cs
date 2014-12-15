// CLASS OF STATIC METHODS:  DataRetrieval      used by PROGRAM:  UseMySqlDb
// AUTHOR:  D. Kaminski
//
// DISCLAIMER:  This program is simplified in order to demonstrate what's needed for
//      a C# program to do DB access with an SQL query.  But this isn't realistic,
//      with the hardcoded SQL queries, but also the hardcoded labels, placeholders,
//      number of parameters, and certainty that a result will contain at least one
//      row.  Such hardcoding is not good programming practice.  A more generic
//      approach is needed.
// A more generic approach would have the program access the DB's schema to determine
//      the names, data types, widths, etc. of each column that was accessed, and use
//      this data to construct the WriteLine labels and placeholder details.
// *************************************************************************************

using System;
using System.IO;

using System.Data;                          // NOTE THIS
using MySql.Data;                           // NOTE THIS
using MySql.Data.MySqlClient;               // NOTE THIS

namespace UseMySqlDb
{
    class DataRetrieval
    {
        // -----------------------------------------------------------------------------
        // Since the query could return MANY rows of the table:
        //      - a DataReader object is used with the ExecuteReader method
        //      - a loop is used to go through the multi-row result set
        //          (A pre-test while loop is used since potentially there could be
        //              0 rows returned).
        // NOTE:  rdr.Read method returns 2 columns' values, as specified in the
        //      SELECT statement: Name & Population.  These are returned in rdr's
        //      array locations [0] and [1].  If needed, the rdr array also has a
        //      "length" property, rdr.FieldCount, which is 2, which could be used
        //      to control a loop.
        // -----------------------------------------------------------------------------
        public static void DoQueryWhichGetsMultRows(MySqlConnection conn,
                            StreamWriter file, int transNum)
        {
            string sql = "SELECT Name, Population FROM Country WHERE " +
                "Region = 'Western Europe' OR Region = 'British Islands'";

            file.WriteLine("\r\nSQL ({0}): {1}", transNum, sql);

            MySqlCommand cmd = new MySqlCommand(sql, conn);

            file.WriteLine("\r\n{0,-14}:  {1,10}", "Country", "Population");

            try
            {
                MySqlDataReader rdr = cmd.ExecuteReader();

                while (rdr.Read())
                {
                    file.WriteLine("{0,-14}:  {1,10:N0}", rdr[0], rdr[1]);
                }
                rdr.Close();
            }
            catch (Exception ex)
            {
                file.WriteLine("\r\nERROR on {0}, QUERY not done", transNum);
                file.WriteLine(ex.ToString());
                Console.WriteLine("ERROR on {0}, QUERY not done", transNum);
            }
        }
        // -----------------------------------------------------------------------------
        public static void DoQueryWhichGetsSingleValue(MySqlConnection conn,
                            StreamWriter file, int transNum)
        {
            string sql = "SELECT COUNT(*) FROM Country";

            file.WriteLine("\r\nSQL ({0}): {1}", transNum, sql);

            MySqlCommand cmd = new MySqlCommand(sql, conn);

            try
            {
                object result = cmd.ExecuteScalar();

                if (result != null)
                {
                    int number = Convert.ToInt32(result);
                    file.WriteLine("\r\n{0} countries in the World database", number);
                }
            }
            catch (Exception ex)
            {
                file.WriteLine("\r\nERROR on {0}, QUERY not done", transNum);
                file.WriteLine(ex.ToString());
                Console.WriteLine("ERROR on {0}, QUERY not done", transNum);
            }
        }
        // -----------------------------------------------------------------------------
        // Similar to the above - it returns a SINGLE VALUE, a string
        //------------------------------------------------------------------------------
        public static void DoQueryToCheckUpdate(MySqlConnection conn,
                            StreamWriter file, int transNum)
        {
            string sql = "SELECT HeadOfState FROM Country WHERE Name = 'United States'";

            file.WriteLine("\r\nSQL ({0}): {1}", transNum, sql);

            MySqlCommand cmd = new MySqlCommand(sql, conn);

            try
            {
                object result = cmd.ExecuteScalar();
                file.WriteLine("\r\nNEW Head of USA is {0}", result);
            }
            catch (Exception ex)
            {
                file.WriteLine("\r\nERROR on {0}, QUERY not done", transNum);
                file.WriteLine(ex.ToString());
                Console.WriteLine("ERROR on {0}, QUERY not done", transNum);
            }
        }
        // -----------------------------------------------------------------------------
        // This query could return ONE row at most since the WHERE condition specifies a
        // "candidate key" (a field which uniquely identifies a row) (although the DB
        // schema didn't specify this when the DB was created - it should have!).
        // So 0 or 1 row could be return, no more.
        // -----------------------------------------------------------------------------
        public static void DoQueryOnCK(MySqlConnection conn,
                            StreamWriter file, int transNum)
        {
            string sql = "SELECT * FROM Country WHERE Name = 'Disneyland'";

            file.WriteLine("\r\nSQL ({0}): {1}", transNum, sql);

            MySqlCommand cmd = new MySqlCommand(sql, conn);

            try
            {
                MySqlDataReader rdr = cmd.ExecuteReader();

                rdr.Read();

                // NOTE:  rdr returned ALL columns as specified in the SELECT *.
                //      These are returned in array locations rdr[0] through rdr[14].
                //      That's hardcoded here, but rdr.FieldCount could've been used.

                file.WriteLine("\r\nThe data for {0}", rdr[1]);
                file.WriteLine("   Code: {0}, Continent: {1}, Region: {2}, " +
                    "HeadOfState: {3}", rdr[0], rdr[2], rdr[3], rdr[12]);
                file.WriteLine("   SurfaceArea: {0}, IndepYear: {1}, Population: {2}, " +
                    "LifeExpectancy: {3}", rdr[4], rdr[5], rdr[6], rdr[7]);
                file.WriteLine("   GNP: {0}, GNPOld: {1}, LocalName: {2}, " +
                    "GovernmentForm: {3}, Capital: {4}, Code2: {5}",
                    rdr[8], rdr[9], rdr[10], rdr[11], rdr[13], rdr[14]);
                file.WriteLine("   NOTE: Most are default values since " +
                        "no data inserted for most columns");

                rdr.Close();
            }
            catch (Exception ex)
            {
                file.WriteLine("\r\nERROR on {0}, QUERY not done", transNum);
                file.WriteLine(ex.ToString());
                Console.WriteLine("ERROR on {0}, QUERY not done", transNum);
            }
        }
        // -----------------------------------------------------------------------------
    }
}
