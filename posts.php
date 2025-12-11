<?php
require_once 'config/db.php';

// جلب كل الرسائل من قاعدة البيانات بالترتيب من الأحدث للأقدم
$result = $conn->query("SELECT * FROM contact_messages ORDER BY message_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>URBANIX - Posts</title>
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/admin.css">
    <style>
        body {
            padding-top: 70px;
            background-color: #f5f5f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .title-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }

        .custom-table th {
            background-color: #343a40;
            color: #fff;
            font-weight: bold;
            text-align: center;
            font-size: 14px;
        }

        .custom-table td {
            text-align: center;
            vertical-align: middle;
        }

      .btn-del i {
            
            color:#ff8c33;
            padding:3px 8px;
            border-radius:4px;
            text-decoration:none;
        }

        .btn-del i:hover {
            
            color:white;
        }

        
        .custom-table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <h5 class="me-4 mt-2 logo text-white">URBANIX</h5>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
       <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link text-white" href="admin.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link text-white active" href="posts.php">Posts</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="content">
    <div class="title-info">
        <i class="fa-solid fa-pen"></i>
        <p>Contact Messages</p>
    </div>

    <table class="table table-bordered table-striped custom-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>City</th>
                <th>Interest</th>
                <th>Timeline</th>
                <th>Message</th>
                <th>Agree Marketing</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['message_id'] ?></td>
                <td><?= $row['first_name'] ?></td>
                <td><?= $row['last_name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['city'] ?></td>
                <td><?= $row['interest'] ?></td>
                <td><?= $row['timeline'] ?></td>
                <td><?= $row['message'] ?></td>
                <td><?= $row['agree_marketing'] ? 'Yes' : 'No' ?></td>
                <td>
                    <a href="delete_post.php?id=<?= $row['message_id'] ?>" class="btn-del" onclick="return confirm('Are you sure you want to delete this message?');"><i class="fa-solid fa-delete-left" ></i></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="js/bootstrap.js"></script>
</body>
</html>
