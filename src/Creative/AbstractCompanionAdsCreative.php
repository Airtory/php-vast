<?php
declare(strict_types=1);

/**
 * This file is part of the PHP-VAST package.
 *
 * (c) Arshad <arshad@bpract.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Airtory\Vast\Creative;

use Airtory\Vast\ElementBuilder;

abstract class AbstractCompanionAdsCreative extends AbstractCreative
{
    /**
     * @var ElementBuilder
     */
    protected $vastElementBuilder;

    /**
     * Dom Element of <Creative></Creative>
     *
     * @var \DOMElement
     */
    private $companionAdsCreativeDomElement;

    /**
     * @param \DOMElement $companionAdsCreativeDomElement
     * @param ElementBuilder $vastElementBuilder
     */
    public function __construct(\DOMElement $companionAdsCreativeDomElement, ElementBuilder $vastElementBuilder)
    {
        $this->companionAdsCreativeDomElement = $companionAdsCreativeDomElement;
        $this->vastElementBuilder = $vastElementBuilder;
    }

    /**
     * Dom Element of <Creative></Creative>
     *
     * @return \DOMElement
     */
    protected function getDomElement(): \DOMElement
    {
        return $this->companionAdsCreativeDomElement;
    }
}
