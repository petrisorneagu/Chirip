<?php
include '../init.php';


//ajax request
if(isset($_POST['search']) && !empty($_POST['search'])){
    $search = $getFromU->checkInput($_POST['search']);
    $result = $getFromU->search($search);

    echo '<div class="nav-right-down-wrap"><ul>';

    foreach($result as $user){

        echo '
   <li>
  		<div class="nav-right-down-inner">
			<div class="nav-right-down-left">
				<a href="'.$user->username.'"><img src="'. BASE_URL.$user->profileImage.'"></a>
			</div>
			<div class="nav-right-down-right">
				<div class="nav-right-down-right-headline">
					<a href="'.$user->username.'">'.$user->screenName.'</a><span>@'.$user->username.'</span>
				</div>
				<div class="nav-right-down-right-body">
				 
			    </div>
			</div>
		</div> 
	 </li> 
        ';
    }

    echo '</ul></div>';
}




