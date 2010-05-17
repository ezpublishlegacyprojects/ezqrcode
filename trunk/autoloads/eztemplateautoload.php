<?php
$eZTemplateOperatorArray = array();

$eZTemplateOperatorArray[] = array( 'script' => eZExtension::baseDirectory() . '/ezqrcode/autoloads/operators.php',
                                    'class' => 'eZQRCodeOperators',
                                    'operator_names' => array( 'qrcode' ) );
?>