package testreadrawdatafile;

import java.io.*;
import java.util.Scanner;

public class TestReadRawDataFile {

    public static void main(String[] args) throws IOException {
        
        // THIS DOESN'T WORK BECAUSE THE DATA FILE HAS EXTENDED ASCII CHAR'S
        // e.g., the 11th field of the 1st record has México (accent on e)

//        File inFile = new File("A2ZRawData.csv");             
//        Scanner input = new Scanner(inFile);
//     
//        String aLine;
//       
//        while (input.hasNext()) {
//            aLine = input.nextLine();
//            System.out.println(aLine);
//        }
//        
//        input.close();
               
        //---------------------------------------------------------------------
        // USE THIS INSTEAD TO DEAL WITH THE EXTENDED ASCII CHAR'S
        
        FileReader inFile = new FileReader("A2ZRawData.csv");
        BufferedReader input = new BufferedReader(inFile);
   
        String aLine;
        
        while ((aLine = input.readLine()) != null) {
            System.out.println(aLine);
        }
        input.close();
        inFile.close();      
    }
}
