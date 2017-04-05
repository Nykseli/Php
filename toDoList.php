<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!DOCTYPE html>
<html>
    <head>
        <title>ToDoList</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css">
        <style>
        body{

            max-width: 60%;
            text-align: center;
            background-color: rgb(179, 179, 204);
        }
        div{
            border-style: solid;
            border-width: 3px;
            border-radius: 3px;
            background-color: white;
        }
        .complete{
            border-width: 3px;
            border-radius: 3px;
            background-color: green;
        }
        </style>
    </head>
    <h1>ToDoList</h1>
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <input type = "text" name="message" placeholder="Enter a task">
        <br/>
        <input type = "text" name="taskId" placeholder="Delete by id">
        <br/>
        <input type = "txt" name="completeId" placeholder="Complete by id">
        <br/>
        <input type = "submit" value="Confirm">
    </form>
    <!-- <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="remove">
        <input type = "text" name="taskId" placeholder="Delte by id">
        <input type = "submit" value="Delete">
    </form> -->

    <?php
        $user = "root";
        $pass = "";
        $db = "tododb";

        #Connect to the database
        $dBase = new mysqli("localhost", $user, $pass, $db) or die("Unable to connect");

        #Check the database connection
        if($dBase->connect_error){
            echo "<p>" . $dBase->connect_error . "</p>";
        }
        #Create a new todolist TABLE if there is not one
        $sql = "CREATE TABLE todolist (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            message VARCHAR(30) NOT NULL,
            complete INT(1) DEFAULT 0
        )";

        if($dBase->query($sql) === TRUE){
            echo "<p>yay</p>";
        }else{
            echo "<p>" . $dBase->connect_error . "</p>";

        }


        #Restet the task id to start from 1
        #or atleast it should do that
        function resetIncrement(){
            global $dBase;

            $sql = "ALTER TABLE todolist AUTO_INCREMENT = 1";

            $dBase->query($sql);

        }
        #Show all the tasks from database
        function showTasks(){
            global $dBase;

            $sql = "SELECT * FROM todolist";
            $result = $dBase->query($sql);

            while($row = $result->fetch_assoc()){
                $completeCheck = "Not completed";
                if($row["complete"] == 1){
                    $completeCheck = "Completed!";
                    echo "<div class='complete'><p>" . "Id: " . $row["id"] . "<br/> Task: " . $row["message"] . "<br/> Status: " . $completeCheck . "</p></div>";
                }else{
                    echo "<div><p>" . "Id: " . $row["id"] . "<br/> Task: " . $row["message"] . "<br/> Status: " . $completeCheck . "</p></div>";
                }
            }
        }
        #Add a task to the database
        function addTask($task){
            global $dBase;
            $sql = "INSERT INTO todolist (message) VALUES ('$task')";
        //    $result = mysql_query($sql, $dBase);
            if ($dBase->query($sql) === TRUE) {
                echo "<p>New task added successfully</p>";
                } else {
                    echo "<p>Error: " . $sql . "<br>" . $dBase->error . "</p>";
                }

        }

        #Complet a task by id
        function completeTask($id){
            global $dBase;
            $sql = "UPDATE todolist set complete=1 WHERE id='$id'";

            $dBase->query($sql);
        }

        #Remove a task from the database
        function removeTask($id){
            global $dBase;
            $sql = "DELETE FROM todolist WHERE id='$id'";


            if($dBase->query($sql) === TRUE){
                echo "<p>Task removed successfully</p>";
                }else{
                    echo "Error: " . $sql . "<br>" . $dBase->error;
            }
        //    showTasks();

        }

        #Add a task if there is text in message box
        if(isset($_POST["message"]) ){
            $message = $_POST["message"];
            if($message != ""){
                addTask($message);
                //resetIncrement();
            }
        }
        #Delete task if there is id in a id box
        if(isset($_POST["taskId"])){
            $taskId = $_POST["taskId"];
            if(strlen($taskId) > 0){
                removeTask($taskId);
                //resetIncrement();

            }
        }
        #Update task as completed by id
        if(isset($_POST["completeId"])){
            $complet = $_POST["completeId"];
            if($complet != ""){
                completeTask($complet);
            }
        }
        showTasks();
        // if($_SERVER["REQUEST_METHOD"] == "POST"){
        //     $message = htmlspecialchars($_REQUEST["message"]);
        //     if(strlen($message) > 0){
        //         addTask($message);
        //     }
        //     $remId = htmlspecialchars($_REQUEST["taskId"]);
        //     if(strlen($remid) > 0){
        //         removeTask($remId);
        //     }
        //     showTasks();
        //     //echo "<p>" . $message . "</p>";
        //     resetIncrement();
        // }

        // if($_SERVER["REQUEST_METHOD"] == "remove"){
        //     $remId = htmlspecialchars($_REQUEST["taskId"]);
        //     if(strlen($remid) > 0){
        //         removeTask($remId);
        //     }
        //
        //     echo "<p>" . $remId . "</p>";
        //     resetIncrement();
        // }


     ?>
