<?php
$lowongan_list = Internship::getAllPostingsForAdmin();
?>

<div class="admin-dashboard">
    <h1>Lowongan Magang</h1>

    <div class="user-list">
        <?php if (empty($lowongan_list)) : ?>
            <p>Tidak ada lowongan.</p>
        <?php else : ?>
            <?php foreach ($lowongan_list as $post) : ?>
                <div class="user-card-lowongan">
                    <div class="user-row">
                        <div class="user-info">
                            <strong class="user-name">
                                <?= htmlspecialchars($post['posisi']) ?>
                            </strong>
                            <span class="user-email">
                                <?= htmlspecialchars($post['perusahaan']) ?>
                            </span>
                            <small>
                                <?= htmlspecialchars($post['ringkasan']) ?>
                            </small>
                        </div>
                    </div>

                    <div class="button-detail-lowongan">
                        <button class="btn-detail"
                                onclick="toggleDetail(<?= $post['id'] ?>)">
                            Detail Selengkapnya
                        </button>
                    </div>

                    <!-- DETAIL (HIDDEN) -->
                    <div class="lowongan-detail" id="detail-<?= $post['id'] ?>">

                        <p><strong>Kualifikasi Jurusan:</strong><br>
                            <?= nl2br(htmlspecialchars($post['kualifikasi_jurusan'])) ?>
                        </p>

                        <p><strong>Durasi:</strong>
                            <?= htmlspecialchars($post['durasi']) ?>
                        </p>

                        <p><strong>Lokasi Penempatan:</strong>
                            <?= htmlspecialchars($post['lokasi_penempatan']) ?>
                        </p>

                        <p><strong>Deskripsi Pekerjaan:</strong><br>
                            <?= nl2br(htmlspecialchars($post['deskripsi_pekerjaan'])) ?>
                        </p>

                        <p><strong>Requirements:</strong><br>
                            <?= nl2br(htmlspecialchars($post['requirements'])) ?>
                        </p>

                        <p><strong>Periode:</strong>
                            <?= htmlspecialchars($post['tanggal_mulai']) ?>
                            –
                            <?= htmlspecialchars($post['tanggal_selesai']) ?>
                        </p>

                        <?php if ($post['website']) : ?>
                            <p><strong>Website:</strong>
                                <?= htmlspecialchars($post['website']) ?>
                            </p>
                        <?php endif; ?>

                        <?php if ($post['instagram_link']) : ?>
                            <p><strong>Instagram:</strong>
                                <?= htmlspecialchars($post['instagram_link']) ?>
                            </p>
                        <?php endif; ?>

                    </div>


                    <div class="user-actions">
                        <?php if ($post['company_status'] === 'active') : ?>
                            <span class="statusLowonganActive">Status : Active</span>
                        <?php else : ?>
                            <span class="statusLowonganBanned">Status : Company Banned</span>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<script>
function toggleDetail(id) {
    const detail = document.getElementById('detail-' + id);
    detail.classList.toggle('show');
}
</script>
