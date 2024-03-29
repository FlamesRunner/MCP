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

#### Installing master using Docker
You may also choose to install the host node using Docker. Before you start, make sure you have docker and docker-compose installed, as well as PHP 7.x and composer.
First, clone the repository and enter the master directory. We will need to run `composer install` to obtain our dependencies.
Then using screen or tmux, run `docker-compose up`. Detach from the screen and then execute the following commands:

    docker exec webserver chown nginx:nginx -R /usr/share/nginx/html
    docker exec webserver bash -c "cd /usr/share/nginx/html && php artisan migrate"

At this point, the system should be up and running.

#### Slave installation
Requirements:
- A freshly installed box running Debian 9

Once your master is installed, you should be able to see the installation instructions on the home screen. In any case, it is provided below for your convenience:

	cd ~ && wget https://raw.githubusercontent.com/FlamesRunner/MCP/master/slave/install.bash
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
- Add SSL to slave nodes so that API keys aren't transported in plain-text (severe)
- Multiple installations of MCP on a single server (working on it)
- For ease of development and use, adding the ability to use Docker to create an instance of the master server
- Master/slave compatibility on the same server
