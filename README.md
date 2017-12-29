Fxp Mailer
==========

[![Latest Version](https://img.shields.io/packagist/v/fxp/mailer.svg)](https://packagist.org/packages/fxp/mailer)
[![Build Status](https://img.shields.io/travis/fxpio/fxp-mailer/master.svg)](https://travis-ci.org/fxpio/fxp-mailer)
[![Coverage Status](https://img.shields.io/coveralls/fxpio/fxp-mailer/master.svg)](https://coveralls.io/r/fxpio/fxp-mailer?branch=master)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/fxpio/fxp-mailer/master.svg)](https://scrutinizer-ci.com/g/fxpio/fxp-mailer?branch=master)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/f644cbc7-5481-49b5-aaab-6b09a0d6973a.svg)](https://insight.sensiolabs.com/projects/f644cbc7-5481-49b5-aaab-6b09a0d6973a)

The Fxp Mailer is a manager for render and send an mail template with different
transport (email, mail, fax, ...).

Features include:

- Stored the templates in:
  - filesystem with twig format
  - filesystem with yaml format
  - app config
  - database with doctrine (optional)
- Compatible with the localization
- Allow to use the Symfony translator with the translation domain
- Use twig for rendered the mail and layout templates
- Send your email with SwiftMailer
- Template filters:
  - Inline CSS to inline styles (`css_to_styles`) with [CssToInlineStyles](https://github.com/tijsverkoyen/CssToInlineStyles)
- SwiftMailer plugins:
  - Embed link images in email
  - DKIM signer
- Add your event listeners for:
  - template pre render
  - template post render
  - transport pre send
  - transport post send
- Register your filters for:
  - template mail
  - transport
- Build your custom loaders for:
  - template mails
  - template layouts
- Build your custom transports
- Twig function for use this templater with existing templates defined in twig files of already existing systems

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
