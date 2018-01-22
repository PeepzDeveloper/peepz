<?php

  echo "<div class='col-md-12'>
                        <div class='card'>
                            <div class='card-body'>
                                <h4 class='card-title'>Default Tab</h4>
                                <h6 class='card-subtitle'>Use default tab with class <code>nav-tabs &amp; tabcontent-border </code></h6>
                                <!-- Nav tabs -->
                                <ul class='nav nav-tabs' role='tablist'>
                                    <li class='nav-item'> <a class='nav-link active' data-toggle='tab' href='#home' role='tab' aria-expanded='true'><span class='hidden-sm-up'><i class='ti-home'></i></span> <span class='hidden-xs-down'>Home</span></a> </li>
                                    <li class='nav-item'> <a class='nav-link' data-toggle='tab' href='#profile' role='tab' aria-expanded='false'><span class='hidden-sm-up'><i class='ti-user'></i></span> <span class='hidden-xs-down'>Profile</span></a> </li>
                                    <li class='nav-item'> <a class='nav-link' data-toggle='tab' href='#messages' role='tab' aria-expanded='false'><span class='hidden-sm-up'><i class='ti-email'></i></span> <span class='hidden-xs-down'>Messages</span></a> </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class='tab-content tabcontent-border'>
                                    <div class='tab-pane active' id='home' role='tabpanel' aria-expanded='true'>
                                        <div class='p-20'>
                                            <h3>Best Clean Tab ever</h3>
                                            <h4>you can use it with the small code</h4>
                                            <p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a.</p>
                                        </div>
                                    </div>
                                    <div class='tab-pane p-20' id='profile' role='tabpanel' aria-expanded='false'>2</div>
                                    <div class='tab-pane p-20' id='messages' role='tabpanel' aria-expanded='false'>3</div>
                                </div>
                            </div>
                        </div>
                    </div>";

