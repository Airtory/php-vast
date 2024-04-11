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

namespace Airtory\Vast\Creative;

use Airtory\Vast\ElementBuilder;

abstract class AbstractCompanionAdsCreative extends AbstractCreative
{
    /**
     * @var ElementBuilder
     */
    protected $vastElementBuilder;

    /**
     * not to be confused with an impression, this event indicates that an individual creative
     * portion of the ad was viewed. An impression indicates the first frame of the ad was displayed; however
     * an ad may be composed of multiple creative, or creative that only play on some platforms and not
     * others. This event enables ad servers to track which ad creative are viewed, and therefore, which
     * platforms are more common.
     */
    public const EVENT_TYPE_CREATIVEVIEW = 'creativeView';

    /**
     * Dom Element of <Creative></Creative>
     *
     * @var \DOMElement
     */
    private $companionAdsCreativeDomElement;

    /**
     * @var \DOMElement
     */
    private $trackingEventsDomElement;

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

    /**
     * List of allowed events
     *
     * @return array
     */
    public static function getEventList(): array
    {
        return [
            self::EVENT_TYPE_CREATIVEVIEW,
        ];
    }

    /**
     * Get TrackingEvents DomElement
     *
     * @return \DOMElement
     */
    protected function getTrackingEventsDomElement(): \DOMElement
    {
        // create container
        if ($this->trackingEventsDomElement) {
            return $this->trackingEventsDomElement;
        }
        
        $this->trackingEventsDomElement = $this->companionAdsCreativeDomElement
            ->getElementsByTagName('TrackingEvents')
            ->item(0);

        if ($this->trackingEventsDomElement) {
            return $this->trackingEventsDomElement;
        }
        
        $this->trackingEventsDomElement = $this->companionAdsCreativeDomElement
            ->ownerDocument
            ->createElement('TrackingEvents');

        $this->companionAdsCreativeDomElement
            ->getElementsByTagName('Linear')
            ->item(0)
            ->appendChild($this->trackingEventsDomElement);
        
        return $this->trackingEventsDomElement;
    }

    /**
     * @param string $event
     * @param string $url
     *
     * @return AbstractLinearCreative
     *
     * @throws \Exception
     */
    public function addTrackingEvent(string $event, string $url): self
    {
        if (!in_array($event, $this->getEventList())) {
            throw new \Exception(sprintf('Wrong event "%s" specified', $event));
        }
        
        // create Tracking
        $trackingDomElement = $this->companionAdsCreativeDomElement->ownerDocument->createElement('Tracking');
        $this->getTrackingEventsDomElement()->appendChild($trackingDomElement);
        
        // add event attribute
        $trackingDomElement->setAttribute('event', $event);

        // create cdata
        $cdata = $this->companionAdsCreativeDomElement->ownerDocument->createCDATASection($url);
        $trackingDomElement->appendChild($cdata);

        return $this;
    }

    /**
     * @param string $url
     * @param int|string $offset seconds or time in format "H:m:i" or percents in format "n%"
     *
     * @return AbstractLinearCreative
     */
    public function addProgressTrackingEvent(string $url, $offset): self
    {
        // create Tracking
        $trackingDomElement = $this->companionAdsCreativeDomElement->ownerDocument->createElement('Tracking');
        $this->getTrackingEventsDomElement()->appendChild($trackingDomElement);

        // add event attribute
        $trackingDomElement->setAttribute('event', self::EVENT_TYPE_PROGRESS);

        // add offset attribute
        if (is_numeric($offset)) {
            $offset = $this->secondsToString($offset);
        }
        $trackingDomElement->setAttribute('offset', $offset);

        // create cdata
        $cdata = $this->companionAdsCreativeDomElement->ownerDocument->createCDATASection($url);
        $trackingDomElement->appendChild($cdata);

        return $this;
    }

    /**
     * Convert seconds to H:m:i
     * Hours could be more than 24
     *
     * @param mixed $seconds
     *
     * @return string
     */
    protected function secondsToString($seconds)
    {
        $seconds = (int) $seconds;

        $time = [];

        // get hours
        $hours = floor($seconds / 3600);
        $time[] = str_pad((string)$hours, 2, '0', STR_PAD_LEFT);

        // get minutes
        $seconds = $seconds % 3600;
        $time[] = str_pad((string)floor($seconds / 60), 2, '0', STR_PAD_LEFT);

        // get seconds
        $time[] = str_pad((string)($seconds % 60), 2, '0', STR_PAD_LEFT);

        return implode(':', $time);
    }

    /**
     * Set video click through url
     *
     * @param string $url
     *
     * @return AbstractLinearCreative
     */
    public function setVideoClicksClickThrough(string $url): self
    {
        // create cdata
        $cdata = $this->getDomElement()->ownerDocument->createCDATASection($url);

        // create ClickThrough
        $clickThroughDomElement = $this->getVideoClicksDomElement()->getElementsByTagName('IFrameResource')->item(0);
        if (!$clickThroughDomElement) {
            $clickThroughDomElement = $this->getDomElement()->ownerDocument->createElement('IFrameResource');
            $this->getVideoClicksDomElement()->appendChild($clickThroughDomElement);
        }

        // update CData
        if ($clickThroughDomElement->hasChildNodes()) {
            $clickThroughDomElement->replaceChild($cdata, $clickThroughDomElement->firstChild);
        } else { // insert CData
            $clickThroughDomElement->appendChild($cdata);
        }

        return $this;
    }

    /**
     * Get VideoClicks DomElement
     *
     * @return \DOMElement
     */
    protected function getVideoClicksDomElement(): \DOMElement
    {
        // create container
        if (!empty($this->videoClicksDomElement)) {
            return $this->videoClicksDomElement;
        }
        
        $this->videoClicksDomElement = $this->companionAdsCreativeDomElement->getElementsByTagName('Companion')->item(0);
        if (!empty($this->videoClicksDomElement)) {
            return $this->videoClicksDomElement;
        }
        
        $this->videoClicksDomElement = $this->companionAdsCreativeDomElement->ownerDocument->createElement('Companion');
        $this->companionAdsCreativeDomElement
            ->getElementsByTagName('CompanionAds')
            ->item(0)
            ->appendChild($this->videoClicksDomElement);
        
        return $this->videoClicksDomElement;
    }
}
