<?php

// POST /transactions/create
function createTransaction(): array {
    $payload = [
        'client_id'     => 'seu_client_id',
        'client_secret' => 'seu_client_secret',
        'account_email' => 'conta@exemplo.com',
        'amount'        => 100.50,
        'method'        => 'mbway',
        'payer'         => [
            'email'    => 'pagador@exemplo.com',
            'name'     => 'João Silva',
            'document' => '123456789',
            'phone'    => '+351912345678',
        ],
        'currency'     => 'EUR',
        'paymentDescription' => 'Pagamento para X',
        'split'        => [
            'active'     => true,
            'percentage' => 10,
            'username'   => 'usuario_split',
        ],
        'callbackUrl' => 'https://exemplo.com/callback',
        'success_url' => 'https://exemplo.com/sucesso',
        'failed_url'  => 'https://exemplo.com/falha',
    ];

    $ch = curl_init('https://api.waymb.com/transactions/create');

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
        CURLOPT_POSTFIELDS     => json_encode($payload),
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
    // [
    //   'statusCode'   => 200,
    //   'message'      => 'Payment created successfully',
    //   'transactionID'=> 'abc123',
    //   'id'           => 'abc123',
    //   'amount'       => 100.50,
    //   'value'        => 100.50,
    //   'method'       => 'mbway',
    //   'generatedMBWay' => true,
    //   ...
    // ]
}
