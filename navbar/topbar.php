<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div>
				<img id="logo" src="images/logo.png" alt="logo" class="navbar-brand" />
					<ul class="nav navbar-nav">
						<li><a href="home.php">Home</a></li>
						<li><a href="browsetutor.php">Tutors</a></li>
						<li><a href="contact.php">Contact Us</a></li> 
					</ul>


					<ul class="nav navbar-nav navbar-right">
						<li><a id = "user" href="<?=$profile?>"><span class="glyphicon glyphicon-user"></span> <?=$name?></a></li>
						<li><a href="<?=$url?>"><span class="glyphicon <?=$logicon?>"></span> <?=$log?></a></li>
					</ul>
				</div>
			</div>
</nav>