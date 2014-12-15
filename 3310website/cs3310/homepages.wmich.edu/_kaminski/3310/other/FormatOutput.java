// DESCRIPTION:  This program demonstrates various types of formatting that can be done
//      when using Java's "format".  Typically, it's the NUMERIC type (and DATE type)
//      variables that need formatting this way, not string, char, etc.
//
// THE BASIC FLAGS FOR FORMATTING:
//      (from: http://docs.oracle.com/javase/1.5.0/docs/api/java/util/Formatter.html)
//      The following table summarizes the supported conversions. Conversions denoted 
//      by an upper-case character (i.e. 'B', 'H', 'S', 'C', 'X', 'E', 'G', 'A', and 'T') 
//      are the same as those for the corresponding lower-case conversion characters 
//      except that the result is converted to upper case according to the rules of 
//      the prevailing Locale. The result is equivalent to the following invocation 
//      of String.toUpperCase()
//
//      Conversion  Argument        Description
//      'b', 'B'    general         If the argument arg is null, then the result is "false". 
//                                  If arg is a boolean or Boolean, then the result is the 
//                                  string returned by String.valueOf(). Otherwise, the result 
//                                  is "true".
//      'h', 'H'    general         If the argument arg is null, then the result is "null". 
//                                  Otherwise, the result is obtained by invoking 
//                                  Integer.toHexString(arg.hashCode()).
//      's', 'S'    general         If the argument arg is null, then the result is "null". 
//                                  If arg implements Formattable, then arg.formatTo is invoked. 
//                                  Otherwise, the result is obtained by invoking arg.toString().
//      'c', 'C'    character       The result is a Unicode character
//      'd'         integral        The result is formatted as a decimal integer
//      'o'         integral        The result is formatted as an octal integer
//      'x', 'X'    integral        The result is formatted as a hexadecimal integer
//      'e', 'E'    floating point  The result is formatted as a decimal number in 
//                                  computerized scientific notation
//      'f'         floating point  The result is formatted as a decimal number
//      'g', 'G'    floating point  The result is formatted using computerized scientific 
//                                  notation or decimal format, depending on the precision 
//                                  and the value after rounding.
//      'a', 'A'    floating point  The result is formatted as a hexadecimal floating-point 
//                                  number with a significand and an exponent
//      't', 'T'    date/time       Prefix for date and time conversion characters. 
//                                  See Date/Time Conversions.
//      '%'         percent         The result is a literal '%' ('\u0025')
//      'n'         line separator  The result is the platform-specific line separator 
//
// Also see http://docs.oracle.com/javase/tutorial/java/data/numberformat.html
//
// DISCLAIMER:  This program does not follow good programming practices because of its
//      length.  Any method (including Main) which is longer than a page/screen (ish)
//      should probably be subdivided into smaller modules (methods, classes).
//      However, I'm doing it this way because we haven't yet covered such 
//      modularization (sufficiently) and it is only for demonstration purposes.
// *************************************************************************************

package formatoutput;

import java.util.Calendar;

public class FormatOutput 
{
    public static void main(String[] args)
    {
        double d = 123456789.987654321;
        int i = -99887766;

        System.out.format("THE ORIGINAL NUMBERS:  d: %f, i: %d\n", d, i);

        // ********************************************************

        System.out.println("\nSPECIFY WIDTH (& LEFT/RIGHT-JUSTIFIED WITHIN WIDTH)");
        System.out.format("\td: [%22f] \t i: [%12d]\n", d, i);
        System.out.format("pad w/ 0s: [%022f] \t i: [%012d]\n", d, i);
        System.out.format("\td: [%-22f] \t i: [%-12d]\n", d, i);
        System.out.format("\t(next line had widths of 10 & 5, too small so. . .)\n");
        System.out.format("\td: [%10f] \t\t i: [%5d]\n", d, i);

        // ********************************************************
        
        System.out.println("\nFLAGS");
        System.out.println("\tNegative or positive numbers (for padding - see above)");
        System.out.println("\t'0' (pad with 0's - see above)");
        System.out.format("\t',' d: %,f \t i: %,d\n", d, i);
        System.out.format("\t'+' d: %+f \t i: %+d\n", d, i);
        System.out.format("\t'(' d: %(f \t i: %(d\n", d, i);
        System.out.format("\t'0' d: %04f \t i: %04d\n", d, i);

        // ********************************************************

        System.out.println("\nUSE VARIOUS FORMAT CODES");
        //  YOU CAN USE CAPITAL LETTER CODES TOO: B,H,S,C,X,E,G,A,T
        //      (essentially equivalent to ".toUpperCase()")
        System.out.format("\t(b: boolean)   T: %b \t\t\t F: %b\n", Boolean.TRUE, Boolean.FALSE);
        System.out.format("\t(h: hexString) d: %h \t\t i: %h\n", d, i);
        System.out.format("\t(s: toString)  d: %s \t i: %s\n", d, i);
        System.out.format("\t(c: char)      a: %c \t\t\t b: %c\n", 'a', 'b');
        System.out.format("\t\t(ints only)\n");
        System.out.format("\t(d: dec int)   d: %d \t\t i: %d\n", (int)d, i);
        System.out.format("\t(o: octal)     d: %o \t\t i: %o\n", (int)d, i);
        System.out.format("\t(x: hex)       d: %x \t\t i: %x\n", (int)d, i);
        System.out.format("\t\t(floats only)\n");
        System.out.format("\t(e: sci not.)  d: %e \t\t i: %e\n", d, (float)i);
        System.out.format("\t(f: dec num)   d: %f \t i: %f\n", d, (float)i);
        System.out.format("\t(g: sc not/dec)d: %g \t\t i: %g\n", d, (float)i);
        System.out.format("\t(a: hex float) d: %a \t i: %a\n", d, (float)i);
        System.out.format("\t(t: date/time) date: %tc\n", Calendar.getInstance());

        // ********************************************************

        System.out.println("\nSPECIFY NUMBER OF PLACES AFTER DEC PT");
        System.out.format("\t(.4f)   d: %.4f \t i: %.4f\n", d, (float)i);
        System.out.format("\t(.4e)   d: %.4e \t\t i: %.4e\n", d, (float)i);      
        
        System.out.println("\n**Other useful tools include NumberFormat, DecimalFormat, MaskFormatter");
        
        // regex formatting
        System.out.print("\nYou can also look into regex:\n\t(ex:)\t");
        long phoneNum = 1234567890;
        System.out.println(String.valueOf(phoneNum).replaceFirst("(\\d{3})(\\d{3})(\\d+)", "($1)-$2-$3"));
        
        // ******************************************************** 
        
        System.out.println("\nTo print integers as 2-columns, simply use '%02d':");
        System.out.println("\tFor example, 25, 7, -1, 0 prints like:");
        int[] intList = new int[] {25,7,-1,0};
        for (int x : intList)
        {
            System.out.format("\t%02d\n", x);
        }        
    }
}
