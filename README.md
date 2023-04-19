# ziptie
A web interface for llama.cpp cli written in js, jQuery and php.

<p align="center">
  <img src="https://github.com/jeddyhhh/ziptie/blob/main/includes/images/screenshot.JPG" height="502px" width='45%' />
  &nbsp;
  <img src="https://github.com/jeddyhhh/ziptie/blob/main/includes/images/ziptie.jpg" width='45%' /> 
  <br>
  ziptiebot - a i5 2400 with 8gb of RAM running 7b models, also what ziptie was developed on.
</p>

I wrote this interface because the version of llama.cpp that oogabooga web-ui (at the time, not sure if this has changed) uses doesn't compile correcly for older processes without AVX2 support, the current mainline llama.cpp (which is command line only) does compile and run correctly on older processors but I didn't want to use cli to interact with the program.

This web-ui is only for one shot prompts and does not use the interactive mode, it will take 1 prompt and generate text until it runs out of tokens.

<b>Install instructions/commands (clean install of Ubuntu server or WSL)</b>:<br>
<b>Note for WSL users:</b> It's possible to access WSL linux files from `\\wsl.localhost` in Windows Explorer, you may not want to install the vsftpd package.<br>

`sudo apt update`<br>
`sudo apt install apache2 php libapache2-mod-php git build-essential vsftpd`<br>

`sudo ufw allow "Apache Full"`<br>
`sudo nano /etc/vsftpd.conf` - uncomment `write_enable=YES` and save.<br>

`cd /var/www/html`<br>
`sudo git clone https://github.com/jeddyhhh/ziptie`<br>
`cd ziptie`<br>
`./installLlama.sh`<br>

Transfer model files via ftp to `/var/www/html/ziptie/llama.cpp/models/["model-name"]/["model-name"].bin`<br>
Example: `/var/www/html/ziptie/llama.cpp/models/vicuna-7b/ggml-model-q4_0.bin`<br>
<b>WSL Users: </b>You can go to `\\wsl.localhost\["distro-name"]\var\www\html\ziptie\llama.cpp\models` then drag and drop model folders to here.<br>
`["distro-name"]` is usually `Ubuntu`.<br>

`sudo chown -R ["yourusername"]:www-data /var/www/html/ziptie`<br>
`sudo chmod -R 775 /var/www/html/ziptie`<br>
`sudo service apache2 restart`<br>
`sudo service vsftpd restart`<br>

go to http://localhost/ziptie to use ziptie.<br>
You can change site settings in adminSettings.txt, there is options to lock certain setting fields and set a default setting file to be loaded on startup.<br>

<b>Usage:</b><br>
1. On very first load, hit the "Reload All Settings" button, this will scan the models and prompts you have transfered and put them into a list for the website to read.<br>
2. Edit any parameters in settings and hit "Save". (Selecting "Save as Default" will change the default settings file to be loaded on startup)<br>
3. You can now hit "Submit Prompt", it will now start generating text.<br>

<b>After restart of WSL (not for Ubuntu server):</b><br>
WSL doesn't auto start services, so you need to run these commands after a restart of WSL and/or Windows:<br>
`wsl sudo service apache2 start`<br>
`wsl sudo service vsftpd start`<br>
WSL is now running in the background with the web server/ftp server, you can now go to http://localhost/ziptie<br>
.bat files for these scripts are in `includes/wsl-scripts` of this repository<br>

<b>To update ziptie:</b><br>
run `./updateZiptie.sh`

<b>To update llama.cpp:</b><br>
run `./updateLlama.sh`




