<?php
// parameters
$hubVerifyToken = 'TOKEN1234GGGSS';
$accessToken = "EAAQ8poRtX3QBADlLXhsd3PZAZADGmDXdZAZAa5EPt41u83ZBHWoITmJ3nqpfLGSGJFQVJA3gE5TfEvkiNfSM9ZCVVqZBq85PtZC1WQHa0aheGQDs4JdKnwaYC8M4eVB1TI5XWsKQH6juioZC1Yreoj5sVcUUwgEboeg1yjbHnLRw1iAZDZD";

// check token at setup
if ($_REQUEST['hub_verify_token'] === $hubVerifyToken) {
  echo $_REQUEST['hub_challenge'];
  exit;
}

// handle bot's anwser
$input = json_decode(file_get_contents('php://input'), true);

$senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
$messageText = $input['entry'][0]['messaging'][0]['message']['text'];


$answer = "I don't understand. Ask me 'hi'.";
if($messageText == "hi") 
{
    $answer = "Hello sir, How may I help you ?";
}
if($messageText == "I want to buy wallet")
{
	$answer = "Please mention the product code";
}
if($messageText == "GSW-501")
{
	$answer = "Product price: Rs 1200";
}
if($messageText == "How to order?")
{
	$answer = "To book your order mention product code, color, name, contact number and complete address.";
}

$response = [
    'recipient' => [ 'id' => $senderId ],
    'message' => [ 'text' => $answer ]
];
$ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_exec($ch);
curl_close($ch);
