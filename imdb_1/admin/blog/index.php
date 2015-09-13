<?php
	echo "yoyoyoy";

	if (isset($_GET['action']) ) {


		echo "gogogo";

		if ( $_GET['action'] == 'gotoapipage' ) {
			echo "real go";
			include 'api.html.php';
		}

	}


	include 'read2.html';

?>