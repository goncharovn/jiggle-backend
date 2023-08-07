Vagrant.configure("2") do |config|
  config.vm.box = "generic/ubuntu2204"
  
  config.vm.network "private_network", ip: "192.168.56.0"
  
  config.vm.synced_folder "www/", "/var/www/"
  config.vm.synced_folder "db/", "/vagrant/db"
  
  config.vm.provision "shell", inline: <<-SHELL
    sudo apt-get update
    sudo apt-get install -y apache2
    sudo apt-get install -y mysql-server
    sudo apt-get install -y php libapache2-mod-php php-mysql
    sudo apt-get install -y php-xdebug
    sudo apt-get install -y ssmtp
    
    sudo cp /var/www/config/tools/xdebug.ini /etc/php/8.1/cli/conf.d/20-xdebug.ini
    
    sudo cp /var/www/config/server/local/jiggle.com.conf /etc/apache2/sites-available/jiggle.com.conf
    sudo a2ensite jiggle.com.conf
    
    sudo a2enmod rewrite
    
    sudo systemctl restart apache2
    
    sudo mysql -e "CREATE USER 'test'@'localhost' IDENTIFIED BY 'test';"
    sudo mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'test'@'localhost' WITH GRANT OPTION;"
    sudo mysql -e "FLUSH PRIVILEGES;"
    sudo mysql -u root -e "CREATE DATABASE IF NOT EXISTS db"
    sudo mysql -u root db < /vagrant/db/entire_dump.sql
    
    sudo service mysql restart
  SHELL
end
