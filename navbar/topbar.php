<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>                        
					</button>
					<img id="logo" src="images/logo.png" alt="logo" class="navbar-brand" />
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
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