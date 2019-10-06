
INTEGRATION INSTRUCTIONS FOR NET2FTP AND DRUPAL 5.3

1 - Install net2ftp on your web server

2 - On your PC, open /modules/net2ftp/net2ftp.module in your favorite editor, 
    and enter your settings as indicated in the file. 
    It's short, there are only 2 parameters to enter!

3 - Upload /drupal 5.3/net2ftp to your web server in Drupal's /modules directory. 
    Once this is done the net2ftp module should appear in Drupal's admin 
    panel (Administer > Site building > Modules).

4 - MODIFICATIONS MUST BE MADE TO 1 DRUPAL FILE:
	/includes/theme.inc (to print the Javascript & CSS needed by net2ftp)

    Rename the existing /includes/theme.inc file to /includes/theme.inc.old,
    and upload the modified file which is provided.

    If you made other modifications to this file, you can also insert the 
    changes manually. Look for the keyword NET2FTP to locate the modifications.

5 - Enable the net2ftp module: 
        - Go to Administer > Site building > Modules
        - In the list of modules, flag the checkbox and click on Save 
          configuration

6 - Enable the net2ftp block:
        - Go to Administer > Site building > Blocks
        - In the list of blocks, select a region from the drop-down box next to
          "net2ftp login form" (e.g. left sidebar) and click on Save blocks

If you have any question or remark, post a message on the forum at 
http://www.net2ftp.org/forums.
