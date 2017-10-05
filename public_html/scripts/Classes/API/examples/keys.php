

<?php
require_once '../lib/block_io.php';
/* Replace the $apiKey with the API Key from your Block.io Wallet. A different API key exists for Dogecoin, Dogecoin Testnet, Litecoin, Litecoin Testnet, etc. */
$apiKey = '70b6-050f-0b43-9f16';
$pin = '30019130';
$version = 2; // the API version

$block_io = new BlockIo($apiKey, $pin, $version);
$network = $block_io->get_balance()->data->network; // get our current network off Block.io

$passphrase = strToHex('alpha1alpha2alpha3alpha4');
$key = $block_io->initKey()->fromPassphrase($passphrase);

echo "Current Network: " . $network . "\n";
echo "Private Key: " . $key->toWif($network) . "\n"; // print out the private key for the given network

?>
