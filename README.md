# php math parser postfix


This class only works with binary operators.

To use just create the object and call the calculate method with the string

//create an object of the class
$mathClass = new solveMathString();

//print the result
echo $exp = $mathClass->calculate("(20*(30+ 10) / (10*2))");


This code works on postfix logic, converting the infix expression to postfix.


