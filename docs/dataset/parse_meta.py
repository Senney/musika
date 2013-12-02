#!/usr/bin/python
import sqlite3

print "Opening connection to database."
conn = sqlite3.connect("track_metadata.db")
c = conn.cursor()
fout = open("data.sql", "w")

print "Starting selection operation."
c.execute("SELECT * FROM songs")

artist = {}
album = {}

while True:
	obj = c.fetchone()
	if obj == None:
		break
	songTitle = obj[1].encode("utf-8")
	albumTitle = obj[3].encode("utf-8")
	artistTitle = obj[6].encode("utf-8")
	if (artistTitle not in artist):
		query = "INSERT INTO artist(name) VALUES('%s');"
		fout.write(query % artistTitle + "\n")
		artist[artistTitle] = 1	
	if (albumTitle not in album):
		query = "INSERT INTO album(name) VALUES('%s');"
		fout.write(query % albumTitle + "\n")
		query = "INSERT INTO albumcontributor VALUES(" \
			"(SELECT artistId FROM artist WHERE name='%s'),"\
			"(SELECT albumID FROM album WHERE name='%s'));"
		fout.write(query % (artistTitle, albumTitle) + "\n")
		album[albumTitle] = 1
	query = "INSERT INTO song(title, AID) " \
		"SELECT '%s', artistId FROM artist WHERE " \
		"name = '%s';"
	fout.write(query % (songTitle, artistTitle) + "\n")
	query = "INSERT INTO albumsongs(albumId, songId) " \
		"VALUES((SELECT albumID FROM album WHERE name = '%s'),"\
		"(SELECT SID FROM song WHERE title = '%s'));"
	fout.write(query % (albumTitle, songTitle) + "\n")
