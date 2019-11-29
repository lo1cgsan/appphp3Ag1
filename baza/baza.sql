DROP TABLE IF EXISTS menu;
CREATE TABLE menu (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	tytul VARCHAR,
	plik VARCHAR,
	pozycja INTEGER
);

INSERT INTO menu VALUES(NULL, 'Strona główna', 'glowna.html', 1);
INSERT INTO menu VALUES(NULL, 'Użytkownicy', 'userform.html', 2);
INSERT INTO menu VALUES(NULL, 'Wiadomości', 'wiadomosci.html', 3);

DROP TABLE IF EXISTS users;
CREATE TABLE users (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	login CHAR(20),
	haslo CHAR(40),
	email VARCHAR(50),
	data DATE
);

DROP TABLE IF EXISTS posty;
CREATE TABLE posty (
	id INTEGER PRIMARY KEY AUTOINCREMENT,
	wiadomosc VARCHAR,
	id_user INTEGER,
	FOREIGN KEY (id_user) REFERENCES users(id)
);