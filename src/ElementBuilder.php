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

namespace Airtory\Vast;

use Airtory\Vast\Ad\InLine;
use Airtory\Vast\Ad\Wrapper;
use Airtory\Vast\Creative\InLine\Linear as InLineAdLinearCreative;
use Airtory\Vast\Creative\InLine\Linear\InteractiveCreativeFile;
use Airtory\Vast\Creative\InLine\CompanionAds as InLineAdCompanionAdsCreative;
use Airtory\Vast\Creative\Wrapper\Linear as WrapperAdLinearCreative;
use Airtory\Vast\Creative\InLine\Linear\MediaFile;
use Airtory\Vast\Creative\InLine\CompanionAds\Companion;
use Airtory\Vast\Creative\InLine\Linear\ClosedCaptionFile;

/**
 * Builder of VAST document elements, useful for overriding element classes
 */
class ElementBuilder
{
    /**
     * <?xml> with <VAST> inside
     *
     * @param \DomDocument $xmlDocument
     *
     * @return Document
     */
    public function createDocument(\DomDocument $xmlDocument): Document
    {
        return new Document(
            $xmlDocument,
            $this
        );
    }

    /**
     * <Ad> with <InLine> inside
     *
     * @param \DomElement $adElement
     *
     * @return InLine
     */
    public function createInLineAdNode(\DomElement $adElement): InLine
    {
        return new InLine($adElement, $this);
    }

    /**
     * <Ad> with <Wrapper> inside
     *
     * @param \DomElement $adElement
     *
     * @return Wrapper
     */
    public function createWrapperAdNode(\DomElement $adElement): Wrapper
    {
        return new Wrapper($adElement, $this);
    }

    /**
     * <Ad><InLine><Creatives><Creative> with <Linear> inside
     *
     * @param \DOMElement $creativeDomElement
     *
     * @return InLineAdLinearCreative
     */
    public function createInLineAdLinearCreative(\DOMElement $creativeDomElement): InLineAdLinearCreative
    {
        return new InLineAdLinearCreative($creativeDomElement, $this);
    }

    /**
     * <Ad><InLine><Creatives><Creative> with <CompanionAds> inside
     * 
     * @param \DOMElement $creativeDomElement
     * 
     * @return InLineAdCompanionAdsCreative
     */
    public function createInLineAdCompanionAdsCreative(\DOMElement $creativeDomElement): InLineAdCompanionAdsCreative
    {
        return new InLineAdCompanionAdsCreative($creativeDomElement, $this);
    }


    /**
     * <Ad><Wrapper><Creatives><Creative> with <Linear> inside
     *
     * @param \DOMElement $creativeDomElement
     *
     * @return WrapperAdLinearCreative
     */
    public function createWrapperAdLinearCreative(\DOMElement $creativeDomElement): WrapperAdLinearCreative
    {
        return new WrapperAdLinearCreative($creativeDomElement, $this);
    }

    /**
     * <Ad><InLine><Creatives><Creative><Linear><MediaFiles><MediaFile>
     *
     * @param \DOMElement $mediaFileDomElement
     *
     * @return MediaFile
     */
    public function createInLineAdLinearCreativeMediaFile(\DOMElement $mediaFileDomElement): MediaFile
    {
        return new MediaFile($mediaFileDomElement);
    }

    /**
     * <Ad><InLine><Creatives><Creative><CompanionAds><Companion>
     * 
     * @param \DOMElement $companionDomElement
     * 
     * @return Companion
     */
    public function createInLineAdCompanionAdsCreativeCompanion(\DOMElement $companionDomElement): Companion
    {
        return new Companion($companionDomElement);
    }

    /**
     * <Ad><InLine><Creatives><Creative><Linear><MediaFiles><InteractiveCreativeFile>
     *
     * @param \DOMElement $mediaFileDomElement
     *
     * @return InteractiveCreativeFile
     */
    public function createInlineAdLinearCreativeInteractiveCreativeMediaFile(\DOMElement $mediaFileDomElement): InteractiveCreativeFile
    {
        return new InteractiveCreativeFile($mediaFileDomElement);
    }

    /**
     * <Ad><InLine><Creatives><Creative><Linear><MediaFiles><ClosedCaptionFiles><ClosedCaptionFile>
     *
     * @param \DOMElement $mediaFileDomElement
     *
     * @return ClosedCaptionFile
     */
    public function createInLineAdLinearCreativeClosedCaptionFile(\DOMElement $mediaFileDomElement): ClosedCaptionFile
    {
        return new ClosedCaptionFile($mediaFileDomElement);
    }
}
