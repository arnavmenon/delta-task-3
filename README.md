# delta-task-3-Invitation WebApp
## Setup guide for Windows(Using Apache server and MySQL)

1. Copy all files into **C:\Apache\htdocs** folder;
2. Open **password.php** in **processes** folder with Notepad. Type your MySQL username and password inside the apprpriate " " and save the file.
3. In MySQL create a new database, **inviteapp**.
```
CREATE DATABASE inviteapp
```
4. Select the database and create tables **userdata** and **invites**.
```
USE inviteapp

CREATE TABLE userdata(
username varchar(25) PRIMARY KEY,
email varchar(50),
p_word varchar(25)
)

CREATE TABLE invites(
id int(6) PRIMARY KEY AUTO INCREMENT,
invite_id int(6),
from_user varchar(25),
to_user varchar(25),
header varchar(50),
body varchar(300),
footer varchar(100),
accept int(6)
)

```
5.Start the server and open **localhost** on your browser.


