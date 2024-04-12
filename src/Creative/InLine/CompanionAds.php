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

namespace Airtory\Vast\Creative\InLine;

use Airtory\Vast\Creative\AbstractCompanionAdsCreative;
use Airtory\Vast\Creative\InLine\CompanionAds\Companion;

class CompanionAds extends AbstractCompanionAdsCreative
{
    /**
     * @var \DOMElement
     */
    private $companionDomElement;

    /**
     * @return \DOMElement
     */
    private function getCompanionElement(): \DOMElement
    {
        if (empty($this->companionDomElement)) {
            $this->companionDomElement = $this->getDomElement()->getElementsByTagName('CompanionAds')->item(0);
            if (!$this->companionDomElement) {
                $this->companionDomElement = $this->getDomElement()->ownerDocument->createElement('CompanionAds');
                $this->getDomElement()
                    ->getElementsByTagName('CompanionAds')
                    ->item(0)
                    ->appendChild($this->companionDomElement);
            }
        }

        return $this->companionDomElement;
    }

    /**
     * @return Companion
     */
    public function createCompanion(): Companion
    {
        // get needed DOM element
        $companionDomElement = $this->getCompanionElement();

        // create Companion and append to CompanionAds
        $createElement = $companionDomElement->ownerDocument->createElement('Companion');
        $companionDomElement->appendChild($createElement);

        // object
        return $this->vastElementBuilder->createInLineAdCompanionAdsCreativeCompanion($createElement);
    }

}
