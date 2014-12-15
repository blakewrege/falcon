// STATIC CLASS:  GotoStructure      used by PROGRAM: ProgStr
// DESCRIPTION:  This shows the goto hierarchical program structure.  It is shown here
//      using recursive calls (which masks the "forbidden" use of goto command).
// NOTE:  goto is sometimes seen as appropriate to use in an emergency exit situation.
// NOTE:  recursion is USEFUL when:
//          - a method calls just itself (not A calls B calls C calls D calls A...)
//          - and for processing recursive data structures (like binary search trees).
//        Recursion is NOT generally used for:
//          - linear processing of a sequential access file or an arrays, although they
//              are both recursive data structures
//          - a looping structure (other than a method calling itself)
// *************************************************************************************

using System;

namespace ProgStr
{
    static class GotoStructure
    {
        static int count = 0;
        public static void Starter()
        {
            Console.WriteLine("\nGotoStructure.Starter");
            MethodA();
        }
        // *****************************************************************************
        private static void MethodA()
        {
            count++;
            if (count == 2)
                return;
            Console.WriteLine("MethodA");
            MethodB();
        }
        // *****************************************************************************
        private static void MethodB()
        {
            Console.WriteLine("MethodB");
            MethodC();
        }
        // *****************************************************************************
        private static void MethodC()
        {
            Console.WriteLine("MethodC");
            MethodC_Subordinate1();
        }
        // *****************************************************************************
        private static void MethodC_Subordinate1()
        {
            Console.WriteLine("MethodC_Subordinate1");
            MethodC_Subordinate2();
        }
        // *****************************************************************************
        private static void MethodC_Subordinate2()
        {
            Console.WriteLine("MethodC_Subordinate2");
            MethodA();
        }
    }
}
