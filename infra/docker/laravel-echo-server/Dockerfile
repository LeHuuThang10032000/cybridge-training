FROM node:20.3.1-alpine

WORKDIR /app

COPY ./infra/docker/laravel-echo-server/echo.json /app/echo.json
COPY ./infra/docker/laravel-echo-server/laravel-echo-server.json /app/laravel-echo-server.json

RUN npm install -g pm2 laravel-echo-server

EXPOSE 6001

CMD ["pm2-runtime", "echo.json"]
