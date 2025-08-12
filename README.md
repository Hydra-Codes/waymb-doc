# WayMB API Documentation

Base URL: `https://api.waymb.com`

---

## Endpoints

### POST `/transactions/create`

Cria uma nova transação de depósito utilizando um dos métodos de pagamento disponíveis.

#### Corpo da requisição (JSON):

| Campo          | Tipo                   | Obrigatório | Descrição                                               |
|----------------|------------------------|-------------|---------------------------------------------------------|
| client_id      | string                 | Sim         | Client ID da API (globalAPI ou sibsAPI do usuário)      |
| client_secret  | string                 | Sim         | Client Secret correspondente                             |
| account_email  | string (email)         | Sim         | E-mail da conta vinculada                                |
| amount         | number (float)         | Sim         | Valor da transação                                       |
| method         | string (enum)          | Sim         | Método de pagamento (`myxspend`)|
| payer          | object                 | Sim         | Dados do pagador                                        |
| &nbsp;&nbsp;name     | string                 | Sim         | Nome do pagador                                         |
| &nbsp;&nbsp;document | string                 | Sim         | Documento de identificação (NIF, CPF, etc.)             |
| &nbsp;&nbsp;phone    | string                 | Sim         | Telefone do pagador                                     |
| currency       | string                 | Não         | Moeda da transação (default: EUR)                       |
| split          | object                 | Não         | Configuração de divisão de pagamento                     |
| &nbsp;&nbsp;active    | boolean                | Não         | Indica se divisão está ativa                            |
| &nbsp;&nbsp;percentage| number                 | Não         | Percentual da divisão                                   |
| &nbsp;&nbsp;username  | string                 | Não         | Usuário que receberá a divisão                          |
| callbackUrl    | string (URI)           | Não         | URL para notificações de status                          |
| success_url    | string (URI)           | Não         | URL de redirecionamento após sucesso                    |
| failed_url     | string (URI)           | Não         | URL de redirecionamento após falha                       |

#### Respostas:

- **200 OK**: Transação criada com sucesso.

```json
{
  "statusCode": 200,
  "message": "Payment created successfully",
  "transactionID": "data.customerOrderId",
  "id": "data.customerOrderId",
  "createdAt": 1688985600000,
  "paymentLink": "data.PaymentLink",
  "amount": 100.50,
  "value": 100.50,
  "paymentLinkCode": "data.PaymentLinkCode",
  "country": "data.country",
  "currency": "data.currency",
  "responseCode": "data.responseCode",
  "responseMessage": "data.responseMessage",
  "createdOn": "data.CreatedOn"
}
```

### POST `/transactions/info`

Retorna as informações de uma transação.

#### Corpo da requisição (JSON):

| Campo          | Tipo                   | Obrigatório | Descrição                                               |
|----------------|------------------------|-------------|---------------------------------------------------------|
| id      | string                 | Sim         | ID da transação      |

#### Respostas:

- **200 OK**: Retorna as informações da transação corretamente.

```json
{
  "id": "string",
  "status": "PENDING",
  "amount": 100.5,
  "createdAt": 1712861010,
  "split": {},
  "payer": {},
}
```

## Webhook

Notificação enviada para o `callbackUrl` configurado, sempre que há uma atualização no status da transação.

### Corpo da requisição (JSON):

```json
{
  "statusCode": 200,
  "message": "Payment processed successfully",
  "transactionId": "transaction.id",
  "id": "transaction.id",
  "amount": 100.50,
  "value": 100.50,
  "currency": "EUR",
  "status": "COMPLETED",
  "updatedAt": 1712861310
}
```
