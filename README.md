<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px" alt="Yii2">
    </a>
    &nbsp;
    <a href="https://oauth.net/2/" target="_blank">
        <img src="https://oauth.net/images/oauth-2-sm.png" height="90px" alt="Oauth 2">
    </a>
    &nbsp;&nbsp;&nbsp;
    <a href="https://openid.net/" target="_blank">
        <img src="https://openid.net/images/logo/openid-icon-250x250.png" height="90px" alt="OpenID Connect">
    </a>
    <h1 align="center">Oauth2 + OpenID Connect Extension for Yii 2</h1>
    <br>
</p>

[![Latest Stable Version](https://img.shields.io/packagist/v/rhertogh/yii2-oauth2-server.svg)](https://packagist.org/packages/rhertogh/yii2-oauth2-server)
[![build Status](https://github.com/rhertogh/yii2-oauth2-server/actions/workflows/build.yml/badge.svg)](https://github.com/rhertogh/yii2-oauth2-server/actions/workflows/build.yml)
[![Code Coverage](https://scrutinizer-ci.com/g/rhertogh/yii2-oauth2-server/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/rhertogh/yii2-oauth2-server/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rhertogh/yii2-oauth2-server/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/rhertogh/yii2-oauth2-server/?branch=master)
[![GitHub](https://img.shields.io/github/license/rhertogh/yii2-oauth2-server)](https://github.com/rhertogh/yii2-oauth2-server/blob/master/LICENSE.md)

The Yii2-Oauth2-Server is an extension for [Yii framework 2.0](http://www.yiiframework.com) applications and provides 
an [Oauth2](https://oauth.net/2/) server based on the [League OAuth2 server](https://github.com/thephpleague/oauth2-server).
The server also supports [OpenID Connect Core](https://openid.net/specs/openid-connect-core-1_0.html).

For license information please check the [LICENSE](LICENSE.md)-file.

Documentation is at [docs/guide/README.md](docs/guide/README.md).

If you're not yet familiar with Oauth 2 check out [An Illustrated Guide to OAuth and OpenID Connect](
https://developer.okta.com/blog/2019/10/21/illustrated-guide-to-oauth-and-oidc)


Installation
------------
* The minimum required PHP version is 7.4 (compatibility tested up till and including PHP 8.1).
* The minimum required Yii version is 2.0.43.

```bash
composer install rhertogh/yii2-oauth2-server
```

Full installation details can be found in the docs under [Installing the Yii2-Oauth2-Server](docs/guide/start-installation.md)


Documentation
-------------
There are two main sections in the documentation
* [Usage Guide](docs/guide/README.md) for using the Yii2-Oauth2-Server in your own project.
* [Development Guide](docs/internals/README.md) for contributing to the Yii2-Oauth2-Server.


Contributing
------------
The Yii2-Oauth2-Server is [Open Source](LICENSE.md). You can help by:

- [Report an issue](docs/internals/report-an-issue.md)
- [Contribute with new features or bug fixes](docs/internals/pull-request-qa.md)


Reporting Security issues
-------------------------
In case you found a security issue please [contact us directly](
https://forms.gle/8aEGxmN51Hvb7oLJ7)
DO NOT use the issue tracker or discuss it in the public forum as it will cause more damage than help.


Versioning & Change Log
-----------------------
The Yii2-Oauth2-Server follows [Semantic Versioning 2.0](https://semver.org/spec/v2.0.0.html)  
Please see the [Change Log](CHANGELOG.md) for more information on version history 
and the [Upgrading Instructions](UPGRADE.md) when upgrading to a newer version.

Directory Structure
-------------------
```
docker/     Docker container definition
docs/       Documentation (for both usage and development)
sample/     Sample app for the server
src/        Yii2-Oauth2-Server source
tests/      Codeception unit and functional tests
```


Credits
-------
- [Rutger Hertogh](https://github.com/rhertogh)
- [All Contributors](https://github.com/rhertogh/yii2-oauth2-server/graphs/contributors)


License
-------
The Yii2-Oauth2-Server is free software. It is released under the terms of the Apache License.
Please see [`LICENSE.md`](LICENSE.md) for more information.
