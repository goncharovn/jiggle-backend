Vagrant.configure("2") do |config|
  config.vm.box = "generic/ubuntu2204"
  
  config.vm.network "private_network", ip: "192.168.56.0"
  
  config.vm.synced_folder "www/", "/var/www/"
  
  config.vm.provision "shell", inline: <<-SHELL
    sudo apt-get update
    sudo apt-get install -y apache2
    sudo apt-get install -y mysql-server
    sudo apt-get install -y php libapache2-mod-php php-mysql
    sudo apt-get install -y php-xdebug
    
    sudo cp /var/www/config/xdebug.ini /etc/php/8.1/cli/conf.d/20-xdebug.ini
    
    sudo cp /var/www/config/jiggle.com.conf /etc/apache2/sites-available/jiggle.com.conf
    sudo a2ensite jiggle.com.conf
    
    sudo a2enmod rewrite
    
    sudo systemctl restart apache2
  SHELL
end
