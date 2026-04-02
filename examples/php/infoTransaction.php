<?php

// POST /transactions/info
function getTransactionInfo(string $transactionId): array {
    $payload = [
        'id' => $transactionId,
    ];

    $ch = curl_init('https://api.waymb.com/transactions/info');

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
    //   'id'        => 'abc123',
    //   'status'    => 'PENDING', // PENDING | COMPLETED | DECLINED
    //   'amount'    => 100.50,
    //   'createdAt' => 1712861010,
    //   'updatedAt' => 1712861010,
    //   'method'    => 'mbway',
    //   ...
    // ]
}