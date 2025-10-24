<!-- Improved compatibility of back to top link: See: https://github.com/othneildrew/Best-README-Template/pull/73 -->

<a name="readme-top"></a>

<!--
*** Thanks for checking out the Best-README-Template. If you have a suggestion
*** that would make this better, please fork the repo and create a pull request
*** or simply open an issue with the tag "enhancement".
*** Don't forget to give the project a star!
*** Thanks again! Now go create something AMAZING! :D
-->

<!-- PROJECT SHIELDS -->
<!--
*** I'm using markdown "reference style" links for readability.
*** Reference links are enclosed in brackets [ ] instead of parentheses ( ).
*** See the bottom of this document for the declaration of the reference variables
*** for contributors-url, forks-url, etc. This is an optional, concise syntax you may use.
*** https://www.markdownguide.org/basic-syntax/#reference-style-links
-->

![](https://img.shields.io/static/v1?label=STATUS&message=DEVELOPING&color=GREEN&style=for-the-badge)
[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]

<!-- [![MIT License][license-shield]][license-url] -->

[![LinkedIn][linkedin-shield]][linkedin-url]

<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/henriqk0/personal-library-manager">
    <img src="read.png" alt="Logo" height="80">
  </a>

<h3 align="center">MaxRead</h3>

  <p align="center">
    Management and analysis of your reading productivity
    <br />
    <a href="https://github.com/henriqk0/personal-library-manager"><strong>Explore the docs »</strong></a>
    <br />
    <br />
    <a href="https://github.com/henriqk0/personal-library-manager">View Demo</a>
    ·
    <a href="mailto:henriquedeslima2811@gmail.com?subject=BugReport">Report Bug</a>
    ·
    <a href="mailto:henriquedeslima2811@gmail.com?subject=RequestFeature">Request Feature</a>
  </p>
</div>

<!-- TABLE OF CONTENTS -->
<details>
  <summary>Summary:</summary>
  <ol>
    <li>
      <a href="#about-the-project">About the Project</a>
      <ul>
        <li><a href="#built-with">Built with</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Starting</a>
      <ul>
        <li><a href="#prerequisites">Pre requisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <!-- <li><a href="#license">License</a></li> -->
    <li><a href="#contact">Contact</a></li>
  </ol>
</details>

<!-- ABOUT THE PROJECT -->

## About the Project

[![SymfonyMaxRead][product-screenshot]]()

In this project, i develop a web system to manager the read to the users, using MVC Symfony Pattern as Code Architeture and Voter to security with personal data. The user can filter their last productivity in a dashboard screen.

At moment, the application only can be accessed locally.

### Built with

- [![Symfony][Symfony.js]][Symfony-url]
- [![Docker][Docker.js]][Docker-url]
- [![PostgreSQL][PostgreSQL.js]][PostgreSQL-url]
- [![JavaScript][JavaScript.js]][JavaScript-url]
- [![HTML][HTML.js]][HTML-url]
- [![CSS3][CSS3.js]][CSS3-url]

<!-- GETTING STARTED -->

## Getting Started

To execute the local version, assert that

### Pre requisites:

- Have PHP, Composer and Symfony installed
- Docker: If you want to use an image as database.
- Clone this repository.
- Create a .env.local with your `DATABASE_URL` inside the cloned repository

### Configurating:

2. With your Database Started, run, in the cloned repository: symfony server:start
3. At `localhost:8000`, which is where the application is located, you will be redirected to a login screen. Enter your username and password. If it doesn't exist, click to register and register with email and password before that. Register your current readings. If the book does not exist, register your writer and, providing the full name of the book and its number of pages, go to the 'readi' section

<!-- USAGE EXAMPLES -->

## Usage

This system provides an intuitive web interface to manage information related to your readings. After launching the application, you can access it using a web browser and start using the available features.

<!--

## Roadmap

- [ ] Feature 1
- [ ] Feature 2
- [ ] Feature 3
    - [ ] Nested Feature

-->

<!-- CONTRIBUTING -->

## Contributing

Contributions are what make the open source community such an incredible place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that could improve this, please fork the repository and create a pull request. You can also simply open an issue with the "improvement" tag.
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add AmazingFeature'`)
4. Push to Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<!-- LICENSE -->
<!-- ## License

Distributed under the Apache 2.0 License. See `LICENSE` for more information. -->

<!-- CONTACT -->

## Contact

Me: [linkedin-url]

Project: [github.com/henriqk0/personal-library-manager](https://github.com/henriqk0/personal-library-manager/tree/main)

<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->

[Symfony-url]: https://symfony.com
[Symfony.js]: https://img.shields.io/badge/Symfony-black?logo=symfony
[PostgreSQL-url]: https://www.postgresql.org/
[CSS3-url]: https://developer.mozilla.org/docs/Web/CSS
[CSS3.js]: https://img.shields.io/static/v1?style=for-the-badge&message=CSS3&color=264DE4&logo=css3&logoColor=FFFFFF&label=
[HTML-url]: https://developer.mozilla.org/en-US/docs/Web/HTML
[HTML.js]: https://img.shields.io/static/v1?style=for-the-badge&message=HTML&color=E34F26&logo=HTML5&logoColor=FFFFFF&label=
[JavaScript-url]: https://developer.mozilla.org/en-US/docs/Web/JavaScript
[JavaScript.js]: https://img.shields.io/static/v1?style=for-the-badge&message=JavaScript&color=F7DF1E&logo=JavaScript&logoColor=FFFFFF&label=
[PostgreSQL.js]: https://img.shields.io/static/v1?style=for-the-badge&message=PostgreSQL&color=336791&logo=PostgreSQL&logoColor=FFFFFF&label=
[Docker-url]: https://www.docker.com/
[Docker.js]: https://img.shields.io/static/v1?style=for-the-badge&message=Docker&color=2496ED&logo=Docker&logoColor=FFFFFF&label=
[contributors-shield]: https://img.shields.io/github/contributors/henriqk0/personal-library-manager.svg?style=for-the-badge
[contributors-url]: https://github.com/henriqk0/personal-library-manager/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/henriqk0/personal-library-manager.svg?style=for-the-badge
[forks-url]: https://github.com/henriqk0/personal-library-manager/network/members
[stars-shield]: https://img.shields.io/github/stars/henriqk0/personal-library-manager.svg?style=for-the-badge
[stars-url]: https://github.com/henriqk0/personal-library-manager/stargazers
[issues-shield]: https://img.shields.io/github/issues/henriqk0/personal-library-manager.svg?style=for-the-badge
[issues-url]: https://github.com/henriqk0/personal-library-manager/issues

<!-- [license-shield]: https://img.shields.io/github/license/henriqk0/personal-library-manager.svg?style=for-the-badge
[license-url]: https://github.com/henriqk0/personal-library-manager/blob/main/LICENSE -->

[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://www.linkedin.com/in/henriqdeslima/
[product-screenshot]: https://github.com/henriqk0/personal-library-manager/blob/main/2readme/image.js
