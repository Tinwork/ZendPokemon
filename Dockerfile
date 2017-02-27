# Image base
FROM ubuntu:14.04
# Author
MAINTAINER Didier Youn <didier.youn@gmail.com>
# Update & install package
RUN apt-get update \
    && apt-get install -y software-properties-common \
    && apt-add-repository -y ppa:nginx/stable \
    && apt-get update \
    && apt-get install -y nginx \
    && apt-get install -y curl \
    && apt-get install -y nano \
    && rm -rf /var/lib/apt/lists/*
# Change nginx configurations 
ADD docker/nginx/conf/nginx.conf /etc/nginx/nginx.conf
ADD docker/nginx/conf/conf.d/default.conf /etc/nginx/conf.d/default.conf
# Workdir 
ADD app/ /data/www
# Delete nginx folder (unused)
RUN rm /etc/nginx/sites-enabled/default
# Create symlink for nginx logs
RUN ln -sf /dev/stdout /var/log/nginx/access.log \
    && ln -sf /dev/stderr /var/log/nginx/error.log 
# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --filename=composer --install-dir=/bin
ENV PATH /root/.composer/vendor/bin:$PATH
# Work directory
WORKDIR /data/www
# Expose ports
EXPOSE 80 443
# Run nginx
CMD ["nginx", "-g", "daemon off;"]