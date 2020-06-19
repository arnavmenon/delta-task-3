# delta-task-3-Invitation WebApp
### NOTE:
The integrated PHPMailer API currently only supports mails sent from a **GMail** account. Sender will have to enter their GMail login details if they wish to send invitation via e-mail (Login details will not be stored).
In order to send invitation by mail:

1. Login to the your Google account on the same browser.
2. Send a dummy private invitation to yourself.
3. Enable less secure app access in this link:https://myaccount.google.com/lesssecureapps
4. In case you get a Critical Security Alert mail, verify it.
5. Now you can send invitations through Email! 

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
5.In **php/php.ini** configuration file, enable the following extensions (remove preceding ;).
```
extension=mysqli
extension=curl
extension=openssl
```
6.Start the server and open **localhost** on your browser.


