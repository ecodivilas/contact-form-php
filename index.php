<?php
    include "config.php";

    $sql = "SELECT cc.name, cc.email, cc.contact_number,
            b.barangay_name, c.city_name, p.province_name
            FROM client_contacts as cc
            INNER JOIN barangay as b ON cc.barangay_id = b.id
            INNER JOIN cities as c ON b.city_id = c.id
            INNER JOIN provinces as p ON c.province_id = p.id";
    $result = mysqli_query($con, $sql);

    $client_contacts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);

    mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Display Client's Info</title>
    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Contact Number</th>
            <th>Barangay</th>
            <th>City</th>
            <th>Province</th>
        </tr>
        <?php foreach($client_contacts as $client): ?>
            <tr>
                <td><?= $client['name']; ?></td>
                <td><?= $client['email']; ?></td>
                <td><?= $client['contact_number']; ?></td>
                <td><?= $client['barangay_name']; ?></td>
                <td><?= $client['city_name']; ?></td>
                <td><?= $client['province_name']; ?></td>
            </tr>
            <?php endforeach; ?>
    </table>
</head>
<body>
    
</body>
</html>