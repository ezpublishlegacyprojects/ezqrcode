<?php
/**
 * Formats geographical informations from an ezgmaplocation attribute
 *
 * Output format: "geo:lat,lon"
 */
class eZQRDatatypeGmapLocation extends eZQRDatatype
{
    /**
     * Get the mapped data in a QR code compatible format
     * @return string The barcode data, or an empty string
     */
    public function data()
    {
        if ( $this->contentObjectAttribute->hasContent() )
        {
            $content = $this->contentObjectAttribute->content();
            $return = sprintf( 'geo:%s,%s',
                $content->attribute( 'latitude' ), $content->attribute( 'longitude' ) );
        }
        else
        {
            $return = '';
        }

        return $return;
    }
}
?>