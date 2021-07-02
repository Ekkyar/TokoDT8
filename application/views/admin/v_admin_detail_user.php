   <!-- Begin Page Content -->
   <div class="container-fluid">

       <!-- Card View User -->
       <?php foreach ($getuser as $usr) : ?>
           <div class="card mb-3 mx-auto" style="max-width: 650px;">
               <div class="row no-gutters p-2">
                   <div class="col-4 my-auto mx-auto">
                       <img src="<?= base_url('assets/img/profil/') . $usr['foto']; ?>" class="card-img" alt="...">
                   </div>
                   <div class="col-md-8">
                       <div class="card-body text-center">
                           <h3 class="card-title text-center">
                               <?= $usr['nama']; ?>
                               <?php foreach ($getakses as $aks) : ?>
                                   <span>
                                       <?php if ($usr['id_akses'] == $aks['id_akses']) : ?>
                                           (<?= $aks['nama_akses']; ?>)
                                       <?php endif; ?>
                                   </span>
                               <?php endforeach; ?>
                           </h3>
                           <p class="card-text pt-3">
                               <?= $usr['alamat']; ?> <br>
                               <?= $usr['kontak']; ?> <br>
                               <?= $usr['email']; ?> <br>
                           </p>
                           <p class="card-text text-center"><small class="text-muted">Terdaftar sejak <?= date('d F Y'); ?> </small></p>
                       </div>
                   </div>
               </div>
           </div>
       <?php endforeach; ?>
       <!-- End Card View User -->

       <!-- Card Edit User -->
       <div class="card shadow mb-4">

           <!-- Header Card -->
           <div class="card-header py-3 text-center bg-primary">
               <h6 class="m-0 font-weight-bold text-light">Detail User</h6>
           </div>

           <!-- Form Edit -->
           <div class="card-body mx-auto">
               <div class="row mt-3">

                   <?php foreach ($getuser as $usr) : ?>
                       <!-- Tabel -->
                       <div class="col">
                           <table class="table table-borderless my-auto">
                               <!-- ID -->
                               <form action="<?= base_url('Admin/Admin_Akun/detail_user/'); ?><?= $usr['id_user']; ?>" method="post">
                                   <tr>
                                       <th width="200px"> ID User </th>
                                       <td width="20px">:</td>
                                       <td width="500px">
                                           <input type=" text" class="form-control" id="id_user" name="id_user" value="<?= $usr['id_user']; ?>" readonly>
                                       </td>
                                   </tr>
                                   <!-- Nama -->
                                   <tr>
                                       <th>Nama Lengkap</th>
                                       <td>:</td>
                                       <td>
                                           <input type="text" class="form-control" id="nama" name="nama" value="<?= $usr['nama']; ?>">
                                           <?= form_error('nama', '<small class="text-danger pl-1">', '</small>'); ?>
                                       </td>
                                   </tr>
                                   <!-- Alamat -->
                                   <tr>
                                       <th>Alamat</th>
                                       <td>:</td>
                                       <td>
                                           <input type="text" class="form-control" id="alamat" name="alamat" value="<?= $usr['alamat']; ?>">
                                           <?= form_error('alamat', '<small class="text-danger pl-1">', '</small>'); ?>
                                       </td>
                                   </tr>
                                   <!-- Kontak -->
                                   <tr>
                                       <th>Kontak</th>
                                       <td>:</td>
                                       <td>
                                           <input type="text" class="form-control" id="kontak" name="kontak" value="<?= $usr['kontak']; ?>">
                                           <?= form_error('kontak', '<small class="text-danger pl-1">', '</small>'); ?>
                                       </td>
                                   </tr>
                                   <!-- Email -->
                                   <tr>
                                       <th>Email</th>
                                       <td>:</td>
                                       <td>
                                           <input type="text" class="form-control" value="<?= $usr['email']; ?>" readonly>
                                       </td>
                                   </tr>
                                   <!-- Username -->
                                   <tr>
                                       <th>Username</th>
                                       <td>:</td>
                                       <td>
                                           <input type=" text" class="form-control" value="<?= $usr['username']; ?>" readonly>
                                       </td>
                                   </tr>
                                   <!-- Foto -->
                                   <tr>
                                       <th>Foto</th>
                                       <td>:</td>
                                       <td>
                                           <img src="<?= base_url('assets/img/profil/') . $usr['foto']; ?>" class="img-thumbnail" style="width: 8rem;" alt=".img">
                                       </td>
                                   </tr>
                                   <!-- Date Created -->
                                   <tr>
                                       <th>Tanggal Dibuat</th>
                                       <td>:</td>
                                       <td>
                                           <input type="text" class="form-control" value="<?= date('d F Y', $usr['date_created']); ?>" readonly>
                                       </td>
                                   </tr>
                                   <!-- Akses -->
                                   <tr>
                                       <th>Akses</th>
                                       <td>:</td>
                                       <td>
                                           <select class="form-control" id="id_akses" name=" id_akses">
                                               <?php foreach ($getakses as $aks) : ?>
                                                   <option value="<?= $aks['id_akses']; ?>" <?php if ($usr['id_akses'] == $aks['id_akses']) : ?> selected="selected" <?php endif; ?>>
                                                       <?= $aks['nama_akses']; ?>
                                                   </option>
                                               <?php endforeach; ?>
                                           </select>
                                       </td>
                                   </tr>
                                   <!-- Tombol -->
                                   <tr>
                                       <th></th>
                                       <td></td>
                                       <td>
                                           <!-- Backspace -->
                                           <?php $url = htmlspecialchars($_SERVER['HTTP_REFERER']); ?>
                                           <a href="<?= $url ?>" class="btn btn-secondary">Kembali</a>
                                           <!-- Simpan Edit -->
                                           <button type="submit" class="btn btn-primary">Simpan</button>
                                       </td>
                                   </tr>
                               </form>
                           </table>
                       </div>
                       <!-- End Tabel -->
                   <?php endforeach; ?>

               </div>
           </div>
           <!-- End Form Edit -->

       </div>
       <!-- End Card Edit User -->

   </div>
   <!-- /.container-fluid -->