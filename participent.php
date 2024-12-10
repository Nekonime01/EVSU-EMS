<?php
include_once 'classes/db1.php';

$message = '';

$limit = 10;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$start_from = ($page - 1) * $limit;

$searchField = "name"; 

if(isset($_GET['search']) && !empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    if(isset($_GET['searchField']) && !empty($_GET['searchField'])) {
        $searchField = $_GET['searchField'];
    }
    $condition = "$searchField LIKE '%$search%'";
    $sql = "SELECT * FROM participent 
            WHERE $condition 
            ORDER BY name 
            LIMIT $start_from, $limit";
    $result = mysqli_query($conn, $sql);
    $total_sql = "SELECT COUNT(*) FROM participent 
                  WHERE $condition";
} else {
    $sql = "SELECT * FROM participent 
            LIMIT $start_from, $limit";
    $result = mysqli_query($conn, $sql);
    $total_sql = "SELECT COUNT(*) FROM participent";
}

$total_result = mysqli_query($conn, $total_sql);
$total_rows = mysqli_fetch_array($total_result)[0];
$total_pages = ceil($total_rows / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Registered Student (ADMIN)</title>
    <style>
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
    </style>
    <script>
        function scrollToCenter() {
            var targetScroll = (document.body.scrollHeight - window.innerHeight) / 20;
            var duration = 60; 
            var delay = 60;

            setTimeout(function() {
                var start = window.pageYOffset;
                var distance = targetScroll - start;
                var startTime = null;

                function animation(currentTime) {
                    if (startTime === null) startTime = currentTime;
                    var timeElapsed = currentTime - startTime;
                    var scrollAmount = easeInOutQuad(timeElapsed, start, distance, duration);
                    window.scrollTo(0, scrollAmount);
                    if (timeElapsed < duration) {
                        requestAnimationFrame(animation);
                    }
                }

                function easeInOutQuad(t, b, c, d) {
                    t /= d / 2;
                    if (t < 1) return c / 2 * t * t + b;
                    t--;
                    return -c / 2 * (t * (t - 2) - 1) + b;
                }

                requestAnimationFrame(animation);
            }, delay);
        }
    </script>
</head>
<body onload="scrollToCenter()">
    <?php include 'utils/adminHeader.php'?>
    <div class="content">
        <div class="container">
            <h1 style="color: #710000; text-shadow: 2px 2px red; user-select: none; font-size: 40px;"><strong>STUDENTS DETAILS</strong><hr></h1>
            <div class="search-container">
                <form id="searchForm" method="GET" action="">
                    <input type="text" class="btn btn-default" name="search" placeholder="Search..." value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>">
                    <select name="searchField" style="border-radius: 20px; padding: 7px 5px;" class="btn btn-default">
                        <option value="usn" <?php if ($searchField == 'usn') echo 'selected'; ?>>StudentID</option>
                        <option value="name" <?php if ($searchField == 'name') echo 'selected'; ?>>Name</option>
                        <option value="branch" <?php if ($searchField == 'branch') echo 'selected'; ?>>Course</option>
                        <option value="email" <?php if ($searchField == 'email') echo 'selected'; ?>>Email</option>
                        <option value="phone" <?php if ($searchField == 'phone') echo 'selected'; ?>>Phone</option>
                    </select>
                    <input type="submit" value="" class="btn btn-default" style="border-radius: 20px; background-image: url('images/search-icon.png'); background-repeat: no-repeat; background-size: 20px; background-position: center; padding: 7px 25px;">
                </form>
            </div>
            <?php if (mysqli_num_rows($result) > 0) { ?>
            <table class="table table-hover" style="font-size: 16px;">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Course</th>
                        <th>Semester</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>College</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($result)) { ?>
                    <tr>
                        <td><?php echo $row['usn']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['branch']; ?></td>
                        <td><?php echo $row['sem']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['college']; ?></td>
                        <td>
                            <a href="updateParticipant.php?usn=<?php echo $row['usn']; ?>" class="btn btn-success">Update</a>
                            <a href="deleteParticipants.php?usn=<?php echo $row['usn']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this participant?')">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="pagination-container">
                <ul class="pagination">
                    <?php if ($page > 1) { ?>
                    <li><a href="?page=<?php echo ($page - 1); ?>">Previous</a></li>
                    <?php } ?>
                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                    <li><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                    <?php } ?>
                    <?php if ($page < $total_pages) { ?>
                    <li><a href="?page=<?php echo ($page + 1); ?>">Next</a></li>
                    <?php } ?>
                </ul>
            </div>
            <?php } else { echo "No participants found."; } ?>
        </div>
    </div>
</body>
</html>
