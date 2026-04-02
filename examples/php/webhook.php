<?php

// Confirma recebimento imediatamente para a WayMB
http_response_code(200);
header('Content-Type: application/json');
echo json_encode(['received' => true]);

// Encerra o envio da resposta sem encerrar o script
if (function_exists('fastcgi_finish_request')) {
    fastcgi_finish_request(); // PHP-FPM: libera a conexão e continua execução
} else {
    ob_end_flush();           // Apache/mod_php: força flush do buffer
    flush();
}

// Processamento do webhook após confirmação
try {
    $body   = json_decode(file_get_contents('php://input'), true);

    $transactionId = $body['transactionId'] ?? null;
    $status        = $body['status']        ?? null;
    $amount        = $body['amount']        ?? null;
    $currency      = $body['currency']      ?? null;
    $payer         = $body['payer']         ?? [];
    $updatedAt     = $body['updatedAt']     ?? null;

    switch ($status) {
        case 'COMPLETED':
            error_log("Pagamento confirmado — Transação: {$transactionId}, Valor: {$amount} {$currency}");
            // ex: atualizar pedido na base de dados, enviar e-mail de confirmação...
            break;

        case 'DECLINED':
            error_log("Pagamento recusado — Transação: {$transactionId}");
            // ex: notificar utilizador, reverter reserva...
            break;

        case 'PENDING':
            error_log("Pagamento pendente — Transação: {$transactionId}");
            // ex: aguardar próxima notificação...
            break;

        default:
            error_log("Status desconhecido: {$status}");
    }
} catch (Throwable $e) {
    // Erro interno nunca afeta o 200 já enviado
    error_log("Erro ao processar webhook: " . $e->getMessage());
}