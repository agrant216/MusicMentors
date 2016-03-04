<?php
	session_start();
	if (isset($_POST['Logout']))
	{
		if (session_status() == PHP_SESSION_ACTIVE)
		{
			session_unset();
			session_destroy();
		}
		unset($_POST['Logout']);
	}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music Mentors</title>

    <!-- Bootstrap core CSS  -->
    <link href="bootstrap3_defaultTheme/dist/css/bootstrap.css" rel="stylesheet">

  </head>
<body>

<div class="container">
   <div class="row">
      <div class="col-md-3">
      </div>
      <div class="col-md-6">
         <div id="login">
            <div class="page-header">
               <h2>Welcome</h2>
            </div>
            <?php
            	if (isset($_SESSION['username']))
				{
					echo "<h1>Hello, ".$_SESSION['username']."</h1>";
					echo '<form role="form" method="post">
					<button name="Logout" class="btn btn-primary">Logout</button>
					</form>';
				}
				else
				{
					header("Location:	login.php");
				}
            ?>
         </div>
      </div>
      <div class="col-md-3">
      </div>
   </div>
</div>  <!-- end container -->

</body>
</html>