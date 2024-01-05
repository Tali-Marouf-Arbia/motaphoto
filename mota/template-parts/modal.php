 <!-- The Modal -->
<div id="myModal" class="modal">

 <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
       <img src="<?php echo get_template_directory_uri() ?>/assets/images/img-modal.png" alt="image du formulaire de contact" id="img-modal" />
    </div>
    <div id="contact-form-container">
        <?php // insère le formulaire de contact
            echo do_shortcode('[contact-form-7 id="4460a13" title="Formulaire de contact"]');
        ?>  
    </div>
  </div>
</div>


