<?php
    ob_start();

    session_start();
    if(!(isset($_SESSION['bag']))){
        $_SESSION['bag'];
    }

    if(isset($_GET['id'])){
        $qty = 1;
        $id = $_GET['id'];

        if(isset($_SESSION['bag'][$id])){
            echo'<script>alert("You have been here and collected everything!");alert("Please go back to the map and start the next task.");</script>';
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

<?php
    $id = $_GET['id'];
    $query = "SELECT * FROM inglewood WHERE id=$id";
    $sql = mysqli_query($connection,$query);
    $row = mysqli_fetch_array($sql);

    $image =  "images/".$row['loca_pic'];
    $image_night = "images/".$row['loca_pic_night'];

    $data = getimagesize("$image");
    //Array ( [0] => 205 [1] => 120 ) width="205" height="120"
    $width = $data[0];
    $height = $data[1];

    $data_night = getimagesize("$image_night");
    //Array ( [0] => 205 [1] => 120 ) width="205" height="120"
    $width_night = $data_night[0];
    $height_night = $data_night[1];

    

    $item_image = "items/".$row['item_pic'];
    $item_data = getimagesize("$item_image");
            //Array ( [0] => 205 [1] => 120 ) width="205" height="120"
    $item_width = $item_data[0];
    $item_height = $item_data[1];

    $audio = "audio/".$row['audio'];


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Ghost Hunting In Inglewood - </title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet"  href="loca_styles.css">
        <script src="https://kit.fontawesome.com/6fa380ccb2.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
        <style>
            input[type="submit"]{
                background-image: url("<?php echo $item_image;?>");
                background-size: contain;
                background-repeat: no-repeat;
                width: 100px;
                background-color: unset;
                border: none;
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
         <h1>
            <?php echo $row['title'];?>
         </h1>
    <div class="p-background">
        <h2 class="ml3">
            <?php echo $row['sub'];?>
        </h2>

        <audio autoplay controls id="song">
            <source src="<?php echo $audio;?>">
        </audio>
        
        <div>
            <p>
                <?php echo $row['image_descr'];?>
            </p>
        </div>
        

        <p class="task_p">
            Task: <?php echo $row['task'];?>
        </p>
        
    </div>

    <div class="imgBox">

         <img src="<?php echo $image;?>" alt="<?php echo $row['title'];?>" width="<?php echo $width;?>" height="<?php echo $height;?>" id="imgA">

         <img src="<?php echo $image_night;?>" alt="<?php echo $row['title'];?>" width="<?php echo $width_night;?>" height="<?php echo $height_night;?>" class="hidden" id="imgB">

         <form method="GET" id="form" action="#">
            <input type="hidden" id="pId" name="pId" value="<?php echo $row['id'];?>">
            <input type="submit" id="banana" value="" class="hidden">
        </form>
    </div>

    <!-- <p id="msg" class="hidden">Collected!</p> -->
        

	</main>

    <script>
        var textWrapper = document.querySelector('.ml3');
        textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

        anime.timeline()
        .add({
            targets: '.ml3 .letter',
            opacity: [0,1],
            easing: "easeInOutQuad",
            duration: 3000,
            delay: (el, i) => 150 * (i+1)
        });


      imgA.addEventListener("mouseenter", () => {
        imgB.classList.remove("hidden");
        banana.classList.remove("hidden");
      });
      imgA.addEventListener("click", () => {
        imgB.classList.add("hidden");
        banana.classList.add("hidden");
      });
      
      imgB.addEventListener("mouseleave",()=>{
        imgA.classList.remove("hidden");
        imgB.classList.add("hidden");
        banana.classList.add("hidden");
      })

      banana.addEventListener("mouseenter",()=>{
        imgA.classList.add("hidden");
        imgB.classList.remove("hidden");
        banana.classList.remove("hidden");
      })

      var first_click = true;
      banana.addEventListener("click", (e) => {
        banana.classList.add("hidden");
        // msg.classList.remove("hidden");
        e.preventDefault();

        if (first_click) {
                alert("Baleket dio ma leket dio! You have collected <?php echo $row['item_title'];?>.");
                first_click = false;
            } else {
                alert("You have been here and collected everything!");
            }

        alert("We are taking you back to the map and start the next task.");
        history.back(1);
        
      });
    
    //   window.addEventListener("load", event => {
    //         const audio = document.querySelector("audio");
    //         audio.volume = 0.2;
    //         audio.play();
    //     });
    </script>

    </body>
</html>
<?php ob_end_flush(); ?>