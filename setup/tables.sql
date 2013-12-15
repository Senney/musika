USE musika;

CREATE TABLE IF NOT EXISTS gracenote(
	userId VARCHAR(60) NOT NULL,

	PRIMARY KEY (userId)
);

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
	description TEXT,
	era INTEGER,
	genre INTEGER,
	
	PRIMARY KEY (artistId),
	FOREIGN KEY (genre) REFERENCES genre(GID)
);

CREATE TABLE IF NOT EXISTS album(
	albumID INTEGER NOT NULL AUTO_INCREMENT,
	name TEXT NOT NULL,
	year INTEGER,
	genre INTEGER,
	
	PRIMARY KEY (albumID),
	FOREIGN KEY (genre) REFERENCES genre(GID)
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
	media INTEGER,
	
	PRIMARY KEY (UID, AID),
	FOREIGN KEY (UID) REFERENCES users(UserId),
	FOREIGN KEY (AID) REFERENCES album(albumId),
	FOREIGN KEY (media) REFERENCES media(MID)
);

CREATE TABLE IF NOT EXISTS song(
	SID INTEGER NOT NULL AUTO_INCREMENT,
	title TEXT NOT NULL,
	description TEXT,
	AID INTEGER NOT NULL,
	genre INTEGER,
	
	PRIMARY KEY (SID),
	FOREIGN KEY (AID) REFERENCES artist(artistId),
	FOREIGN KEY (genre) REFERENCES genre(GID)
);

CREATE TABLE IF NOT EXISTS songownership(
	UID INTEGER NOT NULL,
	SID INTEGER NOT NULL,
	media INTEGER,
	
	PRIMARY KEY (UID, SID),
	FOREIGN KEY (SID) REFERENCES song(SID),
	FOREIGN KEY (UID) REFERENCES users(UserId),
	FOREIGN KEY (media) REFERENCES media(MID)
);

CREATE TABLE IF NOT EXISTS albumsongs(
	albumId INTEGER NOT NULL,
	songId INTEGER NOT NULL,
	
	PRIMARY KEY (albumId, songId),
	FOREIGN KEY (albumId) REFERENCES album(albumId),
	FOREIGN KEY (songId) REFERENCES song(SID)
);

CREATE TABLE IF NOT EXISTS playlist(
	userId INTEGER NOT NULL,
	pId INTEGER NOT NULL,
	name TEXT,

	PRIMARY KEY (userId, pId),
	FOREIGN KEY (userId) REFERENCES users(UserId)
);

CREATE TABLE IF NOT EXISTS playlistentry(
	userId INTEGER NOT NULL,
	pId INTEGER NOT NULL,
	sId INTEGER NOT NULL,
	
	PRIMARY KEY (userId, pId, sId),
	FOREIGN KEY (userId, pId) REFERENCES playlist(userId, pId),
	FOREIGN KEY (sId) REFERENCES song(SID)
);

CREATE TABLE IF NOT EXISTS playlistrating(
	userId1 INTEGER NOT NULL,
	userId2 INTEGER NOT NULL,
	pId INTEGER NOT NULL,
	rating INTEGER NOT NULL,
	
	PRIMARY KEY (userId1, userId2, pId),
	FOREIGN KEY (userId2) REFERENCES users(UserId),
	FOREIGN KEY (userId1, pId) REFERENCES playlist(userId pId)
);
	