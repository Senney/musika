#!/usr/bin/python
import sqlite3
import json 

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
	songTitle = json.dumps(obj[1].encode("utf-8"))
	albumTitle = json.dumps(obj[3].encode("utf-8"))
	artistTitle = json.dumps(obj[6].encode("utf-8"))
	if (artistTitle not in artist):
		query = "A %s"
		fout.write(query % artistTitle + "\n")
		artist[artistTitle] = 1	
	if ((albumTitle not in album) or (album[albumTitle] != artistTitle)):
		query = "B %s"
		fout.write(query % albumTitle + "\n")
		query = "C %s\nC %s"
		fout.write(query % (artistTitle, albumTitle) + "\n")
		album[albumTitle] = artistTitle 
	query = "S %s\nS %s"
	fout.write(query % (songTitle, artistTitle) + "\n")
	query = "Z %s\nZ %s"
	fout.write(query % (albumTitle, songTitle) + "\n")
