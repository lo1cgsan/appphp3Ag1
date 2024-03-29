DROP TABLE IF EXISTS menu;
CREATE TABLE menu (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	tytul VARCHAR,
	plik VARCHAR,
	pozycja INTEGER
);

INSERT INTO menu VALUES(NULL, 'Główna', 'glowna.html', 1);
INSERT INTO menu VALUES(NULL, 'Wiadomości', 'wiadomosci.html', 2);
INSERT INTO menu VALUES(NULL, 'Konto', 'userform.html', 3);
INSERT INTO menu VALUES(NULL, 'Zaloguj się', 'userlogin.html', 4);
INSERT INTO menu VALUES(NULL, 'Wyloguj się', 'wyloguj.html', 5);


DROP TABLE IF EXISTS users;
CREATE TABLE users (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	login CHAR(20),
	haslo CHAR(40),
	email VARCHAR(50),
	data DATE DEFAULT CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS posty;
CREATE TABLE posty (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	wiadomosc VARCHAR,
	id_user INTEGER,
	data DATE DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (id_user) REFERENCES users(id)
);