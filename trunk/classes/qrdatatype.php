<?php
/**
 * Abstract class for datatype handlers
 */
abstract class eZQRDatatype
{
    /**
     * Mapped content object attribute
     * @var eZContentObjectAttribute
     */
    protected $contentObjectAttribute;

    /**
     * Constructor. Requires the mapped content object attribute
     * @param eZContentObjectAttribute $contentObjectAttribute
     */
    public function __construct( eZContentObjectAttribute $contentObjectAttribute )
    {
        $this->contentObjectAttribute = $contentObjectAttribute;
    }

    /**
     * Get the mapped data in a QR code compatible format
     * @return string The barcode data, or an empty string
     */
    abstract public function data();
}
?>