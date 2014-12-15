// PROGRAM:  GotoStructure 
// AUTHOR:  D. Kaminski
// DESCRIPTION:  This shows the goto hierarchical program structure.  It is shown here
//      using recursive calls (which masks the "forbidden" use of goto command):
//          - a main STARTER method which may include
//                  - doing some actual work
//                  - a call to a 2nd method - in effect, "pushing go",
//          - a 2nd method which does some actual work (whatever the MethodName says it
//                  is supposed to do),
//                  then at the bottom (tail recursion) it calls a 3rd method
//                  (i.e., a peer method)
//          - a 3rd method which does some actual work
//                  then at the bottom it calls a 4th method
//          - etc. etc.
//          - an Nth method which does some actual work
//                  then at the bottom calls the 2nd method
//          And one of these methods has a condition which stops the program execution.
// NOTE:  goto is sometimes seen as appropriate to use in an emergency exit situation.
// NOTE:  recursion is USEFUL when:
//          - a method calls just itself (not A calls B calls C calls D calls A...)
//          - and for processing recursive data structures (like binary search trees).
//        Recursion is NOT generally used for:
//          - linear processing of a sequential access file or an arrays, although they
//              are both recursive data structures
//          - a looping structure (other than a method calling itself)
// *************************************************************************************

package gotostructure;

public class GotoStructure 
{
    static int count = 0;        
    public static void main(String[] args) 
    {
        Starter();
    }
    // *****************************************************************************   
    private static void Starter()
    {
        System.out.println("\nGotoStructure.Starter");
        MethodA();
    }
    // *****************************************************************************
    private static void MethodA()
    {
        count++;
        if (count == 2)
            return;
        System.out.println("MethodA");
        MethodB();
    }
    // *****************************************************************************
    private static void MethodB()
    {
        System.out.println("MethodB");
        MethodC();
    }
    // *****************************************************************************
    private static void MethodC()
    {
        System.out.println("MethodC");
        MethodC_Subordinate1();
    }
    // *****************************************************************************
    private static void MethodC_Subordinate1()
    {
        System.out.println("MethodC_Subordinate1");
        MethodC_Subordinate2();
    }
    // *****************************************************************************
    private static void MethodC_Subordinate2()
    {
        System.out.println("MethodC_Subordinate2");
        MethodA();
    }       
}
