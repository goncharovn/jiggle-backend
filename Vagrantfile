Vagrant.configure("2") do |config|
  config.vm.box = "generic/ubuntu2204"
  
  config.vm.network "private_network", ip: "192.168.56.0"
  
  config.vm.synced_folder "www/", "/var/www/"
  config.vm.synced_folder "db/", "/vagrant/db"
  
  config.vm.provision "shell", path: "scripts/install-packages.sh"
  config.vm.provision "shell", path: "scripts/setup-xdebug.sh"
  config.vm.provision "shell", path: "scripts/setup-apache.sh"
  config.vm.provision "shell", path: "scripts/setup-db.sh"
  config.vm.provision "shell", path: "scripts/setup-mail.sh"
  config.vm.provision "shell", inline: <<-SHELL
    rm -r /var/www/html
  SHELL
end
