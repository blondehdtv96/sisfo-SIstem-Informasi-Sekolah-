<section class="content-header">
  <h1>
    Ubah Password
    <small>Update password akun</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo site_url('siswa/profile'); ?>">Profile</a></li>
    <li class="active">Ubah Password</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Ubah Password</h3>
        </div>

        <?php if($this->session->flashdata('error')): ?>
          <div class="alert alert-danger">
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

        <?php
            echo form_open('siswa/change_password', 'role="form" class="form-horizontal"');
        ?>

        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-4 control-label">Password Lama</label>
            <div class="col-sm-8">
              <input type="password" name="old_password" class="form-control" placeholder="Masukkan Password Lama" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4 control-label">Password Baru</label>
            <div class="col-sm-8">
              <input type="password" name="new_password" class="form-control" placeholder="Masukkan Password Baru" required>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-4 control-label">Konfirmasi Password</label>
            <div class="col-sm-8">
              <input type="password" name="confirm_password" class="form-control" placeholder="Konfirmasi Password Baru" required>
            </div>
          </div>
        </div>

        <div class="box-footer">
          <button type="submit" name="submit" class="btn btn-primary">Ubah Password</button>
          <a href="<?php echo site_url('siswa/profile'); ?>" class="btn btn-default">Kembali</a>
        </div>
        </form>
      </div>
    </div>
  </div>
</section>