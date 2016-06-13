<!DOCTYPE html>
<html class="" dir="ltr" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <title>Home n Office: Office Stationery Supplier Singapore</title>
    <!-- base href="http://www.homenoffice.sg/" -->
    <meta name="description" content="Home n Office is your one stop office stationery supplier, offering basic stationery, accessories, IT products, &amp; high end office equipment in Singapore.">
    <meta name="keywords" content="Home n Office, office stationery, stationery online, stationery supplier">
    <link href="http://www.homenoffice.sg/image/data/cart.png" rel="icon">
    <link href="http://www.homenoffice.sg/" rel="canonical">

    {{ HTML::style('assets/site/css/css.css') }}
    {{ HTML::style('assets/site/css/stylesheet.css') }}
    {{ HTML::style('assets/site/css/ui.css') }}
    {{ HTML::style('assets/site/css/slideshow.css', array('media' => 'screen')) }}
    {{ HTML::script('assets/site/js/jquery-1.js') }}
    {{ HTML::script('assets/site/js/jquery_004.js') }}
    {{--{{ HTML::script('assets/site/js/jquery.nivo.slider.js') }}--}}
    {{--<link rel="stylesheet" type="text/css" href="vpp_site_files/bootstrap-modal.css">--}}
    {{--<link rel="stylesheet" type="text/css" href="vpp_site_files/bootstrap-theme.css">--}}
    {{--<script type="text/javascript" src="vpp_site_files/bootstrap.js"></script>--}}

    {{--<!--[if IE 7]>--}}
    {{--<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />--}}
    {{--<![endif]-->--}}
    {{--<!--[if lt IE 7]>--}}
    {{--<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />--}}
    {{--<![endif]-->--}}

    <script type="text/javascript">
        function mouseover(id, img_path) {
            $('#icon-'+id).attr("src", img_path);
        }
        function mouseout(id, img_path) {
            $('#icon-'+id).attr("src", img_path);
        }
    </script>
    </head>
<body>
<div id="container">
    <div id="header">
        <div id="logo"><a href="http://www.homenoffice.sg/"><img src="{{asset('assets/vpp_site_files/HOME-N-OFFICE-LOGO.png')}}" title="Home n Office Products Pte Ltd" alt="Home n Office Products Pte Ltd"></a></div>
        <div id="search">
            <div class="iSearchBoxWrapper">
                <div class="button-search"></div>
                <input autocomplete="off" name="search" placeholder="nhập từ khóa để tìm kiếm :)" type="text">
            </div>
        </div>
        <div id="welcome">
            <div id="divLogin" style="float:right">
                <input class="login" id="btnLogin" value="Đăng nhập" onclick="window.location='http://www.homenoffice.sg/login'" type="button">
                <input class="account" id="btnRegister" value="Đăng ký" onclick="window.location='http://www.homenoffice.sg/register'" type="button">
            </div>
        </div>
    </div>
    <div id="menu">
        <ul>
            <li><a href="{{URL::route('site.home')}}">Trang chủ</a></li>
            <li><a href="http://www.homenoffice.sg/index.php?route=product/category">Sản phẩm</a>
                <span id="sub-menu"><img src="{{asset('assets/site/image/submenu_pointer.png')}}"></span>
                <ul>
                    <li onmouseover="mouseover('0', 'image/data/1-r.png');" onmouseout="mouseout('0', 'image/data/1.png')" class="has-sub">
                        <a href="http://www.homenoffice.sg/basic-stationery">
                            <img id="icon-0" src="vpp_site_files/1.png" valign="middle">&nbsp;&nbsp;Basic Stationery
                        </a>
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
                                <a href="http://www.homenoffice.sg/basic-stationery/clips-pins-and-tacks">Clips, Pins &amp; Tacks</a>
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
                    <li onmouseover="mouseover('1', 'image/data/2-r.png');" onmouseout="mouseout('1', 'image/data/2.png')" class="has-sub"><a href="http://www.homenoffice.sg/paper-products"><img id="icon-1" src="vpp_site_files/2.png" valign="middle">&nbsp;&nbsp;Paper Products</a>
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
                    <li onmouseover="mouseover('2', 'image/data/11-r.png');" onmouseout="mouseout('2', 'image/data/11.png')" class="has-sub"><a href="http://www.homenoffice.sg/ink-cartridges-and-toners"><img id="icon-2" src="vpp_site_files/11.png" valign="middle">&nbsp;&nbsp;Ink Cartridges &amp; Toners</a>
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
                    <li onmouseover="mouseover('3', 'image/data/15_r.png');" onmouseout="mouseout('3', 'image/data/15.png')" class=""><a href="http://www.homenoffice.sg/premium-diary-planner"><img id="icon-3" src="vpp_site_files/15.png" valign="middle">&nbsp;&nbsp;Premium Diary / Planner</a>
                    </li>
                    <li onmouseover="mouseover('4', 'image/data/16-r.png');" onmouseout="mouseout('4', 'image/data/16.png')" class="has-sub"><a href="http://www.homenoffice.sg/it-and-travel-accessories"><img id="icon-4" src="vpp_site_files/16.png" valign="middle">&nbsp;&nbsp;IT &amp; Travel Accessories</a>
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
                    <li onmouseover="mouseover('5', 'image/data/12-r.png');" onmouseout="mouseout('5', 'image/data/12.png')" class="has-sub"><a href="http://www.homenoffice.sg/filing-and-storage"><img id="icon-5" src="vpp_site_files/12.png" valign="middle">&nbsp;&nbsp;Filing &amp; Storage</a>
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
                    <li onmouseover="mouseover('6', 'image/data/7-r.png');" onmouseout="mouseout('6', 'image/data/7.png')" class="has-sub"><a href="http://www.homenoffice.sg/office-equipment-and-accessories"><img id="icon-6" src="vpp_site_files/7.png" valign="middle">&nbsp;&nbsp;Office Equipment &amp; Accessories</a>
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
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/laminators-and-pouches/laminators">Laminating Machine</a></li>
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
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/binding-machines-and-accessories/gbc-100326688">GBC</a></li>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/binding-machines-and-accessories/fellowes-455973437">Fellowes</a></li>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/binding-machines-and-accessories/biosystem-377067439">Biosystem</a></li>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/binding-machines-and-accessories/binding-rings">Binding Rings</a></li>
                                    <li><a href="http://www.homenoffice.sg/office-equipment-and-accessories/binding-machines-and-accessories/binding-covers">Binding Covers</a></li>
                                </ul>
                            </li>
                            <li class="">
                                <a href="http://www.homenoffice.sg/office-equipment-and-accessories/time-attendance-coin-and-notes-counter">Time Attendance, Coin &amp; Notes Counter</a>
                            </li>
                        </ul>
                    </li>
                    <li onmouseover="mouseover('7', 'image/data/13-r.png');" onmouseout="mouseout('7', 'image/data/13.png')" class="has-sub"><a href="http://www.homenoffice.sg/writing-and-correction"><img id="icon-7" src="vpp_site_files/13.png" valign="middle">&nbsp;&nbsp;Writing &amp; Correction</a>
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
                    <li onmouseover="mouseover('8', 'image/data/9-r.png');" onmouseout="mouseout('8', 'image/data/9.png')" class="has-sub"><a href="http://www.homenoffice.sg/miscellaneous"><img id="icon-8" src="vpp_site_files/9.png" valign="middle">&nbsp;&nbsp;Miscellaneous</a>
                        <ul>
                            <li class="">
                                <a href="http://www.homenoffice.sg/miscellaneous/greeting-cards-1598172894">Greeting Cards</a>
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
            <li><a href="http://www.homenoffice.sg/about-us">Giới thiệu</a></li>
            <li><a href="http://www.homenoffice.sg/contact">Liên hệ</a></li>
            {{--<li><a id="icnWishlist" href="http://www.homenoffice.sg/wishlist">My List</a></li>--}}
            <li id="cartLi">
                <a id="icnCart">Giỏ hàng</a>
                <div style="margin-left: -33.3167px;" id="cart"><div class="content">
                        <div id="sub-menu"><img src="{{asset('assets/site/image/submenu_pointer.png')}}"></div>
                        <div id="paperclip" style="margin-top:-15px;margin-left: 1px;"></div>
                        <div class="empty">Giỏ hàng trống !</div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div id="notification"></div>
    <div id="content">
        <div class="slideshow">
            <div id="slideshow0" class="nivoSlider" style="height: 374px">
                <a class="nivo-imageLink" href="http://www.homenoffice.sg/filing-and-storage/ring-and-arch-files">
                    <img src="{{asset('assets/vpp_site_files/demo-1.jpg')}}" alt="HnO Arch File">
                </a>
                <a class="nivo-imageLink" href="http://www.homenoffice.sg/writing-and-correction/highlighters">
                    <img src="{{asset('assets/vpp_site_files/demo-2.jpg')}}" alt="HnO Highlighter">
                </a>
                <a class="nivo-imageLink" href="http://www.homenoffice.sg/writing-and-correction/markers/whiteboard-markers">
                    <img src="{{asset('assets/vpp_site_files/demo-3.jpg')}}" alt="HnO Marker">
                </a>
                <a class="nivo-imageLink" href="http://www.homenoffice.sg/basic-stationery/staplers-and-paper-punches/desktop-staplers">
                    <img  src="{{asset('assets/vpp_site_files/demo-4.jpg')}}" alt="HnO Stapler">
                </a>
                <a class="nivo-imageLink" href="http://www.homenoffice.sg/basic-stationery/desk-accessories">
                    <img src="{{asset('assets/vpp_site_files/demo-5.jpg')}}" alt="HnO Holders">
                </a>
                <a class="nivo-imageLink" href="http://www.homenoffice.sg/index.php?route=product/isearch&amp;search=sarasa">
                    <img  src="{{asset('assets/vpp_site_files/demo-6.jpg')}}" alt="Sarasa">
                </a>
                <a class="nivo-imageLink" href="http://www.homenoffice.sg/basic-stationery/clips-pins-and-tacks">
                    <img src="{{asset('assets/vpp_site_files/demo-7.jpg')}}" alt="HnO Basic">
                </a>
            </div>
        </div>
        <div style="margin-left: 75px;">
            <div class="home-column"><a href="http://www.homenoffice.sg/f-a-q"><img src="vpp_site_files/01%2520Online%2520Payment%2520200116.png" style="height:197px; width:197px"></a></div>

            <div class="home-column"><a href="http://www.homenoffice.sg/f-a-q"><img src="vpp_site_files/02%2520Delivery%2520200116.png" style="height:197px; width:197px"></a></div>

            <div class="home-column"><a href="http://www.homenoffice.sg/outlet"><img src="vpp_site_files/03%2520Collection%2520200116.png" style="height:197px; width:197px"></a></div>

            <div class="home-column"><a href="http://www.homenoffice.sg/index.php?route=product/category"><img src="vpp_site_files/04%2520Spend%252050%2520200116.png" style="height:197px; width:197px"></a></div>
        </div>
        <div style="clear:both;"></div><h1 style="display: none;">Home n Office: Office Stationery Supplier Singapore</h1>

        <div class="box">
            <div class="box-heading"><span class="seeall"><a href="http://www.homenoffice.sg/index.php?route=product/category">See All</a></span><span class="title" style="margin-left:390px">Categories</span></div>
            <div class="box-content">
                <div class="box-product" align="center">
                    <div class="box-column3">
                        <a href="http://www.homenoffice.sg/basic-stationery">
                            <img src="vpp_site_files/icon_basicstationery.png" height="150" width="150"><br><br>
                            Basic Stationery		</a>
                    </div>
                    <div class="box-column3">
                        <a href="http://www.homenoffice.sg/paper-products">
                            <img src="vpp_site_files/icon_paper%2520products.png" height="150" width="150"><br><br>
                            Paper Products		</a>
                    </div>
                    <div class="box-column3">
                        <a href="http://www.homenoffice.sg/ink-cartridges-and-toners">
                            <img src="vpp_site_files/icon_cartridges.png" height="150" width="150"><br><br>
                            Ink Cartridges &amp; Toners		</a>
                    </div>
                    <div class="box-column3">
                        <a href="http://www.homenoffice.sg/premium-diary-planner">
                            <img src="vpp_site_files/icon_planner.png" height="150" width="150"><br><br>
                            Premium Diary / Planner		</a>
                    </div>
                    <div class="box-column3">
                        <a href="http://www.homenoffice.sg/it-and-travel-accessories">
                            <img src="vpp_site_files/icon_it%2520travel.png" height="150" width="150"><br><br>
                            IT &amp; Travel Accessories		</a>
                    </div>
                    <div style="clear:both"></div>
                    <div class="box-column3">
                        <a href="http://www.homenoffice.sg/filing-and-storage">
                            <img src="vpp_site_files/icon_fillingsupplies.png" height="150" width="150"><br><br>
                            Filing &amp; Storage		</a>
                    </div>
                    <div class="box-column3">
                        <a href="http://www.homenoffice.sg/office-equipment-and-accessories">
                            <img src="vpp_site_files/icon_office%2520equipments.png" height="150" width="150"><br><br>
                            Office Equipment &amp; Accessories		</a>
                    </div>
                    <div class="box-column3">
                        <a href="http://www.homenoffice.sg/writing-and-correction">
                            <img src="vpp_site_files/icon_writinginstruments_2.png" height="150" width="150"><br><br>
                            Writing &amp; Correction		</a>
                    </div>
                    <div class="box-column3">
                        <a href="http://www.homenoffice.sg/gifts-and-novelties">
                            <img src="vpp_site_files/icon_gift%2520novelties.png" height="150" width="150"><br><br>
                            Gifts &amp; Novelties		</a>
                    </div>
                    <div class="box-column3">
                        <a href="http://www.homenoffice.sg/miscellaneous">
                            <img src="vpp_site_files/icon_misc.png" height="150" width="150"><br><br>
                            Miscellaneous		</a>
                    </div>
                    <div style="clear:both"></div>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-heading"><span class="title-best" style="background-image: none;">Featured Products</span></div>
            <div class="box-content">
                <div class="box-product" align="center">
                    <div class="box-column">
                        <div class="image">
                            <a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4"><img src="vpp_site_files/8993242592544-130x130.jpg" alt="PaperOne Copier Paper 70gsm A4"></a>
                            <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                                   -->
                        </div>
                        <div class="name"><a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4">PaperOne Copier Paper 70gsm A4</a></div>
                        <div class="barcode" style="text-align:left"><small>8993242592544</small></div>
                        <div class="price">
                            <span class="price-new">$3.45</span>
                        </div>
                        <div class="saving-point">
                            Retail Price: $4.00<br>
                            You Save: <span id="save">14%</span>
                        </div>
                        <div class="discount-msg">
                            Bulk Quantity: <span>50 &amp; above</span><br>Bulk Price: <span>$3.00</span>&nbsp;&nbsp;(Save: <span id="save">25%</span>)<br>*same colour, same size etc
                        </div>
                        <div class="cart">
                            <input value="Add to Cart"  class="button" type="button">
                            <span class="counter">
                                <input style="background-color: rgb(5, 113, 175);" name="quantity[]" type="text" value="1">
                            </span>
                        </div>
                    </div>
                    <div class="box-column">
                        <div class="image">
                            <a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4"><img src="vpp_site_files/8993242592544-130x130.jpg" alt="PaperOne Copier Paper 70gsm A4"></a>
                            <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                                   -->
                        </div>
                        <div class="name"><a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4">PaperOne Copier Paper 70gsm A4</a></div>
                        <div class="barcode" style="text-align:left"><small>8993242592544</small></div>
                        <div class="price">
                            <span class="price-new">$3.45</span>
                        </div>
                        <div class="saving-point">
                            Retail Price: $4.00<br>
                            You Save: <span id="save">14%</span>
                        </div>
                        <div class="discount-msg">
                            Bulk Quantity: <span>50 &amp; above</span><br>Bulk Price: <span>$3.00</span>&nbsp;&nbsp;(Save: <span id="save">25%</span>)<br>*same colour, same size etc
                        </div>
                        <div class="cart">
                            <input value="Add to Cart"  class="button" type="button">
                            <span class="counter">
                                <input style="background-color: rgb(5, 113, 175);" name="quantity[]" type="text" value="1">
                            </span>
                        </div>
                    </div>
                    <div class="box-column">
                        <div class="image">
                            <a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4"><img src="vpp_site_files/8993242592544-130x130.jpg" alt="PaperOne Copier Paper 70gsm A4"></a>
                            <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                                   -->
                        </div>
                        <div class="name"><a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4">PaperOne Copier Paper 70gsm A4</a></div>
                        <div class="barcode" style="text-align:left"><small>8993242592544</small></div>
                        <div class="price">
                            <span class="price-new">$3.45</span>
                        </div>
                        <div class="saving-point">
                            Retail Price: $4.00<br>
                            You Save: <span id="save">14%</span>
                        </div>
                        <div class="discount-msg">
                            Bulk Quantity: <span>50 &amp; above</span><br>Bulk Price: <span>$3.00</span>&nbsp;&nbsp;(Save: <span id="save">25%</span>)<br>*same colour, same size etc
                        </div>
                        <div class="cart">
                            <input value="Add to Cart"  class="button" type="button">
                            <span class="counter">
                                <input style="background-color: rgb(5, 113, 175);" name="quantity[]" type="text" value="1">
                            </span>
                        </div>
                    </div>
                    <div class="box-column">
                        <div class="image">
                            <a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4"><img src="vpp_site_files/8993242592544-130x130.jpg" alt="PaperOne Copier Paper 70gsm A4"></a>
                            <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                                   -->
                        </div>
                        <div class="name"><a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4">PaperOne Copier Paper 70gsm A4</a></div>
                        <div class="barcode" style="text-align:left"><small>8993242592544</small></div>
                        <div class="price">
                            <span class="price-new">$3.45</span>
                        </div>
                        <div class="saving-point">
                            Retail Price: $4.00<br>
                            You Save: <span id="save">14%</span>
                        </div>
                        <div class="discount-msg">
                            Bulk Quantity: <span>50 &amp; above</span><br>Bulk Price: <span>$3.00</span>&nbsp;&nbsp;(Save: <span id="save">25%</span>)<br>*same colour, same size etc
                        </div>
                        <div class="cart">
                            <input value="Add to Cart"  class="button" type="button">
                            <span class="counter">
                                <input style="background-color: rgb(5, 113, 175);" name="quantity[]" type="text" value="1">
                            </span>
                        </div>
                    </div>
                    <div class="box-column">
                        <div class="image">
                            <a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4"><img src="vpp_site_files/8993242592544-130x130.jpg" alt="PaperOne Copier Paper 70gsm A4"></a>
                            <!--                       <img class="special" src="catalog/view/theme/default/image/save.png">
                                                   -->
                        </div>
                        <div class="name"><a href="http://www.homenoffice.sg/paperone-copier-paper-70gsm-a4">PaperOne Copier Paper 70gsm A4</a></div>
                        <div class="barcode" style="text-align:left"><small>8993242592544</small></div>
                        <div class="price">
                            <span class="price-new">$3.45</span>
                        </div>
                        <div class="saving-point">
                            Retail Price: $4.00<br>
                            You Save: <span id="save">14%</span>
                        </div>
                        <div class="discount-msg">
                            Bulk Quantity: <span>50 &amp; above</span><br>Bulk Price: <span>$3.00</span>&nbsp;&nbsp;(Save: <span id="save">25%</span>)<br>*same colour, same size etc
                        </div>
                        <div class="cart">
                            <input value="Add to Cart"  class="button" type="button">
                            <span class="counter">
                                <input style="background-color: rgb(5, 113, 175);" name="quantity[]" type="text" value="1">
                            </span>
                        </div>
                    </div>
                    <div style="clear:both"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="footer">
        <div class="column">
            <h3>Need Help?</h3>
            <img class="footer-img" src="vpp_site_files/help.png">
            <p>Email us at <a id="mailto" href="mailto:enquiry@homenoffice.com.sg">enquiry@homenoffice.com.sg</a> and we will get back to you shortly.</p>
        </div>
        <div class="column">
            <h3>Information</h3>
            <img class="footer-img" src="vpp_site_files/info2.png">
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
            <img class="footer-img" src="vpp_site_files/account.png">
            <ul>
                <li><a href="http://www.homenoffice.sg/account">My Account</a></li>
                <li><a href="http://www.homenoffice.sg/index.php?route=account/order">My Invoices</a></li>
                <li><a href="http://www.homenoffice.sg/wishlist">My Wishlist</a></li>
                <!-- <li><a href="http://www.homenoffice.sg/newsletter">Newsletter</a></li> -->
            </ul>
        </div>
        <div class="column">
            <h3>Brochures</h3>
            <img class="footer-img" src="vpp_site_files/brochure.png">
            <ul>
                <li><a href="http://www.homenoffice.sg/catalogs-brochures">Catalogs / Brochures</a></li>
            </ul>
        </div>
        <div class="column"></div>
    </div>
</div>
<div id="footer-bar"></div>
<div id="powered" align="center">
    <img id="footer-logo" src="vpp_site_files/footer-logo.png"><br>
    Copyright 2016 ï¿½ Home n Office Products Pte Ltd. All Rights Reserved.
</div>
<a style="display: none;" href="#" id="toTop"><span id="toTopHover"></span>To Top</a>
<script type="text/javascript">
    $(document).ready(function() {
        $('#slideshow0').nivoSlider();
        $(window).on("scroll", function () {
            var pageOffetTop = (window.pageYOffset !== undefined) ? window.pageYOffset : (document.documentElement || document.body.parentNode || document.body).scrollTop;

            if (pageOffetTop > 200) {
                $("#toTop").show();
            } else
                $("#toTop").hide();
        });
        $("#toTop").on("click", function () {
            $("html, body").animate({scrollTop: 0}, 500);
            return false;
        });
    });
</script>
</body>
</html>