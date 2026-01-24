<?php
/* What's the Problem? 
    - PHP logic + HTML in one file
    - Works, but not scalable
    - Repetition will become a problem

    How can we refactor this code so it’s easier to maintain?
*/

// From this lab, I learned how separating PHP logic into reusable include files
//(like header, footer, and loops) improves organization and maintainability,
//which I will apply in Course Project Phase One to keep my code scalable. 

$items = ["Home", "About", "Contact"];
require "includes/header.php";

require "includes/foreach.php";
require "includes/footer.php";
?>

