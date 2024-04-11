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

namespace Airtory\Vast\Creative\InLine\CompanionAds;

class Companion
{
    /**
     * @var \DomElement
     */
    private $domElement;

    /**
     * @param \DomElement $domElement
     */
    public function __construct(\DomElement $domElement)
    {
        $this->domElement = $domElement;
    }


    /**
     * The native width of the video file, in pixels. (0 for audio ads)
     *
     * @param int $width
     *
     * @return Companion
     */
    public function setWidth(int $width): self
    {
        $this->domElement->setAttribute('width', (string)$width);

        return $this;
    }

    /**
     * The native height of the video file, in pixels. (0 for audio ads)
     *
     
     * @param int $height
     *
     * @return Companion
     */
    public function setHeight(int $height): self
    {
        $this->domElement->setAttribute('height', (string)$height);

        return $this;
    }


    // /**
    //  * Add Error tracking url.
    //  * Allowed multiple error elements.
    //  *
    //  * @param string $url
    //  *
    //  * @return AbstractAdNode
    //  */
    // public function addIFrameResource(string $url): self
    // {
        
    //     // create cdata
    //     $cdata = $this->getDomElement()->ownerDocument->createCDATASection($url);
    //     dd($cdata);
    //     $clickTrackingDomElement->appendChild($cdata);

    //     return $this;
    // }

    /**
     * Set file URL
     *
     * @param string $url URL of the file
     */
    public function setUrl(string $url): self
    {
        $cdata = $this->domElement->ownerDocument->createCDATASection($url);

        // update CData
        if ($this->domElement->hasChildNodes()) {
            $this->domElement->replaceChild($cdata, $this->domElement->firstChild);
        } // insert CData
        else {
            $this->domElement->appendChild($cdata);
        }
        return $this;
    }
}
