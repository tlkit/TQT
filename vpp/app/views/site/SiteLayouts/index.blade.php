<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Home n Office, Office Stationery Supplies Store Singapore</title>
    <base href="http://www.homenoffice.sg/" />
    <meta name="description" content="Home n Office is in the business of retail and office supplies for stationeries, IT products, equipment, filing solutions and related products and services in Singapore." />
    <meta name="keywords" content="Home n Office" />
    <link href="http://www.homenoffice.sg/image/data/cart.png" rel="icon" />
    <link href="http://www.homenoffice.sg/" rel="canonical" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/stylesheet.css" />

    <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/isearch.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/slideshow.css" media="screen" />
    <script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
    <link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
    <script type="text/javascript" src="catalog/view/javascript/common.js"></script>
    <script type="text/javascript" src="catalog/view/javascript/isearch_corporate.js"></script>
    <script type="text/javascript" src="catalog/view/javascript/jquery/nivo-slider/jquery.nivo.slider.pack.js"></script>

    <link rel="stylesheet" type="text/css" href="catalog/view/javascript/bootstrap/css/bootstrap-modal.css" />
    <link rel="stylesheet" type="text/css" href="catalog/view/javascript/bootstrap/css/bootstrap-theme.css" />
    <script type="text/javascript" src="catalog/view/javascript/bootstrap/js/bootstrap.js"></script>

    <!--[if IE 7]>
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />
    <![endif]-->
    <!--[if lt IE 7]>
    <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />
    <script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
    <script type="text/javascript">
        DD_belatedPNG.fix('#logo img');
    </script>
    <![endif]-->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-55318663-1', 'homenoffice.sg');

        ga('send', 'pageview');
    </script>

    <script type="text/javascript">
        function mouseover(id, img_path) {
            $('#icon-'+id).attr("src", img_path);
        }
        function mouseout(id, img_path) {
            $('#icon-'+id).attr("src", img_path);
        }
        $(document).ready(function() {
            $('#tips').click(function() {
                // alert('Hello');
            });
            $.ajax({
                url: 'index.php?route=checkout/cart/delivery',
                type: 'post',
                dataType: 'json',
                success: function(json) {
                    $('#delivery-status').html(json['message']);

                    $( "#progressbar" ).progressbar({
                        value: json['percentage']
                    });
                }
            });
        });
    </script>

    <link rel="stylesheet" href="catalog/view/javascript/jquery.cluetip.css" type="text/css" />
    <script src="catalog/view/javascript/jquery.cluetip.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('a.title').cluetip({splitTitle: '|'});
            $('ol.rounded a:eq(0)').cluetip({splitTitle: '|', dropShadow: false, cluetipClass: 'rounded', showtitle: false});
            $('ol.rounded a:eq(1)').cluetip({cluetipClass: 'rounded', dropShadow: false, showtitle: false, positionBy: 'mouse'});
            $('ol.rounded a:eq(2)').cluetip({cluetipClass: 'rounded', dropShadow: false, showtitle: false, positionBy: 'bottomTop', topOffset: 70});
            $('ol.rounded a:eq(3)').cluetip({cluetipClass: 'rounded', dropShadow: false, sticky: true, ajaxCache: false, arrows: true});
            $('ol.rounded a:eq(4)').cluetip({cluetipClass: 'rounded', dropShadow: false});
        });
    </script>

    <link href="catalog/view/javascript/jquery/cloud-zoom/cloud-zoom.css" rel="stylesheet" type="text/css" />
    <script type="text/JavaScript" src="catalog/view/javascript/jquery/cloud-zoom/cloud-zoom.1.0.2.js"></script>

    <script type="text/javascript" src="catalog/view/javascript/common_ajaxcart.js"></script>
    <link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/fancybox/jquery.fancybox.css" media="screen" />
    <script type="text/javascript" src="catalog/view/javascript/jquery/fancybox/jquery.fancybox.pack.js"></script>



    <link rel="stylesheet" type="text/css" media="screen,projection" href="catalog/view/theme/default/stylesheet/ui.totop.css" />


</head>
<body>
<div id="container">
    <div id="header">
        <div id="logo"><a href="http://www.homenoffice.sg/"><img src="http://www.homenoffice.sg/image/data/HOME-N-OFFICE-LOGO.png" title="Home n Office Products Pte Ltd" alt="Home n Office Products Pte Ltd" /></a></div>

        <div id="search">
            <div class="button-search"></div>
            <input type="text" name="search" placeholder="search for something :)" value="" />
        </div>
        <div id="welcome">
            <div style="float:right"><img id="tips" data-toggle="modal" data-target="#myModal" src="catalog/view/theme/default/image/tips.png"></div>
            <div style="float:right">
                <div id="delivery-status"></div>
                <img src="catalog/view/theme/default/image/truck-bg.png">
                <div id="progressbar"></div>
            </div>
            <div id="divLogin" style="float:right">
                <input type="button" class="login" id="btnLogin" value="Login" onclick="window.location='http://www.homenoffice.sg/login'">
                <input type="button" class="account" id="btnRegister" value="Register" onclick="window.location='http://www.homenoffice.sg/register'">
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade  bs-example-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <img src="catalog/view/theme/default/image/box-bg.png">
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Close <img src="catalog/view/theme/default/image/close2.png" valign="middle"></button>
                </div>
            </div>
        </div>
    </div>
    <div id="menu">
        <ul>
            <li><a href="http://www.homenoffice.sg/">Home</a></li>
            <li><a href="http://www.homenoffice.sg/about-us">About Us</a></li>
            <li><a href="http://www.homenoffice.sg/index.php?route=product/category">Products</a>
                <span id="sub-menu"><img src="catalog/view/theme/default/image/submenu_pointer.png"></span>
                <ul>
                    <li onmouseover="mouseover('0', 'image/data/1-r.png');" onmouseout="mouseout('0', 'image/data/1.png')" class="has-sub"><a href="http://www.homenoffice.sg/basic-stationery"><img id="icon-0" src="image/data/1.png" valign="middle" />&nbsp;&nbsp;Basic Stationery</a>
                        <ul>
                            <li class="">
                                <a href="http://www.homenoffice.sg/basic-stationery/batteries">Batteries</a>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/basic-stationery/boards-and-accessories">Boards &amp; Accessories</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/boards-and-accessories/magnets">Magnets</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/boards-and-accessories/whiteboards">Whiteboards</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/boards-and-accessories/magnetic-glass-boards">Magnetic Glass Boards</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/boards-and-accessories/cork-duo-and-memo-boards">Cork, Duo &amp; Memo Boards</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/boards-and-accessories/easel-pads-and-flip-chart-boards">Easel Pads &amp; Flip Chart Boards</a></li>
                                </ul>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/basic-stationery/clips-pins-and-tacks">Clips&#44; Pins &amp; Tacks</a>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/basic-stationery/desk-accessories">Desk Accessories</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/desk-accessories/card-stands">Card Stands</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/desk-accessories/desk-organizers">Desk Organizers</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/desk-accessories/brochure-holders">Brochure Holders</a></li>
                                </ul>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/basic-stationery/envelopes">Envelopes</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/envelopes/plain-envelopes">Plain Envelopes</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/envelopes/string-envelopes">String Envelopes</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/envelopes/padded-envelopes">Padded Envelopes</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/envelopes/window-envelopes">Window Envelopes</a></li>
                                </ul>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/basic-stationery/fasteners">Fasteners</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/fasteners/card-rings">Card Rings</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/fasteners/cotton-tapes">Cotton Tapes</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/fasteners/paper-fasteners">Paper Fasteners</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/fasteners/treasury-tags">Treasury Tags</a></li>
                                </ul>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/basic-stationery/glue-and-adhesives">Glue &amp; Adhesives</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/glue-and-adhesives/liquid-and-super-glue">Liquid &amp; Super Glue</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/glue-and-adhesives/blu-tacks-and-glue-sticks">Blu-Tacks &amp; Glue Sticks</a></li>
                                </ul>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/basic-stationery/laser-inkjet-labels">Laser / Inkjet Labels</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/laser-inkjet-labels/clear-labels">Clear Labels</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/laser-inkjet-labels/white-labels">White Labels</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/laser-inkjet-labels/notarial-seals">Notarial Seals</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/laser-inkjet-labels/coloured-labels">Coloured Labels</a></li>
                                </ul>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/basic-stationery/mesh-products">Mesh Products</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/basic-stationery/packing-products">Packing Products</a>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/basic-stationery/post-it-notes-flags-and-tabs">Post-it Notes, Flags &amp; Tabs</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/post-it-notes-flags-and-tabs/flags-and-tabs">Flags &amp; Tabs</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/post-it-notes-flags-and-tabs/page-markers">Page Markers</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/post-it-notes-flags-and-tabs/canary-yellow-notes">Canary Yellow Notes</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/post-it-notes-flags-and-tabs/premium-coloured-notes">Premium Coloured Notes</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/post-it-notes-flags-and-tabs/pop-up-notes-and-dispensers">Pop-Up Notes &amp; Dispensers</a></li>
                                </ul>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/basic-stationery/pu-leather-products">PU Leather Products </a>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/basic-stationery/scissors-rulers-and-trimmers">Scissors, Rulers &amp; Trimmers</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/scissors-rulers-and-trimmers/cutters-blades-and-mats">Cutters, Blades &amp; Mats</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/scissors-rulers-and-trimmers/letter-openers">Letter Openers</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/scissors-rulers-and-trimmers/paper-cutters">Paper Cutters</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/scissors-rulers-and-trimmers/rulers-and-measuring-tapes">Rulers &amp; Measuring Tapes</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/scissors-rulers-and-trimmers/scissors">Scissors</a></li>
                                </ul>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/basic-stationery/stamps-stamp-pads-and-inks">Stamps, Stamp Pads &amp; Inks</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/stamps-stamp-pads-and-inks/date-stamps">Date Stamps</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/stamps-stamp-pads-and-inks/pre-inked-stamps">Pre-Inked Stamps</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/stamps-stamp-pads-and-inks/numbering-machines">Numbering Machines</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/stamps-stamp-pads-and-inks/stamp-pads-inks-and-racks">Stamp Pads, Inks &amp; Racks</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/stamps-stamp-pads-and-inks/diy-self-inking-printing-kit">DIY Self-Inking Printing Kit</a></li>
                                </ul>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/basic-stationery/staplers-and-paper-punches">Staplers &amp; Paper Punches</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/staplers-and-paper-punches/desktop-staplers">Desktop Staplers</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/staplers-and-paper-punches/paper-punchers">Paper Punchers</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/staplers-and-paper-punches/staple-removers">Staple Removers</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/staplers-and-paper-punches/staples-bullets">Staples / Bullets</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/staplers-and-paper-punches/heavy-duty-staplers">Heavy Duty Staplers</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/staplers-and-paper-punches/heavy-duty-paper-punchers">Heavy Duty Paper Punchers</a></li>
                                </ul>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/basic-stationery/tapes-and-dispensers">Tapes &amp; Dispensers</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/tapes-and-dispensers/opp-tape">OPP Tape</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/tapes-and-dispensers/cloth-tape">Cloth Tape</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/tapes-and-dispensers/magic-tape">Magic Tape</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/tapes-and-dispensers/masking-tape">Masking Tape</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/tapes-and-dispensers/mounting-tape">Mounting Tape</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/tapes-and-dispensers/cellulose-tape">Cellulose Tape</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/tapes-and-dispensers/transparent-tape">Transparent Tape</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/tapes-and-dispensers/double-sided-tape">Double-Sided Tape</a></li>
                                    <li><a href="http://www.homenoffice.sg/basic-stationery/tapes-and-dispensers/dispensers">Dispensers</a></li>
                                </ul>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/basic-stationery/waste-bin">Waste Bin</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/basic-stationery/laser-pointers-and-presenters">Laser Pointers &amp; Presenters</a>
                            </li>
                        </ul>
                    </li>
                    <li onmouseover="mouseover('1', 'image/data/2-r.png');" onmouseout="mouseout('1', 'image/data/2.png')" class="has-sub"><a href="http://www.homenoffice.sg/paper-products"><img id="icon-1" src="image/data/2.png" valign="middle" />&nbsp;&nbsp;Paper Products</a>
                        <ul>
                            <li class="">
                                <a href="http://www.homenoffice.sg/paper-products/copier-paper">Copier Paper</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/paper-products/special-paper">Special Paper</a>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/paper-products/notebooks-and-pads">Notebooks &amp; Pads</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/paper-products/notebooks-and-pads/notebooks">Notebooks</a></li>
                                    <li><a href="http://www.homenoffice.sg/paper-products/notebooks-and-pads/voucher-pads">Voucher Pads</a></li>
                                    <li><a href="http://www.homenoffice.sg/paper-products/notebooks-and-pads/hardcover-books">Hardcover Books</a></li>
                                    <li><a href="http://www.homenoffice.sg/paper-products/notebooks-and-pads/miscellaneous-pads">Miscellaneous Pads</a></li>
                                    <li><a href="http://www.homenoffice.sg/paper-products/notebooks-and-pads/professional-notebooks">Professional Notebooks</a></li>
                                    <li><a href="http://www.homenoffice.sg/paper-products/notebooks-and-pads/writing-pads-and-exercise-books">Writing Pads &amp; Exercise Books</a></li>
                                </ul>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/paper-products/computer-form-paper">Computer Form Paper</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/paper-products/woodfree-thermal-and-fax-paper">Woodfree, Thermal &amp; Fax Paper</a>
                            </li>
                        </ul>
                    </li>
                    <li onmouseover="mouseover('2', 'image/data/11-r.png');" onmouseout="mouseout('2', 'image/data/11.png')" class="has-sub"><a href="http://www.homenoffice.sg/ink-cartridges-and-toners"><img id="icon-2" src="image/data/11.png" valign="middle" />&nbsp;&nbsp;Ink Cartridges &amp; Toners</a>
                        <ul>
                            <li class="">
                                <a href="http://www.homenoffice.sg/ink-cartridges-and-toners/printers">Printers</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/ink-cartridges-and-toners/hp">HP</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/ink-cartridges-and-toners/epson">Epson</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/ink-cartridges-and-toners/canon">Canon</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/ink-cartridges-and-toners/brother">Brother</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/ink-cartridges-and-toners/samsung">Samsung</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/ink-cartridges-and-toners/fuji-xerox">Fuji Xerox</a>
                            </li>
                        </ul>
                    </li>
                    <li onmouseover="mouseover('3', 'image/data/15_r.png');" onmouseout="mouseout('3', 'image/data/15.png')" class=""><a href="http://www.homenoffice.sg/premium-diary-planner"><img id="icon-3" src="image/data/15.png" valign="middle" />&nbsp;&nbsp;Premium Diary / Planner</a>
                    </li>
                    <li onmouseover="mouseover('4', 'image/data/16-r.png');" onmouseout="mouseout('4', 'image/data/16.png')" class="has-sub"><a href="http://www.homenoffice.sg/it-and-travel-accessories"><img id="icon-4" src="image/data/16.png" valign="middle" />&nbsp;&nbsp;IT &amp; Travel Accessories</a>
                        <ul>
                            <li class="">
                                <a href="http://www.homenoffice.sg/it-and-travel-accessories/cleaning-kits">Cleaning Kits</a>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/it-and-travel-accessories/travel-accessories">Travel Accessories</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/it-and-travel-accessories/travel-accessories/travel-locks">Travel Locks</a></li>
                                    <li><a href="http://www.homenoffice.sg/it-and-travel-accessories/travel-accessories/luggage-tags">Luggage Tags</a></li>
                                    <li><a href="http://www.homenoffice.sg/it-and-travel-accessories/travel-accessories/adaptors-and-sockets">Adaptors &amp; Sockets</a></li>
                                </ul>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/it-and-travel-accessories/privacy-filters">Privacy Filters</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/it-and-travel-accessories/cd-dvd-media">CD / DVD Media</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/it-and-travel-accessories/chair-mats-and-foot-rests">Chair Mats &amp; Foot Rests</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/it-and-travel-accessories/mice-pads-and-keyboards">Mice, Pads &amp; Keyboards</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/it-and-travel-accessories/micro-usb-and-lightning-cables">Micro-USB &amp; Lightning Cables</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/it-and-travel-accessories/webcams-speakers-and-headsets">Webcams, Speakers &amp; Headsets</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/it-and-travel-accessories/power-banks-and-charging-stations">Power Banks &amp; Charging Stations</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/it-and-travel-accessories/flash-hard-drives-and-memory-cards">Flash / Hard Drives &amp; Memory Cards</a>
                            </li>
                        </ul>
                    </li>
                    <li onmouseover="mouseover('5', 'image/data/12-r.png');" onmouseout="mouseout('5', 'image/data/12.png')" class="has-sub"><a href="http://www.homenoffice.sg/filing-and-storage"><img id="icon-5" src="image/data/12.png" valign="middle" />&nbsp;&nbsp;Filing &amp; Storage</a>
                        <ul>
                            <li class="">
                                <a href="http://www.homenoffice.sg/filing-and-storage/clipboards">Clipboards</a>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/filing-and-storage/storage">Storage</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/filing-and-storage/storage/cash-box">Cash Box</a></li>
                                    <li><a href="http://www.homenoffice.sg/filing-and-storage/storage/file-cabinets">File Cabinets</a></li>
                                    <li><a href="http://www.homenoffice.sg/filing-and-storage/storage/key-box-tags">Key Box / Tags</a></li>
                                    <li><a href="http://www.homenoffice.sg/filing-and-storage/storage/document-trays">Document Trays</a></li>
                                    <li><a href="http://www.homenoffice.sg/filing-and-storage/storage/magazine-holders">Magazine Holders</a></li>
                                    <li><a href="http://www.homenoffice.sg/filing-and-storage/storage/book-and-file-racks">Book &amp; File Racks</a></li>
                                </ul>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/filing-and-storage/dividers">Dividers</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/filing-and-storage/dividers/index-dividers">Index Dividers</a></li>
                                    <li><a href="http://www.homenoffice.sg/filing-and-storage/dividers/colour-dividers">Colour Dividers</a></li>
                                    <li><a href="http://www.homenoffice.sg/filing-and-storage/dividers/white-paper-dividers">White Paper Dividers</a></li>
                                </ul>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/filing-and-storage/pp-pvc-files">PP / PVC Files</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/filing-and-storage/pp-pvc-files/clear-files">Clear Files</a></li>
                                    <li><a href="http://www.homenoffice.sg/filing-and-storage/pp-pvc-files/clear-folders">Clear Folders</a></li>
                                    <li><a href="http://www.homenoffice.sg/filing-and-storage/pp-pvc-files/coloured-folders">Coloured Folders</a></li>
                                    <li><a href="http://www.homenoffice.sg/filing-and-storage/pp-pvc-files/management-files">Management Files</a></li>
                                </ul>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/filing-and-storage/paper-files">Paper Files</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/filing-and-storage/index-and-tabs">Index &amp; Tabs</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/filing-and-storage/ring-and-arch-files">Ring &amp; Arch Files</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/filing-and-storage/files-and-card-cases">Files &amp; Card Cases</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/filing-and-storage/card-holders-and-files">Card Holders &amp; Files</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/filing-and-storage/laminated-ring-files">Laminated Ring Files</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/filing-and-storage/reinforcement-rings">Reinforcement Rings</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/filing-and-storage/sheet-protector-and-pockets">Sheet Protector &amp; Pockets</a>
                            </li>
                        </ul>
                    </li>
                    <li onmouseover="mouseover('6', 'image/data/7-r.png');" onmouseout="mouseout('6', 'image/data/7.png')" class="has-sub"><a href="http://www.homenoffice.sg/office-equipment-and-accessories"><img id="icon-6" src="image/data/7.png" valign="middle" />&nbsp;&nbsp;Office Equipment &amp; Accessories</a>
                        <ul>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/office-equipment-and-accessories/paper-shredders">Paper Shredders</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/paper-shredders/gbc">GBC</a></li>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/paper-shredders/aurora">Aurora</a></li>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/paper-shredders/fellowes">Fellowes</a></li>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/paper-shredders/biosystem">Biosystem</a></li>
                                </ul>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/office-equipment-and-accessories/label-printers-and-tapes">Label Printers &amp; Tapes</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/label-printers-and-tapes/label-tapes">Label Tapes</a></li>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/label-printers-and-tapes/label-printers">Label Printers</a></li>
                                </ul>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/office-equipment-and-accessories/laminators-and-pouches">Laminators &amp; Pouches</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/laminators-and-pouches/pouches">Pouches</a></li>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/laminators-and-pouches/laminators">Laminators</a></li>
                                </ul>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/office-equipment-and-accessories/calculators-and-accessories">Calculators &amp; Accessories</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/calculators-and-accessories/ink-rollers">Ink Rollers</a></li>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/calculators-and-accessories/printing-calculators">Printing Calculators</a></li>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/calculators-and-accessories/desktop-calculators">Desktop Calculators</a></li>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/calculators-and-accessories/scientific-and-financial-calculators">Scientific &amp; Financial Calculators</a></li>
                                </ul>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/office-equipment-and-accessories/checkwriter-and-accessories">Checkwriter &amp; Accessories</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/office-equipment-and-accessories/time-recorders-and-accessories">Time Recorders &amp; Accessories</a>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/office-equipment-and-accessories/binding-machines-and-accessories">Binding Machines &amp; Accessories</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/binding-machines-and-accessories/gbc-45109154">GBC</a></li>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/binding-machines-and-accessories/fellowes-246904339">Fellowes</a></li>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/binding-machines-and-accessories/biosystem-1456743626">Biosystem</a></li>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/binding-machines-and-accessories/binding-rings">Binding Rings</a></li>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/binding-machines-and-accessories/binding-covers">Binding Covers</a></li>
                                </ul>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/office-equipment-and-accessories/time-attendance-coin-and-notes-counter">Time Attendance, Coin &amp; Notes Counter</a>
                            </li>
                        </ul>
                    </li>
                    <li onmouseover="mouseover('7', 'image/data/13-r.png');" onmouseout="mouseout('7', 'image/data/13.png')" class="has-sub"><a href="http://www.homenoffice.sg/writing-and-correction"><img id="icon-7" src="image/data/13.png" valign="middle" />&nbsp;&nbsp;Writing &amp; Correction</a>
                        <ul>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/writing-and-correction/pens">Pens</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/writing-and-correction/pens/refills">Refills</a></li>
                                    <li><a href="http://www.homenoffice.sg/writing-and-correction/pens/ballpoint-pens">Ballpoint Pens</a></li>
                                    <li><a href="http://www.homenoffice.sg/writing-and-correction/pens/uni-jetstream-pens">Uni Jetstream Pens</a></li>
                                    <li><a href="http://www.homenoffice.sg/writing-and-correction/pens/liquid-and-gel-ink-pens">Liquid &amp; Gel Ink Pens</a></li>
                                    <li><a href="http://www.homenoffice.sg/writing-and-correction/pens/erasable-and-fibre-tip-pens">Erasable &amp; Fibre-Tip Pens</a></li>
                                </ul>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/writing-and-correction/pencils">Pencils</a>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/writing-and-correction/markers">Markers</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/writing-and-correction/markers/permanent-markers">Permanent Markers</a></li>
                                    <li><a href="http://www.homenoffice.sg/writing-and-correction/markers/whiteboard-markers">Whiteboard Markers</a></li>
                                    <li><a href="http://www.homenoffice.sg/writing-and-correction/markers/chalk-and-paint-markers">Chalk &amp; Paint Markers</a></li>
                                </ul>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/writing-and-correction/fineliners">Fineliners</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/writing-and-correction/sharpeners">Sharpeners</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/writing-and-correction/highlighters">Highlighters</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/writing-and-correction/colour-pencils">Colour Pencils</a>
                            </li>
                            <li class="has-sub-sub">
                                <a href="http://www.homenoffice.sg/writing-and-correction/correction-supplies">Correction Supplies</a>
                                <ul>
                                    <li><a href="http://www.homenoffice.sg/writing-and-correction/correction-supplies/erasers-and-dusters">Erasers &amp; Dusters</a></li>
                                    <li><a href="http://www.homenoffice.sg/writing-and-correction/correction-supplies/correction-pens-tapes">Correction Pens / Tapes</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li onmouseover="mouseover('8', 'image/data/9-r.png');" onmouseout="mouseout('8', 'image/data/9.png')" class="has-sub"><a href="http://www.homenoffice.sg/miscellaneous"><img id="icon-8" src="image/data/9.png" valign="middle" />&nbsp;&nbsp;Miscellaneous</a>
                        <ul>
                            <li class="">
                                <a href="http://www.homenoffice.sg/miscellaneous/greeting-cards-1321448189">Greeting Cards</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/miscellaneous/step-ladders">Step Ladders</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/miscellaneous/maintenance-supplies">Maintenance Supplies</a>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/miscellaneous/office-design-products">Office Design Products</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="http://www.homenoffice.sg/contact">Contact Us</a></li>
            <li><a id="icnWishlist" href="http://www.homenoffice.sg/wishlist">My List</a></li>
            <li id="cartLi">
                <a id="icnCart" >My Cart</a>
                <div id="cart">
                    <!-- <div class="heading">
                      <h4>Shopping Cart</h4>
                      <a><span id="cart-total">0 item(s) - $0.00</span></a></div> -->
                    <div class="content">
                        <div id="sub-menu"><img src="catalog/view/theme/default/image/submenu_pointer.png"></div>
                        <div id="paperclip" style="margin-top:-15px;margin-left: 1px;"></div>
                        <div class="empty">Your shopping cart is empty!</div>
                    </div>
                </div>

                <script type="text/javascript">
                    function increase(key) {
                        var quantity = $("input[name='quantity2[" + key + "]'").val();
                        update(parseInt(quantity) + 1, key);
                        $("input[name='quantity2[" + key + "]'").val(parseInt(quantity) + 1);
                    }
                    function decrease(key) {
                        var quantity = $("input[name='quantity2[" + key + "]'").val();
                        update(parseInt(quantity) - 1, key);
                        $("input[name='quantity2[" + key + "]'").val(parseInt(quantity) - 1);
                    }
                    function update(qty, key) {
                        if(getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout'){
                            var quantity = {};  // = quantity = Object();
                            quantity[key] = qty;
                            var parameter = {quantity: quantity};

                            $('#cart').load('index.php?route=checkout/cart #cart > *', parameter);
                            $('.cart-info').load('index.php?route=checkout/cart .cart-info > *', parameter);
                            $('#total-saving').load('index.php?route=checkout/cart #total-saving > *', parameter);
                            $('.cart-total').load('index.php?route=checkout/cart .cart-total > *', parameter);
                        }
                        else{
                            $('#cart').load('index.php?route=module/cart&product_id=' + key + '&quantity=' + qty + ' #cart > *');
                        }

                        setTimeout(function() {
                            $.ajax({
                                url: 'index.php?route=checkout/cart/delivery',
                                type: 'post',
                                dataType: 'json',
                                success: function(json) {
                                    $('#delivery-status').html(json['message']);

                                    $( "#progressbar" ).progressbar({
                                        value: json['percentage']
                                    });

                                }
                            });
                        }, 2000);

                        $.ajax({
                            url: 'index.php?route=checkout/cart/getProducts',
                            type: 'post',
                            dataType: 'json',
                            success: function(json) {
                                $('input[name^=\'quantity3[\'').val('');
                                $('input[name^=\'quantity3[\'').css("background-color", "#055993");
                                $('input[name^=\'quantity3[\'').css('background-image', 'url(catalog/view/theme/default/image/add-cart.png)');
                                $('input[name^=\'quantity3[\'').attr('readonly', true);
                                $.each(json, function(i,data) {
                                    $('input[name=\'quantity3['+data.product_id+']\']').val(data.quantity);
                                    $('input[name=\'quantity3['+data.product_id+']\']').css('background-image', 'none');
                                    $('input[name=\'quantity3['+data.product_id+']\']').css("background-color", "#094269");
                                    $('input[name=\'quantity3['+data.product_id+']\']').prop('readonly', false);
                                });
                            }
                        });

                    }
                    function getURLVar(key) {
                        var value = [];
                        var query = String(document.location).split('?');

                        if (query[1]) {
                            var part = query[1].split('&');

                            for (i = 0; i < part.length; i++) {
                                var data = part[i].split('=');
                                if (data[0] && data[1]) {
                                    value[data[0]] = data[1];
                                }
                            }

                            if (value[key]) {
                                return value[key];
                            } else {
                                return '';
                            }
                        }
                    }
                    function removeProducts(key) {
                        (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout') ? location = 'index.php?route=checkout/cart&remove=' + key : $('#cart').load('index.php?route=module/cart&remove='+ key + ' #cart > *');

                        setTimeout(function() {
                            $.ajax({
                                url: 'index.php?route=checkout/cart/getProducts',
                                type: 'post',
                                dataType: 'json',
                                success: function(json) {
                                    $('input[name^=\'quantity3[\'').val('');
                                    $('input[name^=\'quantity3[\'').css("background-color", "#055993");
                                    $('input[name^=\'quantity3[\'').css('background-image', 'url(catalog/view/theme/default/image/add-cart.png)');
                                    $('input[name^=\'quantity3[\'').attr('readonly', true);
                                    $.each(json, function(i,data) {
                                        $('input[name=\'quantity3['+data.product_id+']\']').val(data.quantity);
                                        $('input[name=\'quantity3['+data.product_id+']\']').css('background-image', 'none');
                                        $('input[name=\'quantity3['+data.product_id+']\']').css("background-color", "#094269");
                                        $('input[name=\'quantity3['+data.product_id+']\']').prop('readonly', false);
                                    });
                                }
                            });
                        }, 1500);

                        setTimeout(function() {
                            $.ajax({
                                url: 'index.php?route=checkout/cart/delivery',
                                type: 'post',
                                dataType: 'json',
                                success: function(json) {
                                    $('#delivery-status').html(json['message']);

                                    $( "#progressbar" ).progressbar({
                                        value: json['percentage']
                                    });

                                }
                            });
                        }, 2000);

                    }
                </script>    </li>
        </ul>
    </div>
    <div id="notification"></div>

    <div id="content"><style type="text/css">
            .iSearchBox li .iMarq {
                background-color:#F7FF8C;
            }
            .iSearchBoxWrapper .iSearchBox {
                width: 278px !important;
            }

            .iSearchBox li h3 {
                width:42%;
            }
            .iSearchBox li h3 {
                font-weight:bold;
            }
        </style>

        <style type="text/css">
            /*.saving-point {
            display:none;
            }

            .product-grid .description {
              display:block;
              text-align:left;
            }
            */</style>

        <script type="text/javascript">
            var ocVersion = "1.5.6.1";
            var moreResultsText = 'View All Results';
            var noResultsText = 'No Results Found';
            //var SCWords = $.parseJSON('[{"incorrect":"cnema","correct":"cinema"}]');
            //var spellCheckSystem = 'no';
            var useAJAX = 'yes';
            var loadImagesOnInstantSearch = 'yes';
            var useStrictSearch = 'no';

            var enableCategoriesInstant = 'LeftOfProducts';
            var showProductCountInstant = false;
            var categoryHeadingInstant = 'Top Category Results';
            var productHeadingInstant = 'Top Product Results';
            var matchesTextInstant = '(N) Matches';

            var responsiveDesign = 'yes';
            var afterHittingEnter = 'isearchengine1541';
            var searchInModel = 'yes';
            var searchInDescription = false;
            var productsData = [];
            var iSearchResultsLimit = '5';
        </script>
        <style type="text/css">
            .iSearchBox ul li.iSearchHeading {
                margin: 0 0 10px 0;
                font-size: 18px;
                padding-left: 5px;
                position: relative;
            }

            .iSearchBox ul li.iSearchHeading:hover {
                border-color: white;
                cursor: default;
                box-shadow: none;
            }

            .iSearchBox ul li.iSearchCategory {
                padding: 5px;
            }

            .iSearchMatches {
                position: absolute;
                display: block;
                right: 10px;
                top: 0;
                font-size: 14px;
            }
        </style>
        <div class="slideshow">
            <div id="slideshow0" class="nivoSlider" style="width: 1024px; height: 374px;">
                <a href="http://www.homenoffice.sg/filing-and-storage/ring-and-arch-files"><img src="http://www.homenoffice.sg/image/cache/data/Arch File-1024x374.jpg" alt="Arch File" /></a>
                <a href="http://www.homenoffice.sg/writing-and-correction/highlighters"><img src="http://www.homenoffice.sg/image/cache/data/HnO Highlighter 4-1024x374.jpg" alt="HnO Highlighter" /></a>
                <a href="http://www.homenoffice.sg/writing-and-correction/markers/whiteboard-markers"><img src="http://www.homenoffice.sg/image/cache/data/HnO Marker-1024x374.jpg" alt="HnO Marker" /></a>
                <a href="http://www.homenoffice.sg/basic-stationery/staplers-and-paper-punches/desktop-staplers"><img src="http://www.homenoffice.sg/image/cache/data/HnO Stapler-1024x374.jpg" alt="HnO Stapler" /></a>
                <a href="http://www.homenoffice.sg/basic-stationery/desk-accessories"><img src="http://www.homenoffice.sg/image/cache/data/HnO Holders-1024x374.jpg" alt="HnO Holders" /></a>
                <a href="http://www.homenoffice.sg/index.php?route=product/isearch&amp;search=sarasa"><img src="http://www.homenoffice.sg/image/cache/data/Sarasa-1024x374.jpg" alt="Sarasa" /></a>
                <a href="http://www.homenoffice.sg/basic-stationery/clips-pins-and-tacks"><img src="http://www.homenoffice.sg/image/cache/data/HnO Basic Stationery-1024x374.jpg" alt="HnO Basic" /></a>
            </div>
        </div>
        <script type="text/javascript">
        <!--
            $(document).ready(function() {
                $('#slideshow0').nivoSlider();
            });
            -->
        </script>
        <div style="margin-left: 75px;">
            <div class="home-column"><a href="f-a-q"><img src="http://www.homenoffice.sg/image/data/01%20Online%20Payment%20200116.png" style="height:197px; width:197px" /></a></div>

            <div class="home-column"><a href="f-a-q"><img src="http://www.homenoffice.sg/image/data/02%20Delivery%20200116.png" style="height:197px; width:197px" /></a></div>

            <div class="home-column"><a href="outlet"><img src="http://www.homenoffice.sg/image/data/03%20Collection%20200116.png" style="height:197px; width:197px" /></a></div>

            <div class="home-column"><a href="http://www.homenoffice.sg/index.php?route=product/category"><img src="http://www.homenoffice.sg/image/data/04%20Spend%20%2450%20200116.png" style="height:197px; width:197px" /></a></div>
        </div>
        <div style="clear:both;"></div><h1 style="display: none;">Home n Office, Office Stationery Supplies Store Singapore</h1>

        <div class="box">
            <div class="box-heading"><span class="seeall"><a href="http://www.homenoffice.sg/index.php?route=product/category">See All</a></span><span class="title" style="margin-left:390px">Categories</span></div>
            <div class="box-content">
                <div align="center" class="box-product">
                    <div class="box-column3">
                        <a href="http://www.homenoffice.sg/basic-stationery">
                            <img src="image/data/icon_basicstationery.png" width="150" height="150"><br/><br/>
                            Basic Stationery		</a>
                    </div>
                    <div class="box-column3">
                        <a href="http://www.homenoffice.sg/paper-products">
                            <img src="image/data/icon_paper products.png" width="150" height="150"><br/><br/>
                            Paper Products		</a>
                    </div>
                    <div class="box-column3">
                        <a href="http://www.homenoffice.sg/ink-cartridges-and-toners">
                            <img src="image/data/icon_cartridges .png" width="150" height="150"><br/><br/>
                            Ink Cartridges &amp; Toners		</a>
                    </div>
                    <div class="box-column3">
                        <a href="http://www.homenoffice.sg/premium-diary-planner">
                            <img src="image/data/icon_planner.png" width="150" height="150"><br/><br/>
                            Premium Diary / Planner		</a>
                    </div>
                    <div class="box-column3">
                        <a href="http://www.homenoffice.sg/it-and-travel-accessories">
                            <img src="image/data/icon_it travel.png" width="150" height="150"><br/><br/>
                            IT &amp; Travel Accessories		</a>
                    </div>
                    <div style="clear:both"></div>
                    <div class="box-column3">
                        <a href="http://www.homenoffice.sg/filing-and-storage">
                            <img src="image/data/icon_fillingsupplies.png" width="150" height="150"><br/><br/>
                            Filing &amp; Storage		</a>
                    </div>
                    <div class="box-column3">
                        <a href="http://www.homenoffice.sg/office-equipment-and-accessories">
                            <img src="image/data/icon_office equipments.png" width="150" height="150"><br/><br/>
                            Office Equipment &amp; Accessories		</a>
                    </div>
                    <div class="box-column3">
                        <a href="http://www.homenoffice.sg/writing-and-correction">
                            <img src="image/data/icon_writinginstruments_2.png" width="150" height="150"><br/><br/>
                            Writing &amp; Correction		</a>
                    </div>
                    <div class="box-column3">
                        <a href="http://www.homenoffice.sg/gifts-and-novelties">
                            <img src="image/data/icon_gift novelties.png" width="150" height="150"><br/><br/>
                            Gifts &amp; Novelties		</a>
                    </div>
                    <div class="box-column3">
                        <a href="http://www.homenoffice.sg/miscellaneous">
                            <img src="image/data/icon_misc .png" width="150" height="150"><br/><br/>
                            Miscellaneous		</a>
                    </div>
                    <div style="clear:both"></div>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-heading"><span class="title-best" style="background-image: none;">Featured Products</span></div>
            <div class="box-content">
                <div align="center" class="box-product">
                    <div class="box-column">
                        <div class="image">
                            <a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/8993242592544-130x130.jpg" alt="PaperOne Copier Paper 70gsm A4" /></a>
                            <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                                   -->
                        </div>
                        <div class="name"><a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4">PaperOne Copier Paper 70gsm A4</a></div>
                        <div class="barcode" style="text-align:left"><small>8993242592544</small></div>
                        <div class="price">
                            <span class="price-new">$3.45</span>
                        </div>
                        <div class="saving-point">
                            Retail Price: $4.00<br/>
                            You Save: <span id="save">14%</span>
                        </div>
                        <div class="discount-msg">
                            Bulk Quantity: <span>50 & above</span><br />Bulk Price: <span>$3.00</span>&nbsp;&nbsp;(Save: <span id="save">25%</span>)<br/>*same colour, same size etc
                        </div>
                        <div class="cart">
                            <input type="button" value="Add to Cart" onclick="addToCart('422'); ga('send', 'event', 'Featured Product', 'Add to Cart', 'PaperOne Copier Paper 70gsm A4');" class="button" />
                            <span class="counter"><input type="text" name="quantity3[422]" onkeyup="changeQuantity('422', this.value);" onclick="editableField(this.name)" ></span></div>
                    </div>
                    <div class="box-column">
                        <div class="image">
                            <a href="http://www.homenoffice.sg/ik-copy-paper-80gsm-a4"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/8991389139202-130x130.jpg" alt="IK Copy Paper 80gsm A4" /></a>
                            <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                                   -->
                        </div>
                        <div class="name"><a href="http://www.homenoffice.sg/ik-copy-paper-80gsm-a4">IK Copy Paper 80gsm A4</a></div>
                        <div class="barcode" style="text-align:left"><small>8991389139202</small></div>
                        <div class="price">
                            <span class="price-new">$3.60</span>
                        </div>
                        <div class="saving-point">
                            Retail Price: $3.80<br/>
                            You Save: <span id="save">5%</span>
                        </div>
                        <div class="discount-msg">
                            Bulk Quantity: <span>50 & above</span><br />Bulk Price: <span>$3.20</span>&nbsp;&nbsp;(Save: <span id="save">16%</span>)<br/>*same colour, same size etc
                        </div>
                        <div class="cart">
                            <input type="button" value="Add to Cart" onclick="addToCart('4260'); ga('send', 'event', 'Featured Product', 'Add to Cart', 'IK Copy Paper 80gsm A4');" class="button" />
                            <span class="counter"><input type="text" name="quantity3[4260]" onkeyup="changeQuantity('4260', this.value);" onclick="editableField(this.name)" ></span></div>
                    </div>
                    <div class="box-column">
                        <div class="image">
                            <a href="http://www.homenoffice.sg/arch-file-pvc-3-a4"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/ARCH FILE/Arch Files-130x130.jpg" alt="Arch File PVC 3&quot; A4" /></a>
                            <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                                   -->
                        </div>
                        <div class="name"><a href="http://www.homenoffice.sg/arch-file-pvc-3-a4">Arch File PVC 3&quot; A4</a></div>
                        <div class="barcode" style="text-align:left"><small></small></div>
                        <div class="price">
                            <span class="price-new">$2.00</span>
                        </div>
                        <div class="saving-point">
                            Retail Price: $3.50<br/>
                            You Save: <span id="save">43%</span>
                        </div>
                        <div class="discount-msg">
                            Bulk Quantity: <span>6 & above</span><br />Bulk Price: <span>$1.80</span>&nbsp;&nbsp;(Save: <span id="save">49%</span>)<br/>*same colour, same size etc
                        </div>
                        <div class="cart">
                            <input type="button" value="Add to Cart" onclick="addToCart('580'); ga('send', 'event', 'Featured Product', 'Add to Cart', 'Arch File PVC 3&amp;quot; A4');" class="button" />
                            <span class="counter"><input type="text" name="quantity3[580]" onkeyup="changeQuantity('580', this.value);" onclick="editableField(this.name)" ></span></div>
                    </div>
                    <div class="box-column">
                        <div class="image">
                            <a href="http://www.homenoffice.sg/hno-pvc-l-shape-folder-25-s-a4-clear"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/6921696300042-130x130.jpg" alt="HnO PVC L-Shape Folder 25'S A4 Clear" /></a>
                            <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                                   -->
                        </div>
                        <div class="name"><a href="http://www.homenoffice.sg/hno-pvc-l-shape-folder-25-s-a4-clear">HnO PVC L-Shape Folder 25'S A4 Clear</a></div>
                        <div class="barcode" style="text-align:left"><small>6921696300042</small></div>
                        <div class="price">
                            <span class="price-new">$5.50</span>
                        </div>
                        <div class="saving-point">
                            Retail Price: $6.12<br/>
                            You Save: <span id="save">10%</span>
                        </div>
                        <div class="discount-msg">
                            Bulk Quantity: <span>5 & above</span><br />Bulk Price: <span>$4.90</span>&nbsp;&nbsp;(Save: <span id="save">20%</span>)<br/>*same colour, same size etc
                        </div>
                        <div class="cart">
                            <input type="button" value="Add to Cart" onclick="addToCart('657'); ga('send', 'event', 'Featured Product', 'Add to Cart', 'HnO PVC L-Shape Folder 25\'S A4 Clear');" class="button" />
                            <span class="counter"><input type="text" name="quantity3[657]" onkeyup="changeQuantity('657', this.value);" onclick="editableField(this.name)" ></span></div>
                    </div>
                    <div class="box-column">
                        <div class="image">
                            <a href="http://www.homenoffice.sg/hno-translucent-pp-l-shape-folder-12-s-a4-colour"><img src="http://www.homenoffice.sg/image/cache/data/Product Pictures/HnO Translucent LShape Folder_NEW-130x130.jpg" alt="HnO Translucent PP L-Shape Folder 12'S A4 Colour" /></a>
                            <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                                   -->
                        </div>
                        <div class="name"><a href="http://www.homenoffice.sg/hno-translucent-pp-l-shape-folder-12-s-a4-colour">HnO Translucent PP L-Shape Folder 12'S A4 Colour</a></div>
                        <div class="barcode" style="text-align:left"><small></small></div>
                        <div class="price">
                            <span class="price-new">$2.20</span>
                        </div>
                        <div class="saving-point">
                            Retail Price: $2.44<br/>
                            You Save: <span id="save">10%</span>
                        </div>
                        <div class="discount-msg">
                            Bulk Quantity: <span>5 & above</span><br />Bulk Price: <span>$1.95</span>&nbsp;&nbsp;(Save: <span id="save">20%</span>)<br/>*same colour, same size etc
                        </div>
                        <div class="cart">
                            <input type="button" value="Add to Cart" onclick="addToCart('697'); ga('send', 'event', 'Featured Product', 'Add to Cart', 'HnO Translucent PP L-Shape Folder 12\'S A4 Colour');" class="button" />
                            <span class="counter"><input type="text" name="quantity3[697]" onkeyup="changeQuantity('697', this.value);" onclick="editableField(this.name)" ></span></div>
                    </div>
                    <div style="clear:both"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
        <div class="column">
            <h3>Need Help?</h3>
            <img class="footer-img" src="catalog/view/theme/default/image/help.png">
            <p>Email us at <a id="mailto" href="mailto:enquiry@homenoffice.com.sg">enquiry@homenoffice.com.sg</a> and we will get back to you shortly.</p>
        </div>
        <div class="column">
            <h3>Information</h3>
            <img class="footer-img" src="catalog/view/theme/default/image/info2.png">
            <ul>
                <li><a href="http://www.homenoffice.sg/f-a-q">F.A.Q</a></li>
                <li><a href="http://www.homenoffice.sg/privacy-policy">Privacy Policy</a></li>
                <li><a href="http://www.homenoffice.sg/terms-and-conditions">Terms &amp; Conditions</a></li>
                <!-- <li><a href="http://www.homenoffice.sg/contact">Contact Us</a></li> -->
            </ul>
        </div>
        <!-- <div class="column">
        <h3>Delivery</h3>
        <img class="footer-img" src="catalog/view/theme/default/image/delivery.png">
        <ul>
          <li><a href="http://www.homenoffice.sg/returns">Shipping & Returns</a></li>
          <li><a href="http://www.homenoffice.sg/f-a-q">F.A.Q</a></li>
          <li><a href="http://www.homenoffice.sg/index.php?route=information/information&information_id=6">Delivery Information</a></li>
        </ul>
      </div> -->
        <div class="column">
            <h3>My Account</h3>
            <img class="footer-img" src="catalog/view/theme/default/image/account.png">
            <ul>
                <li><a href="http://www.homenoffice.sg/account">My Account</a></li>
                <li><a href="http://www.homenoffice.sg/index.php?route=account/order">My Invoices</a></li>
                <li><a href="http://www.homenoffice.sg/wishlist">My Wishlist</a></li>
                <!-- <li><a href="http://www.homenoffice.sg/newsletter">Newsletter</a></li> -->
            </ul>
        </div>
        <div class="column">
            <h3>Brochures</h3>
            <img class="footer-img" src="catalog/view/theme/default/image/brochure.png">
            <ul>
                <li><a href="http://www.homenoffice.sg/catalogs-brochures">Catalogs / Brochures</a></li>
            </ul>
        </div>
        <div class="column"></div>
    </div>
</div>
<div id="footer-bar"></div>
<div align="center" id="powered">
    <img id="footer-logo" src="catalog/view/theme/default/image/footer-logo.png"><br/>
    Copyright 2016 &copy; Home n Office Products Pte Ltd. All Rights Reserved.</div>


<script src="catalog/view/javascript/backtop/easing.js" type="text/javascript"></script>
<script src="catalog/view/javascript/backtop/jquery.ui.totop.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        /*
         var defaults = {
         containerID: 'toTop', // fading element id
         containerHoverID: 'toTopHover', // fading element hover id
         scrollSpeed: 1200,
         easingType: 'linear'
         };
         */

        $().UItoTop({ easingType: 'easeOutQuart' });

    });
</script>


</body></html>
