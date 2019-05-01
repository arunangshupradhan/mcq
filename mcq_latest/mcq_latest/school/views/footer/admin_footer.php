<footer>
    <div class="container">
        <ul class="social-menu navbar navbar-right">
            <?php if ($this->session->userdata('fb_url')): ?>
                <li><a class="text-muted" href="<?= $this->session->userdata('fb_url') ?>" target="_blank"><i class="fa fa-facebook"></i></a><span class="social-span">Become a fan on Facebook</span></li>
            <?php endif; ?>
            <?php if ($this->session->userdata('googlep_url')): ?>
                <li><a class="text-muted" href="<?= $this->session->userdata('googlep_url') ?>" target="_blank"><i class="fa fa-google-plus"></i></a><span class="social-span">Circle us on Google+</span></li>
            <?php endif; ?>
            <?php if ($this->session->userdata('twtr_url')): ?>
                <li><a class="text-muted" href="<?= $this->session->userdata('twtr_url') ?>" target="_blank"><i class="fa fa-twitter"></i></a><span class="social-span">Follow us on Twitter</span></li>
            <?php endif; ?>
            <?php if ($this->session->userdata('youtube_url')): ?>
                <li><a class="text-muted" href="<?= $this->session->userdata('youtube_url') ?>" target="_blank"><i class="fa fa-youtube"></i></a><span class="social-span">View us on YouTube</span></li>
            <?php endif; ?>
            <?php if ($this->session->userdata('pinterest_url')): ?>
                <li><a class="text-muted" href="<?= $this->session->userdata('pinterest_url') ?>" target="_blank"><i class="fa fa-pinterest"></i></a><span class="social-span">Pin us on Pinterest</span></li>
            <?php endif; ?>
            <?php if ($this->session->userdata('flkr_url')): ?>
                <li><a class="text-muted" href="<?= $this->session->userdata('flkr_url') ?>" target="_blank"><i class="fa fa-flickr"></i></a><span class="social-span">Add us on Flickr</span></li>
            <?php endif; ?>
        </ul>
        <p class="text-muted">Copyright &copy; <?=$this->session->userdata('brand_name').', '. date('Y')?></p>
    </div>
</footer>
<!-- bootstrap Scripts-->
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>

<!-- Data table Scripts-->
<?php
   $this->load->view('plugin_scripts/datatable_scripts');
?>
<!-- X-Editable Scripts-->
<?php
   $this->load->view('plugin_scripts/x-editable_scripts');
?>
