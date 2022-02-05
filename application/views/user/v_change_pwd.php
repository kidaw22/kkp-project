<section class="content">
    <div class="container-fluid">
        <div class="d-flex items-center justify-content-center">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <form id="frm_header">
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3"> Old Password </label>
                                <div class="col-lg-9">
                                    <input type="password" name="old_password" id="old_password" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3"> New Password </label>
                                <div class="col-lg-9">
                                    <input type="password" name="new_password" id="new_password" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-lg-3"> Confirm Password </label>
                                <div class="col-lg-9">
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary float-right" id="btn_save"> Simpan </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const validationPassword = () => {
        const newPassword = $('#new_password')
        const confirmationPassword = $('#confirm_password')
        $('.label-password-validation').remove();
        $('#btn_save').prop('disabled', false)

        if((newPassword.val() !== '' && confirmationPassword.val() !== '') && (newPassword.val() !== confirmationPassword.val())){
            newPassword.after('<label class="label-password-validation" style="color: red">Kata sandi baru dan konfirmasi tidak cocok</label>');
            confirmationPassword.after('<label class="label-password-validation" style="color: red">Kata sandi baru dan konfirmasi tidak cocok</label>');
            $('#btn_save').prop('disabled', true)
        }
    }

    $(document).ready(function(){
        $('#new_password').on('change', validationPassword);
        $('#confirm_password').on('change', validationPassword);

        $('#frm_header').validate({
            submitHandler: function(e){
                $.ajax({
                    url: "<?= site_url() ?>" + "/user/change_pwd/savePassword",
                    type: 'POST',
                    dataType: 'JSON',
                    data: $('#frm_header').serialize(),
                    success: function(data){
                        if(data.status === 'success'){
                            Swal.fire({
                                icon: 'success',
                                title: data.message
                            }).then(() => {
                                window.location.reload()
                            })
                        }else{
                            Swal.fire({
                                icon: 'warning',
                                title: data.message
                            })
                        }
                    }
                })
            }
        })
    });
</script>