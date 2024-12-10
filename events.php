<div class="container">
    <div class="col-md-12">
        <hr>
    </div>

    <div class="row">
        <section>
            <div class="container">
                <div class="col-md-6">
                    <img src="<?php echo $row['img_link']; ?>" class="img-responsive">
                </div>
                <div class="subcontent col-md-6">                        
                    <h1 style="color:#003300 ; font-size:38px ;" ><u><strong><?php echo $row['event_title']; ?></strong></u></h1>
                    <p style="color:#003300  ;font-size:20px ">
                        <?php
                            echo 'Date:' . $row['Date'] .'<br>'; 
                            echo 'Time:' . $row['time'] .'<br>'; 
                            echo 'Location:' . $row['location'] .'<br>'; 
                            echo 'Student Co-ordinator:' . $row['st_name'] .'<br>'; 
                            echo 'Staff Co-ordinator:' . $row['name'] .'<br>'; 
                            echo 'Event Price:' . $row['event_price'].'<br>' ;
                        ?>
                    </p>
                    <br><br>
                    <!-- Registration form -->
                    <form action="subusn.php" method="POST">
                        <input hidden value="<?php echo $row['event_title']; ?>" name="event_name">
                        <input type="submit" class="btn btn-primary" name="register_event" value="Register event">
                        <input hidden value="<?php echo $row['event_id'] ?>" name="event_id">
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
