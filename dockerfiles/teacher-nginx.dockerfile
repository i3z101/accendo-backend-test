FROM nginx:stable-alpine

WORKDIR /etc/nginx/conf.d

COPY nginx/teacher-nginx.conf .

RUN mv teacher-nginx.conf default.conf

WORKDIR /var/www/html

COPY . .