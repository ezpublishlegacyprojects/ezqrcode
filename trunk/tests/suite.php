<?php
class eZQRCodeTestSuite extends ezpTestSuite
{
    public function __construct()
    {
        parent::__construct();
        $this->setName( "ezqrcode extension test suite" );
        $this->addTestSuite( 'eZQRCodeTest' );
    }
}
?>