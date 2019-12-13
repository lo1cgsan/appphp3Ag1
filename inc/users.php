<?php
ini_set('session.save_path', 'sesje');

class User {
	var $dane = array();
	var $keys = array('id', 'login', 'email', 'haslo', 'data');
	var $CookieDomain = '';
	var $CookieName = 'phpapp'; // nazwa ciasteczka
	var $remTime = 7200; // 2 godz.
	var $kom = array();

	function __construct() {
		if ($this->CookieDomain == '') $this->CookieDomain = 'localhost';

		if (!isset($_SESSION)) session_start();

		if (isset($_COOKIE[$this->CookieName]) && !$this->id) {
			$c = unserialize(base64_decode($_COOKIE[$this->CookieName]));
			if ($this->login($c['login'], $c['haslo'], false, true)) {
				$this->kom[] = "Automatyczne logowanie.";
			}
		}

		if (!$this->id && isset($_POST['login2'])) {
			$login2 = clrtxt($_POST['login2']);
			$haslo2 = clrtxt($_POST['haslo2']);
			$this->login($login2, $haslo2, true, true);
		}
	}

	function login($login, $haslo, $rem=false, $load=true) {
		if ($load && $this->is_user($login, $haslo)) {
			if ($rem) { // zapis ciasteczka
				$cookie = base64_encode(serialize(array('login'=>$login, 'haslo'=>$haslo)));
				$a = setcookie($this->CookieName, $cookie, time()+$this->remTime, '/', $this->CookieDomain, false, true);
				if ($a) $this->kom[] = 'Zapisano ciasteczko.';
				$this->kom[] = "Witaj $login! Zostałeś zalogowany.";
				return true;
			}
		} else {
			$this->kom[] = '<p class="text-warning">Błędny login lub hasło</p>';
			return false;
		}
	}

	function logout(){
		setcookie($this->CookieName, '', time()-(3*$this->remTime), '/', $this->CookieDomain, false, true);
		$this->dane = array();
		$_SESSION = array();
		if (session_destroy()) $this->kom[] = 'Zosatłeś wylogowany!';
	}

	function is_user($login, $haslo) {
		$q = "SELECT * FROM users WHERE login='$login' AND haslo='".sha1($haslo)."' LIMIT 1";
		Baza::db_query($q);

		if (!empty(Baza::$ret[0])) {
			$this->dane = array_merge($this->dane, Baza::$ret[0]);
			$sid = sha1($this->id.$this->login.session_id());
			$_SESSION['sid'] = $sid;
			return true;
		}
		return false;
	}

	function __set($k, $v) {
		$this->dane[$k] = $v;
	}

	function __get($k) {
		if (array_key_exists($k, $this->dane))
			return $this->dane[$k];
		else
			return null;
	}

	function is_login($login) {
		$q = "SELECT id FROM users WHERE login = '$login' LIMIT 1";
		Baza::db_query($q);
		if (Baza::$ret) return true;
		return false;
	}

	function is_email($email) {
		$q = "SELECT id FROM users WHERE email = '$email' LIMIT 1";
		Baza::db_query($q);
		if (Baza::$ret) return true;
		return false;
	}

	function create_user() {
		$this->haslo = sha1($this->haslo);
		$q = 'INSERT INTO users (id, login, email, haslo)';
		$q .= ' VALUES(NULL, \''.$this->login.'\', \''.$this->email.'\', \''.$this->haslo.'\')';
		echo $q."<br>";
		Baza::db_exec($q);
		$this->id = Baza::db_lastID();
	}
}
?>