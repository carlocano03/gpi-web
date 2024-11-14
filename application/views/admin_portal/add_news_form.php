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
            <div class="card-header mb-3 pb-3 d-flex align-items-center gap-2 ">
                <img src="<?php echo base_url('assets/images/admin/news.png'); ?>" width="36px"
                    alt="Calendar" />
                <h5 class="table__title"><?= $card_title?></h5>
            </div>
            <div class="card-body mt-4">
                <form id="addForm" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="news_title" class="form-label">News Title</label>
                            <input type="text" class="form-control" id="news_title" required>
                            <div class="invalid-feedback">
                                Please provide a valid news title.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="news_link" class="form-label">New Link (Optional)</label>
                            <input type="text" class="form-control" id="news_link" placeholder="https://example-news.com">
                        </div>
                    </div>
                    <div class="fomr-group mb-3">
                        <label for="formFile" class="form-label">Upload News Image</label>
                        <input class="form-control" type="file" id="formFile" accept="image/*" required>
                        <div class="invalid-feedback">
                            Please provide a valid image.
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="newsContent" class="form-label mb-1"><i class="bi bi-newspaper me-1"></i>News Content</label>
                        <textarea class="form-control summernote" id="newsContent" name="newsContent" rows="5" required></textarea>
                        <div class="invalid-feedback">
                            Please provide a valid news content.
                        </div>
                    </div>
                </form>
                <hr>
                <div class="d-flex align-items-center justify-content-end gap-2">
                    <a href="<?= base_url('admin/manage-news')?>" class="btn btn-secondary">Cancel</a>
                    <button class="btn btn-primary" id="save_news">Save News</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="loading-screen text-center" style="display: none;">
    <div class="spinner-border text-dark" role="status">

    </div>
</div>

<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 200,
            callbacks: {
                onChange: function(contents, $editable) {
                    $('#newsContent').val(contents);
                }
            }
        });

        $(document).on('click', '#save_news', function(event) {
            event.preventDefault();
            event.stopPropagation();

            var form = $('#addForm')[0];
            var formData = new FormData(form);
            formData.append('news_title', $('#news_title').val());
            formData.append('news_link', $('#news_link').val());
            formData.append('news_image', $('#formFile')[0].files[0]);
            formData.append('news_content', $('#newsContent').val());
            formData.append('_token', csrf_token_value);

            form.classList.add('was-validated');
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                Swal.fire({
                    title: 'Are you sure..',
                    text: "You want to continue this transaction?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, continue',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "<?= base_url('admin_portal/news_management/add_news');?>",
                            method: "POST",
                            data: formData,
                            contentType: false,
                            processData: false,
                            dataType: "json",
                            beforeSend: function() {
                                $('.loading-screen').show();
                            },
                            success: function(data) {
                                if (data.error != '') {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Ooops...',
                                        text: data.error,
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Thank You!',
                                        text: data.success,
                                    });
                                    form.reset();
                                    form.classList.remove('was-validated');
                                    setTimeout(() => {
                                        window.location.href = "<?= base_url('admin/manage-news')?>";
                                    }, 3000);
                                }
                            },
                            complete: function() {
                                $('.loading-screen').hide();
                            },
                            error: function() {
                                $('.loading-screen').hide();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Ooops...',
                                    text: 'An error occurred while processing the request.',
                                });
                            }
                        });
                    }
                });
            }
        });
    });
</script>