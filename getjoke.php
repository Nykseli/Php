<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<html>
    <head>
        <title>Joke selector</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

    </head>
<style>
body{
    background-color: lightgrey;
    color: green;
}
</style>
<body>
<?php
    $q = $_GET['q'];


    $dBase = new mysqli("localhost", "root", "", "jokedb");

    mysqli_select_db($dBase,"jokedb");
    $sql = "SELECT joketext FROM jokelist WHERE type = '$q' ORDER BY RAND() LIMIT 1";
    $result = $dBase->query($sql);

    while ($row = $result->fetch_assoc()) {
        echo"<p>" . $row["joketext"] . "</p>";
    }

?>

</body>

</html>
