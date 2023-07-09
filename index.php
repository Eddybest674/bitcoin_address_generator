<html>
<head>
  <title>Exercise</title>
</head>
<body>
  <p>Wallet Address</p>
  <?php
  require_once 'vendor/autoload.php';

  use BitWasp\Bitcoin\Bitcoin;
  use BitWasp\Bitcoin\Key\Deterministic\HierarchicalKeyFactory;
  use BitWasp\Bitcoin\Network\NetworkFactory;
  use BitWasp\Bitcoin\Script\ScriptType;
  use BitWasp\Bitcoin\Script\WitnessProgram;
  use BitWasp\Bitcoin\Address\AddressCreator;
  use BitWasp\Bitcoin\Mnemonic\Bip39\Bip39SeedGenerator;

  
  $network = NetworkFactory::bitcoin();

  
  $words = 'love with is great all my heart today for those men yes';

  
  $seedGenerator = new Bip39SeedGenerator();
  $seed = $seedGenerator->getSeed($words);

  $hdFactory = new HierarchicalKeyFactory();
  $masterKey = $hdFactory->fromEntropy($seed);

  
  $accountKey = $masterKey->derivePath("m/84'/0'/0'");

  
  $receivingKey = $accountKey->deriveChild(0);

  
  $publicKey = $receivingKey->getPublicKey();
  $witnessProgram = WitnessProgram::v0($publicKey->getPubKeyHash());
  $script = ScriptType::p2wsh()->payToWitnessPublicKeyHash($witnessProgram->getProgram());

  
  $addressCreator = new AddressCreator();
  $address = $addressCreator->fromOutputScript($script, $network);

  
  echo "Native SegWit Address: " . $address->getAddress() . "\n";
  ?>
 
  
</body>
</html>
