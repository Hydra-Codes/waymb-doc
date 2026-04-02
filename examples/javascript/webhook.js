const express = require("express");
const app = express();

app.use(express.json());

app.post("/callback", (req, res) => {
  // Confirma recebimento imediatamente para a WayMB
  res.status(200).json({ received: true });

  const {
    transactionId,
    id,
    status,
    amount,
    currency,
    email,
    payer,
    updatedAt,
  } = req.body;

  try {
    switch (status) {
      case "COMPLETED":
        console.log(`Pagamento confirmado — Transação: ${transactionId}, Valor: ${amount} ${currency}`);
        // ex: atualizar pedido na base de dados, enviar e-mail de confirmação...
        break;

      case "DECLINED":
        console.log(`Pagamento recusado — Transação: ${transactionId}`);
        // ex: notificar utilizador, reverter reserva...
        break;

      case "PENDING":
        console.log(`Pagamento pendente — Transação: ${transactionId}`);
        // ex: aguardar próxima notificação...
        break;

      default:
        console.log(`Status desconhecido: ${status}`);
    }
  } catch (err) {
    // Erro interno nunca deve impedir o 200 já enviado
    console.error("Erro ao processar webhook:", err);
  }
});

app.listen(3000, () => console.log("Servidor a escutar na porta 3000"));