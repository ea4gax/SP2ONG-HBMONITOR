Requirements:

- a webserver with activated PHP (apache, nginx or whatever) – PHP 7.x is ok

 

Extension of hbmonitor  – we log if a call is ended (I think it’s better as start) Please check permissions for writing the logfile in target folder !

Please remove comment char # in lines 516 - 520 

https://github.com/sp2ong/HBmonitor/blob/master/web_tables.py#L516

The line: 

    if int(float(p[9])) > 2:

we can skip show in last heard for exmaple from MASTER with name OPB-Link

    if p[3] != 'OPB-Link' and int(float(p[9])) > 2:


I recommed to shorten the lastheard.log from time to time (I cut every day to 550 lines, longer values maybe extend the load time and parsing) with this script lastheard.sh:

    #!/bin/bash
    mv /var/www/html/lastheard.log /var/www/html/lastheard.log.save
    /usr/bin/tail -550 /var/www/html/lastheard.log.save > /var/www/html/lastheard.log
    mv /var/www/html/lastheard.log /var/www/html/lastheard.log.save
    /usr/bin/tail -550 /var/www/html/lastheard.log.save > /var/www/html/lastheard.log


Call this script with crontab for everyday use.

Put this file in /etc/cron.daily/


Call the website with http://[YOUR_HOST/log.php it runs with a refresh/reload time of 30sec, change the script for other timeset.



Thank you, Heiko DL1BZ, who shared the lastheard code.

The version of web_tables.py in my fork contains the display in the column of group names.

73 Waldek SP2ONG

