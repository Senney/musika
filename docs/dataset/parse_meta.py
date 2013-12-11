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
		query = "A %s"
		fout.write(query % artistTitle + "\n")
		artist[artistTitle.lower()] = 1	
	if ((albumTitle.lower() not in album) or (album[albumTitle.lower()] != artistTitle.lower())):
		query = "B %s"
		fout.write(query % albumTitle + "\n")
		query = "C %s\nC %s"
		fout.write(query % (artistTitle, albumTitle) + "\n")
		album[albumTitle.lower()] = artistTitle.lower()
	query = "S %s\nS %s"
	fout.write(query % (songTitle, artistTitle) + "\n")
	query = "Z %s\nZ %s"
	fout.write(query % (albumTitle, songTitle) + "\n")
