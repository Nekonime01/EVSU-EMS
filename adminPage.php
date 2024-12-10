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
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start_from = ($page - 1) * $limit;

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$search_condition = !empty($search) ? "WHERE e.event_title LIKE '%$search%'" : '';

$sql = "SELECT * FROM staff_coordinator s 
        INNER JOIN event_info ef ON ef.event_id = s.event_id 
        INNER JOIN student_coordinator st ON st.event_id = ef.event_id 
        INNER JOIN events e ON e.event_id = ef.event_id 
        $search_condition
        LIMIT $start_from, $limit";
$total_sql = "SELECT COUNT(*) FROM staff_coordinator s 
              INNER JOIN event_info ef ON ef.event_id = s.event_id 
              INNER JOIN student_coordinator st ON st.event_id = ef.event_id 
              INNER JOIN events e ON e.event_id = ef.event_id 
              $search_condition";

$result = mysqli_query($conn, $sql);
$total_result = mysqli_query($conn, $total_sql);

$total_rows = $total_result ? mysqli_fetch_array($total_result)[0] : 0;
$total_pages = ceil($total_rows / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>EVENT (ADMIN)</title>
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
        .controls-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .search-container input[type="text"] {
            margin-right: 2px;
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
        function confirmDelete(event) {
            if (!confirm("Are you sure you want to delete this event?")) {
                event.preventDefault();
            }
        }
    </script>
</head>
<body>
    <?php include 'utils/adminHeader.php'; ?>
    <div class="content">
        <div class="container" id="eventDetailsSection">
            <h1 style="color: #710000; text-shadow: 2px 2px red; user-select: none; font-size: 40px;"><strong>EVENT DETAILS <hr></strong></h1>
            <div class="controls-container">
                <a class="btn btn-primary" href="createEventForm.php" style="border-radius: 10px;">Create Event</a>
                <div class="search-container">
                    <form id="searchForm" method="GET" action="">
                        <input type="text" class="btn btn-default" name="search" placeholder="Search Event..." value="<?php if(isset($_GET['search'])) echo $_GET['search']; ?>">
                        <input type="submit" value="" class="btn btn-default" style="border-radius: 20px; background-image: url('images/search-icon.png'); background-repeat: no-repeat; background-size: 20px; background-position: center; padding: 7px 25px;">
                    </form>
                </div>
            </div>
            <?php if ($result && mysqli_num_rows($result) > 0) { ?>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>No. of Participants</th>
                        <th>Price</th>
                        <th>Student Co-ordinator</th>
                        <th>Staff Co-ordinator</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Location</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($result)) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['event_title']); ?></td>
                        <td><?php echo htmlspecialchars($row['participents']); ?></td>
                        <td><?php echo htmlspecialchars($row['event_price']); ?></td>
                        <td><?php echo htmlspecialchars($row['st_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['Date']); ?></td>
                        <td><?php echo htmlspecialchars($row['time']); ?></td>
                        <td><?php echo htmlspecialchars($row['location']); ?></td>
                        <td><?php echo getCategoryName($row['type_id']); ?></td>
                        <td>
                            <a href="updateEvent.php?id=<?php echo $row['event_id']; ?>" class="btn btn-success">Update</a>
                            <a href="deleteEvent.php?id=<?php echo $row['event_id']; ?>" class="btn btn-danger" onclick="confirmDelete(event)">Delete</a>
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
            <?php } else { echo "No events found."; } ?>
        </div>
    </div>
    <script>
        document.getElementById('searchForm').addEventListener('submit', function() {
            sessionStorage.setItem('scrollPosition', window.scrollY);
        });

        window.onload = function() {
            var scrollPosition = sessionStorage.getItem('scrollPosition');
            if (scrollPosition !== null) {
                window.scrollTo(0, scrollPosition);
            }
        };

        setTimeout(function() {
            const eventDetailsSection = document.getElementById('eventDetailsSection');
            if (eventDetailsSection) {
                eventDetailsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }, 100);
    </script>
</body>
</html>
