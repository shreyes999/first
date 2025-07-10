<?php
$servername = "localhost";
$username = "username";
$password = "password";
$database = "todo";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $result = mysqli_query($conn, "SELECT * FROM todos WHERE name='$name'");
    $num_rows = mysqli_num_rows($result);
    if ($num_rows) {
        echo '<h1>already exists.</h1>';
    } else {
        $name = $_POST['name'];
        $sql = "INSERT INTO todos(name) VALUES ('$name')";
        $conn->query($sql);
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form method="post" action="/index.php">
        <input type="submit" value="back">
    </form>
    <table class="table-container">
        <tr>
            <th id="num">no</th>
            <th id="todo">todo</th>
            <th id="del">delete(double tap)</th>
        </tr>

        <?php
        $display = "SELECT * FROM todos";
        $result = $conn->query($display);
        $user =  $result->fetch_assoc();


        if ($result->num_rows > 0) {
            // output data of each row
            $i = 0;
            while ($row = $result->fetch_assoc()) {
                if (isset($row['name'])) {
                    echo '<tr><td>' . ($i += 1) . '</td>';
                    echo '<td>' . $row['name'] . '</td><td>';
                    echo '<form method="GET" action="">
                        <input type="hidden" name="del_id" value="' . $row['id'] . '">
                        <input type="submit" id="del" name="del" value="delete">
                    </form>';
                    echo '</td></tr>';
                }
            }
        } else {
            echo "0 results";
        };
        if (isset($_GET['del_id'])) {
            $del_id = $_GET['del_id'];
            $delete = "DELETE FROM todos WHERE id=$del_id";
            $conn->query($delete);
        }

        ?>
    </table>


</body>

</html>