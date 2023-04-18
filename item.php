<?php
    session_start();
    if(!(isset($_SESSION['bag']))){
        $_SESSION['bag'];
    }

    if(isset($_GET['action']) == 'banana'){
        $qty = 1;
        $id = $_GET['id'];

        if(isset($_SESSION['bag'][$id])){
            

        }else { 
            $_SESSION['bag'][$id] = $qty;
        }
        
    }

    if(isset($_SESSION['bag']) && is_array($_SESSION['bag'])) {
        $num_items_in_bag = 0;
        foreach($_SESSION['bag'] AS $productId => $itemQuanity) {
            $num_items_in_bag = $num_items_in_bag + $itemQuanity;
        }
        }
        else {
        $num_items_in_bag = 0;
    }

?>

<?php
    include 'DBconnect.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Haunted Inglewood - Treasure Bag</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet"  href="newcss.css">
        <script src="https://kit.fontawesome.com/6fa380ccb2.js" crossorigin="anonymous"></script>
        <style>
            #show {
                display: none;
            }
        </style>
    </head>
    <body>
        <nav>
            <div id="icon">

                <a href="item.php"><i class="fa-solid fa-gift fa-2x"></i></a>

                <a href="map.php"><i class="fa-regular fa-map fa-2x"></i></a>

                <a href="home.php"><i class="fa-solid fa-book-skull fa-2x"></i></a>
            </div>
        </nav>


	<main>

        <h1>Your treasure bag</h1>

         <?php

         if(isset($_SESSION['bag'])){
            $array = $_SESSION['bag'];
            $key = array_keys($array);
            $qty = array_values($array);

            $total = count($array);
            if($total == 8){
                echo '<h2>You have collected all 8 items! Unlock the secret of the spell if you dare...</h2>';
                echo '<div id="center">';
                echo'<button type="button" id="unlock">Unlock!</button>';
                echo '</div>';
                echo'<div id="show">
                <h3>Congratulations!</h3>
        
                <p>Remember our spell for good luck? It stems from ancient Latin and means <span>"a blessing is a curse"</span>...</p>
                <p>Sorry to disappoint you, but the ghosts of Inglewood need a volunteer to share their grievances, and <em>you</em> will carry them for eternity until you vanish from this world.
                </p>
                </div>';
            }else {
                echo '<div id=ks>';
                echo'<p>Keep Searching, you have collected '. $num_items_in_bag.' item(s).</p>';
                echo'<p>Once you have collected all 8 items, you can unlock the meaning of the spell.</p>';
                echo '</div>';

                echo '<a href="map.php" class="back">Back To Map</a>';
            }
            echo '<div id="container">';
                foreach($_SESSION['bag'] as $key => $qty){
                    $query = "SELECT * FROM inglewood WHERE id=$key ";
                    $sql = mysqli_query($connection, $query);
                
                    $row = mysqli_fetch_array($sql);
                
                        $item_image = "items/".$row['item_pic'];
                        $item_data = getimagesize("$item_image");
                        $item_width = $item_data[0];
                        $item_height = $item_data[1];
                   
                        

                        echo '<div class="itemBox">';

                            echo '<img src="' . $item_image . '" alt="' . $row['item_title'] . '" width="'.$item_width.'" height="'.$item_height.'">';

                        echo '</div>';
                        
                        }
                echo '</div>';
        }else {
            print'<h2>You do not have any items.</h2>';
            print'<a href="map.php" class="back">Back To Map</a>';
        }
         
            
         ?>

        
        
	</main>

    <script>
        unlock.addEventListener("click", () => {
            show.style.display = "block";
            container.style.display = "none";
      });
    </script>

    </body>
</html>