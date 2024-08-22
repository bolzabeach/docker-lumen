# Docker + Lumen with Nginx, MySQL, and Memcached

Setting up an entire Lumen stack can be time consuming. This repo is a quick way to write apps in PHP using Lumen from an any Docker client. It uses docker-compose to setup the application services, databases, cache, etc...

## Clone this repo and create app folder

```bash
git clone https://github.com/bolzabeach/docker-lumen.git
cd docker-lumen
mkdir images/php/app
```

## Create Lumen App

Execute this command if you are in Linux terminal

```bash
docker run --rm -it -v $(pwd)/images/php:/app $(docker build -q .) composer create-project --prefer-dist laravel/lumen ./app
```

Execute this command if you are in Windows Powershell

```bash
docker run --rm -it -v "$(pwd)/images/php:/app" $(docker build -q .) composer create-project --prefer-dist laravel/lumen ./app
```

### Build & Run

```bash
docker-compose up --build -d
```

### Stop Everything

```bash
docker-compose down
```

