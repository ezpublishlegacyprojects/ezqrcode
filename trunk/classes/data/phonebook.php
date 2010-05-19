<?php
/**
 * Definition of a MECARD / Phonebook data structure
 * @see http://www.nttdocomo.co.jp/english/service/imode/make/content/barcode/function/application/addressbook/index.html
 *
 * @property string name Person's name. Can be split as lastname,firstname
 * @property string reading Kana name. Japanese only.
 * @property string|array(string) tel One or more phone numbers
 * @property string|array(string) telav One or more videophone numbers
 * @property string|array(string) email One or more email addresses
 * @property string memo Note
 * @property string birthday Birtyday. Format: YYYYMMDD
 * @property string address Physical address, separated by commas
 * @property string url Website's URL
 * @property string nickname Nickname
 */
class eZQRDataPhonebook extends eZQRData
{
    public function __toString()
    {
        $string = $this->line( "MECARD" );
        $string .= $this->line( 'N',        'name' );
        $string .= $this->line( 'SOUND',    'reading' );
        $string .= $this->line( 'TEL',      'tel' );
        $string .= $this->line( 'TEL-AV',   'telav' );
        $string .= $this->line( 'EMAIL',    'email' );
        $string .= $this->line( 'MEMO',     'memo' );
        $string .= $this->line( 'URL',      'url' );
        $string .= $this->line( 'NICKNAME', 'nickname' );
        $string .= $this->line( 'ADDRESS',  'address' );
        $string .= $this->line();

        return $string;
    }

    private function line( $prefix = null, $property = null )
    {
        if ( $prefix === null && $property !== null )
        {
            throw new ezcBaseValueException( "'property' requires a 'prefix'" );
        }
        if ( $prefix === null )
        {
            return ";";
        }
        if ( $property === null )
        {
            return "{$prefix}:\n";
        }
        if ( !isset( $this->$property ) )
            return "";

        if ( !is_array( $this->$property ) )
            return "{$prefix}:{$this->$property};\n";

        // multiple values
        $string = "";
        foreach( $this->$property as $entry )
        {
            $string .= "{$prefix}:{$entry};\n";
        }
        return $string;
    }

    protected $propertiesList = array(
        'name', 'reading', 'tel', 'telav', 'email', 'memo', 'birthday', 'address', 'url', 'nickname',
    );
}
?>