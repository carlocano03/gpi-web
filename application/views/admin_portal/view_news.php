<style>
    .table__title {
        font-size: 20px;
        font-weight: 500;
        color: #434875 !important;
        padding: 8px 0;
        margin-bottom: 0;
    }

    .card {
        background: #ffffff;
        border-radius: 8px;
        color: #434875;
        box-shadow: 0 9px 20px rgba(46, 35, 94, .07);
    }

</style>
<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header mb-3 pb-3 d-flex align-items-center justify-content-between gap-2 ">
                <div class="d-flex align-items-center gap-2">
                    <img src="<?php echo base_url('assets/images/admin/news.png'); ?>" width="36px"
                        alt="Calendar" />
                    <h5 class="table__title"><?= $card_title?></h5>
                </div>
                <div>
                    <a href="<?= base_url('admin/manage-news')?>" class="btn btn-dark btn-sm me-4"><i class="bi bi-backspace-fill me-2"></i>Back</a>
                </div>
            </div>
            <div class="card-body mt-4">
                <div class="mb-2">
                    <b>News Title:</b> <?= isset($news['news_title']) ? ucwords($news['news_title']) : '';?>
                </div>
                <div class="mb-2">
                    <?php
                        if ($posted_by) {
                            $name = $posted_by['first_name'].' '.$posted_by['last_name'];
                        } else {
                            $name = '';
                        }
                    ?>
                    <b>Posted By:</b> <?= $name;?>
                </div>
                <div class="mb-2">
                    <b>Date Posted:</b> <?= isset($news['date_created']) ? date('D M j, Y H:i A', strtotime($news['date_created'])) : '';?>
                </div>
                <div class="mb-2">
                    <b>News Content:</b>
                </div>
                <div style="text-align:justify;">
                    <?= isset($news['content']) ? $news['content'] : '';?>
                </div>
            </div>
        </div>
    </div>
</div>