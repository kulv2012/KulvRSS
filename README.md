KulvRSS
=======

个人使用的小RSS阅读器，接替google reader的工作。

使用方法：
    1.搭建好nginx-php环境后，部署代码到根目录。然后配置./conf/config.php文件里面的数据库密码，账号等。
    2.创建mysql数据库,create database Db_Myrss
    3.导入表结构: mysql -uroot Db_Myrss < Db_Myrss.sql
    4.创建如上配置 mysql账号信息即可
