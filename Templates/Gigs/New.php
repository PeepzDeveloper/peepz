<div id="Gigdiv">
    <div class='card'>
        <div class='card-header'>Add New Gig </div>
        <div class='card-body'>
            <?php if ($showMessage) : ?>
                <div>
                    <div class='alert alert-warning'>
                        <h3 class='text-warning'><i class='fa fa-exclamation-triangle'></i> Warning</h3>
                        Please note you are adding a Gig that is not linked to a specific event and will therefore be matched as a stand alone event. This will result in limited reporting and functionality.<br>
                        If intended, please ignore, else <button type='button' onclick="LoadMainContent('admin/projects.php?profileid=<?= $ContactID; ?>')" class='btn waves-effect waves-light btn-xs btn-info'>click here</button> to setup from the Events Management.
                    </div>
                </div>
            <?php endif; ?>
            <form action="admin/createJob.php" id='frmGig' name='frmGig' method='post' class='form-horizontal'>
                <?php if (empty($EventID) === false) : ?>
                    <?php HTML::hidden('eventid', $EventID); ?>
                <?php endif; ?>
                <?php HTML::hidden('contactid', $ContactID); ?>
                <?php HTML::hidden('coordinates', ''); ?>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label col-md-4">Peepz Type</label>
                            <div class="col-md-8">
                                <?php HTML::dropdown('selstafftype', $stafftypes, null, ['class' => 'form-control']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label col-md-4">Title</label>
                            <div class="col-md-8">
                                <?php HTML::text('title', '', ['data-validation-required-message' => 'This field is required', 'required' => 'required', 'class' => 'form-control']); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class="col-form-label col-md-4">Address</label>
                            <div class="col-md-8">
                                <?php HTML::text('address', '', ['data-validation-required-message' => 'This field is required', 'required' => 'required', 'class' => 'form-control', 'placeholder' => 'Start typing address...']); ?>
                                <img id="map_canvas" class="display:none;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label col-md-4">Description</label>
                            <div class="col-md-8">
                                <?php HTML::textarea('description', '', '22', '5', ['class' => 'form-control']); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label col-md-4">Rate Type</label>
                            <div class="col-md-8">
                                <?php HTML::dropdown('ratetypeid', [2 => 'Daily', 1 => 'Hourly', 4 => 'Project', 3 => 'Weekly'], 1, ['class' => 'form-control']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label col-md-4">Rate</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <span class="input-group-addon">R</span>
                                    <?php HTML::number('suggestedrate', '', ['class' => 'form-control', 'data-validation-required-message' => 'This field is required']); ?>
                                    <span class="input-group-addon">.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label col-md-4">Start Date</label>
                            <div class="col-md-8">
                                <?php HTML::date('datestart', '', ['class' => 'form-control', 'data-validation-required-message' => 'This field is required']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label col-md-4">End Date</label>
                            <div class="col-md-8">
                                <?php HTML::date('dateend', '', ['class' => 'form-control', 'data-validation-required-message' => 'This field is required']); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label col-md-4">Start Time</label>
                            <div class="col-md-8">
                                <?php HTML::time('timestart', '', ['class' => 'form-control', 'data-validation-required-message' => 'This field is required']); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label col-md-4">End Time</label>
                            <div class="col-md-8">
                                <?php HTML::time('timeend', '', ['class' => 'form-control', 'data-validation-required-message' => 'This field is required']); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" id="btnsavefrmGig" class="btn btn-success">Add New</button>
                        </div>
                    </div>
                </div>
            </form>
            <div id="divsave"></div>
        </div>
    </div>
</div>
<script>
        $(function () { $('input,select,textarea').not('[type=submit]').jqBootstrapValidation(); } );

        $(document).ready(function (e) {



            $('#frmGig').on('submit',(function(e) {

                // validate form
                e.preventDefault();
                var iserror = false;
                var namep = $('#name').val();
                if( namep === '')
                {
                    iserror = true;
                    $('#divsave').text('error, please fill in the name of the product').show();
                }

                if(iserror ==false)
                {
                    $('#divsave').html("<p><img src='images/loader.gif' style='width:12px; height:12px;'>Loading...</p>");
                    $.ajax({
                        url: 'admin/createJob.php',
                        type: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function(data)
                        {
                            var response = $(data);
                            var saveResult = response.find('#saveResult').val();
                            if($.isNumeric(saveResult))
                            {
                                $('#Gigdiv').load('admin/jobs.php?fn=DisplayTable&refresh=true&contactid=2&jobid=' + saveResult);
                            }
                            else
                            {
                                $('#divsave').html(data);
                            }
                        }
                    });
                }
            }));
        });</script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: 'http://maps.googleapis.com/maps/api/js?key=AIzaSyA5h9a9VU1vQ_8CdWmIIZcLu9dAtTJvKb0&libraries=places',
                dataType: 'script',
                success: function() {
                    //Define Autocomplete Textbox
                    var input = document.getElementById('address');
                    var autocomplete = new google.maps.places.Autocomplete(input);

                    //Define Place Changed Event Listener
                    google.maps.event.addListener(autocomplete, 'place_changed', function() {
                        var place = autocomplete.getPlace();
                        var lat = place.geometry.location.lat();
                        var lng = place.geometry.location.lng();
                        var view = lat + ',' + lng;

                        $('#map_canvas')
                            .attr('src','http://maps.googleapis.com/maps/api/staticmap?key=AIzaSyA5h9a9VU1vQ_8CdWmIIZcLu9dAtTJvKb0&center=' + view + '&zoom=15&size=400x400&markers=color:green%7Clabel:S%7C' + view)
                            .show();
                        $('#coordinates').val(view);
                    })
                },
                async: true
            });
        });
    </script>