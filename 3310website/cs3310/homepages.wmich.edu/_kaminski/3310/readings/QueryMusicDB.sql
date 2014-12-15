tee logfile.txt
select user, host from mysql.user;
show databases;
use music;
show tables;
show columns from cds;
select * from cds;
select title, artist, price from cds;
select * from cds where category = "POP";
select * from cds where category = 'POP';
select * from cds where category = "pop";
select category, title, id from cds
    	where price < 15;
select * from cds where title = "4TH DOOR";
select * from cds order by title
	;
select * from cds
	where category = "pop"
	order by price
	;
select * from cds order by artist desc;
notee