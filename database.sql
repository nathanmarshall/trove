CREATE TABLE users (
	userId int UNSIGNED AUTO_INCREMENT NOT NULL,
	userFname VARCHAR(64) NOT NULL,
	userLname VARCHAR(64) NOT NULL,
	userPass VARCHAR(64) NOT NULL,
	salt VARCHAR(16) NOT NULL,
	userEmail VARCHAR (255) NOT NULL,
	userHandle VARCHAR(15) NOT NULL,
	userSince TIMESTAMP,
	PRIMARY KEY(userId)
);

CREATE TABLE userRelationship (
	relationId int UNSIGNED AUTO_INCRMENT NOT NULL, 
	relatingUserId int NOT NULL,
	relatedUserId int NOT NULL,
	relation ENUM('following', 'blocked', 'pending'),
	PRIMARY KEY(relationId)
);

CREATE TABLE comments(
	commentId int UNSIGNED AUTO_INCREMENT NOT NULL, 
	commentUserId int NOT NULL,
	commentPostId int NOT NULL,
	commentDate TIMESTAMP
	PRIMARY KEY(commentId)	 	
);

CREATE TABLE gems (
	gemId int UNSIGNED AUTO_INCREMENT NOT NULL,
	gemPostId int UNSIGNED NOT NULL,
	gemUserId int UNSIGNED NOT NULL,
	PRIMARY KEY(gemId)
);


CREATE TABLE posts(
postId int unsigned NOT NULL AUTO_INCREMENT, 
userId int NOT NULL,
postTitle VARCHAR(255),
postPhoto VARCHAR(64),
postText VARCHAR(300),
postDate TIMESTAMP,
postPrivacy ENUM('public','private') NOT NULL default 'public',
PRIMARY KEY(postId)
);


INSERT INTO users (userFname, userLname, userPass, salt, userEmail, userHandle, userSince) VALUES ('nathan', 'marshall', '12a5d18ee896e59954bdce0f4acc7212eebe03dae1834ef4ce160ac5afa5c4a8', '178a761925435a65', 'nathan123ca@gmail.com', 'natesmarshall', NOW());


INSERT INTO userRelationship ()
INSERT INTO userRelationship ()
INSERT INTO userRelationship ()

