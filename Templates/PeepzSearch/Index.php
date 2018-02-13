<?php
if(empty($Name)) :
    $LoginText = "<a href='#.' class='btn'><i class='fa fa-file-text' aria-hidden='true'></i> Login to set your profile</a>";
else :
    $LoginText = "<div class='randommessage'>Yo $Name<h3> Find your <span>Peepz here...</span></h3></div>";
endif; ?>
<div class='card'>
    <div class='card-body'>
        <div class='row'>
            <div class='col-md-3'><?= $LoginText ?></div>
            <div class='col-md-9'>
                <div class='searchform'>
                    <div class='row'>
                        <div class='col-md-2 col-sm-2'>
                            <?php
                            HTML::dropdown('staff_type', $staffTypes, null, ['class' => 'form-control', 'id' => 'type'])
                            ?>
                        </div>
                        <div class='col-md-2 col-sm-2'>
                            <select class='form-control' id='area'>
                                <option value=''>Any Area</option>
                                <option value='1'>Johannesburg - North</option>
                                <option value='2'>Johannesburg - South</option>
                                <option value='3'>Johannesburg - East</option>
                                <option value='4'>Johannesburg - West</option>
                                <option value='5'>Cape Town</option>
                                <option value='6'>Durban</option>
                                <option value='7'>PE</option>
                                <option value='8'>Bloemfontein</option>
                            </select>
                        </div>
                        <div class='col-md-2 col-sm-2'>
                            <select class='form-control' id='minrate'>
                                <option value='0'>Min Hourly Rate</option>
                                <option value='50'>R50</option>
                                <option value='100'>R100</option>
                                <option value='150'>R150</option>
                                <option value='200'>R200</option>
                                <option value='250'>R250</option>
                                <option value='300'>R300</option>
                                <option value='350'>R350</option>
                            </select>
                        </div>
                        <div class='col-md-2 col-sm-2'>
                            <?php HTML::dropdown('race', ['african' => 'African', 'caucasian' => 'Caucasian', 'mixedrace' => 'Mixed Race', 'Asian' => 'Asian'], null, ['class' => 'form-control']); ?>
                        </div>
                        <div class='col-md-2 col-sm-2'>
                            Date
                        </div>
                        <div class='col-md-1 col-sm-1'>
                            <button class='btn' id='btnTopSearch'><i class='fa fa-search' aria-hidden='true'></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php HTML::checkbox('previous', 'yes', false); ?>
                            <label for='previous'>Only show peepz I've previously worked with</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#btnTopSearch").on('click',(function(e) {

        // validate form
        //e.preventDefault();
        var querystring = "";

        var type = $("#type").val();
        if( type !== '')
        {
            querystring = querystring + "&type=" + type;
        }
        var minrate = $("#minrate").val();
        if( minrate !== '')
        {
            querystring = querystring + "&minrate=" + minrate;
        }
        var area = $("#area").val();
        if( area !== '')
        {
            querystring = querystring + "&area=" + area;
        }
        if(querystring != "")
        {
            $("#divSearchResults").load('peepzsearch.php?fn=Results&search=yes' + querystring);
        }
    }));
</script>
