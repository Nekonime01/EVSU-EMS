<?php
include_once 'classes/db1.php';

function getCategoryName($type_id) {
    switch ($type_id) {
        case 1:
            return 'Technical Event';
        case 2:
            return 'Gaming Event';
        case 3:
            return 'On-Stage Event';
        case 4:
            return 'Off-Stage Event';
        case 5:
            return 'Department Day';
        default:
            return 'Unknown';
    }
}

$limit = 10; 
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$start_from = ($page - 1) * $limit;

$searchField = "event_title";

if(isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $sql = "SELECT * FROM staff_coordinator s 
            INNER JOIN events e ON e.event_id = s.event_id 
            WHERE e.event_title LIKE '%$search%'
            LIMIT $start_from, $limit";
    $result = mysqli_query($conn, $sql);
    $total_sql = "SELECT COUNT(*) FROM staff_coordinator s 
                  INNER JOIN events e ON e.event_id = s.event_id 
                  WHERE e.event_title LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM staff_coordinator s 
            INNER JOIN events e ON e.event_id = s.event_id
            LIMIT $start_from, $limit";
    $result = mysqli_query($conn, $sql);
    $total_sql = "SELECT COUNT(*) FROM staff_coordinator";
}

$total_result = mysqli_query($conn, $total_sql);
$total_rows = mysqli_fetch_array($total_result)[0];
$total_pages = ceil($total_rows / $limit);
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Staff Coordinator (ADMIN)</title>
    <?php require 'utils/styles.php'; ?>
    <style>
        .search-container {
            display: flex;
            justify-content: flex-end; 
            margin-bottom: 20px; 
        }
        .search-container input[type="text"],
        .search-container select,
        .search-container input[type="submit"] {
            margin-right: 5px;
            border-radius: 20px;
        }
        .pagination-container {
            display: flex;
            justify-content: flex-end; 
            margin-top: 20px; 
        }
        .pagination {
            list-style-type: none;
            padding: 0;
            display: flex;
        }
        .pagination li {
            margin: 5px;
        }
        .pagination a {
            text-decoration: none;
            padding: 8px 16px;
            color: #007bff;
            border: 1px solid #dee2e6;
            border-radius: 5px; 
        } 
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #900303da;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        } 
    </style>
</head>

<body>
    <?php include 'utils/adminHeader.php'?>
    <div class="content">
        <div class="container" id="staffCoordinatorDetails">
            <h1 style="color: #710000; text-shadow: 2px 2px red; user-select: none; font-size: 40px;"><strong>STAFF CO-ORDINATOR DETAILS <hr></strong></h1>
            <div class="search-container">
                <form id="searchForm" method="GET" action="">
                    <input type="text" name="search" class="btn btn-default" placeholder="Search by Event..." value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>">
                    <input type="submit" value="" class="btn btn-default" style="border-radius: 20px; background-image: url('images/search-icon.png'); background-repeat: no-repeat; background-size: 20px; background-position: center; padding: 7px 25px;">
                </form>
            </div>
            <?php if (mysqli_num_rows($result) > 0) { ?>
                <table class="table table-hover">
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Event</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                    <?php while($row = mysqli_fetch_array($result)) { ?>
                        <tr>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $row["phone"]; ?></td>
                            <td><?php echo $row["event_title"]; ?></td>
                            <td><?php echo getCategoryName($row['type_id']); ?></td>
                            <td><?php echo '<a href="updateStaff.php?id='.$row['event_id'].'" class="btn btn-success">Update</a>'; ?></td>
                        </tr>
                    <?php } ?>
                </table>
                <div class="pagination-container">
                <ul class="pagination">
                        <?php if ($page > 1) { ?>
                        <li><a href="?page=<?php echo ($page - 1); ?><?php if (isset($_GET['search'])) echo '&search=' . $_GET['search']; ?>">Previous</a></li>
                        <?php } ?>
                        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <li><a href="?page=<?php echo $i; ?><?php if (isset($_GET['search'])) echo '&search=' . $_GET['search']; ?>"><?php echo $i; ?></a></li>
                        <?php } ?>
                        <?php if ($page < $total_pages) { ?>
                        <li><a href="?page=<?php echo ($page + 1); ?><?php if (isset($_GET['search'])) echo '&search=' . $_GET['search']; ?>">Next</a></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } else { echo "No result found"; } ?>
        </div>
    </div>

    <script>
        setTimeout(function() {
            const staffCoordinatorDetailsSection = document.getElementById('staffCoordinatorDetails');
            if (staffCoordinatorDetailsSection) {
                staffCoordinatorDetailsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }, 100);
    </script>
</body>

</html>
