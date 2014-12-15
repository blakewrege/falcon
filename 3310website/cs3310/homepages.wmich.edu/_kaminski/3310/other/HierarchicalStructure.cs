// STATIC CLASS:  Hierarchical Structure      used by PROGRAM: ProgStr
// DESCRIPTION:  This shows the hierarchical program structure.
//
// THIS IS THE COMMONLY USED (STRONGLY PREFERRED) PROGRAM STRUCTURE.
// *************************************************************************************

using System;

namespace ProgStr
{
    static class HierarchicalStructure
    {
        public static void Controller()
        {
            Console.WriteLine("\nHierarchicalStructure.Controller");
            MethodA();
            MethodB();
            MethodC();
        }
        // *****************************************************************************
        private static void MethodA()
        {
            Console.WriteLine("MethodA");
        }
        // *****************************************************************************
        private static void MethodB()
        {
            Console.WriteLine("MethodB");
        }
        // *****************************************************************************
        private static void MethodC()
        {
            Console.WriteLine("MethodC");
            MethodC_Subordinate1();
            MethodC_Subordinate2();
        }
        // *****************************************************************************
        private static void MethodC_Subordinate1()
        {
            Console.WriteLine("MethodC_Subordinate1");
        }
        // *****************************************************************************
        private static void MethodC_Subordinate2()
        {
            Console.WriteLine("MethodC_Subordinate2");
        }
    }
}
