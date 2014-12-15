/* Project:         Countries of the World
 * Module:          PrintUtility
 * Programmer:      Dan Peekstok
 *
 * This module prints the contents of the CountryData file to the Log file.
 * It is written without OOP because of the simplisity of the code
 * 
 * 
 * If you have any questions, Email me at dpeekstok@gmail.com or daniel.g.peekstok@wmich.edu
 * Please have A3 in the subject line. I will be more likely to respond to the first
 * email address. I dont check WMU as often as I should.
 * 
 * updated 10/14/14 at 11:30
 */


using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.IO;

namespace PrintUtility
{
    public class PrintUtility
    {
            //private variables

        //holds the data of each country as it is read in
        private static string[] countryArray = new string[4];

        //private streams used for input.
        private static FileStream dataFileStream;
        private static BinaryReader countryDataReader;


        public static void Main()
        {
            Console.WriteLine("print");
            StreamWriter logWriter;

            //truncates the log if it hasn't been done yet since the start of the program
            //if it has been done, it just opens it in append mode
            
            logWriter = File.AppendText("Log.txt");
            logWriter.WriteLine("STATUS > Log File opened");

            logWriter.WriteLine("STATUS > PrintUtility started");

            countryDataReader = new BinaryReader(File.Open("CountryData.bin", FileMode.Open));

            //since strings are prefixed with the length, there is 1 added to the size of al the strings
            int sizeOfCode = 3, sizeOfId = sizeof(short), sizeOfName = 15, sizeOfCont = 13, sizeOfArea = sizeof(int), 
            sizeOfPop = sizeof(long), sizeOfLE = sizeof(float), sizeOfPointer = sizeof(short);
            int sizeOfHeader = sizeof(short) + sizeof(short) + sizeof(short);

            //variables used for output
            string code;
            string cont;
            int sa;
            long pop;
            float le;
            short id;
            string name;
            short pointer;

            int sizeOfRecord = sizeOfCode + sizeOfId + sizeOfName + sizeOfCont + sizeOfArea + 
                sizeOfPop + sizeOfLE + sizeOfPointer;

            short maxHome = countryDataReader.ReadInt16();
            short nHome = countryDataReader.ReadInt16();
            short nColl = countryDataReader.ReadInt16();
            int numOfCountries = nHome + nColl;
            
            //header
            logWriter.WriteLine("Max Home Locations: " + maxHome);
            logWriter.WriteLine("Number in Home Locations: " + nHome);
            logWriter.WriteLine("Number of Collisions: " + nColl);
            logWriter.WriteLine("LOC/ CDE ID- NAME----------- CONTINENT---- ------AREA " +
                "---POPULATION LIFE LINK");    //header

            //this will do a linear search of the entire file. 
            for (int x = 1; x <= maxHome + nColl; x++)
            {
                try
                {
                    //since the BinaryReader type doesn't have a Seek function, I used this work around. 
                    //its kinds sloppy but it works perfectly
                    //If the file location is empty, it wont advance the reader to the correct spot.

                    //first you close the old reader
                    countryDataReader.Close();
                    //then you create a file stream and use its seek function
                    dataFileStream = new FileStream("CountryData.bin", FileMode.Open);
                    dataFileStream.Seek(((x - 1) * sizeOfRecord) + sizeOfHeader, SeekOrigin.Begin);
                    //when you create a new BinaryReader on the same FileStream, the pointer will be in the same spot
                    countryDataReader = new BinaryReader(dataFileStream);


                    //I output the data to my CountryData.bin file in exactly this manner.
                    //If you use the same format of output, you wont have a problem
                    code = new string(countryDataReader.ReadChars(3));
                    id = countryDataReader.ReadInt16();
                    name = new string(countryDataReader.ReadChars(15));
                    cont = new string(countryDataReader.ReadChars(13));
                    sa = countryDataReader.ReadInt32();
                    pop = countryDataReader.ReadInt64();
                    le = countryDataReader.ReadSingle();
                    pointer = countryDataReader.ReadInt16();
                    

                    if (id == 0)
                        logWriter.WriteLine(x.ToString("000") + "/ Empty");
                    else
                    {

                        logWriter.WriteLine(String.Format("{0,3:000}/ {1,3} {2:000} {3, -15} " +
                            "{4,-13} {5,10:#,##0} {6,13:#,##0} {7,4:#0.0}  {8,2:#0}",
                            x, code, id, name, cont, sa, pop, le, pointer));
                    }
                }
                catch
                {
                    logWriter.WriteLine(x.ToString("000") + "/ Empty");
                }
            }

            
            logWriter.WriteLine("STATUS > PrintUtility finished");

            logWriter.WriteLine("STATUS > Backup File closed");

            countryDataReader.Close();
            logWriter.WriteLine("STATUS > Log File closed");
            logWriter.Close();

        }
    }
}
