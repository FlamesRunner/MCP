# MCP
A PHP/Laravel-based Minecraft server management panel.

### Licensing
This software is released under the GNU General Public License V3, which means that you are free to use this software so long as you keep it open source.

### Installation
Installation of this software is fairly simple. The administration interface isn't entirely complete, so it can only be used by end-users. That said,
you will need to do two things: install a copy of the master software on a web server and a copy of the slave software on the server you want managed.

#### Master installation
This software is best optimised for use on NGINX and PHP 7.2. No guarantees are provided for bugs on versions of PHP < 7.2 and NGINX versions < 1.14.0.
MySQL/MariaDB is also required, but the version is less important in this case. 

Once you have your base system setup, enter your web directory and copy the files from the master/* directory. Fill in your .env file with the .env.example as
a template, and enter your database, application name and settings. While SMTP is not strictly required, it is necessary to enable the lost password
functionality.

In either case, if you set everything up properly (a more extensive guide will be published at a later date), then you should be able to create an account. 

#### Slave installation
Once your master is installed, you should be able to see the installation instructions on the home screen. In any case, it is provided below for your convenience:

	cd ~ && wget https://s.flamz.pw/dl/install.bash
	chmod +x install.bash
	./install.bash

All of the files the installer uses and the archive with the slave data can be found in the slave/ directory. The publically available version is updated as required.

#### Bugs
Please include your operating system version, PHP version and the severity of your bug in an issue report.
Severe bugs include security vulnerabilities and issues that need to be resolved immediately. Normal-severity bugs
are ones that are not as severe, but can still disrupt functionality in the panel. Minor bugs are those that are 
cosmetic and are not urgent.

#### Hosted version
There is a hosted version available at https://mcp.ahong.ca that is fully working and running on the latest tested release. The only thing that you need to do is
add a server (follow the slave installation guide above.) You may choose a port after installation that works for you, although the system will default to 25565. Note that the panel does not properly support NAT yet (well, I'm not actually sure if NAT works on the panel yet. If you're willing to test this, please let me know your findings, and thanks!).

#### TO-DO
- Administration area
- Easier installation process & guide
- ~Alternate ports than 25565~
- Multiple installations of MCP on a single server
- Master/slave compatibility on the same server
