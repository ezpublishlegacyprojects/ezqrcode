<?php
/**
 * QRCode encoder based on the google charts API.
 * @see doc/google_charts_api_qrcode_specifications.txt
 * @see http://code.google.com/apis/chart/docs/gallery/qr_codes.html
 *
 * @property string data Required.
 * @property size Either a width/height array, or a WIDTHxHEIGHT string. Required.
 * @property string encoding Howw to encode data in the chart. Values: UTF-8 (default), Shift_JIS or ISO-8859-1
 * @property string error_correction_level L (default, M, Q or H)
 * @property int margin Margin rows (not pixels). Default = 4. Optional.
 * @property-read string size_string string value for the size, as <width>x<height>
 */
class eZQRCode
{
    public function __construct()
    {

    }

    public function __set( $property, $value )
    {
        switch( $property )
        {
            case 'data':
                $this->properties[$property] = $value;
                break;

            case 'size':
                if ( is_array( $value ) )
                {
                    if ( count( $value ) != 2 || !is_numeric( $value[0] ) || !is_numeric( $value[1] ) )
                    {
                        throw new ezcBaseValueException( $property, $value, 'array( (int)width, (int)height )' );
                    }
                    else
                    {
                        $this->properties[$property] = $value;
                    }
                }
                else
                {
                    if ( !preg_match( '/^([0-9]+)x([0-9]+)$/', $value, $matches ) )
                    {
                        throw new ezcBaseValueException( $property, $value, '<width>x<height> )' );
                    }
                    else
                    {
                        $this->properties[$property] = array( $matches[1], $matches[2] );
                    }
                }
                break;

            case 'error_correction_level':
                if  ( strlen( $value ) != 1 || strstr( 'LMQH', $value ) === false )
                {
                    throw new ezcBaseValueException( $property, $value, 'L, M, Q or H' );
                }
                else
                {
                    $this->properties[$property] = $value;
                }
                break;

            case 'margin':
                if  ( !is_numeric( $value ) )
                {
                    throw new ezcBaseValueException( $property, $value, 'integer' );
                }
                else
                {
                    $this->properties[$property] = $value;
                }
                break;

            case 'encoding':
                if  ( !is_string( $value ) )
                {
                    throw new ezcBaseValueException( $property, $value, 'string' );
                }
                elseif ( !in_array( $value, array( 'UTF-8', 'Shift_JIS', 'ISO-8859-1' ) ) )
                {
                    throw new ezcBaseValueException( $property, $value, 'string( UTF-8, Shift_JIS, ISO-8859-1)' );
                }
                else
                {
                    $this->properties[$property] = $value;
                }
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $property );
        }
    }

    public function __get( $property )
    {
        switch( $property )
        {
            case 'data':
            case 'size':
            case 'margin':
            case 'error_correction_level':
            case 'encoding':
                return $this->properties[$property];
                break;
            case 'size_string':
                if ( !isset( $this->size ) )
                    return '';
                else
                    return "{$this->size[0]}x{$this->size[1]}";

            default:
                throw new ezcBasePropertyNotFoundException( $property );
        }
    }

    public function __isset( $property )
    {
        return isset( $this->properties[$property] );
    }

    public function getChartURI()
    {
        if ( !isset( $this->data ) )
            throw new ezcBaseValueException( 'data', 'none', 'data' );
        if ( !isset( $this->size ) )
            throw new ezcBaseValueException( 'size', 'none', 'size' );
        $baseURI = 'http://chart.apis.google.com/chart?cht=qr&';

        $URIParameters[] = "chs={$this->size_string}";
        $URIParameters[] = 'chl=' . urlencode( $this->data );

        if ( isset( $this->encoding ) )
            $URIParameters[] = 'choe=' . urlencode( $this->encoding );

        if ( isset( $this->error_correction_level ) || isset( $this->margin ) )
        {
            $URIParameters[] = 'chld=' .
                isset( $this->error_correction_level ) ? $this->error_correction_level : self::DefaultErrorCorrectionLevel .
                '|' .
                isset( $this->margin ) ? $this->margin : self::DefaultMargin;
        }
        $uri = $baseURI . implode( '&', $URIParameters );
        return $uri;
    }

    private $properties = array();
    const DefaultErrorCorrectionLevel = 'L';
    const DefaultMargin = 4;
}
?>