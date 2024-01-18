

<?php

echo '<p>Never a dull moment with databases!</p>';

?>

- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

<?php

// For development, you can tell PHP to display errors right in your browser:
ini_set("display_errors", "true");

// The Web server needs to log into the SQL server using an ID and password
// so we need to supply these items.

//Set values (variables) for username, password, server, and database
$user="root";
$pw="CHIPSTER";
$host="127.0.0.1:8806";
$db="persons";

// Create query string
$queryString="SELECT PersonID,FirstName,LastName FROM Persons LIMIT 0,200";

// The following lines are for troubleshooting
// They will show the values of the variables we've created 
echo "<p>";
echo "User Name: <b> $user </b> <p>";
echo "Password: <b> $pw </b> <p>";
echo "Server: <b> $host </b> <p>";
echo "Database: <b> $db </b> <p>";
echo "QueryString: <b> $queryString </b> <p>";

// Create the connection to the MySQL server using the aforementioned ID and password 
$conn = new mysqli($host, $user, $pw, $db );

echo "So far so good...";

//check connection
if ($conn->connect_error) {
printf("Connect failed: %s\n", mysqli_connect_error());
exit();
}

// Now run the select query we created earlier
if ($results = $conn->query($queryString)) {

// Start drawing table
echo "<table border='1' cellpadding='4' cellspacing='0' style='border-collapse: collapse' bordercolor='#C0C0C0'>";

// Draw table headings
print"<tr>";
print"<th>First Name</th>";
print"<th>Last Name</th>";
print"</tr>";

// Draw table rows using associative array in a loop
while($row = $results->fetch_array(MYSQLI_ASSOC)){
print "<tr>";
print "<td>".$row["FirstName"] ."</td>";
print "<td>".$row["LastName"] ."</td>";
print "</tr>";
}

echo "<p>";

// Close result set to free memory and avoid duplication
$results->close();
}

// Close connection to free memory
$conn->close();

// Wrap up table
echo "</table>";

?>
