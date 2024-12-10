<?php
include_once 'classes/db1.php';

$limit = 10; 
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$start_from = ($page - 1) * $limit;

if(isset($_GET['delete']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM participent WHERE usn = '$id'";
    if (mysqli_query($conn, $sql)) {
        header("Location: {$_SERVER['PHP_SELF']}?deleted=true");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

$searchField = "name";

if(isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    if(isset($_GET['searchField']) && !empty($_GET['searchField'])) {
        $searchField = $_GET['searchField'];
    }
    if ($searchField == 'usn') {
        $condition = "r.usn LIKE '%$search%'";
    } else {
        $condition = "$searchField LIKE '%$search%'";
    }
    $sql = "SELECT * FROM events, registered r, participent p 
            WHERE events.event_id = r.event_id 
            AND r.usn = p.usn 
            AND $condition 
            ORDER BY name
            LIMIT $start_from, $limit";
    $result = mysqli_query($conn, $sql);
    $total_sql = "SELECT COUNT(*) FROM events, registered r, participent p 
                  WHERE events.event_id = r.event_id 
                  AND r.usn = p.usn 
                  AND $condition";
} else {
    $sql = "SELECT * FROM events, registered r, participent p 
            WHERE events.event_id = r.event_id 
            AND r.usn = p.usn 
            ORDER BY name
            LIMIT $start_from, $limit";
    $result = mysqli_query($conn, $sql);
    $total_sql = "SELECT COUNT(*) FROM events, registered r, participent p 
                  WHERE events.event_id = r.event_id 
                  AND r.usn = p.usn";
}

$total_result = mysqli_query($conn, $total_sql);
$total_rows = mysqli_fetch_array($total_result)[0];
$total_pages = ceil($total_rows / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" text="text/html; charset=UTF-8">
    <title>Student Details (ADMIN)</title>
    <link rel="stylesheet" href="path/to/your/css/styles.css">
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
        <div class="container" id="studentsSection">
            <h1 style="color: #710000; text-shadow: 2px 2px red; user-select: none; font-size: 40px;"><strong>STUDENT REGISTERED EVENT<hr></strong></h1>
            <div class="search-container">
                <form id="searchForm" method="GET" action="">
                    <input type="text"  class="btn btn-default" name="search" placeholder="Search..." value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>">
                    <select name="searchField" style="border-radius: 20px; padding: 7px 5px;" class="btn btn-default">
                        <option value="name" <?php if ($searchField == 'name') echo 'selected'; ?>>Name</option>
                        <option value="usn" <?php if ($searchField == 'usn') echo 'selected'; ?>>StudentID</option>
                        <option value="phone"><?php if ($searchField == 'phone') echo 'selected'; ?>Phone</option>
                        <option value="event_title"><?php if ($searchField == 'event_title') echo 'selected'; ?>Event</option>
                    </select>
                    <input type="submit" value="" class="btn btn-default" style="border-radius: 20px; background-image: url('images/search-icon.png'); background-repeat: no-repeat; background-size: 20px; background-position: center; padding: 7px 25px;">
                </form>
            </div>
            <?php if (mysqli_num_rows($result) > 0) { ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Student ID</th>
                            <th>Phone</th>
                            <th>Email</th>  
                            <th>Event</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_array($result)) { ?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['usn']; ?></td>
                                <td><?php echo $row['phone']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['event_title']; ?></td>
                                <td><?php echo $row['event_price']; ?></td>
                                <td>
                                    <?php if ($row['paid'] == 'Paid') { ?>
                                        <span class="badge badge-success" style="background-color: green; color: white;">Paid</span>
                                    <?php } elseif ($row['paid'] == 'Cancelled') { ?>
                                        <span class="badge badge-danger" style="background-color: red; color: white;">Cancelled</span>
                                    <?php } else { ?>
                                        <span class="badge badge-secondary">Unpaid</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a href="deletestudetail.php?id=<?php echo $row['event_id']; ?>" class="btn btn-danger">Delete</a>
                                    <a href="editstudent.php?id=<?php echo urlencode($row['usn']); ?>&event_id=<?php echo urlencode($row['event_id']); ?>&name=<?php echo urlencode($row['name']); ?>&phone=<?php echo urlencode($row['phone']); ?>&email=<?php echo urlencode($row['email']); ?>&event_title=<?php echo urlencode($row['event_title']); ?>&event_price=<?php echo urlencode($row['event_price']); ?>" class="btn btn-primary">Edit</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
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
            <?php } else { echo "No students found."; } ?>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchForm = document.getElementById('searchForm');
            if (searchForm) {
                searchForm.addEventListener('submit', function() {
                    sessionStorage.setItem('scrollPosition', window.scrollY);
                });
            }

            const scrollPosition = sessionStorage.getItem('scrollPosition');
            if (scrollPosition) {
                window.scrollTo(0, parseInt(scrollPosition));
                sessionStorage.removeItem('scrollPosition');
            }

            setTimeout(function() {
                const studentDetailsSection = document.getElementById('studentsSection');
                if (studentDetailsSection) {
                    studentDetailsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 100);
        });
    </script>
</body>

</html>
