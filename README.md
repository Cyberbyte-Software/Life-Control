Life-Control is developed by Cammygames. This contains primarily the release and on-going development changes to the Database Panel. This version is forked from the original version to accompany the needs of KBS-Altis.de, a German Altis Life Server. For the original version, please visit https://github.com/cammygames/Life-Control

## Installation

1. Download the latest files (for mostly-stable versions, please visit our [releases section](https://github.com/jastend/Life-Control/releases/tag/1.0))
2. Unpack everything
3. Add your database settings to the [config/db.php](https://github.com/jastend/Life-Control/blob/master/config/db.php)
3. Upload the files to your webserver
4. Run this database query in your Altis Life database: https://gist.github.com/jastend/16eeec33ba470735a8da
   * Default username: Admin
   * Default password: Admin%12345
6. Create a hash of your first password via http://life.kbs-altis.de/hash/
7. Go into the users table and change your username and password for your first account
8. Gently congratulate yourself with a hot beverage of your choice and log in

## Rank system

This version uses a modified rank system that includes 3 permission tiers. The following description starts with the highest permission level and outlines what is restricted compared to the superior level.

### Administrator

1. Can edit **everything**
2. Can add new users and admins
 
### Super-User

1. Can edit **everything**
2. Can't add new users
3. Can't see house locations

### User

1. Can't see richest players in Dashboard
2. Can see Players *- with the exception of house information -* but not edit them *- with the exception of some vehicles*
3. Can't see vehicle list, but access vehicles that got destroyed or aren't in the garage anymore
4. Can't see houses
5. Can access gangs but can't edit them

## Issues / Questions

This plugin is mostly developed to accompany the needs of our server. If you have any questions or issues, feel free to head over to the [issues section](https://github.com/jastend/Life-Control/issues) or contact us (in German) via http://life.kbs-altis.de/index.php/Contact/

## License

Life-Control by Cammygames is licensed under a Creative Commons Attribution-NonCommercial-NoDerivs 3.0 Unported License
http://creativecommons.org/licenses/by-nc-nd/3.0/deed.en_US

This version is just a fork and wouldn't be possible without his great work - so please make sure to [thank Cammygames for it](http://www.altisliferpg.com/topic/9201-tool-life-control-web-panel-for-altis-life/)!
