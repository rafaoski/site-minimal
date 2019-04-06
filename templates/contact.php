<?php namespace ProcessWire; ?>

<head id='html-head' pw-append>
  <style media="screen">
    #main {
      background: linear-gradient( rgba(255, 255, 255, 0.92), rgba(216, 216, 216, 0.88) ),
      url("<?php if(count(page()->images)) echo page()->images->first->url;?>")
      no-repeat center center fixed;
      background-size: contain;
    }
    .contact-body, .google-map { flex-wrap: wrap; }
    .contact-info { font-size: 20px; padding: 20px; }
    .contact-info a { color: red; }
    .search-form input { background: none; }
    .contact-info {  width: 40%; }
    iframe { width: 55%; }
    @media screen and (max-width: 1024px) {
      .contact-info, iframe { width: 100% }
    }
  </style>
</head>

<div id="site-seo" data-pw-remove></div>
<div id="header-image" data-pw-remove></div>

<div id="content-body" class='content-body'>

    <div class="contact-body flex-center">
        <div class='contact-info'>

         <!-- If you want to have more control over the data, create three text fields ( phone, e_mail, adress ) and assign to this template
         Finally, delete unnecessary comments ...
          <ul>
            <li><b><?php // echo setting('phone') ?>:</b> <?php // echo page('phone') ?></li>
            <li><b><?php // echo setting('e-mail') ?>:</b>
                <a href='mailto:<?php // echo page('e_mail') ?>'><?php // echo page('e_mail') ?></a></li>
            <li><b><?php // echo setting('adress') ?>:</b> <?php // echo page('adress') ?></li>
          </ul> -->

            <?= page()->body ?>
        </div>

        <?= page('google_map') ?>

    </div>

</div>
