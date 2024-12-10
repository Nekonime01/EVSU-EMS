<?php
require 'classes/db1.php';
$id=$_GET['id'];
$result = mysqli_query($conn,"SELECT * FROM events,event_info ef,student_coordinator s,staff_coordinator st WHERE type_id = $id and ef.event_id=events.event_id and s.event_id=events.event_id and st.event_id=events.event_id");
?>


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Events (EEMS)</title>
    <?php require 'utils/styles.php'; ?>
</head>
<style>
    .back-button-container {
    display: flex;
    justify-content: flex-end;
}
</style>
<body>
    <?php require 'utils/header.php'; ?>
    <div class="content">
        <div class="container">
            <div class="col-md-12">
            <div class="back-button-container">
                <a class="btn btn-danger" href="index.php"><strong>X</strong></a>
            </div>
            </div>
        </div>
        <?php
        if (mysqli_num_rows($result) > 0) {
            $i=0;
            while($row = mysqli_fetch_array($result)) {
                include 'events.php';
                $i++;
            }
            ?>
            <div class="container">
                <div class="col-md-12">
                    <hr>
                </div>
            </div>
        <?php }?>
    </div>
    <?php require 'utils/footer.php'; ?>
    <script>
        function scrollToCenterSmooth() {
            var targetScroll = (document.body.scrollHeight - window.innerHeight) / 3;
            var duration = 400; 
            var delay = 100; 

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

        window.onload = scrollToCenterSmooth;
    </script>
</body>
</html>

