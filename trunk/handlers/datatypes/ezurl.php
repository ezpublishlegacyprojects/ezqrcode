<?php
/**
 * QR Datatype handler for the ezurl datatype
 *
 * Supports two implementations, configured using URLDatatypeSettings.Handling
 * - standard
 *   the raw URL is returned
 * - MEBKM
 *   a rich structure, based on MEBMK specifications by DOCOMO. Adds support for title + URL
 *   http://www.nttdocomo.co.jp/english/service/imode/make/content/barcode/function/application/bookmark/index.html
 **/
class eZQRDatatypeURL extends eZQRDatatype
{
    public function data()
    {
        $url = $this->contentObjectAttribute->attribute( 'content' );

        $ini = eZINI::instance( 'qrcode.ini' );
        $handling = $ini->hasVariable( 'URLDatatypeSettings', 'Handling' ) ? $ini->variable( 'URLDatatypeSettings', 'Handling' ) : 'standard';
        eZDebug::writeDebug( "handling: $handling", __METHOD__ );
        switch ( $handling )
        {
            case 'standard':
                $return = $url;
                break;

            case 'MEBKM':
                $title = $this->contentObjectAttribute->attribute( 'data_text' );
                $return = <<< EOF
MEBKM:
TITLE:$title;
URL:$url;
;
EOF;
                break;

            default:
                eZDebug::writeDebug( "Unknown handling setting for the ezurl handler", __METHOD__ );
                return '';
        }

        return $return;
    }
}
?>