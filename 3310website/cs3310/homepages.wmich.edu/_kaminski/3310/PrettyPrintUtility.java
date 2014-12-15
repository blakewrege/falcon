/**
 * Name:    Joshua White
 * Section: CS3310-100
 * Package: Countries of the World v.1.5
 * Desc:    PrettyPrintUtility class, v.1.5.4. Reads country data
 * 	    from specified file and displays contents in 
 * 	    log file. Use of this utility requires the following:
 * 
 * 	    1. Data records must be exactly 82 bytes long, written in this format
 *  	       (per assignment specs):
 *  	       - 6 bytes for countryCode (3 chars in default encoding - 
 *  		 UTF-16 - 2 bytes each)
 * 	       - 2 bytes for countryID (written as a short)
 * 	       - 30 bytes for name (15 chars in default encoding)
 * 	       - 26 bytes for continent (13 chars in default encoding)
 * 	       - 4 bytes for area (written as an int)
 * 	       - 8 bytes for population (written as a long)
 * 	       - 4 bytes for life expectancy (written as a single-precision float)
 * 	       - 2 bytes for link (written as a short)
 *  	    2. MAX_N_HOME_LOC, nHome, and nColl must be written in that
 *  	       order, beginning at byte 0
 *	    3. The header must be exactly 6 bytes long (ie., the first data
 *	       record begins at byte 6)
 *
 *	If you have any issues implementing this in your program, feel free
 *	to contact me at joshua.j45.white@wmich.edu. Please put "CS3310" in the
 *	subject line. Before emailing me, please make sure your program
 *	meets the specifications listed above, and that you have reviewed all
 *	notes in the code below.
 *
 *	This utility has been tested and works properly in my own program.
 * 
 *		This code is written in compliance with JavaSE-1.7
 */
package edu.wmich.cs3310.jwhite_cotw;

import java.io.BufferedWriter;
import java.io.DataInputStream;
import java.io.EOFException;
import java.io.File;
import java.io.FileInputStream;
import java.io.FileWriter;
import java.io.IOException;
import java.io.PrintWriter;
import java.nio.channels.FileChannel;
import java.text.NumberFormat;

public class PrettyPrintUtility {

	/* ******************************** *
	 *  	      Main method	    *
	 * ******************************** */

	/**
	 * Main method.
	 * @param args command line arguments
	 * @throws IOException on I/O error
	 */
	public static void main(String[] args) throws IOException {

	 	// Local variables
		NumberFormat nf = NumberFormat.getInstance();
		FileInputStream fstream;

	 	// Try with resources - ensures that resources declared are closed
	 	// properly after try block finishes executing (requires declared 
	 	// resources implement the java.io.AutoCloseable interface)
		try (
			DataInputStream file = new DataInputStream(
				fstream = new FileInputStream(new File("CountryData.bin")));
			PrintWriter log = new PrintWriter(new BufferedWriter(
				new FileWriter("log.txt", true)));
			) {
			
		 	// Write initialization messages to log
			log.println("STATUS > Log FILE opened");
			log.println("STATUS > CountryData FILE opened");
			
		 	// File channel from file stream
			FileChannel fc = fstream.getChannel();
			
		 	// Variables for record data
			char[] continent, countryCode, name;
			short max, nColl, nHome, countryID, link;
			int area, loc = 1;
			long population;
			float lifeExp;
		
			// End of file flag
			boolean eof = false;
			
		 	// Read header record data
			fc.position(0);
			max = file.readShort();
			nHome = file.readShort();
			nColl = file.readShort();
			
		 	// Write data table header in log
			log.println("DATA STORAGE");
			log.printf("MAX_N_HOME_LOC: %02d, nHome: %02d, nColl: %02d%n",
					max, nHome, nColl); 
			log.println("LOC/ CDE ID- NAME----------- CONTINENT---- "
					+ "------AREA ---POPULATION LIFE LINK");
			
			// Loop until end of file flag is set
			while (!eof) {

			 	// DataInputStream throws EOFException at end of file, so wrap
			 	// any stream methods in try block
				try {

				 	// Move file channel to next record location
					fc.position(offset(loc));

				 	/* Read country code (note algorithm used -- 	*
				 	 * ensure your write method follows this same 	*
				 	 * algorithm (this is the algorithm is used to	*
				  	 * read the name and continent fields and is as	*
				 	 * specified in the assignment specs)		*/
					countryCode = new char[3];
					for (int i = 0; i < countryCode.length; i++)
						countryCode[i] = file.readChar();
					
				 	// Read country ID
					countryID = file.readShort();
					
				 	// Read name
					name = new char[15];
					for (int i = 0; i < name.length; i++)
						name[i] = file.readChar();
					
				 	// Read continent
					continent = new char[13];
					for (int i = 0; i < continent.length; i++)
						continent[i] = file.readChar();
					
				 	// Read area, population, life expectancy, and link
					area = file.readInt();
					population = file.readLong();
					lifeExp = file.readFloat();
					link = file.readShort();

				 	// Execute if country ID is not all zero bits - ie., a valid record
					if (countryID != 0x00) 
						log.printf("%03d/ %3s %03d %-15.15s %-13.13s"
						+ " %10s %13s %4.1f %03d%n", loc, 
						new String(countryCode), countryID, 
						new String(name), new String(continent), 
						nf.format(area), nf.format(population),
						lifeExp, link);
					
				 	// Otherwise country ID is zero, which identifies and invalid record
					else
						log.printf("%03d/%n", loc);

				 	// Increment data location counter
					loc++;

			 	// When EOF is reached
				} catch (EOFException e) {

				 	// Set EOF flag
					eof = true;

				}
				
			}
			
		 	// Write data table footer
			log.println("++++++++++++++++++++++++++++++++++++++++++"
					+ "+++++++++++++++++++++++++++++++++++");
			log.println();

		 	// Write closing messages to log
			log.println("STATUS > CountryData FILE closed");
			log.println("STATUS > Log FILE closed");

		} catch (IOException e) {

			e.printStackTrace();

		}

	}

	/* ******************************** *
	 * 		Methods		    *
	 * ******************************** */

	/**
	 * Calculates byte offset.
	 * @param i storage location to calculate
	 * @return byte offset
	 */
	private static long offset(int i) {

		return ((i - 1) * 82) + 6;
		
	}

}
