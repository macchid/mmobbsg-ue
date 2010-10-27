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


create table orders
(
	id			SERIAL PRIMARY KEY,
	user_id		INTEGER,
	type		TEXT,
	start		DATE,
	expiry		DATE,
	active		BOOLEAN default TRUE
);

create table queues
(
	id			SERIAL PRIMARY KEY,
	order_id	INTEGER,
	front		INTEGER,
	rear		INTEGER
);

create table queue_elements
(
	id			SERIAL PRIMARY KEY,
	queue_id	INTEGER,
	next		INTEGER,
	detail		INTEGER
);
