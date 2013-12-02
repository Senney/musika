USE musika;

CREATE TABLE IF NOT EXISTS users(
	UserId INTEGER NOT NULL AUTO_INCREMENT,
	username VARCHAR(254) NOT NULL,
	password VARCHAR(254) NOT NULL,
	email VARCHAR(254) NOT NULL,
	bio TEXT,
	
	PRIMARY KEY (UserId)
);

CREATE TABLE IF NOT EXISTS friend(
	UserId INTEGER NOT NULL,
	FriendId INTEGER NOT NULL,
	
	PRIMARY KEY (UserId, FriendId),
	FOREIGN KEY (UserId) REFERENCES users(UserId),
	FOREIGN KEY (FriendId) REFERENCES users(UserId)
);

CREATE TABLE IF NOT EXISTS genre(
	GID INTEGER NOT NULL AUTO_INCREMENT,
	type TEXT NOT NULL,
	description TEXT,
	
	PRIMARY KEY (GID)
);

CREATE TABLE IF NOT EXISTS media( 
	MID INTEGER NOT NULL AUTO_INCREMENT,
	type TEXT NOT NULL,
	description TEXT,
	
	PRIMARY KEY (MID)
);

CREATE TABLE IF NOT EXISTS artist(
	artistId INTEGER NOT NULL AUTO_INCREMENT,
	name TEXT NOT NULL,
	desc TEXT,
	startYear INTEGER,
	endYear INTEGER,
	genre INTEGER,
	
	PRIMARY KEY (artistId),
	FOREIGN KEY (genre) REFERENCES genre(GID)
);

CREATE TABLE IF NOT EXISTS album(
	albumID INTEGER NOT NULL AUTO_INCREMENT,
	name TEXT NOT NULL,
	year INTEGER,
	genre INTEGER,
	media INTEGER,
	
	PRIMARY KEY (albumID),
	FOREIGN KEY (genre) REFERENCES genre(GID),
	FOREIGN KEY (media) REFERENCES media(MID)
);

CREATE TABLE IF NOT EXISTS albumcontributor(
	artistId INTEGER NOT NULL,
	albumId INTEGER NOT NULL,
	
	PRIMARY KEY (artistId, albumId),
	FOREIGN KEY (artistId) REFERENCES artist(artistId),
	FOREIGN KEY (albumId) REFERENCES album(albumId)
);
	
CREATE TABLE IF NOT EXISTS albumownership(
	UID INTEGER NOT NULL,
	AID INTEGER NOT NULL,
	
	PRIMARY KEY (UID, AID),
	FOREIGN KEY (UID) REFERENCES users(UserId),
	FOREIGN KEY (AID) REFERENCES album(albumId)
);

CREATE TABLE IF NOT EXISTS song(
	SID INTEGER NOT NULL AUTO_INCREMENT,
	title TEXT NOT NULL,
	description TEXT NOT NULL,
	AID INTEGER NOT NULL,
	genre INTEGER,
	media INTEGER,
	
	PRIMARY KEY (SID),
	FOREIGN KEY (AID) REFERENCES artist(artistId),
	FOREIGN KEY (genre) REFERENCES genre(GID),
	FOREIGN KEY (media) REFERENCES media(MID)
);

CREATE TABLE IF NOT EXISTS songownership(
	UID INTEGER NOT NULL,
	SID INTEGER NOT NULL,
	
	PRIMARY KEY (UID, SID),
	FOREIGN KEY (SID) REFERENCES song(SID),
	FOREIGN KEY (UID) REFERENCES users(UserId)
);

CREATE TABLE IF NOT EXISTS albumsongs(
	albumId INTEGER NOT NULL,
	songId INTEGER NOT NULL,
	
	PRIMARY KEY (albumId, songId),
	FOREIGN KEY (albumId) REFERENCES album(albumId),
	FOREIGN KEY (songId) REFERENCES song(SID)
);
