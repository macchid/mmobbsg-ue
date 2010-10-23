create table users
(
	id			SERIAL PRIMARY KEY,
	group_id	INTEGER default 0,		
	username	TEXT not null,
	password	TEXT not null,
	salt		TEXT not null,
	server		TEXT,
	breed		CHAR(1),
	active		BOOLEAN default FALSE
);

