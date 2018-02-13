<div class='row'>
    <?php foreach ($foundPeepz as $peep) : ?>
        <div class='col-lg-3 col-md-3'>
            <div class='card'>
                <img class='card-img-top img-responsive' style='max-height: 180px;' src='<?php HTML::out($peep['profileimage']); ?>' alt='<?php HTML::out($peep['gender']); ?>'>
                <div class='card-body'>
                    <h4 class='card-title'><?php HTML::out($peep['name']); ?></h4>
                    <p class='card-text'><?php echo empty($peep['description']) ? '<i>No description</i>' : HTML::get($peep['description']); ?></p>
                    <a href='#' class='btn btn-primary'>Shortlist</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>