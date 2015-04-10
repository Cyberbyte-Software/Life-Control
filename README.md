# Life-Control

Life-Control is developed by Cammygames. This contains primarily the release and on-going development changes to the Database Panel.
Life-Control by Cammygames is licensed under a Creative Commons Attribution-NonCommercial-NoDerivs 3.0 Unported License
http://creativecommons.org/licenses/by-nc-nd/3.0/deed.en_US

## Credits
	
erdknuffel aka jastend for giving me some ideas and fixes for Life-Control and letting me merge some of them in to the base file from his custom one

MightySCollins for changes ot the code base to make things more effective!

## Installation

1. Download the latest files (for mostly-stable versions, please visit our [releases section](https://github.com/cammygames/Life-Control/releases/tag/2.0))
2. Unpack everything
3. Add your database settings to the [config/db.php](https://github.com/cammygames/Life-Control/blob/master/config/db.php)
3. Upload the files to your webserver
4. Run this database query in your Altis Life database: https://gist.github.com/cammygames/ff1ebe48b1130e10d1b8
   * Default username: Admin
   * Default password: Admin%12345
6. Create a hash of your first password via http://life.kbs-altis.de/hash/
7. Go into the users table and change your username and password for your first account
8. Gently congratulate yourself with a hot beverage of your choice and log in

## Rank system

The System Now Uses A User Level System Based Of The Modifications erdknuffel Made To The Level System

### Administrator

1. Can edit **everything**
2. Can add new users and admins
3. Can see current players in server

### Moderator

1. Can edit **everything** except for Admin level
2. Can't add new users
3. Can see current players in server

### Support

1. Can Only Set Cop/Medic Rank
2. Can't see richest players in Dashboard
3. Can't see vehicles,houses,gangs
4. Can't see current players in server
