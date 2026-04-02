// POST /transactions/info
const getTransactionInfo = async (transactionId) => {
  const response = await fetch("https://api.waymb.com/transactions/info", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      id: transactionId,
    }),
  });

  const data = await response.json();
  console.log(data);
  // {
  //   id: "abc123",
  //   status: "PENDING", // PENDING | COMPLETED | DECLINED
  //   amount: 100.50,
  //   createdAt: 1712861010,
  //   updatedAt: 1712861010,
  //   method: "mbway",
  //   ...
  // }
};