   <!-- Begin Page Content -->
   <div class="container-fluid p-5">

       <!-- Card User -->
       <div class="card mb-3 mx-auto" style="max-width: 650px;">
           <div class="row no-gutters p-2">
               <div class="col-4 my-auto mx-auto">
                   <img src="<?= base_url('assets/img/profil/') . $user['foto']; ?>" class="card-img" alt="...">
               </div>
               <div class="col-md-8">
                   <div class="card-body text-center">
                       <h5 class="card-title text-center">
                           <?= $user['nama']; ?>
                           <span>
                               <h6>
                                   (<?= $akses['nama_akses']; ?>)
                               </h6>
                           </span>
                       </h5>
                       <p class="card-text">
                           <?= $user['alamat']; ?> <br>
                           <?= $user['kontak']; ?> <br>
                           <?= $user['email']; ?> <br>
                       </p>
                       <p class="card-text text-center"><small class="text-muted">Terdaftar sejak <?= date('d F Y'); ?> </small></p>
                   </div>
               </div>
           </div>
       </div>
       <!-- End Card User -->

   </div>
   <!-- /.container-fluid -->