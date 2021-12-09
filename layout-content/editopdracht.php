<?php
$userrole = [3, 4];
include("./php-scripts/security.php");

// Opvragen van gegevens van de huidige inlogger
include("./php-scripts/connectDB.php");
include("./php-scripts/functions.php");
$id = $_SESSION["id"];
$userrole = $_SESSION["userrole"];

// Opvragen opdrachtinfo
$opdrachtid = $_GET["oi"];
$sql1 = "SELECT * FROM `huiswerk_opdrachten` WHERE `opdracht_id` = $opdrachtid";
$res1 = mysqli_query($conn, $sql1);
$opdrachtinfo = mysqli_fetch_array($res1);

if (isset($_SESSION["nieuwvraag"])){
    switch ($_SESSION["nieuwvraag"]) {
      case "success":
        $pwclasses = "success";
        $msg = "Vraag is toegevoegd.";
        unset($_SESSION["nieuwvraag"]);
        break;
      case "error1":
        $pwclasses = "error";
        $msg = "Voer een vraag in.";
        unset($_SESSION["nieuwvraag"]);
        break;
      case "error2":
        $pwclasses = "error";
        $msg = "Voer een antwoord in";
        unset($_SESSION['nieuwvraag']);
        break;
      case "error3":
        $pwclasses = "error";
        $msg = "Er ging iets mis met de SQL Query";
        unset($_SESSION['nieuwvraag']);
        break;
    }
}


?>

<section class="jumbotron jumbotron-fluid homeJumbo" style="background-color:gray">
  <div class="container">
    <div class="row">
      <!-- Error message display -->
      <div class="<?php if (isset($pwclasses)) echo "col-12 col-md-5 offset-md-1 display-message"; ?>">
        <?php
          if (isset($msg)) {
            echo "<p class='". $pwclasses ."'>". $msg ."</p>";
          }
        ?>
      </div>
      <!-- Groepen -->
      <div class="col-12 col-md-11 offset-md-1">
      <h2 class="display-4"><?php echo $opdrachtinfo['opdracht_naam']?></h2>
      </div>
      <div class="col-12 col-md-4 offset-md-1">
        <h3 class="display-5">Bewerk vragen</h3>
        <!-- Naamveranderen -->
        <h4 class="lead">Nieuwe vraag</h4>
        <form action="index.php?content=script-newquestion" method="post">
            <div class="form-group">
                <input class="form-control" style="width:320px" type="name" name="vraag" id="vraag" placeholder="Vraag" required>
                <textarea class="form-control" style="width:320px" type="bericht" name="antwoord" id="antword" placeholder="Antwoord" rows="5" cols="40" required></textarea>
                <input type="hidden" value="<?php echo $opdrachtid ?>" name="oi" id="oi">
                <input class="btn btn-dark" type="submit" value="Maak nieuwe vraag">
            </div>
        </form>
        <a href="./index.php?content=docentopdrachten" class="btn btn-dark">Terug naar mijn opdrachten</a>
      </div>
      <!-- Register form -->
      <div class="col-12 col-md-4">
        <h3 class="display-5">Vragen</h3>
        <!--<h4 class="lead"></h4>-->
        <?php
        $sql2 = "SELECT * FROM `opdrachtvraag_koppel` WHERE `opdracht_id` = $opdrachtid";
        $res2 = mysqli_query($conn, $sql2);
        while ($rec2 = mysqli_fetch_array($res2)) {
            $vraagid = $rec2['vraag_id'];
            $sql3 = "SELECT * FROM `huiswerk_vraag` WHERE `vraag_id` = $vraagid";
            $res3 = mysqli_query($conn, $sql3);
            while ($rec3 = mysqli_fetch_array($res3)) {
                echo "<a href='index.php?content=homepage' style='color:black'><p><b>Vraag:</b> ". $rec3['vraag'] . "<br><b>Antwoord:</b> ". $rec3['antwoord'] . "</p></a>";
            }
        }
        ?>
      </div>
    </div>
  </div>
</section>