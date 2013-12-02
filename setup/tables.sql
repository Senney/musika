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
