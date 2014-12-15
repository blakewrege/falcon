// PROGRAM:  DataTypeStorage
// AUTHOR:  D. Kaminski
// DESCRIPTION:  This program creates a binary file with values of a variety of different
//      data types.  After running the program, examine what's in the file for the
//      different data types.  What you see in the file is what's stored in memory
//      for the value with that data type .
// NOTE ON LITTLE ENDIAN FOR NUMBERIC DATA:  numeric values are stored as "little endian"
//      on PC's (Windows machines) vs. humans (and Sun workstations) using "big endian"
//      representation.  Little endian means that the most significant byte of the number
//      (the leftmost to a human) is stored on the right.  The BITS aren't reversed, the
//      BYTES are reversed.  In Hex, an int 15 would be 00 00 00 0E (as humans typically
//      represent it, i.e., the 32 bits would be
//              00000000 00000000 00000000 0000000E
//      But little endian would store this as 0E 00 00 00.
//      Similarly, an int in hex (to us) which is 1D A6 FE 21 would be stored as
//      21 FE A6 1D in little endian systems.
// NOTE ON STRINGS:  String storage has a 1-byte unsigned integer length field preceeding
//      any string.  [Some systems/languages stored strings using null-terminator (null
//      or '\0') to indicate the end of the string rather than using a preceeding length
//      field].
// NOTE ON CHAR ARRAYS:  These are stored differently than strings.  Just the char's
//      themselves are stored with NO preceeding length field.
// **************************************************************************************

using System;
using System.IO;

namespace DataTypeStorage
{
    class Program
    {
        static void Main()
        {
            FileStream binFile = new FileStream(".\\..\\..\\..\\BinaryFile.bin",
                                    FileMode.Create, FileAccess.Write);
            BinaryWriter binWriter = new BinaryWriter(binFile);

            short s = 14;                           // 2 bytes
            int i = 15;                             // 4 bytes
            long l = 65;                            // 8 bytes
            binWriter.Write("SHORT-INT-LONG:");
            binWriter.Write(s);
            binWriter.Write(i);
            binWriter.Write(l);

            float f = 45.6789F;                     // 4 bytes
            double d = 45.6789;                     // 8 bytes
            binWriter.Write("FLOAT-DOUBLE:");
            binWriter.Write(f);
            binWriter.Write(d);

            decimal dec = 45.6789M;                 // 16 bytes
            binWriter.Write("DECIMAL:");
            binWriter.Write(dec);

            int iMax = int.MaxValue;                // 4 bytes [value:  (2 ^ 31) - 1]
            int iMin = int.MinValue;                // 4 bytes [value:  (2 ^ 31)]
            binWriter.Write("iMAX-iMIN:");
            binWriter.Write(iMax);
            binWriter.Write(iMin);

            int iMaxPlus1 = iMax + 1;               // 4 bytes [value:  same as iMin !!]
            int iSmallestNeg = (iMax * -1) - 1;     // 4 bytes [value:  (2 ^ 31)]
            binWriter.Write("iMAXPLUS1-iSMALLESTNEG:");
            binWriter.Write(iMaxPlus1);
            binWriter.Write(iSmallestNeg);

            bool bTrue = true;                      // 1 byte [value:  01]
            bool bFalse = false;                    // 1 byte [value:  00]
            binWriter.Write("BOOL-BOOL:");
            binWriter.Write(bTrue);
            binWriter.Write(bFalse);

            char chr = 'W';                         // 1 byte
            string str = "WMU";                     // 1 + 3 bytes
            char[] chrArray = { 'W', 'M', 'U' };    // 3 bytes
            binWriter.Write("CHAR-STRING-CHARARRAY:");
            binWriter.Write(chr);
            binWriter.Write(str);
            binWriter.Write(chrArray);

            byte b1 = Convert.ToByte('W');          // 1 byte
            byte b2 = Convert.ToByte("66");         // 1 byte
            binWriter.Write("BYTE-BYTE:");
            binWriter.Write(b1);
            binWriter.Write(b2);

            byte bMax = Byte.MaxValue;              // 1 byte
            byte bMin = Byte.MinValue;              // 1 byte
            binWriter.Write("BYTEMAX-BYTEMIN:");
            binWriter.Write(bMax);
            binWriter.Write(bMin);

            int iZero = 0;                          // 4 bytes [value:  "all 0 bits"]
            double dZero = 0.0;                     // 4 bytes [value:  "all 0 bits"]
            binWriter.Write("iZERO-dZERO:");
            binWriter.Write(iZero);
            binWriter.Write(dZero);

            char charZero = '0';                    // 1 byte [value: NOT "all 0 bits"]
            string stringZero = "0";                // 1+1 bytes [value: NOT"all 0 bits"]
            binWriter.Write("charZERO-stringZERO:");
            binWriter.Write(charZero);
            binWriter.Write(stringZero);

            char charSpace = ' ';                   // 1 byte
            string stringEmpty = "";                // 1 byte [just the length field: 00]
            binWriter.Write("charSPACE-stringSPACE:");
            binWriter.Write(charSpace);
            binWriter.Write(stringEmpty);

            binWriter.Write("THE END");

            binFile.Close();

            Console.WriteLine("Now examine BinaryFile.bin in the HexEditor\n\t" +
                "(or see XVI32 BinaryFile.pdf in the main folder)");
        }
    }
}
