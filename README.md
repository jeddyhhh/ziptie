# ziptie
A web interface for llama.cpp cli written in js and php.

<p align="center">
  <img src="https://github.com/jeddyhhh/ziptie/blob/main/includes/images/ziptie.jpg">
  <br>
  ziptiebot - a i5 2400 with 8gb of RAM running 7b models
</p>

I wrote this interface because the version of llama.cpp that oogabooga web-ui uses doesn't compile correcly for older processes without AVX2 support, the current mainline llama.cpp (which is command line only) does compile and run correctly on older processors but I didn't want to use cli to interact with the program.

This web-ui is only for one shot prompts and does not use the interactive mode, it will take 1 prompt and generate text until it runs out of tokens.

The install instructions are assuming a clean install of Ubuntu server or WSL.

Install instructions:

sudo apt update
sudo apt install apache2 php libapache2-mod-php git build-essential vsftpd

sudo ufw allow "Apache Full"<br>
sudo nano /etc/vsftpd.conf - enable write<br>
sudo nano /etc/apache2/mods-enabled/dir.conf - change to index.php first<br>
sudo service apache2 restart<br>
sudo service vsftpd restart<br>

cd /var/www/html<br>
sudo git clone https://github.com/ggerganov/llama.cpp<br>
cd llama.cpp<br>
sudo make<br>

Transfer files via ftp to /var/www/html<br>

sudo chown -R yourusername:www-data /var/www<br>
sudo chmod -R 775 /var/www<br>
sudo service apache2 restart<br>
sudo service vsftpd restart<br>

go to http://localhost to use ziptie<br>

After restart of WSL (not for Ubuntu server):<br>
WSL doesn't auto start services, so you have to make a startWSLServer.bat:<br>
wsl sudo service apache2 start<br>
wsl sudo service vsftpd start<br>
WSL is now running in the background with the web server/ftp server, you can now go to http://localhost<br>

To update llama.cpp:<br>
cd /var/www/html/llama.cpp<br>
git stash<br>
git pull origin master<br>
make




