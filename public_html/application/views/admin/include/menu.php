<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="brand" href="/admin">GTN Tickets Admin</a>
			<div class="nav-collapse collapse">
				<ul class="nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Events <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="/adminevent/add">Add</a></li>
							<li><a href="/adminevent/all">List</a></li>
						</ul>
					</li>
					
					<?php if (user_is_not_venue($user)) { ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Venues <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="/adminvenue/add">Add</a></li>
							<li><a href="/adminvenue/all">List</a></li>
						</ul>
					</li>
					<?php } ?>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Artists <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="/adminartist/add">Add</a></li>
							<li><a href="/adminartist/all">List</a></li>
						</ul>
					</li>
				</ul>

				<ul class="nav pull-right">
					<li><a href="#">Settings</a></li>
					<li><a href="/admin/logout">Logout</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>