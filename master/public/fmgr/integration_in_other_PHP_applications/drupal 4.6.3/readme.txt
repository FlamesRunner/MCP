
INTEGRATION INSTRUCTIONS FOR NET2FTP AND DRUPAL 4.6.3

1 - Install net2ftp on your web server

2 - On your PC, open net2ftp.module in your favorite editor, and enter your 
    settings as indicated in the file. 
    It's short, there are only 2 parameters to enter!

3 - Upload net2ftp.module to your web server in Drupal's /modules directory. 
    Once this is done the net2ftp module should appear in Drupal's admin 
    panel (administer > modules).

4 - MODIFICATIONS MUST BE MADE TO 1 DRUPAL FILE:
	/includes/theme.inc (to print the Javascript & CSS needed by net2ftp)

    Rename the existing /includes/theme.inc file to /includes/theme.inc.old,
    and upload the modified file which is provided.

    If you made other modifications to this file, you can also insert the 
    changes manually. Look for the keyword NET2FTP to locate the modifications.

5 - Enable the net2ftp module: 
        - Go to administer > modules
        - In the list of modules, flag the checkbox and click on Save 
          configuration

6 - Enable the net2ftp block:
        - Go to administer > blocks
        - In the list of blocks, flag the checkbox next to "net2ftp login form"
          and click on Save blocks

If you have any question or remark, post a message on the forum at 
http://www.net2ftp.org/forums.
