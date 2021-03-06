<?php
    session_start();
    if(!isset($_SESSION['userid']) && isset($_COOKIE['identifier'])){
        $_SESSION['userid'] = $user['id'];
    }
    if(!isset($_SESSION['userid'])) {
        header('location:info');
    }

    $pdo = new PDO("mysql:host=127.0.0.1;dbname=abikarten","web","vKf{DGl1WYon");

    $statement = $pdo->prepare("SELECT * FROM guests ORDER BY `name` ASC");
    $statement->execute();
    $guests = $statement->fetchAll();

    $statement = $pdo->prepare("SELECT COUNT(*) FROM guests");
    $statement->execute();
    $guestnumber = $statement->fetch();
    $guestnumber = $guestnumber[0][0];

    $statement = $pdo->prepare("SELECT COUNT(DISTINCT student) FROM guests WHERE student != 'Kollegium'");
    $statement->execute();
    $studentNumber = $statement->fetch();
    $studentNumber = $studentNumber[0][0];

    $statement = $pdo->prepare("SELECT COUNT(*) FROM guests WHERE student = 'Kollegium'");
    $statement->execute();
    $teacher = $statement->fetch();
    $teacher = $teacher[0][0];

    $statement = $pdo->prepare("SELECT COUNT(*) FROM guests WHERE entrance = '1'");
    $statement->execute();
    $entrance = $statement->fetch(); 
    $entrance = $entrance[0][0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>OHG-Abi 20 | Gästeliste</title>
    <link rel="stylesheet" type="text/css" href="/css/guests/guests.min.css"/>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap4-toggle.min.css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU"
        crossorigin="anonymous">
</head>
<body>

<div id="configContainer">
  <div id="searchBarContainer">
    <i class="fas fa-search"></i>
    <input id="searchBar" type="text" placeholder="Suche...">
  </div>
  <div id="sortToggle">
    <div class="sortContent">Alphabetisch</div>
    <input id="toggle-event" type="checkbox" data-toggle="toggle" data-size="xs" data-on=" " data-off=" " data-onstyle="primary" data-offstyle="primary">
    <div class="sortContent">Nach Schüler</div>
  </div>
</div>

<div class="infoContainer">
  <p>
    <i class="fas fa-user"></i> Gäste insgesamt: <?php echo($guestnumber); ?>
  </p>
  <p>
    <i class="fas fa-user-check"></i> Bereits eingelassen: <?php echo($entrance); ?>
  </p>
  <p>
    <i class="fas fa-user-graduate"></i> Schüler: <?php echo($studentNumber); ?>
  </p>
  <p>
    <i class="fas fa-chalkboard-teacher"></i> Lehrer: <?php echo($teacher); ?>
  </p>

</div>

<button class="btn formbtn" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    <i class="fas fa-plus"></i>
</button>

<div class="collapse addform" id="collapseExample">
  <div class="card card-body">
  <form action="functions" method="post">
    <div class="form-group">
        <input type="text" class="form-control" name="name" placeholder="Name des Gastes">
        <label for="guest">Name des Gastes</label>
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="student" placeholder="Schüler">
        <label for="student">Schüler</label>
    </div>
    <button type="submit" class="btn" id="submit">Hinzufügen</button>
    </form>
  </div>
</div>

<div class="accordion" id="accordion">
<?php $i=0; foreach($guests as $guest): ?>
  <div class="card guest">
    <div class="card-header" id="heading<?php echo($i); ?>">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse<?php echo($i); ?>" aria-expanded="false" aria-controls="collapse<?php echo($i); ?>">
          <div class="name"><?php echo($guest["name"]); ?></div>
          <img id='barcode' 
            src="https://api.qrserver.com/v1/create-qr-code/?data=<?php echo("http://ohg-abi.de/qr?key=".$guest["qr"]); ?>&amp;size=100x100" 
            alt="qrcode_<?php echo($guest["name"]); ?>" 
            title="qrcode_<?php echo($guest["name"]); ?>"
            width="35" 
            height="35" />
        </button>
    </div>
    <div id="collapse<?php echo($i); ?>" class="collapse" aria-labelledby="heading<?php $i ?>" data-parent="#accordion">
      <div class="card-body">
        <div class="removeContainer">
          <a href="functions?remove=<?php echo($guest["qr"]) ?>" class="removeLink"><i class="far fa-times-circle"></i></a>
        </div>
        <div class="row">
          <div class="col-3 align-self-center">
            <div class="student">Schüler: <?php echo($guest["student"]); ?></div>
            <a target="_blank" href="pdf?key=<?php echo($guest["qr"]); ?>&option=I">Vorschau <i class="fas fa-eye"></i></a><br>
            <a href="pdf?key=<?php echo($guest["qr"]); ?>&option=D">Download <i class="fas fa-file-pdf"></i></a>
          </div>
          <div class="offset-7 col-2">
            <div class="qrcode">
              <a target="_blank" href="allow?key=<?php echo($guest["qr"]); ?>">
                <img id='barcode' 
                      src="https://api.qrserver.com/v1/create-qr-code/?data=<?php echo("http://ohg-abi.de/qr?key=".$guest["qr"]); ?>&amp;size=100x100" 
                      alt="qrcode_<?php echo($guest["name"]); ?>" 
                      title="qrcode_<?php echo($guest["name"]); ?>"
                      width="100" 
                      height="100" />
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php $i = $i+1; endforeach; ?>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="js/bootstrap4-toggle.min.js"></script>
<script>
  $(function() {
    $('#toggle-event').change(function() {
      console.log($(this).prop('checked'));
    })
  })
  window.addEventListener("load", function(){
    var alpha = [];
    var schüler = [];
    $('.guest').each(function(){
      //console.log($(this).find(".card-header").find(".btn").find(".name").text());
      //console.log($(this).find(".collapse").find(".card-body").find(".row").find(".col-3").find(".student").text());

      var alphaArr = [];
      var schülerArr = [];
      
      alphaArr.push($(this).find(".card-header").find(".btn").find(".name").text());
      alphaArr.push($(this));
      alpha.push(alphaArr);
      alpha.sort();
      
      
      schülerArr.push($(this).find(".collapse").find(".card-body").find(".row").find(".col-3").find(".student").text());
      schülerArr.push($(this));
      schüler.push(schülerArr);
      schüler.sort();
      
    })
    //console.log(alpha);
    //console.log(schüler);
  $('#toggle-event').change(function() {
      $('.guest').remove();
      if($(this).prop('checked')){
        console.log("Schüler");  
        for(var i=0; i<schüler.length; i++){
          $('#accordion').append(schüler[i][1]);
        }
      } else {
        console.log("Alphabetisch");  
        for(var i=0; i<alpha.length; i++){
          $('#accordion').append(alpha[i][1]);
        } 
      }
    })

    $(document).ready(function(){
      $("#searchBar").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#accordion .card-header .btn .name").filter(function() {
          $(this).parent().parent().parent().toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
  });
</script>
</body>
</html>

