<section class="content-header">
  <h1>
    Profile Siswa
    <small>Update data diri</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Profile</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Data Profile</h3>
        </div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success">
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php endif; ?>

        <?php if($this->session->flashdata('error')): ?>
          <div class="alert alert-danger">
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>

        <?php
            echo form_open_multipart('siswa/profile', 'role="form" class="form-horizontal"');
        ?>

        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label">NISN</label>
            <div class="col-sm-9">
              <input type="text" value="<?php echo $siswa['nisn']; ?>" readonly="true" name="nisn" class="form-control" placeholder="Masukkan nisn">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Username</label>
            <div class="col-sm-9">
              <input type="text" value="<?php echo $siswa['username']; ?>" name="username" class="form-control" placeholder="Masukkan Username">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Nama Lengkap</label>
            <div class="col-sm-9">
              <input type="text" value="<?php echo $siswa['nama']; ?>" name="nama" class="form-control" placeholder="Masukkan Nama Lengkap">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Tempat Lahir</label>
            <div class="col-sm-5">
              <input type="text" value="<?php echo $siswa['tempat_lahir']; ?>" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir">
            </div>
            <label class="col-sm-1 control-label">Tanggal Lahir</label>
            <div class="col-sm-3">
              <input type="date" value="<?php echo $siswa['tanggal_lahir']; ?>" name="tanggal_lahir" class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Jenis Kelamin</label>
            <div class="col-sm-5">
              <?php
                echo form_dropdown('gender', array('Pilih Gender', 'L'=>'Laki-Laki', 'P'=>'Perempuan'), $siswa['gender'], "class='form-control'");
              ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Agama</label>
            <div class="col-sm-5">
              <?php
                echo cmb_dinamis('agama', 'tbl_agama', 'nama_agama', 'kd_agama', $siswa['kd_agama']);
              ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Foto</label>
            <div class="col-sm-5">
              <input type="file" name="userfile">
              <img src="<?php echo base_url()."/uploads/".$siswa['foto']; ?>" width="150px">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Kelas</label>
            <div class="col-sm-5">
              <input type="text" value="<?php echo $siswa['kd_kelas']; ?>" readonly class="form-control">
            </div>
          </div>
        </div>

        <div class="box-footer">
          <button type="submit" name="submit" class="btn btn-primary">Update Profile</button>
          <a href="<?php echo site_url('siswa/change_password'); ?>" class="btn btn-warning">Ubah Password</a>
        </div>
        </form>
      </div>
    </div>
  </div>
</section>