# F3-OOP

This is to run Windows XAMPP Environment.

Create a host on your local machine (machinecompare.test) and set up a virtual host, for example:

In C:\Windows\System32\drivers\etc\host include the line > 127.0.0.1 machinecompare.test

In C:\xampp\apache\conf\extra httpd-vhosts.conf include...

<VirtualHost *:80>
       DocumentRoot "C:/xampp/htdocs/machinecompare"
       ServerName machinecompare.test
</VirtualHost>

Re/start your Xampp server
From your IDE, clone the repo to your DocumentRoot for your virtual host.
Create a MySQL database and run the db.sql (inside SLQ directory).
Rename the .env_example to .env and update the DB details in that file to match database.
In your browser, you should now be able to navigate to the host created (http://machinecompare.test), or whatever you configured.
