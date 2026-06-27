<?php 
//DECLARATIONS DES TABLEAUX
$wallets =[
    0=>['client'=>'lena','code'=>'1234','phone'=>'771143710','solde'=>0],
    1=>['client'=>'khadza','code'=>'2345','phone'=>'711001010','solde'=>0],
    2=>['client'=>'dieyna','code'=>'3456','phone'=>'760007070','solde'=>0]
];

$transactions=[
    0=>['type'=>'depot','montant'=>'1000','indexClient'=>0],
    1=>['type'=>'retrait','montant'=>'2000','indexClient'=>2],
];

//DECLARATION DES FONCTIONS

// saisi du wallet
function saisirWallet(){
    $newWallet=['client'=>'','code'=>'','phone'=>'','solde'=>0];
    $newWallet['client']= readline('Entrer votre nom: ');
    $newWallet['code']= readline('Entrer votre code: ');
    $newWallet['phone']= readline('Entrer votre numero de telephone: ');
    return $newWallet;

};

// enregistrement du wallet
function creerWallet(array &$wallets, array &$newWallet){
    $wallets[]=$newWallet;
};
//choix
function choix(){
    $choix=(int)trim(readline('Entrer votre choix:'));
    return $choix;
};
//trouver client avec code
function trouverClientParCode(array $wallets, $code){
    foreach ($wallets as $index => $wallet) {
        if($wallet['code']==$code){
            return $index;
        };
        
    };
    return -1;
};
//type du transaction
function typeTransaction($choix){
     if($choix==1){
        return 'depot';
    }else{
        return'retrait';
    };
};
//client inexistant
function verifierIndex($index){
    if($index==-1){
        echo "\n**Client inexistant**\n";
        return null;
    }
    return $index;
};
// faire en transaction
function saisirTransaction($choix,array $wallets){
    $newTransaction=['type'=>'','montant'=>0,'indexClient'=>0];
    $newTransaction['type']= typeTransaction($choix);
    $newTransaction['montant']=(int)readline('Entrer le montant de la transaction: ');
    $code= trim(readline('Entrer votre code secret: '));
    $index= trouverClientParCode($wallets, $code);
    $index=verifierIndex($index);
    if($index===null){
        return 'pasTrouve';
    }
    $newTransaction['indexClient']= $index;
    return $newTransaction;
};
//enregitrer la transaction
function creerTransaction(&$transactions,$newTransaction){
$transactions[]=$newTransaction;
};
//afficher le menu au lancement
function afficherMenu(){
    echo "\n**MENU**\n";
    echo "1_Creer un compte\n";
    echo "2_Faire une transaction\n";
    echo "3_lister les transactions\n";
    echo "0_Quitter\n";
};
// prend le choix de l'utilisateur
function action(){
    afficherMenu();
    $choixMenu= (int)readline('Que souhaitez-vous faire: ');
    return $choixMenu;
};
// quand l'utilisateur choisi de creer un compte
function choixMenu1($choixMenu,array &$wallets){
    if ($choixMenu==1){
    $newWallet=saisirWallet();
     creerWallet($wallets,$newWallet);
     echo "\n**compte cree avec succes!**\n\n";
    };
};
//choix depot ou retrait
function choixDepotRetrait(){
    echo "\n**Souhaitez-vous:**\n";
    echo "1_faire un depot\n";
    echo "2_faire un retrait\n";
};
//quand l'utilisateur choisi de faire une transaction
function choixMenu2($choixMenu,array &$transactions,array &$wallets){
    if($choixMenu==2){
    choixDepotRetrait();
     $choix=choix();
     $newTransaction=saisirTransaction($choix,$wallets);
     if($newTransaction!='pasTrouve'){
     creerTransaction($transactions,$newTransaction);
     echo "\n**Transaction reuissie!**\n\n";
     };
    }
};
//Choix menu invalide
function choixMenuInvalide($choixMenu){
    if(($choixMenu!=1)&&($choixMenu!=2)&&($choixMenu!=3)&&($choixMenu!=0)){
            echo "\n**Choix invalide!**\n\n";
    };
};
// decide de quoi afficher
function redirection(array &$wallets,array &$transactions){
    do{
        $choixMenu=action();
        choixMenu1($choixMenu,$wallets);
        choixMenu2($choixMenu,$transactions,$wallets);
        choixMenuInvalide($choixMenu);
    }while($choixMenu!=0);
   
};

//APPEL DES FONCTIONS
redirection($wallets,$transactions);











?>