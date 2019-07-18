<?php
include('inc/Base.php');

$api = new webAPI();

$params = isset($_GET['params'])? $_GET['params'] : 'user';
$id = isset($_GET['id'])? (int) $_GET['id'] : 1;
$html = '';
if($params == 'user' and $id > 0){
    $dataUser = $api->getData('https://sample-accounts-api.herokuapp.com/users/'.$id);
    if($dataUser['http_code'] == 200){
        if(!empty($dataUser['content'])){
            $user = json_decode($dataUser['content'], true);
            $html .= 'Name: '.$user['attributes']['name'];          
        }
    }
    $dataAccounts = $api->getData('https://sample-accounts-api.herokuapp.com/users/'.$id.'/accounts');
    if($dataAccounts['http_code'] == 200){
        if(!empty($dataAccounts['content'])){
            $accounts = json_decode($dataAccounts['content'], true);
            $html .= '<br> Accounts: <br>';
            foreach($accounts as $item){
                $html .= '  - <a href="?params=acc&id='.$item['attributes']['id'].'">'.$item['attributes']['name'].': '.$item['attributes']['balance'].'</a> <br>';
            }   
        }
    }
}
elseif($params == 'acc' and $id > 0){
    $dataAccount = $api->getData('https://sample-accounts-api.herokuapp.com/accounts/'.$id);
    if(!empty($dataAccount['content'])){
        $account = json_decode($dataAccount['content'], true);
        $html .= 'Name: '.$account['attributes']['name']; 
        $html .= 'Balance: '.$account['attributes']['balance']; 
    }
} else {
    $html .= 'Don\'t have data. ';
}
echo $html;
