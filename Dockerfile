# Use Ubuntu as the base image
FROM ubuntu:20.04

# Set environment variables to avoid interactive prompts during package installation
ENV DEBIAN_FRONTEND=noninteractive

# Install PHP, Apache, MySQL, and necessary extensions
RUN apt-get update && apt-get install -y \
    apache2 \
    mysql-server \
    php \
    php-mysqli \
    php-pdo \
    php-pdo-mysql \
    libapache2-mod-php \
    && apt-get clean

# Set up Apache to serve the PHP app on port 8080
RUN echo "Listen 8080" >> /etc/apache2/ports.conf
RUN sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf

# Enable mod_rewrite for URL rewriting
RUN a2enmod rewrite

# Copy the PHP application files into the container
COPY FCDS /var/www/html/

# Initialize MySQL (this will set up the root password and database)
RUN service mysql start && \
    mysql -e "CREATE DATABASE IF NOT EXISTS fcds;" && \
    mysql -e "CREATE USER 'root'@'%' IDENTIFIED BY 'rootpassword';" && \
    mysql -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%';" && \
    mysql -e "FLUSH PRIVILEGES;"

# Run the fcds.sql file to set up the database schema and data
COPY FCDS/fcds.sql /tmp/fcds.sql
RUN service mysql start && \
    mysql -u root -prootpassword fcds < /tmp/fcds.sql && \
    rm /tmp/fcds.sql

# Expose port 8080
EXPOSE 8080

# Start Apache and MySQL services
CMD service mysql start && apache2ctl -D FOREGROUND
