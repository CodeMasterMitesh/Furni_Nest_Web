<div class="site-wrapper-reveal border-bottom">
    <div class="contact-us-info-area mt-30 section-space--mb_60">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="single-contact-info-item">
                        <div class="icon">
                            <i class="icon-clock3"></i>
                        </div>
                        <div class="iconbox-desc">
                            <h6 class="mb-10">Open houses</h6>
                            <p>Mon - Fri : 8:30 - 18:00 <br>Sat - Sun : 9:00 - 17:00</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="single-contact-info-item">
                        <div class="icon">
                            <i class="icon-telephone"></i>
                        </div>
                        <div class="iconbox-desc">
                            <h6 class="mb-10">Phone number</h6>
                            <p>(504) 586 256 23 <br> (306) 574 326 56</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="single-contact-info-item">
                        <div class="icon">
                            <i class="icon-envelope-open"></i>
                        </div>
                        <div class="iconbox-desc">
                            <h6 class="mb-10">Our email</h6>
                            <p>office@helentheme.com <br>Info@helentheme.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="single-contact-info-item">
                        <div class="icon">
                            <i class="icon-map-marker"></i>
                        </div>
                        <div class="iconbox-desc">
                            <h6 class="mb-10">Our location</h6>
                            <p>1102 Helen Estates, Guys <br>Store, San Diego, USA.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="contact-us-page-warpper section-space--pb_120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="border-top">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="contact-form-wrap  section-space--mt_60">
                                    <h5 class="mb-10">Get in touch</h5>
                                    <p>Write us a letter !</p>
                                    <form id="contact-form" class="mt-30" action="https://hasthemes.com/file/mail.php" method="post">
                                        <div class="contact-form">
                                            <div class="contact-input">
                                                <div class="contact-inner">
                                                    <input name="con_name" type="text" placeholder="Name *">
                                                </div>
                                                <div class="contact-inner">
                                                    <input name="con_email" type="email" placeholder="Email *">
                                                </div>
                                            </div>
                                            <div class="contact-inner">
                                                <input name="con_subject" type="text" placeholder="Subject *">
                                            </div>
                                            <div class="contact-inner contact-message">
                                                <textarea name="con_message" placeholder="Please describe what you need."></textarea>
                                            </div>
                                            <div class="submit-btn mt-20">
                                                <button class="btn btn--black btn--md" type="submit">Submit</button>
                                                <p class="form-messege"></p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-4 ms-auto">
                                <div class="conatact-info-text section-space--mt_60">
                                    <h5 class="mb-10">Our address</h5>
                                    <p>Duis aute irure dolor in reprehenderit ioluptate velit esse cillum dolore pariatur.</p>
                                    <p class="mt-30">1102 Helen Estates, Guys Store, San Diego, USA. <br>(693) 650-2389 <br>office@helentheme.com</p>
                                    <div class="product_socials mt-30">
                                        <span class="label">FOLLOW US:</span>
                                        <ul class="furninest-social-share socials-inline">
                                            <li>
                                                <a class="share-twitter furninest-twitter" href="#" target="_blank"><i class="social_twitter"></i></a>
                                            </li>
                                            <li>
                                                <a class="share-facebook furninest-facebook" href="#" target="_blank"><i class="social_facebook"></i></a>
                                            </li>
                                            <li>
                                                <a class="share-google-plus furninest-google-plus" href="#" target="_blank"><i class="social_googleplus"></i></a>
                                            </li>
                                            <li>
                                                <a class="share-pinterest furninest-pinterest" href="#" target="_blank"><i class="social_pinterest"></i></a>
                                            </li>
                                            <li>
                                                <a class="share-linkedin furninest-linkedin" href="#" target="_blank"><i class="social_linkedin"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="map-area">
        <div class="google-map">
            <div id="googleMap-1" class="embed-responsive-item googleMap-1" data-lat="40.730610" data-Long="-73.935242"></div>
        </div>
    </div>
</div>

<?php include("pages/footer.php"); ?>
</div>

<script>
    /*--
        Google Map
        -----------------------------------*/

    // Google Map For Single Property Map
    $('.googleMap-1').each(function() {
        if ($(this).length) {
            var $this = $(this);
            var $lat = $this.data('lat');
            var $long = $this.data('long');

            function initialize() {
                var mapOptions = {
                    zoom: 14,
                    scrollwheel: false,
                    center: new google.maps.LatLng($lat, $long),
                    styles: [{
                            "featureType": "water",
                            "elementType": "geometry.fill",
                            "stylers": [{
                                "color": "#F1F1F1"
                            }]
                        },
                        {
                            "featureType": "transit",
                            "stylers": [{
                                    "color": "#F1F1F1"
                                },
                                {
                                    "visibility": "off"
                                }
                            ]
                        },
                        {
                            "featureType": "road.highway",
                            "elementType": "geometry.stroke",
                            "stylers": [{
                                    "visibility": "on"
                                },
                                {
                                    "color": "#fff"
                                }
                            ]
                        },
                        {
                            "featureType": "road.highway",
                            "elementType": "geometry.fill",
                            "stylers": [{
                                "color": "#fff"
                            }]
                        },
                        {
                            "featureType": "road.local",
                            "elementType": "geometry.fill",
                            "stylers": [{
                                    "visibility": "on"
                                },
                                {
                                    "color": "#F1F1F1"
                                },
                                {
                                    "weight": 1.8
                                }
                            ]
                        },
                        {
                            "featureType": "road.local",
                            "elementType": "geometry.stroke",
                            "stylers": [{
                                "color": "#ECECEC"
                            }]
                        },
                        {
                            "featureType": "poi",
                            "elementType": "geometry.fill",
                            "stylers": [{
                                    "visibility": "on"
                                },
                                {
                                    "color": "#FF5151"
                                }
                            ]
                        },
                        {
                            "featureType": "administrative",
                            "elementType": "geometry",
                            "stylers": [{
                                "color": "#fff"
                            }]
                        },
                        {
                            "featureType": "road.arterial",
                            "elementType": "geometry.fill",
                            "stylers": [{
                                "color": "#F1F1F1"
                            }]
                        },
                        {
                            "featureType": "road.arterial",
                            "elementType": "geometry.fill",
                            "stylers": [{
                                "color": "#ffffff"
                            }]
                        },
                        {
                            "featureType": "landscape",
                            "elementType": "geometry.fill",
                            "stylers": [{
                                    "visibility": "on"
                                },
                                {
                                    "color": "#F9F9F9"
                                }
                            ]
                        },
                        {
                            "featureType": "road",
                            "elementType": "labels.text.fill",
                            "stylers": [{
                                "color": "#B7B7B7"
                            }]
                        },
                        {
                            "featureType": "administrative",
                            "elementType": "labels.text.fill",
                            "stylers": [{
                                    "visibility": "on"
                                },
                                {
                                    "color": "#8b8b8b"
                                }
                            ]
                        },
                        {
                            "featureType": "poi",
                            "elementType": "labels.icon",
                            "stylers": [{
                                "visibility": "off"
                            }]
                        },
                        {
                            "featureType": "poi",
                            "elementType": "labels",
                            "stylers": [{
                                "visibility": "off"
                            }]
                        },
                        {
                            "featureType": "road.arterial",
                            "elementType": "geometry.stroke",
                            "stylers": [{
                                "color": "#d6d6d6"
                            }]
                        },
                        {
                            "featureType": "road",
                            "elementType": "labels.icon",
                            "stylers": [{
                                "visibility": "off"
                            }]
                        },
                        {},
                        {
                            "featureType": "poi",
                            "elementType": "geometry.fill",
                            "stylers": [{
                                "color": "#EBEBEB"
                            }]
                        }
                    ]
                };
                var map = new google.maps.Map(document.getElementById('googleMap-1'), mapOptions);
                var marker = new google.maps.Marker({
                    position: map.getCenter(),
                    icon: '',
                    map: map,
                    overlay: {
                        values: [{
                            address: "40.7590615,-73.969231",
                            position: 'center',
                            options: {
                                content: '',
                            }
                        }, ],
                        events: {
                            mouseover: function(overlay, event, context) {
                                var target = overlay.getDOMElement();

                                target.style.zIndex = 2;

                                var info = $(target).find('.gmap-info-wrapper');
                                info.find('.gmap-info-template').show();
                            },
                            mouseout: function(overlay) {
                                var target = overlay.getDOMElement();

                                target.style.zIndex = 1;

                                var info = $(target).find('.gmap-info-wrapper');
                                info.find('.gmap-info-template').hide();
                            }
                        }
                    },


                });






            };

            google.maps.event.addDomListener(window, 'load', initialize);
        }
    });
</script>