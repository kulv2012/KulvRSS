KulvRSS
=======

个人使用的小RSS阅读器，接替google reader的工作。

功能主治：
    1.可以使用国外feed，当然依靠你的服务器是否能安全。
    2.简单，可依靠；
    3.支持关键词邮件订阅，加星功能;
    4.巧妙的/所谓的可以离线阅读;
    5.跨平台支持。其实是html




使用方法：
    1.搭建好nginx-php环境后，部署代码到根目录。然后配置./conf/config.php文件里面的数据库密码，账号等。
    2.创建mysql数据库,create database Db_Myrss
    3.导入表结构: mysql -uroot Db_Myrss < Db_Myrss.sql
    4.创建如上配置 mysql账号信息即可



