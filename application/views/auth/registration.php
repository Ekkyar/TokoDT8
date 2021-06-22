<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">

                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Buat Akun!</h1>
                        </div>

                        <!-- Form -->
                        <form class="user">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="nama" name="nama" placeholder="Nama Lengkap">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="password" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Buat Akun
                            </button>
                        </form>
                        <!-- End Form -->
                        <div class="text-center">
                            <a class="small" href="<?= base_url('Auth'); ?>">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>