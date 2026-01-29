<div class="container py-5">
    <h3 class="fw-bold mb-4">Daftar Pesanan Masuk</h3>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Invoice</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($data['orders'] as $order): ?>
                        <tr>
                            <td class="ps-4 fw-bold">#<?= $order['invoice_number']; ?></td>
                            <td><?= $order['user_name']; ?></td>
                            <td><?= date('d M Y H:i', strtotime($order['order_date'])); ?></td>
                            <td class="fw-bold text-dark">Rp <?= number_format($order['total_amount'], 0, ',', '.'); ?></td>
                            <td>
                                <?php 
                                    $badge = 'secondary';
                                    if($order['status'] == 'pending') $badge = 'warning text-dark';
                                    if($order['status'] == 'paid') $badge = 'info text-dark';
                                    if($order['status'] == 'shipped') $badge = 'primary';
                                    if($order['status'] == 'completed') $badge = 'success';
                                    if($order['status'] == 'cancelled') $badge = 'danger';
                                ?>
                                <span class="badge bg-<?= $badge; ?> text-uppercase" style="font-size: 0.7rem;">
                                    <?= $order['status']; ?>
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="<?= BASEURL; ?>/admin/orderDetail/<?= $order['id']; ?>" class="btn btn-sm btn-primary-custom rounded-pill px-3">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>