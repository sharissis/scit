Database Information:
	00.	DEV:	jerome_scit-dev
	01.	PROD:	jerome_scit


#########
#	Steel City Improv
127.0.0.5 scit.com
127.0.0.5 forum.scit.com
127.0.0.5 tv.scit.com
127.0.0.5 info.scit.com
#
#	Development Database
127.0.0.5 dev.scit.com
127.0.0.5 dev-forum.scit.com
127.0.0.5 dev-tv.scit.com
127.0.0.5 dev-info.scit.com

#######
XAMPP:
apache\conf\extra\httpd-vhosts.conf
#########
<VirtualHost 127.0.0.5:80>
ServerAdmin me@scit.com
DocumentRoot C:\xampp\htdocs\networks\steelcityimprov.com
ServerName scit.com
ServerAlias www.scit.com
</VirtualHost>