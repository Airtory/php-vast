<?php
declare(strict_types=1);

/**
 * This file is part of the PHP-VAST package.
 *
 * (c) Dmytro Sokil <dmytro.sokil@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Airtory\Vast\Ad;

use Airtory\Vast\Creative\AbstractCreative;
use Airtory\Vast\Creative\InLine\Linear as InLineAdLinearCreative;
use Airtory\Vast\Creative\InLine\CompanionAds as InLineAdCompanionAdsCreative;

class InLine extends AbstractAdNode
{
    /**
     * @public
     */
    const TAG_NAME = 'InLine';

    /**
     * @private
     */
    const CREATIVE_TYPE_LINEAR = 'Linear';
    const CREATIVE_TYPE_COMPANIONADS = 'CompanionAds';

    /**
     * @return string
     */
    public function getAdSubElementTagName(): string
    {
        return self::TAG_NAME;
    }

    /**
     * Set Ad title
     *
     * @param string $value
     *
     * @return InLine
     */
    public function setAdTitle(string $value): self
    {
        $this->setScalarNodeCdata('AdTitle', $value);

        return $this;
    }

    /**
     * Set Ad serving ID
     *
     * @param string $value
     *
     * @return InLine
     */
    public function setAdServingId(string $value): self
    {
        $this->setScalarNodeCdata('AdServingId', $value);

        return $this;
    }

    /**
     * Set description
     *
     * @param string $value
     *
     * @return InLine
     */
    public function setDescription(string $value): self
    {
        $this->setScalarNodeCdata('Description', $value);

        return $this;
    }

    /**
     * @return string[]
     */
    protected function getAvailableCreativeTypes(): array
    {
        return [
            self::CREATIVE_TYPE_LINEAR,
            self::CREATIVE_TYPE_COMPANIONADS,
        ];
    }

    /**
     * @param string $type
     * @param \DOMElement $creativeDomElement
     *
     * @return AbstractCreative|InLineAdLinearCreative
     */
    protected function buildCreativeElement(string $type, \DOMElement $creativeDomElement): AbstractCreative
    {
        switch ($type) {
            case self::CREATIVE_TYPE_LINEAR:
                $creative = $this->vastElementBuilder->createInLineAdLinearCreative($creativeDomElement);
                break;
            case self::CREATIVE_TYPE_COMPANIONADS:
                $creative = $this->vastElementBuilder->createInLineAdCompanionAdsCreative($creativeDomElement);
                break;
            default:
                throw new \RuntimeException(sprintf('Unknown Wrapper creative type %s', $type));
        }

        return $creative;
    }

    /**
     * Create Linear creative
     *
     * @throws \Exception
     *
     * @return InLineAdLinearCreative
     */
    public function createLinearCreative(): InLineAdLinearCreative
    {
        /** @var InLineAdLinearCreative $creative */
        $creative = $this->buildCreative(self::CREATIVE_TYPE_LINEAR);

        return $creative;
    }


    /**
     * Create CompanionAds creative
     * 
     * @throws \Exception
     * 
     * @return InLineAdCompanionAdsCreative
     */
    public function createCompanionAdsCreative(): InLineAdCompanionAdsCreative
    {
        /** @var InLineAdCompanionAdsCreative $creative */
        $creative = $this->buildCreative(self::CREATIVE_TYPE_COMPANIONADS);

        return $creative;
    }
}
