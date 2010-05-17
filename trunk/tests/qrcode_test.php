<?php
class eZQRCodeTest extends ezpTestCase
{
    /**
     * Global data provider for generic __set tests
     */
    public static function providerForSetTest()
    {
        return array(
            // PROPERTY: size

            // valid input array/string
            array( 'size', '10x10', array( 10, 10 ) ),
            array( 'size', array( 20, 20 ), array( 20, 20 ) ),

            // invalid input array/string
            array( 'size', array( 1, 2, 3 ), null, 'ezcBaseValueException' ),
            array( 'size', '10x10x10', null, 'ezcBaseValueException' ),

            // PROPERTY: error_correction_level
            // valid input strings
            array( 'error_correction_level', 'L', 'L' ),
            array( 'error_correction_level', 'M', 'M' ),
            array( 'error_correction_level', 'Q', 'Q' ),
            array( 'error_correction_level', 'H', 'H' ),

            // invalid input strings
            array( 'error_correction_level', '',  null, 'ezcBaseValueException' ),
            array( 'error_correction_level', 'A', null, 'ezcBaseValueException' ),
            array( 'error_correction_level', 4,   null, 'ezcBaseValueException' ),

            // PROPERTY: margin
            array( 'margin', 1, 1 ),
            array( 'margin', 5, 5 ),
            array( 'margin', '', null, 'ezcBaseValueException' ),
            array( 'margin', 'A', null, 'ezcBaseValueException' ),

            // PROPERTY: encoding
            array( 'encoding', 'UTF-8', 'UTF-8' ),
            array( 'encoding', 'Shift_JIS', 'Shift_JIS' ),
            array( 'encoding', 'ISO-8859-1', 'ISO-8859-1' ),
            array( 'encoding', 'somestring', null, 'ezcBaseValueException' ),

            // PROPERTY: data
            array( 'data', 'http://ez.no', 'http://ez.no' ),
        );
    }

    /**
     * @dataProvider providerForSetTest
     */
    function testSet( $property, $value, $expectedValue, $expectedException = null )
    {
        if ( $expectedException !== null )
            $this->setExpectedException( $expectedException );

        $qr = new eZQRCode();
        $qr->$property = $value;
        if ( $expectedValue !== null )
            $this->assertEquals( $qr->$property, $expectedValue );
    }

    function testGetChartURI()
    {
        $qr = new eZQRCode();
        $qr->size = '100x100';
        $qr->data = 'http://ez.no';

        $this->assertEquals( $qr->getChartURI(), 'http://chart.apis.google.com/chart?cht=qr&chs=100x100&chl=http%3A%2F%2Fez.no' );
    }
}

?>