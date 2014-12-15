// PROGRAM:  Hierarchical Structure
// AUTHOR:  D. Kaminski
// DESCRIPTION:  This shows the hierarchical program structure, with:
//          - a main CONTROLLER method (the boss) which doesn't do much actual work,
//              but shows "the big picture" of what that overall module does including:
//                  - the overall control structure
//                  - calls to worker methods to do the actual work
//                  - maybe doing a bit of actual work itself
//          - subordinate WORKER methods which actually DO THE WORK
//                  - these do NOT call another peer method, any calls to a peers would
//                      be done by the controller
//                  - they could themselves be a controller method which calls its own
//                      subordinate worker methods
//
// THIS IS THE COMMONLY USED (STRONGLY PREFERRED) PROGRAM STRUCTURE.
// *************************************************************************************

package hierarchicalstructure;

public class HierarchicalStructure 
{
    public static void main(String[] args) 
    {
        Controller();
    }
    // *****************************************************************************
    private static void Controller()
    {
        System.out.println("\nHierarchicalStructure.Controller");
        MethodA();
        MethodB();
        MethodC();
    }
    // *****************************************************************************
    private static void MethodA()
    {
        System.out.println("MethodA");
    }
    // *****************************************************************************
    private static void MethodB()
    {
        System.out.println("MethodB");
    }
    // *****************************************************************************
    private static void MethodC()
    {
        System.out.println("MethodC");
        MethodC_Subordinate1();
        MethodC_Subordinate2();
    }
    // *****************************************************************************
    private static void MethodC_Subordinate1()
    {
        System.out.println("MethodC_Subordinate1");
    }
    // *****************************************************************************
    private static void MethodC_Subordinate2()
    {
        System.out.println("MethodC_Subordinate2");
    }        
}
