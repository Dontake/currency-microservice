<?php

declare(strict_types=1);

namespace App\External\Services\Storage\Xml;

use DOMDocument;
use DOMElement;
use DOMException;

class XmlService
{
    private const VERSION = '1.0';
    private const ENCODING = 'utf-8';

    protected domDocument $xmlDoc;

    /**
     * @throws DOMException
     */
    public function __construct(
        public string $root,
        public array $data
    ) {
        $this->xmlDoc = new domDocument(self::VERSION, self::ENCODING);
        $this->xmlDoc->appendChild($this->createDOM($data, $root));
    }

    public function getXmlDoc(): false|string
    {
        return $this->xmlDoc->saveXML();
    }

    /**
     * @throws DOMException
     */
    protected function createDOM(mixed $data, string $localName): DOMElement
    {
        if (!is_array($data)) {
            return $this->xmlDoc->createElement($localName, (string)$data);
        }

        $item = $this->xmlDoc->createElement($localName);

        foreach ($data as $key => $value) {
            if ($key === 'attributes' && is_array($value)) {
                $this->setAttribute($item, $value);

                continue;
            }

            if (!is_numeric($key)) {
                $item->appendChild($this->createDOM($value, $key !== $localName ? $key : null));
            }
        }

        return $item;
    }

    protected function setAttribute(DOMElement $element, array $attribute): DOMElement
    {
        foreach ($attribute as $attrName => $attrValue) {
            $element->setAttribute($attrName, $attrValue);
        }

        return $element;
    }
}
