<?php
/**
 * Base struct that represents a QR data set.
 *
 * Actual data is set using basic PHP setters (and getters of course).
 * Formatting the output data is done using __toString(), which must of course be implemented.
 *
 * Valid properties must be added to eZQRData::$propertiesList
 */
abstract class eZQRData
{
    public function __set( $name, $value )
    {
        if ( !in_array( $name, $this->propertiesList ) )
            throw new ezcBasePropertyNotFoundException( $name );
        $this->properties[$name] = $value;
    }

    public function __get( $name )
    {
        if ( !in_array( $name, $this->propertiesList ) )
            throw new ezcBasePropertyNotFoundException( $name );
        elseif ( !isset( $this->properties[$name] ) )
            return null;
        return $this->properties[$name];
    }

    public function __isset( $name )
    {
        if ( !in_array( $name, $this->propertiesList ) )
            throw new ezcBasePropertyNotFoundException( $name );
        return isset( $this->properties[$name] );
    }

    abstract public function __toString();

    protected $properties = array();
    protected $propertiesList = array();
}
?>