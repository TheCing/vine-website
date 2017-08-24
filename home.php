<?php
  ob_start();
  session_start();
  require_once 'dbconnect.php';
  
  // if session is not set this will redirect to login page
  if( !isset($_SESSION['user']) ) {
    header("Location: index.php");
    exit;
  }
  // select loggedin users detail
  $res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
  $userRow=mysql_fetch_array($res);
?>
<!DOCTYPE html>
<html>
<title>Home</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Pattaya">
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="main.css">
<style>
/*body,h1 {font-family: "Raleway", sans-serif}
body, html {height: 100%}
.bgimg {
    background-image: url('forestbridge.jpg');
    min-height: 100%;
    background-position: center;
    background-size: cover;
}*/
.default {
	
}
.default h1:hover {
  color: #aaaaaa;
  transition: all ease-in-out 200ms;
  cursor: pointer;
}
.newset p:hover {
  color: #aaaaaa;
  transition: all ease-in-out 200ms;
  cursor: pointer;
}
.submit h1:hover {
  color: #aaaaaa;
  transition: all ease-in-out 200ms;
  cursor: pointer;
}
.setlists {
  display: none;
  width: 40%;
  margin: auto;
}
.stats {
  display: none;
  width: 40%;
  margin: auto;
}
.resources {
  display: none;
  width: 40%;
  margin: auto;
}
.enterset {
  display: none;
  width: 40%;
  margin: auto;
}
a {
  color: white;
  transition: all ease-in-out 200ms;
  text-decoration: none;
}
a:hover {
  color: #333333;
  text-decoration: none;
  cursor: pointer;
}
.logout {
  color: white;
  background-color: transparent; 
  text-align: center;
}
</style>
<body>

<div class="bgimg w3-display-container w3-animate-opacity w3-text-white">
	<div class="w3-display-topleft w3-padding-large w3-xlarge">
      <a href="index.php" class="logo">the vine</a>
  </div>
	<div class="w3-display-topright w3-padding-large w3-xlarge w3-dropdown-hover">
		<a id="login">welcome, <?php echo $userRow['userName']; ?></a>
    <div class="w3-dropdown-content w3-padding logout">
    <a href="logout.php?logout" class="w3-padding logout"><span class="fa fa-sign-out"></span>&nbsp;Log Out</a>
    </div>
	</div>
  <div class="w3-display-middle default">
    <h1 class="w3-xxxlarge w3-center w3-animate-top" id="setlists">setlists</h1>
    <hr class="w3-border-grey" style="margin:auto;width:40%">
    <h1 class="w3-xxxlarge w3-center w3-animate-top" id="stats">statistics</h1>
    <hr class="w3-border-grey" style="margin:auto;width:40%">
    <h1 class="w3-xxxlarge w3-center w3-animate-top" id="resources">resources</h1>
  </div>
  <div class="w3-display-middle w3-round w3-block w3-responsive w3-card-4 setlists">
    <button onclick="myFunction('date1')" class="w3-button w3-block w3-left-align w3-vivid-white">Jan 11, 2017</button>
    <div id="date1" class="w3-hide w3-container w3-light-grey">
      <table class="w3-table-all w3-card-4">
        <tr>
          <th>Song Title</th>
          <th>Artist</th>
          <th>Key</th>
        </tr>
        <tr>
          <td>Jill</td>
          <td>Smith</td>
          <td>50</td>
        </tr>
        <tr>
          <td>Eve</td>
          <td>Jackson</td>
          <td>94</td>
        </tr>
        <tr>
          <td>Adam</td>
          <td>Johnson</td>
          <td>67</td>
        </tr>
      </table>
    </div>
    <button onclick="myFunction('date2')" class="w3-button w3-block w3-left-align w3-vivid-white">Jan 18, 2017</button>
    <div id="date2" class="w3-hide w3-container w3-light-grey">
      <p>Setlist goes here</p>
    </div>
    <button onclick="myFunction('date3')" class="w3-button w3-block w3-left-align w3-vivid-white">Jan 25, 2017</button>
    <div id="date3" class="w3-hide w3-container w3-light-grey">
      <p>Setlist goes here</p>
    </div>
  </div>
  <div class="w3-display-middle w3-block w3-round w3-responsive stats">
    <h1 class="w3-xxxlarge w3-center">Graphs here</h1>
  </div>
  <div class="w3-display-middle w3-block w3-round w3-responsive resources">
    <h1 class="w3-xxxlarge w3-center">Links here</h1>
  </div>
  <div class="w3-display-middle w3-block w3-round w3-responsive enterset">
    <div class="w3-row-padding">
      <label>Set Date</label>
      <input class="w3-input w3-border" type="date">
    </div>
    <div class="w3-row-padding">
      <div class="w3-third">
        <label>Song Title</label>
        <input class="w3-input w3-border" type="text" placeholder="title">
      </div>
      <div class="w3-third">
        <label>Artist</label>
        <input class="w3-input w3-border" type="text" placeholder="artist">
      </div>
      <div class="w3-third">
        <label>Key</label>
        <input class="w3-input w3-border" type="text" placeholder="key">
      </div>
    </div>
    <div class="w3-row-padding">
      <div class="w3-third">
        <input class="w3-input w3-border" type="text" placeholder="title">
      </div>
      <div class="w3-third">
        <input class="w3-input w3-border" type="text" placeholder="artist">
      </div>
      <div class="w3-third">
        <input class="w3-input w3-border" type="text" placeholder="key">
      </div>
    </div>
    <div class="w3-row-padding">
      <div class="w3-third">
        <input class="w3-input w3-border" type="text" placeholder="title">
      </div>
      <div class="w3-third">
        <input class="w3-input w3-border" type="text" placeholder="artist">
      </div>
      <div class="w3-third">
        <input class="w3-input w3-border" type="text" placeholder="key">
      </div>
    </div>
    <div class="w3-xxxlarge w3-right w3-animate-opacity submit">
      <h1 id="submit">go ></h1>
    </div>
  </div>
  <div class="w3-display-bottomright w3-padding-large newset">
      <p id="newset">+ enter new setlist...</p>
    </div>
  <div class="w3-display-bottomleft w3-padding-large">
    <p>&copy;2017 JP Tyndall</p>
  </div>
</div>

<script>
  $(document).ready(function(){
      $("#setlists").click(function(){
          $(".default").fadeOut();
          $(".setlists").fadeIn();
      });
      $("#stats").click(function(){
          $(".default").fadeOut();
          $(".stats").fadeIn();
      });
      $("#resources").click(function(){
          $(".default").fadeOut();
          $(".resources").fadeIn();
      });
      $("#newset").click(function(){
          $(".default").fadeOut();
          $("div[class="w3-display-middle"]").fadeOut();
          $(".enterset").fadeIn();
      });
      $("#back-to-home").click(function(){
          $(".register-screen").fadeOut();
          $(".default").fadeIn();
      });
  });
  </script>

</body>

<foot>

  <script>
    function myFunction(id) {
        var x = document.getElementById(id);
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
        } else { 
            x.className = x.className.replace(" w3-show", "");
        }
    }
    </script>
</foot>

</html>
<?php ob_end_flush(); ?>