<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Mailer\Filter\Template;

use Fxp\Component\Mailer\Filter\TemplateFilterInterface;
use Fxp\Component\Mailer\MailRenderedInterface;
use Fxp\Component\Mailer\MailTypes;
use Fxp\Component\Mailer\Util\MailUtil;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

/**
 * Filter for convert the inline CSS to inline styles.
 *
 * @author François Pluchino <francois.pluchino@gmail.com>
 */
class CssToStylesFilter implements TemplateFilterInterface
{
    /**
     * {@inheritdoc}
     */
    public function filter(MailRenderedInterface $mailRendered)
    {
        $cssToInlineStyles = new CssToInlineStyles();

        $mailRendered->setHtmlBody($cssToInlineStyles->convert($mailRendered->getHtmlBody()));
    }

    /**
     * {@inheritdoc}
     */
    public function supports(MailRenderedInterface $mailRendered)
    {
        $validTypes = MailUtil::getValidTypes($mailRendered->getTemplate()->getType());

        return in_array(MailTypes::TYPE_SCREEN, $validTypes);
    }
}
