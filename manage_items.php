<?php include 'db_connect.php'; ?>

<title>Menu Management</title>

<style>
    .navigate {
        list-style-type: none;
        margin: 0;
        padding: 0;
        overflow: hidden;
        background-color: #444;
        position: fixed;
        bottom: 0;
        left: 0;
        height: 100%;
        width: 15%;
        text-align: left;
    }

    .item {
        display: block;
        width: 100%;
        margin: 8px 0;
        padding-left: 15px;
    }

    .item a {
        display: block;
        color: white;
        text-decoration: none;
        width: calc(100% - 30px);
        margin: 0;
        transition: all 0.3s;
        font-size: 18px;
        padding: 12px 15px;
    }

    .item a:hover:not(.active) {
        background-color: #a7bf69;
        transform: scale(1.05); 
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-left: 5px;
    }

    .nav-title {
        color: antiquewhite;
        font-size: 32px;
        margin-left: 23px;
        padding: 15px 0;
        letter-spacing: 2px;
    }
    .nav-title:hover {
        transform: translateX(10px);
        color: #a7bf69;
    }

    .main-content {
        margin-left: 15%;
        padding: 15px;
        position: relative;
    }

    table {
        width: 100%;
        border: 3px solid #333;
        border-collapse: collapse;
        margin: 20px 0;
    }

    th, td {
        border: 2px solid #666;
        padding: 12px;
        text-align: left;
    }

    .prefix td {
        text-align: center;
    }

    .section-header td {
        background-color: #f8f9fa;
        font-size: 1.4em;
        padding: 20px;
        border-bottom: 4px solid #a7bf69;
        font-weight: bold;
    }

    button {
        padding: 5px 12px;
        margin: 0 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s;
    }

    button:hover {
        background-color: #a7bf69;
        border-color: #8fa358;
    }

    a.active {
            background-color: #a7bf69;
            color: white;
        }
</style>

<nav class="navigate">
    <br>
    <h2 class="nav-title">Restaurant</h2>
    <ul>
        <li class="item"><a href="admin_index.php" style="color:#fff;font-size: 15px;">Home</a></li>
        <li class="item"><a href="add_item.php" style="color:#fff;font-size: 15px;">Add Item</a></li>
        <li class="item"><a class="active" href="manage_items.php" style="color:#fff;font-size: 15px;">Manage Items</a></li>
        <li class="item"><a href="manage_user.php" style="color:#fff;font-size: 15px;">Manage Users</a></li>
        <li class="item"><a href="view_orders.php" style="color:#fff;font-size: 15px;">View Orders</a></li>
        <li class="item"><a href="order_details.php" style="color:#fff;font-size: 15px;">Order Details</a></li>
        <li class="item"><a href="logout.php" style="color:#fff;font-size: 15px;">Log Out</a></li>
    </ul>
</nav>

<div class="main-content">
    <h2>Menu Management</h2>

    <?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Retrieve the photo path from the database
        $sql = "SELECT photo FROM menu_items WHERE id='$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $photo_path = $row['photo'];

            // Delete the photo file from the img_file directory
            $full_photo_path = __DIR__ . '/' . $photo_path;
            if (file_exists($full_photo_path)) {
                unlink($full_photo_path);
            }

            // Delete the record from the database
            $sql = "DELETE FROM menu_items WHERE id='$id'";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Item deleted successfully');</script>";
            } else {
                echo "<script>alert('Error deleting item: " . $conn->error . "');</script>";
            }
        }
    }
    ?>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Photo</th>
            <th>Name</th>
            <th>Type</th>
            <th>Ingredients</th>
            <th>Description</th>
            <th>Price</th>
            <th>Action</th>
        </tr>

        <?php
        $sql = "SELECT id, photo, name, type, Ingredients, description, price FROM menu_items";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"]. "</td>
                        <td><img src='" . $row["photo"] . "' alt='Photo' width='50' height='50'></td>
                        <td>" . $row["name"]. "</td>
                        <td>" . $row["type"]. "</td>
                        <td>" . $row["Ingredients"]. "</td>
                        <td>" . $row["description"]. "</td>
                        <td>" . $row["price"]. "</td>
                        <td><a href='manage_items.php?id=" . $row["id"] . "'>Delete</a></td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No items found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</div>