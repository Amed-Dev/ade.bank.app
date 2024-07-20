<?php
use App\Models\Account;

$user = $_SESSION['user'];
$account = $_SESSION['account'];

$userId = $_SESSION['user']['Id']; // Asegúrate de obtener el ID del usuario correctamente
$accountModel = new Account();
$transactions = $accountModel->getTransactions($userId);
$styles = ['/css/cuenta_ahorros.css'];
$scripts = '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';

$bannerTitle = 'Mi cuenta de ahorros';
$pageTitle = 'Cuenta de ahorros';
include '../Templates/header.php';
?>


<main id="transactions_board">
  <div class="widget-balance">
    <i class="logo">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="24px">
        <defs>
          <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="0%" stop-color="#3ef9e6" />
            <stop offset="100%" stop-color="#0053a7" />
          </linearGradient>
        </defs>
        <path fill="url(#gradient)"
          d="M160 0c17.7 0 32 14.3 32 32V67.7c1.6 .2 3.1 .4 4.7 .7c.4 .1 .7 .1 1.1 .2l48 8.8c17.4 3.2 28.9 19.9 25.7 37.2s-19.9 28.9-37.2 25.7l-47.5-8.7c-31.3-4.6-58.9-1.5-78.3 6.2s-27.2 18.3-29 28.1c-2 10.7-.5 16.7 1.2 20.4c1.8 3.9 5.5 8.3 12.8 13.2c16.3 10.7 41.3 17.7 73.7 26.3l2.9 .8c28.6 7.6 63.6 16.8 89.6 33.8c14.2 9.3 27.6 21.9 35.9 39.5c8.5 17.9 10.3 37.9 6.4 59.2c-6.9 38-33.1 63.4-65.6 76.7c-13.7 5.6-28.6 9.2-44.4 11V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V445.1c-.4-.1-.9-.1-1.3-.2l-.2 0 0 0c-24.4-3.8-64.5-14.3-91.5-26.3c-16.1-7.2-23.4-26.1-16.2-42.2s26.1-23.4 42.2-16.2c20.9 9.3 55.3 18.5 75.2 21.6c31.9 4.7 58.2 2 76-5.3c16.9-6.9 24.6-16.9 26.8-28.9c1.9-10.6 .4-16.7-1.3-20.4c-1.9-4-5.6-8.4-13-13.3c-16.4-10.7-41.5-17.7-74-26.3l-2.8-.7 0 0C119.4 279.3 84.4 270 58.4 253c-14.2-9.3-27.5-22-35.8-39.6c-8.4-17.9-10.1-37.9-6.1-59.2C23.7 116 52.3 91.2 84.8 78.3c13.3-5.3 27.9-8.9 43.2-11V32c0-17.7 14.3-32 32-32z" />
      </svg>
    </i>
    <div class="container-product-info">
      <div class="product-type">
        <span>Cuentas de ahorros</span>
        <div class="card-info">
          <span class="visibles-numbers" id="account-number"><?= $account['AccountNumber'] ?></span>
          <button id="copyButton" data-toggle="copy-to-clipboard" data-target="#account-number"
            title="Compartir número de cuenta"><i class="fa-regular fa-copy"></i></button>
        </div>
      </div>
      <div class="available_balance">
        <b class="balance-label fs-2" data-balance="<?= $account['Balance'] ?>"></b>
        <span class="bold">Saldo disponible</span>
      </div>
    </div>
  </div>
  <h2 class="text-dblue">Mis movimientos</h2>
  <?php if (!empty($transactions)): ?>
    <ul>
      <?php foreach ($transactions as $transaction): ?>
        <li class="widget-transactions">
          <?php
          $balanceClass = ($transaction['DestinationAccountId'] === $userId) ? 'paid' : 'received';
          ?>
          <?php if ($transaction['DestinationAccountId'] === $userId): ?>
            <image-abbr img="" text="<?= htmlspecialchars($transaction['Sender_Name']) ?>"
              background="<?= htmlspecialchars($transaction['Sender_Avatar']) ?>" color="#333" width="48px"
              title="<?= htmlspecialchars($transaction['Sender_Name']) ?>"></image-abbr>
            <div class="container-product-info">
              <div class="product-type">
                <span><?= htmlspecialchars($transaction['Type']) ?></span>
                <div class="date-info" data-date="<?= htmlspecialchars($transaction['Date']) ?>">
                </div>
              </div>
              <div class="available_balance  <?= $balanceClass ?>">
                <b class="balance-label fs-1" data-balance="<?= htmlspecialchars($transaction['Amount']) ?>"></b>
              </div>
            </div>
          <?php else: ?>
            <image-abbr img="" text="<?= htmlspecialchars($transaction['Destination_Holder_Name']) ?>"
              background="<?= htmlspecialchars($transaction['Destination_Avatar']) ?>" color="#333" width="48px"
              title="<?= htmlspecialchars($transaction['Destination_Holder_Name']) ?>"></image-abbr>
            <div class="container-product-info">
              <div class="product-type">
                <span><?= htmlspecialchars($transaction['Type']) ?></span>
                <div class="date-info" data-date="<?= htmlspecialchars($transaction['Date']) ?>">

                </div>
              </div>
              <div class="available_balance  <?= $balanceClass ?>">
                <b class="balance-label fs-1" data-balance="<?= "-" . htmlspecialchars($transaction['Amount']) ?>"></b>
              </div>
            </div>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p>No hay transacciones disponibles.</p>
  <?php endif; ?>

</main>
<script type="module" src="/js/cuenta_ahorros.js"></script>
<script src="/js/components/avatar/image_abbr.js"></script>
</body>

</html>