
INTEGRATION INSTRUCTIONS FOR NET2FTP AND JOOMLA 1.0.8

The module mod_net2ftp simply prints the login screen of net2ftp.
The component com_net2ftp generates the other screens.

1 - Install net2ftp on your web server

2 - On your PC, open /com_net2ftp/net2ftp.php and /mod_net2ftp.php in your 
    favorite editor, and enter your settings as indicated in the file. 
    It's short, there are only 2 parameters to enter!

3 - Upload the /com_net2ftp and /mod_net2ftp directory to a temporary directory 
    on your web server, for example to /temporary/com_net2ftp and 
    /temporary/mod_net2ftp.

4 - Install the net2ftp module using Joomla's admin panel:
        - Go to Installers > Modules
        - Under the heading "Install from directory", select the directory 
          containing the net2ftp module files /temporary/mod_net2ftp
        - Click on "Install"

    Install the net2ftp component in a similar way:
        - Go to Installers > Components
        - Under the heading "Install from directory", select the directory 
          containing the net2ftp component files /temporary/com_net2ftp
        - Click on "Install"

5 - MODIFICATIONS MUST BE MADE TO 2 JOOMLA FILES:
	/index.php (to suppress the HTTP headers sent by Joomla)
	/includes/frontend.php (to print the CSS & Javascript needed by net2ftp)

    These files are provided in the directory /joomla_files_to_modify.

    Rename the existing files on your web server (as a backup) and upload the 
    modified files.

    If you made other modifications to these files, you can also insert the 
    changes manually. Look for the keyword NET2FTP to locate the modifications.

6 - Publish the net2ftp module:
        - Go to Modules > Site Modules
        - Select the net2ftp module, and click on "Publish"

If you have any question or remark, post a message on the forum at 
http://www.net2ftp.org/forums.
