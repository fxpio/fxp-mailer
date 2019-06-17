Fxp Mailer
==========

[![Latest Version](https://img.shields.io/packagist/v/fxp/mailer.svg)](https://packagist.org/packages/fxp/mailer)
[![Build Status](https://img.shields.io/travis/fxpio/fxp-mailer/master.svg)](https://travis-ci.org/fxpio/fxp-mailer)
[![Coverage Status](https://img.shields.io/coveralls/fxpio/fxp-mailer/master.svg)](https://coveralls.io/r/fxpio/fxp-mailer?branch=master)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/fxpio/fxp-mailer/master.svg)](https://scrutinizer-ci.com/g/fxpio/fxp-mailer?branch=master)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/f644cbc7-5481-49b5-aaab-6b09a0d6973a.svg)](https://insight.sensiolabs.com/projects/f644cbc7-5481-49b5-aaab-6b09a0d6973a)

The Fxp Mailer is a manager to render and send an mail template with different
transporter (email, sms, etc...).

Features include:

- Available transporters:
  - Email with [Symfony Mailer](https://symfony.com/doc/current/mailer.html)
- Twig loaders to retrieve automatically the localized templates with a fallback behavior:
  - Filesystem
  - Doctrine (optional)
- Secure the rendering for the message templates of users by activating simply the Twig Sandbox
  (only available tags, functions, etc. can be used, and templates loaded only from Doctrine)
- Disable automatically the Twig option `strict variables` for the messages rendering
- Build your custom transporters and messages with [Symfony Mime](https://symfony.com/doc/current/components/mime.html)
- Creation of template layout using the `embed` Twig tag in template message
- Direct use of transporters keeping the functionality of this component
- Template Message repository is compatible with the [Doctrine Extensions Translatable](https://github.com/Atlantic18/DoctrineExtensions)

Documentation
-------------

The bulk of the documentation is stored in the `Resources/doc/index.md`
file in this library:

[Read the Documentation](Resources/doc/index.md)

Installation
------------

All the installation instructions are located in [documentation](Resources/doc/index.md).

License
-------

This library is under the MIT license. See the complete license in the library:

[LICENSE](LICENSE)

About
-----

Fxp Mailer is a [François Pluchino](https://github.com/francoispluchino) initiative.
See also the list of [contributors](https://github.com/fxpio/fxp-mailer/graphs/contributors).

Reporting an issue or a feature request
---------------------------------------

Issues and feature requests are tracked in the [Github issue tracker](https://github.com/fxpio/fxp-mailer/issues).
