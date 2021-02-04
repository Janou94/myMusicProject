create table user_account(ID int primary key AUTO_INCREMENT, LOGIN text, PASSWORD text);

create table user_chords (ID int primary key AUTO_INCREMENT, NAME text, VALUE text, ID_USER int  references user_account(ID), PERCUSSION text, MELODY text );

alter table user_account add column (LASTSEEN date);