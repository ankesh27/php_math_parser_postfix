<?php
define("DEBUG", 0);
class MathString
{
/*
 * calculate the passed string and solve the math expression
 * only takes binary operators
 * @math_string string
 * @return integer
 */
    function calculate($math_string)
    {
        if(DEBUG)
        {
            echo $math_string;
            echo PHP_EOL;
        }
        $split_string = str_split($math_string);
        //echo "<pre>";echo "string";echo PHP_EOL;
        //print_r($math_string);
    
        // array for numbers
        $values = array();
    
        // array for Operators
        $operators = array();
    
        for ($i = 0; $i < count($split_string); $i++) {
            if ($split_string[$i] == ' ') //if we have a white space or a space string
                continue;
    
            // Current string is a number, push it to array for numbers
            if ($split_string[$i] >= '0' && $split_string[$i] <= '9') {
                $single_string = '';
                // There may be more than one digits in number
                while ($i < count($split_string) && $split_string[$i] >= '0' && $split_string[$i] <= '9'){
                    $single_string.=$split_string[$i];
                    $i+=1;
                }
                $i-=1;
               // echo "number-".$single_string;echo PHP_EOL;
                array_unshift($values, $single_string);
            }
            
            else if ($split_string[$i] == '(') {
                //echo "(-";echo PHP_EOL;
                array_unshift($operators, $split_string[$i]);
                
            }
    
            // if colsing braces found solve the problem
            else if ($split_string[$i] == ')') {
                //echo ")-";echo PHP_EOL;
                while ($operators[0] != '('){
                    array_unshift($values, $this->calculate_two_strings(array_shift($operators), array_shift($values), array_shift($values)));
                }
                array_shift($operators);
            }
    
            // operator found.
            else if ($split_string[$i] == '+' || $split_string[$i] == '-' || $split_string[$i] == '*' || $split_string[$i] == '/') {
               // echo "operator found";echo PHP_EOL;
                
                while (!empty($operators) && $this->has_high_val($split_string[$i], $operators[0]))
                    array_unshift($values, $this->calculate_two_strings(array_shift($operators), array_shift($values), array_shift($values)));
    
                
                array_unshift($operators, $split_string[$i]);
                
            }
                $this->printStack($values);
                //print_r($operators);
    
        }
    
        // solve remaining equation
        while (!empty($operators))
            array_unshift($values, $this->calculate_two_strings(array_shift($operators), array_shift($values), array_shift($values)));
        $this->printStack($values);
        //print_r($operators);
        
    
        // return result
        return array_shift($values);
    }
    
    function has_high_val($op1, $op2)
    {
        if ($op2 == '(' || $op2 == ')')
            return false;
        if (($op1 == '*' || $op1 == '/') && ($op2 == '+' || $op2 == '-'))
            return false;
        else
            return true;
    }
    
    
    function calculate_two_strings($operator, $s2, $s1)
    {
        $this->printStack('performing-'.$s1.$operator.$s2);
        switch ($operator)
        {
            case '+':
                return $s1 + $s2;
            case '-':
                return $s1 - $s2;
            case '*':
                return $s1 * $s2;
            case '/':
                if ($s2 == 0)
                    die("Invalid");
                return $s1 / $s2;
        }
        return 0;
    }
    
    function printStack($a)
    {
        if(DEBUG)
        {
        echo PHP_EOL."<pre>";
        print_r($a);
        echo "</pre>".PHP_EOL;
        }
    }
}
//create an object of the class
$mathClass = new solveMathString();

//print the result
echo $exp = $mathClass->calculate("(20*(30+ 10) / (10*2))");
?>
