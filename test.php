<html>
<head>
    <title> db table</title>
</head>
<body>
    <table>
    <tr>
        <th>Id</th>
        <th>student Name</th>
        <th>member type </th>
    </tr>
    <?php
    $conn=mysqli_connect ("localhost","root","","student");
    if($conn-> connect_error)
    {
        die ("connection failed:".$conn->connect_error);
    }
    $sql="SELECT ID, StudentName, MemberType from student_details";
    $result = $conn-> query($sql);

    if($result-> num_rows > 0)
    {
        while ($row = $result-> fetch_assoc())
        {
            echo"<tr><td>".$row["ID"]."</td><td>".$row["StudentName"]."</td><td>".$row["MemberType"]."</td></tr>";
        }
        echo "</table>";

    }
    else{
        echo"0 result";
    }
    $conn -> close();
    ?>
    </table>
</body>
