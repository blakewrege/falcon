// PROGRAM:  LoopStr
// AUTHOR:  D. Kaminski
// DESCRIPTION:  This demonstrates using recursion as a looping structure to process
//      a file.  Although it does work, and some may argue that a sequential access file
//      IS indeed a recursive structure, this is not commonly seen as an appropriate
//      looping structure for file handling.  Similarly, it is not commonly used for
//      linear processing of an array.
// NOTE:  Structured programming languages generally use:
//      - while loops (an event-controlled loop) for linear processing of a file
//      - for loops (a count-countrolled loop) for processing arrays since N is known
// NOTE:  The Prolog programming language does not contain loop-control commands like
//      while and for because it is designed as a declarative rather than procedural
//      language (used for artificial intelligence problems).  Since recursion is built
//      in for declaring rule definitions, it is availabe for control as well.  As such
//      it is the main loop-control structure (in addition to backtrack/fail.
// *************************************************************************************

package loopstr;

import java.io.*;

public class LoopStr 
{
    public static void main(String[] args) throws FileNotFoundException, IOException 
    {
        BufferedReader inFile = new BufferedReader(new FileReader("InFile.txt"));

        ReadARec(inFile);

        inFile.close();
    }
    // ******************************************************************************
    static void ReadARec(BufferedReader inFile) throws IOException
    {
        String aLine;

        if ((aLine = inFile.readLine()) == null)
        {
            return;      
        }
        else
        {
            System.out.println(aLine);
            ReadARec(inFile);      
        }      
    }
}
