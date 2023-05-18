# RAINBOW6-CASTER-DASHBOARD

[Repository on Github](https://github.com/ReVolTPFE/rainbow6-caster-dashboard/)

---

## Table of contents

* [About the project](#markdown-header-about-the-project)
    * [Contributors](#markdown-header-contributors)
    * [Environments](#markdown-header-environments)
* [Getting started](#markdown-header-getting-started)
    * [Prerequisites](#markdown-header-prerequisites)
    * [Installation](#markdown-header-installation)
    * [Credentials](#markdown-header-credentials)
* [Production](#markdown-header-test-and-deploy)
    * [Production setup](#markdown-header-production-setup) 
* [Test and deploy](#markdown-header-test-and-deploy)
    * [Deploy method](#markdown-header-deploy-method)  
* [Frequently asked questions](#markdown-header-frequently-asked-questions)

---

## About the project

This project contains a Symfony API, a NextJS website interface and a websocket server.
The Symfony API is used to manage the data of the website and the NextJS website is used to display the data. We use the websocket server to send the data to the website in real time.

The goal of the project is to create a dashboard for Rainbow6 casters to display the data of the match they are casting.

Summary of the project features :
- Display the matchs, teams, maps, rounds data
- Enable the casters to change the data in real time
- Add OBS overlays to display the data in a live stream (Twitch, Youtube...)

Everything in the project is managed with Docker.

- Git
- Docker
- NextJS `13.4.2`
- Symfony `6.2`
- Status `DEV` / `TEST` / `PROD`

### Contributors

* Developers : Arnaud Steiner
* Designer : Arnaud Steiner
* Project manager : Arnaud Steiner
* Marketing : xxxx XXXX
* Commercial : xxxx XXXX

### Environments

* Preproduction :  https://example.com/
* Production : https://example.com/

---

## Getting started

### Prerequisites

The complete application is fragmented in Docker containers. Everything is setup in the project root in the `docker-compose.yml` file. You will also need Git in order to clone the repository.

* [Download Git](https://git-scm.com/downloads)
* [Download Docker](https://docs.docker.com/get-docker/)

### Installation

To install the complete application in this repository, you will have to execute these steps in a command line interface :

1. Clone the repository
```sh
git@github.com:ReVolTPFE/rainbow6-caster-dashboard.git
```

2. Navigate in the project root
```sh
cd rainbow6-caster-dashboard
```

3. Launch the app
```sh
docker-compose up --build
```

The different services are accessible from the following URLs:

- Symfony API : [http://localhost:8080](http://localhost:8080)
- MySQL interface : [http://localhost:8000](http://localhost:8000)
- NextJS website : [http://localhost:3000](http://localhost:3000)

### Credentials

All the credentials of the differents applications are available in the environment files and variables.

---

## Production

### Production setup

TBD

---

## Test and deploy

### Deploy method

TBD

---

## Frequently asked questions

##### Question 1
* Answer 1

##### Question 2
* Answer 2
