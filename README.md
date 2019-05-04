# SimpleBankWebApp
Simple Web Banking Application Model

To run this app, you must first ensure that a web server is set up running php, mysql and a connection between the two.

Steps for Linux:

1) create the database using MySQL with the provided "setup.sql"
2) after setup, edit the credentials within the .php files where you see "CREDENTIALS HERE"
3) place all files except the "crontab" folder in your /var/www/html/ or the equivalent on Windows
4) afterwards, follow the steps in the crontab folder of this repository
(dont forget to also change credentials within the php file in the crontab)

Everything should work from there.
