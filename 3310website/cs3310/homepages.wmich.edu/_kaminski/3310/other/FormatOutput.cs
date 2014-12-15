// PROGRAM:  FormatOutput
// AUTHOR:  Dr. Kaminski
// DESCRIPTION:  This program demonstrates various types of formatting that can be done
//      when using WriteLine or Write methods.  It's the NUMERIC type (and DATE type)
//      variables that generally need formatting this way, not string, char, etc.
//
// NOTE:  The examples below all use the PLACEHOLDER approach vs. concatenating various
//      strings/values together which are to be written.  The concatenate approach can
//      still be used if the ToString method is used to build a string since the method
//      accepts format strings (with placeholders) and corresponding arguments as its
//      parameter.  This will be demonstrated in another example program dealing with
//      String methods. 
//
// THE BASIC FORMAT FOR PLACEHOLDERS:
//          {Position,Width:FormatCode} in any of these common forms:
//                  {P} or {P,W} or {P:F} or {P,W:F} or {P:FN} or {P,W:FN}
//      P - Position (or index) in argument list (starting at 0)
//      W - Width (# columns or allignment) to print
//			    positive - right-justified
//			    negative - left-justified
//			    (W's value is ignored if it's too small for the actual value)
//      F - Formatting code (with or without the N after it)
//      N - Number of places after the decimal point
//
// DISCLAIMER:  This program does not follow good programming practices because of its
//      length.  Any method (including Main) which is longer than a page/screen (ish)
//      should probably be subdivided into smaller modules (methods, classes).
//      However, I'm doing it this way because we haven't yet covered such 
//      modularization (sufficiently) and it is only for demonstration purposes.
// *************************************************************************************

using System;

namespace FormatOutput
{
    class Program
    {
        static void Main()
        {
            double d = 123456789.987654321;
            int i = 99887766;

            Console.WriteLine("THE ORIGINAL NUMBERS:  d: {0}, i: {1}", d, i);

            // ********************************************************

            Console.WriteLine("\nUSE NON-NORMAL ORDER & RE-USE OF PLACEHOLDERS");
            Console.WriteLine("\ti: {1}, i: {1}, d: {0}\n", d, i);
 
            // ********************************************************

            Console.WriteLine("\nSPECIFY WIDTH (& LEFT/RIGHT-JUSTIFIED WITHIN WIDTH)");
            Console.WriteLine("\td: [{0,22}] \t i: [{1,12}]", d, i);
            Console.WriteLine("\td: [{0,-22}] \t i: [{1,-12}]", d, i);
            Console.WriteLine("\t(next line had widths of 10 & 5, too small so. . .)");
            Console.WriteLine("\td: [{0,10}] \t\t i: [{1,5}]", d, i);

            // ********************************************************

            Console.WriteLine("\nUSE VARIOUS FORMAT CODES");
            //                      YOU CAN USE SMALL LETTER CODES TOO: g,f,e,c,n,p,d,x
            Console.WriteLine("\t(G: general)   d: {0:G} \t i: {1:G}", d, i);
            Console.WriteLine("\t(F: fixedPt)   d: {0:F} \t\t i: {1:F}", d, i);
            Console.WriteLine("\t(E: sci not.)  d: {0:E} \t i: {1:E}", d, i);
            Console.WriteLine("\t(N: with ,'s)  d: {0:N} \t i: {1:N}", d, i);
            Console.WriteLine("\t(C: currency)  d: {0:C} \t i: {1:C}", d, i);
            Console.WriteLine("\t(P: percent)   d: {0:P} \t i: {1:P}", d, i);
            Console.WriteLine
                ("\t\tNotice 25 prints as {0:P} and .25 prints as {1:P} with P", 25, .25);
            Console.WriteLine
                ("\n\tX code (heXadecimal) only works on int values, so d was cast 1st");
            Console.WriteLine("\t(X: hex int)   d: {0:X} \t\t i: {1:X}", (int)d, i);

            // ********************************************************

            Console.WriteLine("\nSPECIFY NUMBER OF PLACES AFTER DEC PT");
            Console.WriteLine("\t(F4)   d: {0:F4} \t i: {1:F4}", d, i);
            Console.WriteLine("\t(E4)   d: {0:E4} \t\t i: {1:E4}", d, i);
            Console.WriteLine("\t(N4)   d: {0:N4} \t i: {1:N4}\n", d, i);
            Console.WriteLine("\t(C4)   d: {0:C4} \t i: {1:C4}", d, i);
            Console.WriteLine
                ("\tSo (P0) for 25 prints as {0:P0} and .25 prints as {1:P0}", 25, .25);

            // ********************************************************

            Console.WriteLine("\nUSE CURRENCY CODE (C) WITH DIFFERENT VALUES");
            Console.WriteLine
                ("\t9.99 is {0:C}, 12345.6789 is {1:C}, 0 is {2:C}, .27 is {3:C}" +
                    ",\n\t\t 12 is {4:C}, .9 is {5:C}",
                    9.99, 12345.6789, 0, .27, 12, .9);
            Console.WriteLine
                ("\tand specifying a width of 7 for all of the above:");
            Console.WriteLine
                 ("\t\t[{0,7:C}],[{1,7:C}],[{2,7:C}],[{3,7:C}],[{4,7:C}],[{5,7:C}]",
                    9.99, 12345.6789, 0, .27, 12, .9);
           
            // ********************************************************

            Console.WriteLine("\nSPECIFY CUSTOM FORMAT STRING");

            //                  # SYMBOLS INDICATE A COLUMN FOR A DIGIT
            Console.WriteLine("\tUsing #'s for digit-columns:");
            Console.WriteLine("\tWIN:  {0:###-###-###} or is it {0:###-##-####}",
                123456789);
            Console.WriteLine("\tBut a WIN like 001234567 shows as: {0:###-###-###}",
                001234567);
            Console.WriteLine("\tAnd a WIN like 000000004 (or 4) shows as: " +
                "{0:###-###-###} (or {0:###-###-###})", 000000004, 4);

            //                  0 SYMBOLS INDICATE "DON'T SUPPRESS LEADING 0'S
            Console.WriteLine("\tSo use 0's not #'s in format string: 001234567 shows as " +
                "{0:000-000-00#}", 001234567);
            Console.WriteLine("\tAnd 123 prints as {0:000-000-00#}, 0 prints as " +
                "{1:000-000-00#}", 123, 0);

            //                  FOR LONGER FORMAT STRINGS OR THOSE THAT WOULD BE USED
            //                  MULTIPLE TIMES, YOU CAN DO THE FOLLOWING:
            string formatStr = "{0:(###) ###-####}";
            Console.Write("\n\tPHONE:  ");
            Console.WriteLine(formatStr, 2693871000);

            //                  3 POSSIBLE FORMATTERS, SEPARATED BY ;'s
            //                          1) FOR HANDLING POSITIVE NUMBERS
            //                          2) FOR HANDLING NEGATIVE NUMBERS
            //                          3) FOR HANDLING 0
            Console.WriteLine("\n\tFormat string for handling positives, negatives " +
                "and zero differently");
            formatStr = "{0:$#,##0.00;($#,##0.00CR);0.00}";
            Console.WriteLine("\t\t14.92  displays as: " + formatStr, 14.92);
            Console.WriteLine("\t\t-14.92 displays as: " + formatStr, -14.92);
            Console.WriteLine("\t\t0      displays as: " + formatStr, 0);

            // *************************************************************************
            Console.Write("\n\nHit ENTER to quit");
            Console.ReadLine();
        }
    }
}
