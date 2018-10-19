FROM php:7.1.16-apache
RUN mkdir /app
ADD . /app/
WORKDIR /app

CMD ["php","-S","0.0.0.0:5000"]
