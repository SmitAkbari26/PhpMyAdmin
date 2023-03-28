<?php

session_start();

if (isset($_SESSION['success'])) {
    $tablename = $_SESSION['tablename'];
    $columns = $_SESSION['columns'];

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PhpMyAdmin</title>
    </head>

    <body>
        <form method="post" style="width:100%; height:100%;">
            <fieldset style="width: 70%; margin:auto; height:100%;display:flex; justify-content:center; align-items:center; flex-direction:column;">
                <legend>Structure</legend>
                <table style="margin: 1rem;">
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Length/Value</th>
                        <th>Default</th>
                        <th>Index</th>
                        <th>AI</th>
                    </tr>
                    <?php
                    for ($i = 0; $i < $columns; $i++) {
                    ?>
                        <tr>
                            <td>
                                <input type="text" name="name[]" id="name">
                            </td>
                            <td>
                                <select name="type[]">
                                    <option value="int">INT</option>
                                    <option value="varchar">VARCHAR</option>
                                    <option value="date">DATE</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" name="value[]" id="value">
                            </td>
                            <td>
                                <select name="default[]">
                                    <option value="NOT NULL">NONE</option>
                                    <option value="NULL">NULL</option>
                                    <option value="CURRENT_TIMESTAMP">CURRENT_TIMESTAMP</option>
                                </select>
                            </td>
                            <td>
                                <select name="index[]">
                                    <option value="">---</option>
                                    <option value="PRIMARY KEY">PRIMARY</option>
                                    <option value="unique">UNIQUE</option>
                                    <option value="index">INDEX</option>
                                </select>
                            </td>
                            <td>
                                <input type="checkbox" value="AUTO_INCREMENT" name="ai[ <?php echo $i ?> ]" id="ai">
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </table>
                <button type="submit" name="submit" style="border-radius: 20px; padding: 0.5rem 2rem; margin-top: 10px;">Save</button>
            </fieldset>
        </form>
    </body>

    </html>
<?php

    if (isset($_POST['submit'])) {
        if (isset($_POST['name']) && isset($_POST['type']) && isset($_POST['value']) && isset($_POST['default']) && isset($_POST['index']) && isset($_POST['ai'])) {

            $name = $_POST['name'];
            $type = $_POST['type'];
            $value = $_POST['value'];
            $default = $_POST['default'];
            $index = $_POST['index'];
            $ai = $_POST['ai'];
            if (isset($_POST['ai'])) {
                $indexAI = array_search("AUTO_INCREMENT", $_POST['ai'], true);
            }
            if (isset($_POST['index'])) {
                $indexI = array_search("PRIMARY KEY", $_POST['index'], true);
            }

            $serverHost = "localhost";
            $serverName = "root";
            $serverPass = "";
            $dbname = "restaurant";

            $conn = mysqli_connect($serverHost, $serverName, $serverPass, $dbname);

            if (!$conn) {
                die("Error : " . mysqli_connect_error());
            } else {
                $sql = "CREATE TABLE `$tablename` (";
                for ($i = 0; $i < $columns; $i++) {
                    $sql .= "`$name[$i]` $type[$i]($value[$i]) $default[$i]";
                    if ($i == $indexAI) {
                        $sql .= " $ai[$indexAI],";
                    } else {
                        $sql .= ",";
                    }
                }
                $sql .= "$index[$indexI] (`$name[$indexI]`)";
                $sql .= ")";
                echo "SQL : " . $sql;
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo "<br/> Table created successfully";
                } else {
                    echo "Table not created successfully" . mysqli_error($conn);
                }
            }
        } else {
            echo "ERROR: Fields are required";
        }
    }
}
