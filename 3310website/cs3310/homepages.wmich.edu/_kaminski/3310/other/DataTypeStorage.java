// PROGRAM:  DataTypeStorage
// AUTHOR:  D. Kaminski
// DESCRIPTION:  This program creates a binary file with values of a variety of different
//      data types.  After running the program, examine what's in the file for the
//      different data types.  What you see in the file is what's stored in memory
//      for the value with that data type .
// NOTE ON BIG ENDIAN FOR NUMBERIC DATA:  numeric values are stored as "big endian"
//      in Java (vs "little endian" in C#). Big endian means that the most significant 
//      byte of the number is stored on the left as the first byte (similar to a number
//      written on paper).  With little endian, the most significant byte would be on 
//      the right as the last byte.  (The BITS aren't reversed, the BYTES are reversed.)  
//      For example, In Hex, an int 15 would be 00 00 00 0E (as humans typically
//      represent it, i.e., the 32 bits would be
//              00000000 00000000 00000000 0000000E
//      But little endian would store this as 0E 00 00 00.
//      Similarly, an int in hex (to us) which is 1D A6 FE 21 would be stored as
//      21 FE A6 1D in little endian systems.
//      However, big endian stores the bytes left-to-right (as one would read them).
// NOTE ON STRINGS:  In C#, string storage has a 1-byte unsigned integer length field 
//      preceeding any string.  [Some other systems/languages store strings using 
//      null-terminator (null or '\0') to indicate the end of the string rather than 
//      using a preceeding length field].
//      In Java, (with variable length strings) one could emulate either of the above 
//      methods, or use write/readUTF, which is similar - it writes two preceding bytes 
//      containing the number of bytes being written/read (NOT the length of the string).
//      (This will be at least two plus the length of str, and at most two plus thrice 
//      the length of str.)
// **************************************************************************************

package datatypestorage;

import java.io.*;

public class DataTypeStorage 
{
    public static void main(String[] args) throws FileNotFoundException, IOException 
    {
        FileOutputStream binFile = new FileOutputStream("BinaryFile.bin");
        DataOutputStream binWriter = new DataOutputStream(binFile);
        
        short s = 14;                               // 2 bytes
        int i = 15;                                 // 4 bytes
        long l = 65L;                               // 8 bytes
        binWriter.writeBytes("SHORT-INT-LONG:");
        binWriter.writeShort(s);
        binWriter.writeInt(i);
        binWriter.writeLong(l);
        
        float f = 45.6789F;                         // 4 bytes
        double d = 45.6789;                         // 8 bytes
        binWriter.writeBytes("FLOAT-DOUBLE:");
        binWriter.writeFloat(f);
        binWriter.writeDouble(d);
        
        int iMax = Integer.MAX_VALUE;               // 4 bytes [value: (2 ^ 31) - 1]
        int iMin = Integer.MIN_VALUE;               // 4 bytes [value: (2 ^ 31)
        binWriter.writeBytes("iMAX-iMIN:");
        binWriter.writeInt(iMax);
        binWriter.writeInt(iMin);
        
        boolean bTrue = true;                       // 1 byte [value: 01]
        boolean bFalse = false;                     // 1 byte [value: 00]
        binWriter.writeBytes("BOOL-BOOL:");
        binWriter.writeBoolean(bTrue);
        binWriter.writeBoolean(bFalse);
        
        char chr = 'W';                             // 1 bytes
        String str = "WMU";                         // 3 bytes
        binWriter.writeBytes("CHAR-STRING:");
        binWriter.writeByte(chr);
        binWriter.writeBytes(str);
        
        byte b = Byte.valueOf("10");                 // 1 byte
        byte bMax = Byte.MAX_VALUE;                 // 1 byte
        byte bMin = Byte.MIN_VALUE;                 // 1 byte
        binWriter.writeBytes("BYTE-BYTEMAX-BYTEMIN:");
        binWriter.write(b);
        binWriter.write(bMax);
        binWriter.write(bMin);        
        
        binWriter.close();
        
        System.out.println("Now examine BinaryFile.bin in the HexEditor\n\t" +
            "(or see XVI32 BinaryFile.pdf in the main folder)");
    }
}
