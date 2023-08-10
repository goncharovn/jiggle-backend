sudo cp /var/www/config/server/local/jiggle.com.conf /etc/apache2/sites-available/jiggle.com.conf
sudo a2ensite jiggle.com.conf
sudo a2enmod rewrite
sudo systemctl restart apache2
