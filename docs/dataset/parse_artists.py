#!/usr/bin/python

fio = open("unique_artists.txt", "r")
out = open("artists.sql", "w")

query = "INSERT INTO artists(name) VALUES('%s')"
for line in fio:
    parts = line.split("<SEP>")
    artist = parts[3][:-1]
    artist_query = query % artist
    out.write(artist_query + "\n")
