<?php

function get_menu($id, &$strona) {
	Baza::db_query('SELECT * FROM menu');
	foreach (Baza::$ret as $t) {
		echo '
<li class="nav-item';

		if ($t['id'] == $id) {
			echo ' active';
			$strona = $t;
		}

echo '">
    <a class="nav-link" href="?id='.$t['id'].'">'.$t['tytul'].'</a>
</li>
		';
	}
}

function get_page_title($strona) {
	echo $strona['tytul'];
}

function get_page_content($strona) {
	if (file_exists($strona['plik']))
		include($strona['plik']);
	else
		include('404.html');
}

function get_kom($kom) {
	foreach ($kom as $v) {
		echo '<p class="text-info">'.$v.'</p>';
	}
}

?>