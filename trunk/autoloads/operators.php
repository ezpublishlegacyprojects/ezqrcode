<?php
class eZQRCodeOperators
{
    function eZQRCodeOperators()
    {
        $this->Operators = array( 'qrcode' );
    }

    function &operatorList()
    {
        return $this->Operators;
    }

    function namedParameterPerOperator()
    {
        return true;
    }

    function namedParameterList()
    {
        return array( 'qrcode' => array( 'size' => array( 'type' => 'mixed',
                                                          'required' => true ) ) );
    }

    function modify( $tpl, $operatorName, $operatorParameters, $rootNamespace,
                     $currentNamespace, &$operatorValue, $namedParameters, $placement )
    {
        switch ( $operatorName )
        {
            case 'qrcode':
            {
                $operatorValue = $this->getQRCode( $operatorValue, $namedParameters );
            } break;
        }
    }

    /**
     * Returns the URL for the given parameters
     */
    function getQRCode( $data, $parameters )
    {
        $qr = new eZQRCode();

        try
        {
            $qr->size = $parameters['size'];
        } catch ( Exception $e ) {
            eZDebug::writeError( (string)$e );
            return null;
        }

        // basic string
        if ( is_string( $data ) )
        {
            $qr->data = $data;
        }

        // object
        elseif( is_object( $data ) )
        {
            // content object attribute
            if ( $data instanceof eZContentObjectAttribute )
            {
                $datatypeString = $data->attribute( 'data_type_string' );
                switch ( $datatypeString )
                {
                    case 'ezstring':
                        $qr->data = $data->attribute( 'content' );
                        break;

                    case 'ezemail':
                        $qr->data = "mailto:" . $data->attribute( 'content' );
                        break;

                    default:
                        $handlerOptions = new ezpExtensionOptions();
                        $handlerOptions->iniFile = 'qrcode.ini';
                        $handlerOptions->iniSection = 'Datatypes';
                        $handlerOptions->iniVariable = 'Mapping';
                        $handlerOptions->handlerIndex = $datatypeString;
                        $handlerOptions->handlerParams = array( $data );

                        $handler = eZExtension::getHandlerClass( $handlerOptions );

                        if ( is_object( $handler ) )
                        {
                            $qr->data = $handler->data();
                        }
                        else
                        {
                            eZDebug::writeError( "No handler was found for datatype '$datatypeString'", __METHOD__ );
                            return '';
                        }
                }
            }
            else
            {
                eZDebug::writeError( "The qrcode operator only supports eZContentObjectAttribute objects", __METHOD__ );
                return '';
            }
        }

        try
        {
            return $qr->getChartURI();
        } catch ( Exception $e ) {
            eZDebug::writeError( (string)$e );
            return null;
        }
    }
}

?>
