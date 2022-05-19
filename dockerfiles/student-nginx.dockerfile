FROM nginx:stable-alpine

WORKDIR /etc/nginx/conf.d

COPY nginx/student-nginx.conf .

RUN mv student-nginx.conf default.conf

WORKDIR /var/www/html

COPY . .