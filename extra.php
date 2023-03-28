<?php

session_start();

if (isset($_POST['submit'])) {
    if (empty($_POST['columns']) && empty($_POST['tablename'])) {
        header('Location:extra.php?error=ERROR Fields are required');
    } elseif (empty($_POST['tablename'])) {
        header('Location:extra.php?error=ERROR Table name is required');
    } elseif (empty($_POST['columns'])) {
        header('Location:extra.php?error=ERROR Columns is required');
    }
    if (!empty($_POST['tablename']) && !empty($_POST['columns'])) {
        header('Location:extraBack.php');
        $tablename = $_POST['tablename'];
        $columns = $_POST['columns'];
        $_SESSION['success'] = true;
        $_SESSION['tablename'] = $tablename;
        $_SESSION['columns'] = $columns;
    }
}
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
        <?php
        if (isset($_GET['error'])) {
        ?>
            <p align="center" style="color:crimson; background-color: #FF000020; padding:1rem; font-size:1.1rem;">
                <?php echo $_GET['error'] ?>
            </p>
        <?php
        }
        ?>
        <fieldset style="width:40%; margin:auto; height:100%;display:flex; justify-content:center; align-items:center; flex-direction:column;">
            <legend>Create new table</legend>
            <table style="margin: 1rem;">
                <tr>
                    <td>
                        <label for="tableName">Table Name</label>
                    </td>
                    <td>
                        <input type="text" name="tablename" id="tablename">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="columns">Number of Columns</label>
                    </td>
                    <td>
                        <input type="text" name="columns" id="columns">
                    </td>
                </tr>
            </table>
            <button type="submit" name="submit" style="border-radius: 20px; padding: 0.5rem 2rem; margin-top: 10px;">Create</button>
        </fieldset>
    </form>
</body>

</html>