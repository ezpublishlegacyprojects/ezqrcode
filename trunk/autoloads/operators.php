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
            $qr->data = $data;
            return $qr->getChartURI();
        } catch ( Exception $e ) {
            eZDebug::writeError( (string)$e );
            return null;
        }
    }
}

?>
